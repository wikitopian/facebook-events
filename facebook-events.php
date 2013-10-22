<?php
/*
 * Plugin Name: Facebook Events
 * Plugin URI: http://www.github.com/wikitopian/facebook-events
 * Description: Track upcoming events from a Facebook page.
 * Version: 0.1.0
 * Author: @wikitopian
 * Author URI: http://www.github.com/wikitopian
 * License: GPLv2
 */

require_once( 'facebook.php' ); // FB-specific logic
require_once( 'facebook-events-menu.php' );
require_once( 'facebook-events-shortcode.php' );
require_once( 'facebook-events-widget.php' );

class Facebook_Events {
	public static $PREFIX = 'facebook-events';
	private $settings;

	private $facebook;
	private $menu;
	private $shortcode;

	private $events;

	public function __construct() {
		$this->do_settings();

		$this->facebook  = new Facebook_Events_Facebook( $this->settings );
		$this->menu      = new Facebook_Events_Menu( $this->settings );
		$this->shortcode = new Facebook_Events_Shortcode( $this->settings );

		add_action( 'wp_enqueue_scripts', array( &$this, 'do_style' ) );

		add_action( 'widgets_init', array( &$this, 'do_widget' ) );

		$this->events = $this->facebook->get_event_query();
	}
	public function do_settings() {
		$defaults = array(
			'appId'      => false,
			'secret'     => false,
			'page_id'    => false,
			'max_events' => 10,
		);

		$this->settings = get_option( self::$PREFIX, $defaults );
		update_option( self::$PREFIX, $this->settings );
	}
	public function do_style() {
		wp_enqueue_style(
			Facebook_Events::$PREFIX,
			plugins_url( 'style/facebook-events.css', __FILE__ )
		);
	}
	public function do_widget() {
		register_widget( 'Facebook_Events_Widget' );
	}
}

$facebook_events = new Facebook_Events();

?>
