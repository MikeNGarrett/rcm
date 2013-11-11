<?php

/**
 * BuddyPress Capabilites
 *
 * @package BuddyPress
 * @subpackage Capabilities
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Adds capabilities to WordPress user roles.
 *
 * This is called on plugin activation.
 *
 * @since BuddyPress (1.6)
 *
 * @uses get_role() To get the administrator, default and moderator roles
 * @uses WP_Role::add_cap() To add various capabilities
 * @uses do_action() Calls 'bp_add_caps'
 */
function bp_add_caps() {
	global $wp_roles;

	// Load roles if not set
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	// Loop through available roles and add them
	foreach( $wp_roles->role_objects as $role ) {
		foreach ( bp_get_caps_for_role( $role->name ) as $cap ) {
			$role->add_cap( $cap );
		}
	}

	do_action( 'bp_add_caps' );
}

/**
 * Removes capabilities from WordPress user roles.
 *
 * This is called on plugin deactivation.
 *
 * @since BuddyPress (1.6)
 *
 * @uses get_role() To get the administrator and default roles
 * @uses WP_Role::remove_cap() To remove various capabilities
 * @uses do_action() Calls 'bp_remove_caps'
 */
function bp_remove_caps() {
	global $wp_roles;

	// Load roles if not set
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	// Loop through available roles and remove them
	foreach( $wp_roles->role_objects as $role ) {
		foreach ( bp_get_caps_for_role( $role->name ) as $cap ) {
			$role->remove_cap( $cap );
		}
	}

	do_action( 'bp_remove_caps' );
}

/**
 * Maps community caps to built in WordPress caps
 *
 * @since BuddyPress (1.6)
 *
 * @param array $caps Capabilities for meta capability
 * @param string $cap Capability name
 * @param int $user_id User id
 * @param mixed $args Arguments
 * @uses get_post() To get the post
 * @uses get_post_type_object() To get the post type object
 * @uses apply_filters() Calls 'bp_map_meta_caps' with caps, cap, user id and
 *                        args
 * @return array Actual capabilities for meta capability
 */
function bp_map_meta_caps( $caps, $cap, $user_id, $args ) {
	return apply_filters( 'bp_map_meta_caps', $caps, $cap, $user_id, $args );
}

/**
 * Return community capabilities
 *
 * @since BuddyPress (1.6)
 *
 * @uses apply_filters() Calls 'bp_get_community_caps' with the capabilities
 * @return array Forum capabilities
 */
function bp_get_community_caps() {

	// Forum meta caps
	$caps = array();

	return apply_filters( 'bp_get_community_caps', $caps );
}

/**
 * Returns an array of capabilities based on the role that is being requested.
 *
 * @since BuddyPress (1.6)
 *
 * @param string $role Optional. Defaults to The role to load caps for
 * @uses apply_filters() Allow return value to be filtered
 *
 * @return array Capabilities for $role
 */
function bp_get_caps_for_role( $role = '' ) {

	// Which role are we looking for?
	switch ( $role ) {

		// Administrator
		case 'administrator' :
			$caps = array(
				// Misc
				'bp_moderate',
			);

			break;

		case 'editor'          :
		case 'author'          :
		case 'contributor'     :
		case 'subscriber'      :
		default                :
			$caps = array();
			break;
	}

	return apply_filters( 'bp_get_caps_for_role', $caps, $role );
}

/**
 * Give a user the default 'Forum Participant' role when creating a topic/reply
 * on a site they do not have a role or capability on.
 *
 * @since BuddyPress (1.6)
 *
 * @global BuddyPress $bp
 *
 * @uses is_multisite()
 * @uses bp_allow_global_access()
 * @uses bp_is_user_inactive()
 * @uses is_user_logged_in()
 * @uses current_user_can()
 * @uses WP_User::set_role()
 */
function bp_set_current_user_default_role() {

	// Bail if not multisite or not root blog
	if ( ! is_multisite() || ! bp_is_root_blog() )
		return;

	// Bail if user is not logged in or already a member
	if ( ! is_user_logged_in() || is_user_member_of_blog() )
		return;

	// Bail if user is not active
	if ( bp_is_user_inactive() )
		return;

	// Set the current users default role
	buddypress()->current_user->set_role( bp_get_option( 'default_role', 'subscriber' ) );
}

