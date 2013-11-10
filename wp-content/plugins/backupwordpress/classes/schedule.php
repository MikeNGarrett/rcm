<?php

/**
 * Extend HM Backup with scheduling and backup file management
 *
 * @extends HM_Backup
 */
class HMBKP_Scheduled_Backup extends HM_Backup {

	/**
	 * The unique schedule id
	 *
	 * @var string
	 * @access private
	 */
	private $id = '';

	/**
	 * The slugified version of the schedule name
	 *
	 * @var string
	 * @access private
	 */
	private $slug = '';

	/**
	 * The raw schedule options from the database
	 *
	 * @var array
	 * @access private
	 */
	private $options = array();

	/**
	 * The schedule start time
	 *
	 * (default value: current_time( 'timestamp' ))
	 *
	 * @var mixed
	 * @access private
	 */
	private $schedule_start_time = 0;

	/**
	 * Setup the schedule object
	 * Loads the options from the database and populates properties
	 *
	 * @param string $id
	 * @throws Exception
	 */
	public function __construct( $id ) {

		// Verify the schedule id
		if ( ! is_string( $id ) || ! trim( $id ) )
			throw new Exception( 'Argument 1 for ' . __METHOD__ . ' must be a non empty string' );

		// Setup HM Backup
		parent::__construct();

		// Store id for later
		$this->id = $id;

		// Load the options
		$this->options = array_filter( (array) get_option( 'hmbkp_schedule_' . $this->get_id() ) );

		// Some properties can be overridden with defines
		if ( defined( 'HMBKP_ROOT' ) && HMBKP_ROOT )
			$this->set_root( HMBKP_ROOT );

		if ( defined( 'HMBKP_PATH' ) && HMBKP_PATH )
			$this->set_path( HMBKP_PATH );

		if ( defined( 'HMBKP_EXCLUDE' ) && HMBKP_EXCLUDE )
			parent::set_excludes( HMBKP_EXCLUDE, true );

		parent::set_excludes($this->default_excludes(), true );

		if ( defined( 'HMBKP_MYSQLDUMP_PATH' ) )
			$this->set_mysqldump_command_path( HMBKP_MYSQLDUMP_PATH );

		if ( defined( 'HMBKP_ZIP_PATH' ) )
			$this->set_zip_command_path( HMBKP_ZIP_PATH );

		if ( defined( 'HMBKP_ZIP_PATH' ) && HMBKP_ZIP_PATH === 'PclZip' && $this->skip_zip_archive = true )
			$this->set_zip_command_path( false );

		// Set the path - TODO remove external function dependancy
		$this->set_path( hmbkp_path() );

		$hmbkp_schedules = $this->get_cron_schedules();

		// Set the archive filename to site name + schedule slug + date
		$this->set_archive_filename( implode( '-', array( sanitize_title( str_ireplace( array( 'http://', 'https://', 'www' ), '', home_url() ) ), $this->get_id(), $this->get_type(), date( 'Y-m-d-H-i-s', current_time( 'timestamp' ) ) ) ) . '.zip' );
		$this->set_database_dump_filename( implode( '-', array( sanitize_title( str_ireplace( array( 'http://', 'https://', 'www' ), '', home_url() ) ), $this->get_id(), $this->get_type(), date( 'Y-m-d-H-i-s', current_time( 'timestamp' ) ) ) ) . '.sql' );

		// Setup the schedule if it isn't set
		if ( ( ! $this->get_next_occurrence() && in_array( $this->get_reoccurrence(), array_keys(  $hmbkp_schedules ) ) ) || ( date( get_option( 'time_format' ), strtotime( HMBKP_SCHEDULE_TIME ) - ( get_option( 'gmt_offset' ) * 3600 ) ) !== date( get_option( 'time_format' ), $this->get_next_occurrence() ) ) )
			$this->schedule();

	}

	/**
	 * Get the id for this schedule
	 *
	 * @access public
	 */
	public function get_id() {
		return esc_attr( $this->id );
	}

