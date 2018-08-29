<?php

/**
 * This class takes care of requests coming from HelpScout App Integrations
 */
class WP_HelpScout_Endpoint {

	/**
	 * @var array|mixed
	 */
	private $data;

	/**
	 * @var int
	 */
	private $user;

	/**
	 * Constructor
	 */
	public function __construct() {

		// get request data
		$this->data = $this->parse_data();

		// validate request
		if( ! $this->validate() ) {
			$this->respond( 'Invalid signature' );
			exit;
		}

		$this->user = $this->get_user();

		// build the final response HTML for HelpScout
		$html = $this->build_response_html();

		// respond with the built HTML string
		$this->respond( $html );
	}

	/**
	 * @return array|mixed
	 */
	private function parse_data() {

		$data_string = file_get_contents( 'php://input' );
		$data = json_decode( $data_string, true );

		return $data;

	}

	/**
	 * Validate the request
	 *
	 * - Validates the payload
	 * - Validates the request signature
	 *
	 * @return bool
	 */
	private function validate() {

		// we need at least this
		if ( ! isset( $this->data['customer']['email'] ) && ! isset( $this->data['customer']['emails'] ) ) {
			return false;
		}

		// check request signature
		$request = new WP_HelpScout_Request( $this->data );

		if ( isset( $_SERVER['HTTP_X_HELPSCOUT_SIGNATURE'] ) && $request->signature_equals( $_SERVER['HTTP_X_HELPSCOUT_SIGNATURE'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get user from email
	 *
	 * @return int
	 */
	private function get_user() {

		foreach( $this->data['customer']['emails'] as $email ) {

			$user = get_user_by( 'email', $email );

			if( $user !== false ) {
				return $user;
			}

		}

		// Try by name
		if( $user == false ) {

			$args  = array(
				'meta_query'	=> array(
					'relation' => 'AND',
					array(
						'key'		=> 'first_name',
						'value'		=> $this->data['customer']['fname'],
						'compare'	=> 'LIKE'
					),
					array(
						'key'		=> 'last_name',
						'value'		=> $this->data['customer']['lname'],
						'compare'	=> 'LIKE'
					),

				)
			);

			$users = get_users($args);

			if( ! empty( $users ) ) {
				return $users[0];
			}

		}

		return false;

	}

	/**
	 * Process the request
	 *  - Find purchase data
	 *  - Generate response*
	 * @link http://developer.helpscout.net/custom-apps/style-guide/ HelpScout Custom Apps Style Guide
	 * @return string
	 */
	private function build_response_html() {

		if( $this->user == false ) {
			return 'No user found.';
		}

		$user = $this->user;

		ob_start();
		include dirname( WP_HelpScout::FILE ) . '/views/output.php';
		$html = ob_get_clean();

		$html = apply_filters( 'wp_helpscout_html_output', $html, $user );

		return $html;
	}

	/**
	 * Set JSON headers, return the given response string
	 *
	 * @param string $html
	 */
	private function respond( $html ) {

		$response = array( 'html' => $html );

		// clear output, some plugins might have thrown errors by now.
		if ( ob_get_level() > 0 ) {
			ob_end_clean();
		}

		header( "Content-Type: application/json" );
		echo json_encode( $response );
		die();

	}

}
