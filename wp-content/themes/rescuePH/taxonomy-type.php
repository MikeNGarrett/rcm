<?php
/*
This is the custom post type taxonomy template.
If you edit the custom taxonomy name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom taxonomy is called
register_taxonomy( 'shoes',
then your single template should be
taxonomy-shoes.php

*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

			<div id="main" class="twelvecol first clearfix" role="main">

				<h1 class="archive-title h2"><?php single_cat_title(); ?> <span>Cases</span></h1>

				<table id="caseTable">
					<thead>
						<tr>
							<th>Type</th>
							<th>Status</th>
							<th>Name</th>
							<th>Date</th>
							<th>Priority</th>
							<th>Summary</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php if (have_posts()) : while (have_posts()) : the_post();
							$type = get_field('type');
							$priority = get_field('priority');
							$status = get_field('status');
						?>
						<tr class="<?php echo $type[0]->slug." "; echo $priority[0]->slug; ?> case">
							<td>
								<?php echo $type[0]->name; ?>
							</td>
							<td class="status <?php echo $status[0]->slug; ?> sprdsht">
								<?php echo $status[0]->name; ?>
							</td>
							<td>
								<?php
								if($type[0]->slug == 'rescue') {
									the_field('name');
								}
								if($type[0]->slug == 'tracing') {
									the_field('tracing_name');
								}
								?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
							</td>
							<td class="priority <?php echo $priority[0]->slug; ?> sprdsht">
								<?php echo $priority[0]->name; ?>
							</td>
							<td>
								<?php the_field('summary'); ?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>" target="_blank">view case</a>
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
									<p><?php _e( 'This is the error message in the taxonomy-custom_cat.php template.', 'bonestheme' ); ?></p>
							</footer>
						</article>

				<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
