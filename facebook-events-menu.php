<?php

class Facebook_Events_Menu {
	private $settings;

	public function __construct( $settings ) {
		$this->settings = $settings;

		add_action( 'admin_menu', array( &$this, 'add_options_page' ) );
	}
	public function add_options_page() {
		register_setting( Facebook_Events::$PREFIX, Facebook_Events::$PREFIX );

		add_settings_section(
			Facebook_Events::$PREFIX,
			'Facebook Connection Info',
			array( &$this, 'do_section' ),
			Facebook_Events::$PREFIX
		);

		add_settings_field(
			Facebook_Events::$PREFIX . '[' . 'appId' . ']',
			'Application ID',
			array( &$this, 'do_app_id_field' ),
			Facebook_Events::$PREFIX,
			Facebook_Events::$PREFIX
		);

		add_settings_field(
			Facebook_Events::$PREFIX . '[' . 'secret' . ']',
			'Secret',
			array( &$this, 'do_secret_field' ),
			Facebook_Events::$PREFIX,
			Facebook_Events::$PREFIX
		);

		add_settings_field(
			Facebook_Events::$PREFIX . '[' . 'page_id' . ']',
			'Page ID',
			array( &$this, 'do_page_id_field' ),
			Facebook_Events::$PREFIX,
			Facebook_Events::$PREFIX
		);

		add_settings_field(
			Facebook_Events::$PREFIX . '[' . 'max_events' . ']',
			'Maximum Events Shown',
			array( &$this, 'do_max_events_field' ),
			Facebook_Events::$PREFIX,
			Facebook_Events::$PREFIX
		);

		add_options_page(
			'Facebook Events',
			'Facebook Events',
			'manage_options',
			Facebook_Events::$PREFIX,
			array( &$this, 'do_options_page' )
		);
	}
	public function do_options_page() {
?>
<div id="wrap">
	<h2>Facebook Events</h2>

	<form action="options.php" method="post">
		<?php settings_fields( Facebook_Events::$PREFIX ); ?>
		<?php do_settings_sections( Facebook_Events::$PREFIX ); ?>

		<input name="Submit" type="submit" value="Save Changes" />
	</form>
</div>

<?php
	}
	public function do_section() {

	}
	public function do_app_id_field() {
		echo '<input ';
		echo 'type = "text" ';
		echo 'name = "' . Facebook_Events::$PREFIX . '[appId]" ';
		echo 'value = "' . $this->settings['appId'] . '"';
		echo ' />';
	}
	public function do_secret_field() {
		echo '<input ';
		echo 'type = "text" ';
		echo 'name = "' . Facebook_Events::$PREFIX . '[secret]" ';
		echo 'value = "' . $this->settings['secret'] . '"';
		echo ' />';
	}
	public function do_page_id_field() {
		echo '<input ';
		echo 'type = "text" ';
		echo 'name = "' . Facebook_Events::$PREFIX . '[page_id]" ';
		echo 'value = "' . $this->settings['page_id'] . '"';
		echo ' />';
	}
	public function do_max_events_field() {
		echo '<input ';
		echo 'type = "text" ';
		echo 'name = "' . Facebook_Events::$PREFIX . '[max_events]" ';
		echo 'value = "' . $this->settings['max_events'] . '"';
		echo ' />';
	}
}

?>