	/**
	 * Get a slugified version of name
	 *
	 * @access public
	 */
	public function get_slug() {

		// We cache slug in $this to save expensive calls to sanitize_title
		if ( isset( $this->slug ) )
			return $this->slug;

		return $this->slug = sanitize_title( $this->get_name() );

	}

	/**
	 * Get the name of this backup schedule
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {

		$reoccurence = ( 'manually' === $this->get_reoccurrence() ) ? $this->get_reoccurrence() : substr( $this->get_reoccurrence(), 6 );

		return ucwords( $this->get_type() ) . ' ' . $reoccurence;

	}

	/**
	 * Get the type of backup
	 *
	 * @access public
	 * @return string
	 */
	public function get_type() {

		if ( empty( $this->options['type'] ) )
			$this->set_type( 'complete' );

		return $this->options['type'];

	}

	/**
	 * Set the type of backup
	 *
	 * @access public
	 * @param string $type
	 */
	public function set_type( $type ) {

		if ( isset( $this->options['type'] ) && $this->options['type'] === $type )
			return;

		parent::set_type( $type );

		$this->options['type'] = $type;

		$this->clear_filesize_cache();

	}

	/**
	 * Get the exclude rules
	 *
	 * @access public
	 * @return array
	 */
	public function get_excludes() {

		if ( ! empty( $this->options['excludes'] ) )
			parent::set_excludes( $this->options['excludes'] );

		return parent::get_excludes();

	}

	/**
	 * Set the exclude rules
	 *
	 * @access public
	 * @param mixed $excludes A comma separated list or array of exclude rules
	 * @param bool $append Whether to replace or append to existing rules
	 * @return string
	 */
	public function set_excludes( $excludes, $append = false ) {

		// Use the validation from HM_Backup::set_excludes
		parent::set_excludes( $excludes, $append );

		// If these are valid excludes and they are different save them
		if ( parent::get_excludes() && ( empty( $this->options['excludes'] ) || $this->options['excludes'] !== parent::get_excludes() ) ) {

			$this->options['excludes'] = $append && ! empty( $this->options['excludes'] ) ? array_merge( (array) $this->options['excludes'], parent::get_excludes() ) : parent::get_excludes();;

			parent::set_excludes( $this->options['excludes'] );

			$this->clear_filesize_cache();

		}

	}

	/**
	 * Get the maximum number of backups to keep
	 *
	 * @access public
	 */
	public function get_max_backups() {

		if ( empty( $this->options['max_backups'] ) )
			$this->set_max_backups( 10 );

		return (int) esc_attr( $this->options['max_backups'] );

	}

	/**
	 * Set the maximum number of backups to keep
	 *
	 * @param int $max
	 * @throws Exception
	 */
	public function set_max_backups( $max ) {

		if ( empty( $max ) || ! is_int( $max ) )
			throw new Exception( 'Argument 1 for ' . __METHOD__ . ' must be a valid integer' );

		$this->options['max_backups'] = $max;

	}

	/**
	 * Get the array of services options for this schedule
	 *
	 * @param      $service
	 * @param null $option
	 * @return array
	 */
	public function get_service_options( $service, $option = null ) {

		if ( ! is_null( $option ) ) {

			if ( isset( $this->options[$service][$option] ) )
				return $this->options[$service][$option];

			return array();

		}

		if ( isset( $this->options[$service] ) )
			return $this->options[$service];

		return array();

	}

	/**
	 * Set the service options for this schedule
	 *
	 * @access public
	 */
	public function set_service_options( $service, Array $options ) {

		$this->options[$service] = $options;

	}

