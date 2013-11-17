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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<div id="content">

<<<<<<< HEAD
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

<<<<<<< HEAD
										<?php $status = get_field('status'); ?>
										<?php $t = get_the_title(); ?>
										<div class="status <?php echo $status[0]->slug; ?>">
											<?php echo $status[0]->name; ?>
=======
										<?php /*$status = get_field('status'); */?>
										<div class="status <?php /*echo $status[0]->slug; */?>">
											<?php /*echo $status[0]->name; */?>
>>>>>>> master
										</div>
										<div class="map" id="loc" style="height:200px; width:200px">
										</div>
										<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
											<script>
											    var map;
											    var myLatLang = new google.maps.LatLng( <?php the_field('wp_gp_latitude'); ?> , <?php the_field('wp_gp_longitude'); ?>);
											    var myPinColor = "FE7569";
												var nearbyPinColor = "FEB869";

											    function getIcon(pinColor) {
											    	return new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
											            new google.maps.Size(21, 34),
											            new google.maps.Point(0,0),
											            new google.maps.Point(10, 34));
											    }

											    function initialize() {
											        var mapOptions = {
											            zoom: 6,
											            center: myLatLang,
											            mapTypeId: google.maps.MapTypeId.ROADMAP
											        };
											        map = new google.maps.Map(document.getElementById('loc'),
											        mapOptions);
											        
											        var marker = new google.maps.Marker({
											            position: myLatLang,
											            map: map,
											            icon: getIcon(myPinColor),
											            title: <?php echo '"'.$t.'"'?>,
											        });
											        
											        <?php
											        ob_start();
													$query = new WP_GeoQuery(array(
													  'latitude' => the_field('wp_gp_latitude'), // Post's Latitude (optional)
													  'longitude' => the_field('wp_gp_longitude'),// Post's Longitude (optional)
													  'radius' => 50, // Radius to select for in miles (optional)
													  'posts_per_page' => 50, // Any regular options available via WP_Query
													)); 
													$throwAway = ob_get_contents();
													ob_end_clean();
													?>
													var nearbyIcon = getIcon(nearbyPinColor);
													<?php 
													$i =0; 
													foreach($query->posts as $near) :?>
													<?php if(get_post_meta( $near->ID, "wp_gp_latitude", true ) && $near->post_title != $t) :?>
								var marker<?php echo $i; ?> = new google.maps.Marker({
														position: 	new google.maps.LatLng( <?php  echo get_post_meta( $near->ID, "wp_gp_latitude", true )?> , <?php echo get_post_meta( $near->ID, "wp_gp_longitude", true ); ?>),
														map : map,
														icon: nearbyIcon,
														title: <?php echo '"'.$near->post_title.'"'; ?>
													});
													<?php $i=$i+1; ?>
													<?php endif ?>
													<?php endforeach ?>
											    };

											    google.maps.event.addDomListener(window, 'load', initialize);
											</script>
										
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

<<<<<<< HEAD

