<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<header class="article-header">

									<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'bonestheme' ) ), bones_get_the_author_posts_link());
									?></p>

								</header>

								<section class="entry-content clearfix">

									<h2>Status</h2>
									<?php echo get_the_term_list( $post->ID, 'status', ' ', ', ', '' ); ?>
									<h2>Priority</h2>
									<?php echo get_the_term_list( $post->ID, 'priority', ' ', ', ', '' ); ?>
									<h2>Type</h2>
									<?php echo get_the_term_list( $post->ID, 'type', ' ', ', ', '' ); ?>
									<?php
									print '<h2>Name</h2>';
									the_field('name');
									print '<h2>Contact Info</h2>';
									the_field('contact_info');
									print '<h2>Request Source</h2>';
									the_field('request_source');
									print '<h2>Location</h2>'; ?>
									<?php $location = get_field('request_location'); ?>
									<?php echo $location['address']; ?>
									<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
									<script>
									    var map;
									    var myLatLang = new google.maps.LatLng( <?php echo $location['coordinates']; ?>);
									    function initialize() {
									        var mapOptions = {
									            zoom: 6,
									            center: myLatLang,
									            mapTypeId: google.maps.MapTypeId.ROADMAP
									        };
									        map = new google.maps.Map(document.getElementById('map-canvas'),
									        mapOptions);
									        var marker = new google.maps.Marker({
									            position: myLatLang,
									            map: map,
									            title:"Location"
									        });
									    };
									    google.maps.event.addDomListener(window, 'load', initialize);
									</script>
									<div id="map-canvas"></div>
									<?php if($tracing = get_field('tracing_information')) {
										print '<h2>Tracing Information</h2>';
										print $tracing;
									} ?>
									<h2>More details</h2>
									<?php the_content(); ?>

								</section>

								<footer class="article-footer">

								</footer>

								<?php comments_template(); ?>

							</article>

							<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

						<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
