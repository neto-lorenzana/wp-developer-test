<div class="Posts Section">
    <div class="Posts__inner Section__inner">

        <div>
            <h2 class="Section__title">In The News</h2>
            <p class="Section__sub-title">Choro oblique vituperata est ex, ea est natum latine vivendo. Est ex iudico
                meliore appetere.</p>
        </div>

		<?php if ( have_posts() ): ?>

            <div class="Posts__posts">
				<?php while ( have_posts() ): ?>
					<?php the_post(); ?>

                    <div class="Posts__post">

                        <a href="<?php the_permalink() ?>">
                            <div class="Posts__post-image"
                                 style="background-image:url('<?= get_the_post_thumbnail_url() ?>')">
                            </div>
                        </a>

                        <h3 class="Posts__post-title">
                            <a href="<?php the_permalink() ?>">
								<?php the_title() ?>
                            </a>
                        </h3>

                        <div class="Posts__post-excerpt">
							<?= wp_trim_excerpt() // todo - set this as get_the_excerpt() for dev test  ?>
                        </div>

                    </div>

				<?php endwhile; ?>
            </div>

            <div class="Posts__pagination">
                <?php posts_nav_link(' || ', 'Newer entries', 'Previous entries'); ?>
            </div>

		<?php endif; ?>

    </div>
</div>