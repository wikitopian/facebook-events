<?php

require_once( 'facebook-php-sdk/src/facebook.php' ); // official FB lib

class Facebook_Events_Facebook {
	private $settings;

	private $fb;

	public function __construct( $settings ) {
		$this->settings = $settings;

		$this->fb = new Facebook(
			array(
				'appId'  => $this->settings['appId'],
				'secret' => $this->settings['secret'],
				'cookie' => true,
			)
		);
	}
	public function get_event_query() {

		if ( true === ( $events = get_transient( Facebook_Events::$PREFIX ) ) ) {
			return $events;
		}

		$fql = <<<FQL
SELECT eid, name, pic, pic_small, start_time, end_time, location, description
	FROM event WHERE eid IN ( SELECT eid FROM event_member
	WHERE uid = '{$this->settings['page_id']}' )
	  AND start_time > now()
	ORDER BY start_time ASC
	LIMIT {$this->settings['max_events']}
FQL;

		$param = array (
			'method' => 'fql.query',
			'query' => $fql,
			'callback' => ''
		);

		$events = $this->fb->api( $param );

		set_transient( Facebook_Events::$PREFIX, $events, 60 * 5 );

		return $events;
	}
}



?>