/**
 * Whether current user has a capability or role. Can be passed blog ID, or will
 * use the root blod by default
 *
 * @since BuddyPress (1.6)
 *
 * @param string $capability Capability or role name.
 * @param int $blog_id Blog ID
 * @return bool
 */
function bp_current_user_can( $capability, $blog_id = 0 ) {

	// Use root blog if no ID passed
	if ( empty( $blog_id ) )
		$blog_id = bp_get_root_blog_id();

	$retval = current_user_can_for_blog( $blog_id, $capability );

	return (bool) apply_filters( 'bp_current_user_can', $retval, $capability, $blog_id );
}

/**
 * Temporary implementation of 'bp_moderate' cap
 *
 * In BuddyPress 1.6, the 'bp_moderate' cap was introduced. In order to enforce that
 * bp_current_user_can( 'bp_moderate' ) always returns true for Administrators, we must manually
 * add the 'bp_moderate' cap to the list of user caps for Admins.
 *
 * Note that this level of enforcement is only necessary in the case of non-Multisite. This is
 * because WordPress automatically assigns every capability - and thus 'bp_moderate' - to Super
 * Admins on a Multisite installation. See WP_User::has_cap().
 *
 * This implementation of 'bp_moderate' is temporary, until BuddyPress properly matches caps to
 * roles and stores them in the database. Plugin authors: Do not use this function.
 *
 * @since BuddyPress (1.6)
 * @see WP_User::has_cap()
 * @access private
 *
 * @param array $allcaps The caps that WP associates with the given role
 * @param array $caps The caps being tested for in WP_User::has_cap()
 * @param array $args Miscellaneous arguments passed to the user_has_cap filter
 * @return array $allcaps The user's cap list, with 'bp_moderate' appended, if relevant
 */
function _bp_enforce_bp_moderate_cap_for_admins( $caps = array(), $cap = '', $user_id = 0, $args = array() ) {

	// Bail if not checking the 'bp_moderate' cap
	if ( 'bp_moderate' !== $cap )
		return $caps;

	// Bail if BuddyPress is not network activated
	if ( bp_is_network_activated() )
		return $caps;

	// Never trust inactive users
	if ( bp_is_user_inactive( $user_id ) )
		return $caps;

	// Only users that can 'manage_options' on this site can 'bp_moderate'
	return array( 'manage_options' );
}
add_filter( 'map_meta_cap', '_bp_enforce_bp_moderate_cap_for_admins', 10, 4 );

/** Deprecated ****************************************************************/

/**
 * Adds BuddyPress-specific user roles.
 *
 * This is called on plugin activation.
 *
 * @since BuddyPress (1.6)
 *
 * @deprecated since version 1.7
 */
function bp_add_roles() {
	_doing_it_wrong( 'bp_add_roles', __( 'Special community roles no longer exist. Use mapped capabilities instead', 'buddypress' ), '1.7' );
}

/**
 * Removes BuddyPress-specific user roles.
 *
 * This is called on plugin deactivation.
 *
 * @since BuddyPress (1.6)
 *
 * @deprecated since version 1.7
 */
function bp_remove_roles() {
	_doing_it_wrong( 'bp_remove_roles', __( 'Special community roles no longer exist. Use mapped capabilities instead', 'buddypress' ), '1.7' );
}


/**
 * The participant role for registered users without roles
 *
 * This is primarily for multisite compatibility when users without roles on
 * sites that have global communities enabled
 *
 * @since BuddyPress (1.6)
 *
 * @deprecated since version 1.7
 */
function bp_get_participant_role() {
	_doing_it_wrong( 'bp_get_participant_role', __( 'Special community roles no longer exist. Use mapped capabilities instead', 'buddypress' ), '1.7' );
}

/**
 * The moderator role for BuddyPress users
 *
 * @since BuddyPress (1.6)
 *
 * @deprecated since version 1.7
 */
function bp_get_moderator_role() {
	_doing_it_wrong( 'bp_get_moderator_role', __( 'Special community roles no longer exist. Use mapped capabilities instead', 'buddypress' ), '1.7' );
}