	/**
	 * Calculate the size of the backup
	 *
	 * Doesn't account for
	 * compression
	 *
	 * @access public
	 * @param bool $cached Whether to return from cache
	 * @return string
	 */
	public function get_filesize( $cached = true ) {

		$filesize = 0;
		
		if ( $cached ) {

			// Check if we have the filesize in the cache
			$filesize = get_transient( 'hmbkp_schedule_' . $this->get_id() . '_filesize' );

			// If we do and it's not still calculating then return it straight away
			if ( $filesize && $filesize !== 'calculating' )
				return $filesize;

			// If the filesize is calculating in another thread then we should wait for it to finish
			if ( $filesize === 'calculating' ) {

				global $wpdb;

				$counter = 1;

				// Keep checking the cached filesize to see if the other thread is finished
				while ( 'calculating' === ( $filesize = $wpdb->get_var( "SELECT option_value FROM $wpdb->options WHERE option_name = '_transient_hmbkp_schedule_" . $this->get_id() . "_filesize'" ) ) ) {

					// Check once every 10 seconds
					sleep( 10 );

					// Only run for a maximum of 5 minutes (30*10)
					if ( $counter === 30 )
						break;

					$counter++;

				}

				// If we have the filesize then return it
				if ( $filesize && $filesize !== 'calculating' )
					return $filesize;

			}

		}

		// If we don't have it in cache then mark it as calculating
		set_transient( 'hmbkp_schedule_' . $this->get_id() . '_filesize', 'calculating', time() + HOUR_IN_SECONDS );

    	// Don't include database if file only
		if ( $this->get_type() != 'file' ) {

    		global $wpdb;

    		$res = $wpdb->get_results( 'SHOW TABLE STATUS FROM `' . DB_NAME . '`', ARRAY_A );

    		foreach ( $res as $r )
    			$filesize += (float) $r['Data_length'];

    	}

    	// Don't include files if database only
   		if ( $this->get_type() != 'database' ) {

    		// Get rid of any cached filesizes
    		clearstatcache();

			$excludes = $this->exclude_string( 'regex' );

			foreach ( $this->get_files() as $file ) {

				// Skip dot files, they should only exist on versions of PHP between 5.2.11 -> 5.3
				if ( method_exists( $file, 'isDot' ) && $file->isDot() )
					continue;

				if ( ! @realpath( $file->getPathname() ) || ! $file->isReadable() )
					continue;

			    // Excludes
			    if ( $excludes && preg_match( '(' . $excludes . ')', str_ireplace( trailingslashit( $this->get_root() ), '', HM_Backup::conform_dir( $file->getPathname() ) ) ) )
			        continue;

			    $filesize += (float) $file->getSize();

			}

		}

		// Cache for a day
		set_transient( 'hmbkp_schedule_' . $this->get_id() . '_filesize', $filesize, time() + DAY_IN_SECONDS );

	    return $filesize;

	}

	/**
	 * Convenience function to format the file size
	 *
	 * @param bool $cached
	 * @return bool|string
	 */
	public function get_formatted_file_size( $cached = true ){

		return size_format( $this->get_filesize( $cached ) );
	}

	/**
	 * Check whether the filesize has already been calculated and cached.
	 *
	 * @access public
	 * @return bool
	 */
	public function is_filesize_cached() {

		$size = get_transient( 'hmbkp_schedule_' . $this->get_id() . '_filesize' );

		return ! ( ! $size || $size === 'calculating' );

	}

	/**
	 * Clear the cached filesize, forces the filesize to be re-calculated the next
	 * time get_filesize is called
	 *
	 * @access public
	 * @return void
	 */
	public function clear_filesize_cache() {
		delete_transient( 'hmbkp_schedule_' . $this->get_id() . '_filesize' );
	}

	/**
	 * Get the start time for the schedule
	 *
	 * @access public
	 * @return int timestamp || 0 for manual only schedules
	 */
	public function get_schedule_start_time() {

		if ( $this->get_reoccurrence() === 'manually' )
			return 0;

		if ( empty( $this->schedule_start_time ) ) {

			if ( defined( 'HMBKP_SCHEDULE_TIME' ) && HMBKP_SCHEDULE_TIME )
				$date = strtotime( HMBKP_SCHEDULE_TIME );

			else
				$date = strtotime( '11pm' );

			// Convert to UTC
			$date -= get_option( 'gmt_offset' ) * 3600;

			// if the scheduled time already passed today then start at the next interval instead
			if ( $date <= strtotime( 'now' ) )
				$date += $this->get_interval();

			$this->set_schedule_start_time( $date );
		}

		return $this->schedule_start_time;

	}

