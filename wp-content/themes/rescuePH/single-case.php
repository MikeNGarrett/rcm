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

			<div id="content" class="row">

				<div id="inner-content" class="col-md-9">
					<!-- Changed to full width -->
						<div id="main" class="twelvecol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">


                                <header class="article-header">
									<div class="single-title custom-post-type-title">
                                        <div class="date">
										<a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
                                        <?php if($status = get_field('status')) { ?>
                                            <?php
                                            foreach ($status as $term) {
                                                $term_link = get_term_link( $term, 'status' );
                                                if( is_wp_error( $term_link ) )
                                                    continue;
                                                echo ' - <a href="' . $term_link . '">' . $term->name . '</a>';
                                            }
                                            ?>
                                        <?php } ?>
									</div>
                                    </div>
								</header>



                                <section class="entry-content clearfix">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h1><?php the_title(); ?></h1>
                                    </div>
                                    <div class="panel-body">
                                        <!--<h1><?php /*the_title(); */?></h1>-->
                                        <?php if(has_post_thumbnail()) { ?>
                                            <?php the_post_thumbnail(array(150,150)); ?>
                                        <?php } else { ?>
                                            <!--<img src="http://placehold.it/150&text=No+Image" alt="">-->
                                        <?php } ?>
                                        <?php if($summary = get_field('summary')) { ?>
                                            <?php echo $summary; ?>
                                            <hr>
                                        <?php } ?>
<!--
								<section class="case-details">
									<div class="case-status">
										<?php /*$priority = get_field('priority'); */?>
										<div class="priority <?php /*echo $priority[0]->slug; */?>">
											<?php /*echo $priority[0]->name; */?>
										</div>

										<?php /*$status = get_field('status'); */?>
										<div class="status <?php /*echo $status[0]->slug; */?>">
											<?php /*echo $status[0]->name; */?>
										</div>
									</div>
								</section>-->


									<?php if($priority = get_field('priority')) { ?>
										<h4>Priority</h4>
										<?php
										echo '<ul class="list-group">';
										foreach ($priority as $term) {
										    $term_link = get_term_link( $term, 'priority' );
										    if( is_wp_error( $term_link ) )
										        continue;
										    echo '<li class="list-group-item"><a href="' . $term_link . '">' . $term->name . '</a></li>';
										}
										echo '</ul>'; ?>
									<?php } ?>


									<?php if($type = get_field('type')) { ?>
										<h4>Type</h4>
										<?php
										echo '<ul class="list-group">';
										foreach ($type as $term) {
										    $term_link = get_term_link( $term, 'type' );
										    if( is_wp_error( $term_link ) )
										        continue;
										    echo '<li class="list-group-item"><a href="' . $term_link . '">' . $term->name . '</a></li>';
										}
										echo '</ul>'; ?>
									<?php } ?>


									<h2>Request made by</h2>
                                        <?php if($requester_name = get_field('requester_name')) { ?>
                                        <div class="row">
                                            <h4 class="col-md-6">Name</h4>
                                            <div class="col-md-6"><?php echo $requester_name; ?></div>
                                        </div>
                                        <?php } ?>

                                        <?php if($requester_contact_info = get_field('requester_contact_info')) { ?>
                                            <div class="row">
                                            <h4 class="col-md-6">Contact Information</h4>
                                            <div class="col-md-6"><?php echo $requester_contact_info; ?></div>
                                            </div>
                                        <?php } ?>

                                        <?php if($request_source = get_field('request_source')) { ?>
                                                <div class="row">
                                                    <h4 class="col-md-6">Request Source</h4>
                                                    <ul class="col-md-6"><?php
                                                    foreach ($request_source as $source) {
                                                        echo '<li>' . $source . '</li>';
                                                    }
                                                    ?></ul>
                                                </div>
                                        <?php } ?>
                                    </div>
                                </div>

									<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
									<? if($type[0]->slug == 'rescue') { ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h1>Assistance Request Information</h1>
                                            </div>
                                            <div class="panel-body">

										<?php if($name = get_field('name')) { ?>
                                            <div class="row">
											<h4 class="col-md-6">Name</h4>
                                            <div class="col-md-6"><?php echo $name; ?></div>
                                            </div>
										<?php } ?>

										<?php if($contact = get_field('contact')) { ?>
                                            <div class="row">
											<h4 class="col-md-6">Contact Information</h4>
                                            <div class="col-md-6"><?php echo $contact; ?></div>
                                            </div>
										<?php } ?>

										<?php if($rescue_location = get_field('request_location')) { ?>
                                            <div class="row">
											<h4 class="col-md-6">Location</h4>
                                            <div class="col-md-6"><?php echo $rescue_location['address']; ?></div>
                                            </div>
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
                                </div>
                        </div>
									<?php } // End check for rescue type ?>


									<? if($type[0]->slug == 'tracing') { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h1>Tracing Request Information</h1>
                                        </div>
                                        <div class="panel-body">
										<?php if($tracing_name = get_field('tracing_name')) { ?>
                                            <div class="row">
                                                <h4 class="col-md-6">Name of Missing Person</h4>
                                                <div class="col-md-6"><?php echo $tracing_name; ?></div>
                                            </div>
										<?php } ?>
										<?php if($tracing_location = get_field('tracing_location')) { ?>
                                            <div class="row">
                                                <h4 class="col-md-6">Last Seen</h4>
                                                <div class="col-md-6"><?php echo $tracing_location['address']; ?></div>
                                            </div>
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
                                        </div>
                                    </div>
									<?php  } // End check for tracing type ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h2>More details</h2>
                                            </div>
                                            <div class="panel-body">
                                                <?php the_content(); ?>
                                            </div>
                                        </div>
								</section>

								<footer class="article-footer">

								</footer>

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <?php comments_template(); ?>
                                    </div>
                                </div>

							</article>

							<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
										<!-- Amended Not Found Messages -->
											<h1><?php _e( 'Case Not Found!', 'ResuePH' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Something is missing. Try double checking things.', 'ResuePH' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'ResuePH' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

						<!-- Removed Sidebar	<?php get_sidebar(); ?> -->

				</div>
                <div class="col-md-3">
                    <div class="priority <?php echo $priority[0]->slug; ?>">
                        <?php echo $priority[0]->name; ?>
                    </div>

                    <div class="status <?php echo $status[0]->slug; ?>">
                        <?php echo $status[0]->name; ?>
                    </div>
                    <?php //get_sidebar();
                        ?>
                </div>

			</div>

<?php get_footer(); ?>
