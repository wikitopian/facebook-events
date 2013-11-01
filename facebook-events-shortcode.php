<?php

class Facebook_Events_Shortcode {
	private $settings;

	public function __construct( $settings ) {
		$this->settings = $settings;

		add_shortcode( Facebook_Events::$PREFIX, array( &$this, 'do_shortcode' ) );
	}
	public function do_shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'max_events' => $this->settings['max_events'],
				),
				$atts
			)
		);
		$events = get_transient( Facebook_Events::$PREFIX );

		echo "<ul id='" . Facebook_Events::$PREFIX . "'>\n";
		foreach ( $events as $event ) {
			$link = 'http://www.facebook.com/events/' . $event['eid'] . '/';

			echo '<li>' . "\n";
			echo '<h3>' . "<a href=\"{$link}\">" . $event['name'] .  '</a>';
			echo '<br /><span id="date">' . esc_textarea( $event['start_time'] ) . '</span>';
			echo '</h3>' . "\n";
			echo "<a href=\"{$link}\">\n";
			echo "<img src='" . $event['pic_small'] . "' class='alignright' />\n";
			echo "</a>\n";
			echo '<p>' . $event['description'] . '</p>' . "\n";
			echo '</li>' . "\n";
		}
		echo "</ul>\n<hr />\n";

		if( empty( $events ) ) {
			echo 'No Upcoming Events';
		}
	}
}

?>
