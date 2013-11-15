<?php get_header(); ?>

			<div id="content" class="row">

				<div id="inner-content" class="col-md-12">

						<div id="main" class="twelvecol first clearfix" role="main">
							<table id="caseTable">
								<thead>
								<tr>
									<th>Type</th>
									<th>Name</th>
									<th>Date</th>
									<th>Priority</th>
									<th>Status</th>
									<th>Summary</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
							<?php
							$q = new WP_Query( array('post_type' => 'case') );
							if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); ?>
							<tr class="<?php
							$type = get_field('type');
							$priority = get_field('priority');
							echo $type[0]->slug, " ";
							echo $priority[0]->slug;
							?> case">
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
										<div class="priority <?php echo $priority[0]->slug; ?> sprdsht">
											<?php echo $priority[0]->name; ?>
										</div>
								</td>
								<td>
										<?php $status = get_field('status'); ?>
										<div class="status <?php echo $status[0]->slug; ?> sprdsht">
											<?php echo $status[0]->name; ?>
										</div>
								</td>
								<td>
										<?php the_field('summary'); ?>
								</td>
								<td>
									<a class="" href="<?php the_permalink(); ?>" target="_blank" rel="nofollow">
									<span class="">view case</span>
									<span class=""><span></span></span>
									</a>
								</td>
								</tr>
							

<?php /*
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

								<header class="article-header">

									<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', '));
									?></p>

								</header>

								<section class="entry-content clearfix">
									<?php the_content(); ?>
								</section>

								<footer class="article-footer">
									<p class="tags"><?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?></p>

								</footer>

								<?php // comments_template(); // uncomment if you want to use them ?>

							</article>

*/ ?>
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

						<?php //get_sidebar(); ?>

				</div>
                <!--<div class="col-md-3">
                    <?php /*get_sidebar(); */?>
                </div>-->

			</div>

<?php get_footer(); ?>
