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

									<?php if($summary = get_field('summary')) { ?>
										<h2>Summary</h2>
										<?php echo $summary; ?>
									<?php } ?>
									<?php if($status = get_field('status')) { ?>
										<h2>Status</h2>
										<?php
										echo '<ul>';
										foreach ($status as $term) {
										    $term_link = get_term_link( $term, 'status' );
										    if( is_wp_error( $term_link ) )
										        continue;
										    echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
										}
										echo '</ul>'; ?>
									<?php } ?>
									<?php if($priority = get_field('priority')) { ?>
										<h2>Priority</h2>
										<?php
										echo '<ul>';
										foreach ($priority as $term) {
										    $term_link = get_term_link( $term, 'priority' );
										    if( is_wp_error( $term_link ) )
										        continue;
										    echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
										}
										echo '</ul>'; ?>
									<?php } ?>
									<?php if($type = get_field('type')) { ?>
										<h2>Type</h2>
										<?php
										echo '<ul>';
										foreach ($type as $term) {
										    $term_link = get_term_link( $term, 'type' );
										    if( is_wp_error( $term_link ) )
										        continue;
										    echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
										}
										echo '</ul>'; ?>
									<?php } ?>


									<h1>Request made by</h1>
									<?php if($requester_name = get_field('requester_name')) { ?>
										<h2>Name</h2>
										<?php echo $requester_name; ?>
									<?php } ?>
									<?php if($requester_contact_info = get_field('requester_contact_info')) { ?>
										<h2>Contact Information</h2>
										<?php echo $requester_contact_info; ?>
									<?php } ?>
									<?php if($request_source = get_field('request_source')) { ?>
										<h2>Request Source</h2>
										<?php echo $request_source; ?>
									<?php } ?>


									<? if($type[0]->slug == 'rescue') { ?>
										<h1>Assistance Request Information</h1>
										<?php if($name = get_field('name')) { ?>
											<h2>Name</h2>
											<?php echo $name; ?>
										<?php } ?>
										<?php if($contact = get_field('contact')) { ?>
											<h2>Contact Information</h2>
											<?php echo $contact; ?>
										<?php } ?>
										<?php if($rescue_location = get_field('request_location')) { ?>
											<h2>Location</h2>
											<?php echo $rescue_location['address']; ?>
											<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
											<script>
											    var map;
											    var myLatLang = new google.maps.LatLng( <?php echo $rescue_location['coordinates']; ?>);
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
											            title:"Rescue Location"
											        });
											    };
											    google.maps.event.addDomListener(window, 'load', initialize);
											</script>
											<div id="map-canvas"></div>
										<?php } // End Rescue location ?>
									<?php } // End check for rescue type ?>
									<? if($type[0]->slug == 'tracing') { ?>
										<h1>Tracing Request Information</h1>
										<?php if($tracing_name = get_field('tracing_name')) { ?>
											<h2>Name of Missing Person</h2>
											<?php echo $tracing_name; ?>
										<?php } ?>
										<?php if($tracing_location = get_field('tracing_location')) { ?>
											<h2>Last Seen</h2>
											<?php echo $tracing_location['address']; ?>
											<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
											<script>
											    var map;
											    var myLatLang = new google.maps.LatLng( <?php echo $tracing_location['coordinates']; ?>);
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
											            title:"Last Seen Location"
											        });
											    };
											    google.maps.event.addDomListener(window, 'load', initialize);
											</script>
											<div id="map-canvas"></div>
										<?php } // End Tracing location ?>
										<?php if($tracing_information = get_field('tracing_information')) { ?>
											<h2>Additional Information</h2>
											<?php echo $tracing_information; ?>
										<?php } ?>
									<?php } // End check for tracing type ?>

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
