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
	<div id="content" class="row">

		<div id="inner-content" class="col-md-9">
			<!-- Changed to full width -->
			<div id="main" class="twelvecol first clearfix" role="main">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

					<h2>Location</h2>
					<?php if (get_field('wp_gp_latitude') && get_field('wp_gp_longitude')) { ?>
					<div class="full-map">
						<div class="map" id="loc" style="height:400px; width:980px"></div>
						<script>
							function createPinIcon(pinColor) {
								return new google.maps.MarkerImage(
									"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
									new google.maps.Size(21, 34),
									new google.maps.Point(0,0),
									new google.maps.Point(10, 34)
								);
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
								foreach ($query->posts as $near){ ?>

									<?php if (get_post_meta( $near->ID, "wp_gp_latitude", true ) && $near->post_title != $t){
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
									<?php }//End if ?>
								<?php }//End foreach ?>
							}; <?php //initialize js function ?>

							google.maps.event.addDomListener(window, 'load', initialize);

						</script>
						<p><strong><?php the_field('location'); ?></strong></p>
					</div><?php //Full-map ?>
					<?php } else { // end graceful handler when there is no Lat/Lng data ?>
						<p><strong>Location Unknown</strong></p>
					<?php } ?>
					<div class="case-summary-head case-block">
						<h2 class="case-heading">Case Summary</h2>
						<ul class="case-summ">
							<li>
								<span class="summ-name">Date</span>
								<span class="summ-entry"><a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a></span>
							</li>

							<li>
								<span class="summ-name">Status</span>
								<span class="summ-entry">
								    <?php
									$status = wp_get_post_terms( $post->ID, 'status');
								    if (is_user_logged_in()) {
										$statusOptions = get_terms('status', 'hide_empty=0');
								    ?>
										<select name="status" id="status">
								    	<?php foreach ($statusOptions as $statusOption):
								    		$isSelected = $status[0]->term_id == $statusOption->term_id ?>
									    	<option value="<?php echo $statusOption->term_id; ?>" <?php if($isSelected) { echo 'selected="selected"'; } else { echo ''; }; ?>>
									    		<?php echo $statusOption->name; ?>
									    	</option>
								    	<?php endforeach ?>
								    	</select>
								    	<input type="hidden" id="old-status" value="<?php echo $status[0]->term_id; ?>" />
								    	<input type="hidden" id="case-id" value="<?php the_ID()?>" />

								    	<input type="button" id="update-status" class="button" value="Update"/>
								    	<span id="update-status-msg" style="display:none"></span>
								    	<img id="update-status-loader" class="loader" style="display:none;" src="<? echo get_template_directory_uri(); ?>/library/images/ajax-loader.gif">
								    <?php } else {
											foreach ($statusOptions as $term) {
											    $term_link = get_term_link( $term, 'status' );
											    if( is_wp_error( $term_link ) )
											        continue;
												echo '<a href="' . $term_link . '" class="casestatus">' . $term->name . '</a>';
											}
										}
									?>
								</span>
							</li>


							<?php if($priority = wp_get_post_terms( $post->ID, 'priority')) { ?>
								<li>
									<span class="summ-name">Priority</span>
									<span class="summ-entry priority <?php echo $priority[0]->slug; ?>">
										<?php
										echo '<ul class="list-group">';
										foreach ($priority as $term) {
										    $term_link = get_term_link( $term, 'priority' );
										    if( is_wp_error( $term_link ) ) { continue; }
										    echo '<li class="list-group-item"><a href="' . $term_link . '">' . $term->name . '</a></li>';
										}
										echo '</ul>'; ?>
									</span>
								</li>
							<?php } ?>

							<?php if($type = wp_get_post_terms( $post->ID, 'type')) { ?>
								<li>
									<span class="summ-name">Type</span>
									<span class="summ-entry">
											<?php
											foreach ($type as $term) {
												$term_link = get_term_link( $term, 'type' );
												if( is_wp_error( $term_link ) ) { continue; }
												echo '<a href="' . $term_link . '">' . $term->name . '</a>';
											} ?>
									</span>
								</li>
							<?php } ?>
						</ul> <!-- case-summ -->
					</div> <!-- case-block (1) -->


					<div class="case-detail-head case-block">
						<h2 class="case-heading">Case Details</h2>
						<div class="case-detail-entry clearfix">
                            <?php if(has_post_thumbnail()) { ?>
                                <?php the_post_thumbnail(array(150,150), array('class' => 'casethumbnail')); ?>
                            <?php } else { ?>
                                <img class="casethumbnail" src="http://placehold.it/150&text=No+Image" alt="">
                            <?php } ?>

                            <?php if($summary = get_field('concern')) { ?>
                                <h3 class="case-title">The Concern</h3>
                                <div class="casesummary clearfix"><p><?php  echo $summary; ?></p></div>
                            <?php }  ?>

							<h3 class="case-title">More Details</h3>
							<?php the_content(); ?>

						</div> <!-- case-detail-entry -->

					</div> <!-- case-block (2) -->

					<div class="case-summary-head case-block">
						<h2 class="case-heading">Request Details</h2>
						<ul class="case-summ">
							<?php if($requester_name = get_field('reported_by')) { ?>
							<li>
								<span class="summ-name">Reported By</span>
								<span class="summ-entry"><?php echo $requester_name; ?></span>
							</li>
							<?php } ?>

							<?php if($requester_contact_info = get_field('contact_info')) { ?>
							<li>
								<span class="summ-name">Contact Information</span>
								<span class="summ-entry"><?php  echo $requester_contact_info; ?></span>
							</li>
							<?php } ?>

							<?php if($request_source = wp_get_post_terms( $post->ID, 'source')) { ?>
							<li>
								<span class="summ-name">Request Source</span>
								<span class="summ-entry">
						            <ul><?php
						            foreach ($request_source as $source) {
						                echo '<li>' . $source->name . '</li>';
						            }
						            ?></ul>
								</span>
							</li>
							<?php } ?>
						</ul>
					</div> <!-- case-block (3) -->

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

			</div> <!-- #main -->

			<!-- Removed Sidebar <?php get_sidebar(); ?> -->

		</div> <!-- inner-content -->

		<?php /*
        <div class="col-md-3">
            <div class="priority <?php echo $priority[0]->slug; ?>">
                <?php echo $priority[0]->name; ?>
            </div>

            <div class="status <?php echo $status[0]->slug; ?>">
                <?php echo $status[0]->name; ?>
            </div>
        </div>
        */ ?>

	</div> <!-- content -->
<?php get_footer(); ?>