	/**
	 * Set the schedule start time.
	 *
	 * @access public
	 * @param int $timestamp in UTC
	 * @return void
	 */
	public function set_schedule_start_time( $timestamp ) {
		$this->schedule_start_time = $timestamp;
	}

	/**
	 * Get the schedule reoccurrence
	 *
	 * @access public
	 */
	public function get_reoccurrence() {

		// Default to no reoccurrence
		if ( empty( $this->options['reoccurrence'] ) )
			$this->set_reoccurrence( 'manually' );

		return $this->options['reoccurrence'];

	}

	/**
	 * Set the schedule reoccurrence
	 *
	 * @param string $reoccurrence
	 * @throws Exception
	 */
	public function set_reoccurrence( $reoccurrence ) {

		$hmbkp_schedules = $this->get_cron_schedules();

		// Check it's valid
		if ( ! is_string( $reoccurrence ) || ! trim( $reoccurrence ) || ( ! in_array( $reoccurrence, array_keys( $hmbkp_schedules ) ) ) && $reoccurrence !== 'manually' )
			throw new Exception( 'Argument 1 for ' . __METHOD__ . ' must be a valid cron reoccurrence or "manually"' );

		if ( isset( $this->options['reoccurrence'] ) && $this->options['reoccurrence'] === $reoccurrence )
			return;

		$this->options['reoccurrence'] = $reoccurrence;

		if ( $reoccurrence === 'manually' )
			$this->unschedule();

		else
			$this->schedule();

	}

	/**
	 * Get the interval between backups
	 *
	 * @access public
	 * @return int
	 */
	public function get_interval() {

		$hmbkp_schedules = $this->get_cron_schedules();

		if ( $this->get_reoccurrence() === 'manually' )
			return 0;

		return $hmbkp_schedules[$this->get_reoccurrence()]['interval'];

	}

	/**
	 * Return an array of BackUpWordPress cron schedules
	 *
	 * @return array
	 */
	public function get_cron_schedules(){

		$schedules = wp_get_schedules();

		// remove any schedule whose key is not prefixed with 'hmbkp_'
		foreach ( $schedules as $key => $arr ) {
			if( ! preg_match("/^hmbkp_/", $key ) )
				unset( $schedules[$key] );
		}

		return $schedules;
	}

	/**
	 * Get the next occurrence of this scheduled backup
	 *
	 * @access public
	 */
	public function get_next_occurrence( $gmt = true ) {

		$time = wp_next_scheduled( 'hmbkp_schedule_hook', array( 'id' => $this->get_id() ) );

		if ( ! $time )
			$time = 0;

		if ( ! $gmt )
			$time += get_option( 'gmt_offset' ) * 3600;

		return $time;

	}


	/**
	 * Get the path to the backup running file that stores the running backup status
	 *
	 * @access private
	 * @return string
	 */
	private function get_schedule_running_path() {
		return $this->get_path() . '/.schedule-' . $this->get_id() . '-running';
	}

	/**
	 * Schedule the backup cron
	 *
	 * @access public
	 */
	public function schedule() {

		// Clear any existing hooks
		$this->unschedule();

		wp_schedule_event( $this->get_schedule_start_time(), $this->get_reoccurrence(), 'hmbkp_schedule_hook', array( 'id' => $this->get_id() ) );

	}


	/**
	 * Unschedule the backup cron.
	 *
	 * @access public
	 * @return void
	 */
	public function unschedule() {
		wp_clear_scheduled_hook( 'hmbkp_schedule_hook', array( 'id' => $this->get_id() ) );
	}

