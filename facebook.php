<?php

require_once( 'facebook-php-sdk-v4/src/Facebook/Facebook.php' ); // official FB lib
require_once( 'facebook-php-sdk-v4/src/Facebook/Exceptions/FacebookSDKException.php' );

class Facebook_Events_Facebook {
	private $settings;

	private $fb;

	public function __construct( $settings ) {
		$this->settings = $settings;

		if( !empty( $this->settings['app_id'] ) ) {
			$this->fb = new \Facebook\Facebook(
				array(
					'appId'  => $this->settings['app_id'],
					'secret' => $this->settings['secret'],
					'cookie' => true,
				)
			);
		}
	}
	public function get_event_query() {

		if( empty( $this->settings['app_id'] ) ) {
			return null;
		}

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
