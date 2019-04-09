<div class="Post Section">
    <div class="Post__inner Section__inner">

		<?php if ( have_posts() ): the_post() ?>

            <div class="Post__post">

                <div class="Post__post-image"
                     style="background-image:url('<?= get_the_post_thumbnail_url() ?>')">

                    <div class="Post__post-image-overlay">
                        <h1 class="Post__post-title">
		                    <?php the_title() ?>
                        </h1>
                    </div>

                </div>

                <div class="Post__post-content">
	                <?php the_content() ?>
                </div>

            </div>

		<?php endif; ?>

    </div>
</div>