	/**
	 * Run the backup
	 *
	 * @access public
	 */
	public function run() {

		// Don't run if this schedule is already running
		if ( $this->get_running_backup_filename() )
			return;

		// Mark the backup as started
		$this->set_status( __( 'Starting Backup', 'hmbkp' ) );

		// Delete old backups now in-case we fatal error during the backup process
		$this->delete_old_backups();

		$this->backup();

		// Delete the backup running file
		if ( file_exists( $this->get_schedule_running_path() ) )
			unlink( $this->get_schedule_running_path() );

		// Delete old backups again
		$this->delete_old_backups();

	}

	/**
	 * Get the status of the running backup.
	 *
	 * @access public
	 * @return string
	 */
	public function get_status() {

		if ( ! file_exists( $this->get_schedule_running_path() ) )
			return '';

		$status = explode( '::', file_get_contents( $this->get_schedule_running_path() ) );

		return end( $status );

	}

	/**
	 * Get the filename that the running status is stored in.
	 *
	 * @access public
	 * @return string
	 */
	public function get_running_backup_filename() {

		if ( ! file_exists( $this->get_schedule_running_path() ) )
			return '';

		$backup_running_file = explode( '::', file_get_contents( $this->get_schedule_running_path() ) );

		return reset( $backup_running_file );
	}

	/**
	 * Set the status of the running backup
	 *
	 * @access public
	 * @param string $message
	 * @return void
	 */
	public function set_status( $message ) {

		if ( ! $handle = fopen( $this->get_schedule_running_path(), 'w' ) )
			return;

		fwrite( $handle, $this->get_archive_filename() . '::' . $message );

		fclose( $handle );

	}

	/**
	 * Hook into the actions fired in HM Backup and set the status
	 * @param $action
	 */
	protected function do_action( $action ) {

		switch ( $action ) :

	    	case 'hmbkp_mysqldump_started' :

	    		$this->set_status( sprintf( __( 'Dumping Database %s', 'hmbkp' ), '(<code>' . $this->get_mysqldump_method() . '</code>)' ) );

	    	break;

	    	case 'hmbkp_mysqldump_verify_started' :

	    		$this->set_status( sprintf( __( 'Verifying Database Dump %s', 'hmbkp' ), '(<code>' . $this->get_mysqldump_method() . '</code>)' ) );

	    	break;

			case 'hmbkp_archive_started' :

	    		$this->set_status( sprintf( __( 'Creating zip archive %s', 'hmbkp' ), '(<code>' . $this->get_archive_method() . '</code>)' ) );

	    	break;

	    	case 'hmbkp_archive_verify_started' :

	    		$this->set_status( sprintf( __( 'Verifying Zip Archive %s', 'hmbkp' ), '(<code>' . $this->get_archive_method() . '</code>)' ) );

	    	break;

	    	case 'hmbkp_backup_complete' :

	    		$this->set_status( __( 'Finishing Backup', 'hmbkp' ) );

	    	break;

	    	case 'hmbkp_error' :

				if ( $this->get_errors() ) {

			    	$file = $this->get_path() . '/.backup_errors';

					if ( file_exists( $file ) )
						@unlink( $file );

			    	if ( ! $handle = @fopen( $file, 'w' ) )
			    		return;

					fwrite( $handle, json_encode( $this->get_errors() ) );

			    	fclose( $handle );

			    }

			break;

			case 'hmbkp_warning' :

			    if ( $this->get_warnings() ) {

					$file = $this->get_path() . '/.backup_warnings';

					if ( file_exists( $file ) )
			  			@unlink( $file );

					if ( ! $handle = @fopen( $file, 'w' ) )
			  	  		return;

			  		fwrite( $handle, json_encode( $this->get_warnings() ) );

					fclose( $handle );

				}

	    	break;

	    endswitch;

	    // Pass the actions to all the services
	    foreach ( HMBKP_Services::get_services( $this ) as $service )
	    	$service->action( $action );

	    // Fire the parent function as well
	    parent::do_action( $action );

	}

