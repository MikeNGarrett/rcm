<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="twelvecol first clearfix" role="main">
						<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
					<h2><a href="<?php the_permalink(); ?>">Case posted <?php the_time(get_option('date_format')); ?></a></h2>
					<h3>Location</h3>
					<?php if (get_field('wp_gp_location')) { ?>
						<p><strong><?php the_field('location'); ?></strong></p>
					<?php } else { // end graceful handler when there is no Lat/Lng data ?>
						<p><strong>Location Unknown</strong></p>
					<?php } ?>

					<div class="case-summary-head case-block">
						<h2 class="case-heading">Case Summary</h2>
						<ul class="case-summ">
							<li>
								<span class="summ-name">Status</span>
								<span class="summ-entry">
								    <?php
									$status = wp_get_post_terms( $post->ID, 'status');
									foreach ($status as $term) {
									    $term_link = get_term_link( $term, 'status' );
									    if( is_wp_error( $term_link ) )
									        continue;
										echo '<a href="' . $term_link . '" class="casestatus">' . $term->name . '</a>';
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
					<p><a href="<?php the_permalink(); ?>" class="button">View Case</a></p>
				</article>
				<hr>
						<?php endwhile; ?>

								<?php if (function_exists('bones_page_navi')) { ?>
										<?php bones_page_navi(); ?>
								<?php } else { ?>
										<nav class="wp-prev-next">
												<ul class="clearfix">
													<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'bonestheme' )) ?></li>
													<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'bonestheme' )) ?></li>
												</ul>
										</nav>
								<?php } ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Try your search again.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the search.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

					</div>

			</div>

<?php get_footer(); ?>
