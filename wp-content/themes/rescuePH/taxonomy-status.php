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

							<h1 class="archive-title h2"><?php single_cat_title(); ?> Cases</h1>
								
							<table id="caseTable">
								<thead>
									<tr>
										<th>Type</th>
										<th>Name</th>
										<th>Date</th>
										<th>Case Status</th>
										<th>Summary</th>
									</tr>
								</thead>
								<tbody>
									<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
									<tr>
										<td>
											<?php
											$type = get_field('type');
											echo $type[0]->name;
											?>
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
										<td>
											<?php $priority = get_field('priority'); ?>
											<div class="priority <?php echo $priority[0]->slug; ?>">
												<?php echo $priority[0]->name; ?>
											</div>

											<?php $status = get_field('status'); ?>
											<div class="status <?php echo $status[0]->slug; ?>">
												<?php echo $status[0]->name; ?>
											</div>
										</td>
										<td>
											<?php the_field('summary'); ?>
											<a href="<?php the_permalink(); ?>">View Case &raquo;</a>
										</td>
									</tr>
									<?php endwhile; ?>
								</tbody>
							</table>

<?php /*
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

								<header class="article-header">

									<h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'bonestheme' )), bones_get_the_author_posts_link(), get_the_term_list( get_the_ID(), 'custom_cat', "" ) );
									?></p>

								</header>

								<section class="entry-content">
									<?php the_excerpt( '<span class="read-more">' . __( 'Read More &raquo;', 'bonestheme' ) . '</span>' ); ?>

								</section>

								<footer class="article-footer">

								</footer>

							</article>
*/ ?>


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

						<?php //get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
