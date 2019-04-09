<?php


namespace WPLMixTheme\Framework;


trait Singleton {

	private static $_instance;

	public static function get_instance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}