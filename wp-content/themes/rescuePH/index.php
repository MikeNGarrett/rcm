<?php get_header(); ?>

<div id="content" class="row">

	<div id="inner-content" class="col-md-12">

			<div id="systemMsg"></div>

			<div id="main" class="twelvecol first clearfix" role="main">
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
						$q = new WP_Query( array('post_type' => 'case', 'posts_per_page' => '50') );
						if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post();
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
				<?php if ( function_exists( 'bones_page_navi' ) ) { ?>
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