<<<<<<< HEAD
									<?php if($type[0]->slug == 'rescue') { ?>
										<h1>Assistance Request Information</h1>
=======
=======
									<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
>>>>>>> 67bb9798fba544b2a70a3a5eece7558aa99382f2
									<? if($type[0]->slug == 'rescue') { ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h1>Assistance Request Information</h1>
                                            </div>
                                            <div class="panel-body">

>>>>>>> master
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
<<<<<<< HEAD
									
									<?php if($type[0]->slug == 'tracing') { ?>
										<h1>Tracing Request Information</h1>
=======


									<? if($type[0]->slug == 'tracing') { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h1>Tracing Request Information</h1>
                                        </div>
                                        <div class="panel-body">
>>>>>>> master
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
=======
	<div id="inner-content" class="wrap clearfix">
		<div id="main" class="twelvecol first clearfix" role="main">
>>>>>>> 735ff86aa39bd2f2a39887703c398b81ce4f1ff8

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
					<header class="article-header">
						<div class="single-title custom-post-type-title">
							<div class="date">
								<a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
								<?php if ($status = get_field('status')) {
									foreach ($status as $term) {
										$term_link = get_term_link( $term, 'status' );
										if ( is_wp_error( $term_link ) ) { continue; }
										echo ' - <a href="' . $term_link . '">' . $term->name . '</a>';
									}
								} ?>
							</div>

							<h1><?php the_title(); ?></h1>

							<?php if (has_post_thumbnail()) {
								the_post_thumbnail(array(150, 150));
							} else { ?>
								<img src="http://placehold.it/150&text=No+Image" alt="">
							<?php } ?>

							<?php if ($summary = get_field('summary')) { ?>
								<h2><?php echo $summary; ?></h2>
							<?php } ?>
						</div>
					</header>

					<section class="case-details">
						<div class="case-status">
							<?php $priority = get_field('priority');
							 $status = get_field('status');
							 $t = get_the_title(); ?>

							<div class="priority <?php echo $priority[0]->slug; ?>">
								<?php echo $priority[0]->name; ?>
							</div>

							<div class="status <?php echo $status[0]->slug; ?>">
								<?php echo $status[0]->name; ?>
							</div>

							<div class="map" id="loc" style="height:400px; width:400px">
							</div>

							<script>
								function createPinIcon(pinColor) {
									return new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
									new google.maps.Size(21, 34),
									new google.maps.Point(0,0),
									new google.maps.Point(10, 34));
								}

								var map;
								var myLatLang = new google.maps.LatLng( <?php the_field('wp_gp_latitude'); ?> , <?php the_field('wp_gp_longitude'); ?>);
								var myPinColor = "FE7569";
								var nearbyPinColor = "FEB869";

								function initialize() {
									var mapOptions = {
										zoom: 6,
										center: myLatLang,
										mapTypeId: google.maps.MapTypeId.ROADMAP
									};
									map = new google.maps.Map(document.getElementById('loc'), mapOptions);

									var infoWindow = new google.maps.InfoWindow({ maxWidth: 200 });

									var marker = new google.maps.Marker({
										position: myLatLang,
										map: map,
										icon: createPinIcon(myPinColor),
										title: <?php echo '"'.$t.'"'?>,
									});

									<?php
									$infoContent = "<div class='infoWindow'><h1>" . get_the_title() . '</h1>';

									if ($summary) {
										$infoContent .= "<div>{$summary}</div>";
									}

									$infoContent .= '</div>'; ?>

									google.maps.event.addListener(marker, 'click', function() {
										infoWindow.setContent("<?php echo $infoContent ?>");
										infoWindow.open(map,this);
									});

									<?php
									ob_start();
									$query = new WP_GeoQuery(array(
										'latitude' => the_field('wp_gp_latitude'), // Post's Latitude (optional)
										'longitude' => the_field('wp_gp_longitude'), // Post's Longitude (optional)
										'radius' => 50, // Radius to select for in miles (optional)
										'posts_per_page' => 50, // Any regular options available via WP_Query
									));
									$throwAway = ob_get_contents();
									ob_end_clean();
									?>

									var nearbyIcon = createPinIcon(nearbyPinColor);

									<?php
									$i =0;
									$infoContent = array();
									foreach ($query->posts as $near) :?>

										<?php if (get_post_meta( $near->ID, "wp_gp_latitude", true ) && $near->post_title != $t) :
											$permalink = get_permalink($near->ID);
											$customFields = get_post_custom($near->ID);
											$infoContent[$i] = "<div class='infoWindow'><h1><a href='$permalink'>{$near->post_title}</a></h1>";

											if (isset($customFields['summary'][0])) {
												$infoContent[$i] .= '<div>' . $customFields['summary'][0] . '</div>';
											}

											$infoContent[$i] .= '</div>'; ?>

											var marker<?php echo $i; ?> = new google.maps.Marker({
												position: 	new google.maps.LatLng( <?php echo get_post_meta( $near->ID, "wp_gp_latitude", true ); ?> , <?php echo get_post_meta( $near->ID, "wp_gp_longitude", true ); ?>),
												map : map,
												icon: nearbyIcon,
												title: <?php echo '"'.$near->post_title.'"'; ?>
											});

											google.maps.event.addListener(marker<?php echo $i; ?>, 'click', function() {
												infoWindow.setContent("<?php echo $infoContent[$i] ?>");
												infoWindow.open(map,this);
											});
											<?php $i++; ?>
										<?php endif ?>
									<?php endforeach ?>
								};

								google.maps.event.addDomListener(window, 'load', initialize);

							</script>

						</div>
					</section>

					<section class="entry-content clearfix">
						<div class="summary">
							<?php if ($priority = get_field('priority')) { ?>
								<h2>Priority</h2>
								<?php
								echo '<ul>';
									foreach ($priority as $term) {
										$term_link = get_term_link( $term, 'priority' );
										if ( is_wp_error( $term_link ) ) { continue; }
										echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
									}
								echo '</ul>';
							}
							if ($type = get_field('type')) { ?>
								<h2>Type</h2>
								<?php
								echo '<ul>';
									foreach ($type as $term) {
										$term_link = get_term_link( $term, 'type' );
										if ( is_wp_error( $term_link ) ) { continue; }
										echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
									}
								echo '</ul>';
							} ?>


							<h1>Request made by</h1>
							<?php if ($requester_name = get_field('requester_name')) { ?>
								<h2>Name</h2>
								<?php echo $requester_name; ?>
							<?php } ?>

							<?php if ($requester_contact_info = get_field('requester_contact_info')) { ?>
								<h2>Contact Information</h2>
								<?php echo $requester_contact_info; ?>
							<?php } ?>

							<?php if ($request_source = get_field('request_source')) { ?>
								<h2>Request Source</h2>
								<?php echo $request_source; ?>
							<?php } ?>

							<?php if ($type[0]->slug == 'rescue') { ?>

								<h1>Assistance Request Information</h1>

								<?php if ($name = get_field('name')) { ?>
									<h2>Name</h2>
									<?php echo $name; ?>
								<?php } ?>

								<?php if ($contact = get_field('contact')) { ?>
									<h2>Contact Information</h2>
									<?php echo $contact; ?>
								<?php } ?>

								<?php if ($rescue_location = get_field('request_location')) { ?>
									<h2>Location</h2>
									<?php echo $rescue_location['address']; ?>
									<script>
										var map;
										var myLatLang = new google.maps.LatLng( <?php echo $rescue_location['coordinates']; ?>);
										function initialize() {
											var mapOptions = {
												zoom: 6,
												center: myLatLang,
												mapTypeId: google.maps.MapTypeId.ROADMAP
											};
											map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
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

							<?php if ($type[0]->slug == 'tracing') { ?>

								<h1>Tracing Request Information</h1>

								<?php if ($tracing_name = get_field('tracing_name')) { ?>
									<h2>Name of Missing Person</h2>
									<?php echo $tracing_name; ?>
								<?php } ?>

								<?php if ($tracing_location = get_field('tracing_location')) { ?>
									<h2>Last Seen</h2>
									<?php echo $tracing_location['address']; ?>
									<script>
										var map;
										var myLatLang = new google.maps.LatLng( <?php echo $tracing_location['coordinates']; ?>);
										function initialize() {
											var mapOptions = {
												zoom: 6,
												center: myLatLang,
												mapTypeId: google.maps.MapTypeId.ROADMAP
											};
											map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
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

								<?php if ($tracing_information = get_field('tracing_information')) { ?>
									<h2>Additional Information</h2>
									<?php echo $tracing_information; ?>
								<?php } ?>
							<?php  } // End check for tracing type ?>

							<h2>More details</h2>
							<?php the_content(); ?>
						</div>
					</section>

					<footer class="article-footer">

					</footer>

					<?php comments_template(); ?>

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

<<<<<<< HEAD
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
=======
			<?php endif; ?>
>>>>>>> 735ff86aa39bd2f2a39887703c398b81ce4f1ff8

		</div>
	</div>
</div>

<?php get_footer(); ?>
