<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

			<div id="main" class="twelvecol first clearfix" role="main">
							<?php if (is_category()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Posts Categorized:', 'bonestheme' ); ?></span> <?php single_cat_title(); ?>
								</h1>

							<?php } elseif (is_tag()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Posts Tagged:', 'bonestheme' ); ?></span> <?php single_tag_title(); ?>
								</h1>
							<?php } elseif (is_tax('type')) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Case Type:', 'bonestheme' ); ?></span> <?php single_tag_title(); ?>
								</h1>
							<?php } elseif (is_tax('status')) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Case Status:', 'bonestheme' ); ?></span> <?php single_tag_title(); ?>
								</h1>
							<?php } elseif (is_tax('priority')) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Case Priority:', 'bonestheme' ); ?></span> <?php single_tag_title(); ?>
								</h1>

							<?php } elseif (is_author()) {
								global $post;
								$author_id = $post->post_author;
							?>
								<h1 class="archive-title h2">

									<span><?php _e( 'Posts By:', 'bonestheme' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

								</h1>
							<?php } elseif (is_day()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Daily Archives:', 'bonestheme' ); ?></span> <?php the_time('l, F j, Y'); ?>
								</h1>

							<?php } elseif (is_month()) { ?>
									<h1 class="archive-title h2">
										<span><?php _e( 'Monthly Archives:', 'bonestheme' ); ?></span> <?php the_time('F Y'); ?>
									</h1>

							<?php } elseif (is_year()) { ?>
									<h1 class="archive-title h2">
										<span><?php _e( 'Yearly Archives:', 'bonestheme' ); ?></span> <?php the_time('Y'); ?>
									</h1>
							<?php } ?>
				<table id="caseTable">
					<thead>
						<tr>
							<th>Type</th>
							<th>Status</th>
							<th>Concern</th>
							<th>Priority</th>
							<th>Date</th>
							<th>Reported By</th>
							<th>View Case</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (have_posts()) : while (have_posts()) : the_post();
							$type = wp_get_post_terms($post->ID, 'type');
							$type = $type[0];
							$priority = wp_get_post_terms($post->ID, 'priority');
							$priority = $priority[0];
							$status = wp_get_post_terms($post->ID, 'status');
							$status = $status[0];
							//$status = get_field('status');
							?>

							<tr class="<?php echo $type->slug." "; echo $priority->slug; ?> case">
								<td>
									<?php echo $type->name; ?>
								</td>
								<td class="status sprdsht <?php echo $status->slug; ?>">
									<?php echo $status->name; ?>
								</td>
								<td class="concern">
									<?php the_field('concern'); ?>
								</td>
								<td class="priority <?php echo $priority->slug; ?> sprdsht">
									<?php echo $priority->name; ?>
								</td>
								<td class="date">
									<a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
								</td>
								<td class="reportedBy">
									<?php the_field('reported_by'); ?>
								</td>
								<td class="action">
									<a href="<?php the_permalink(); ?>" target="_blank" >view case</a>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>

		<?php else : ?>

				<article id="post-not-found" class="hentry clearfix">
						<header class="article-header">
							<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
					</header>
						<section class="entry-content">
							<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
					</section>
					<footer class="article-footer">
							<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
					</footer>
				</article>

		<?php endif; ?>

		</div>

						</div>


								</div>


<?php get_footer(); ?>
