<?php

class Facebook_Events_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			Facebook_Events::$PREFIX,
			'Facebook Events',
			array( 'description' => 'Facebook Events', )
		);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$title = 'Upcoming Events';

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		do_shortcode( '[' . Facebook_Events::$PREFIX . ']' );
		echo $args['after_widget'];
	}
}

?>
