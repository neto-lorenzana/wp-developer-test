<div class="Header Section">

    <div class="Header__inner Section__inner">

        <div class="Header__left">
            <h1 class="Logo"><a href="<?= home_url() ?>">Company Logo</a></h1>
        </div>

        <div class="Header__right -v-center">
			<?php
			wp_nav_menu( [
				'theme_location'  => 'main_nav',
				'menu'            => '',
				'container'       => 'div',
				'container_class' => 'NavMenu',
				'container_id'    => '',
				'menu_class'      => 'NavMenu__menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'depth'           => 1,
			] );
			?>
        </div>

    </div>

</div>