	/**
	 * Get the backups created by this schedule
	 *
	 * @todo look into using recursiveDirectoryIterator and recursiveRegexIterator
	 * @access public
	 * @return string[] - file paths of the backups
	 */
	public function get_backups() {

		$files = array();

		if ( $handle = @opendir( $this->get_path() ) ) {

			while ( false !== ( $file = readdir( $handle ) ) )
				if ( pathinfo( $file, PATHINFO_EXTENSION ) === 'zip' && strpos( $file, $this->get_id() ) !== false && $this->get_running_backup_filename() != $file )
		     		$files[@filemtime( trailingslashit( $this->get_path() ) . $file )] = trailingslashit( $this->get_path() ) . $file;

			closedir( $handle );

		}

		krsort( $files );

		return $files;

	}

	/**
	 * Delete old backups
	 *
	 * @access private
	 */
	public function delete_old_backups() {

		if ( count( $this->get_backups() ) <= $this->get_max_backups() )
	   		return;

		array_map( array( $this, 'delete_backup' ), array_slice( $this->get_backups(), $this->get_max_backups() ) );

	}

	/**
	 * Delete a specific back up file created by this schedule
	 *
	 * @param string $filepath
	 * @throws Exception
	 */
	public function delete_backup( $filepath ) {

		// Check that it's a valid filepath
		if ( empty( $filepath ) || ! is_string( $filepath ) )
			throw new Exception( 'Argument 1 for ' . __METHOD__ . ' must be a non empty string' );

		// Make sure it exists
		if ( ! file_exists( $filepath ) )
			throw new Exception( $filepath . ' doesn\'t exist' );

		// Make sure it was created by this schedule
		if ( strpos( $filepath, $this->get_id() ) === false )
			throw new Exception( 'That backup wasn\'t created by this schedule' );

		unlink( $filepath );

	}

	/**
	 * Delete all back up files created by this schedule
	 *
	 * @access public
	 */
	public function delete_backups() {

		array_map( array( $this, 'delete_backup' ), $this->get_backups() );

	}

	/**
	 * Save the schedules options.
	 *
	 * @access public
	 */
	public function save() {

		// Only save them if they have changed
		if ( $this->options !== get_option( 'hmbkp_schedule_' . $this->get_id() ) )
			update_option( 'hmbkp_schedule_' . $this->get_id(), $this->options );

	}

	/**
	 * Cancel this schedule
	 *
	 * Cancels the cron job, removes the schedules options
	 * and optionally deletes all backups crated by
	 * this schedule.
	 *
	 * @access public
	 */
	public function cancel() {

		// Delete the schedule options
		delete_option( 'hmbkp_schedule_' . $this->get_id() );

		// Clear any existing schedules
		$this->unschedule();

		// Clear the filesize transient
		$this->clear_filesize_cache();

		// Delete it's backups
		$this->delete_backups();

	}

	/**
	 * Sets the default excluded folders fr a schedule
	 *
	 * @return Array
	 */
	public function default_excludes() {

		$excluded = array();

		// updraftplus plugin
		if ( is_dir( trailingslashit( WP_CONTENT_DIR ) . 'updraft' ) ) {
			$excluded[] = trailingslashit( WP_CONTENT_DIR ) . 'updraft';
		}

		//wponlinebackup plugin
		if ( is_dir( trailingslashit( WP_CONTENT_DIR ) . 'backups' ) ) {
			$excluded[] = trailingslashit( WP_CONTENT_DIR ) . 'backups';
		}

		//duplicator plugin
		if ( is_dir( trailingslashit( ABSPATH ) . 'wp-snapshots' ) ) {
			$excluded[] = trailingslashit( ABSPATH ) . 'wp-snapshots';
		}

		if ( defined( 'WP_BACKUP_DIR' ) && is_dir( WP_BACKUP_DIR ) )
			$excluded[] = WP_BACKUP_DIR;

		// version control dirs
		$excluded[] = '.svn/';
		$excluded[] = '.git/';

		return apply_filters( 'hmbkp_default_excludes', $excluded );
	}

}