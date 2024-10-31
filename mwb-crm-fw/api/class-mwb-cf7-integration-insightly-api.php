<?php
/**
 * Base Api Class
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Insightly
 * @subpackage Mwb_Cf7_Integration_With_Insightly/mwb-crm-fw
 */

/**
 * Base Api Class.
 *
 * This class defines all code necessary api communication.
 *
 * @since      1.0.0
 * @package    Mwb_Cf7_Integration_With_Insightly
 * @subpackage Mwb_Cf7_Integration_With_Insightly/mwb-crm-fw
 */
class Mwb_Cf7_Integration_Insightly_Api extends Mwb_Cf7_Integration_Insightly_Api_Base {

	/**
	 * Insightly API key
	 *
	 * @var     string  api key
	 * @since   1.0.0
	 */
	public static $api_key;

	/**
	 * Insightly API url
	 *
	 * @var     string  api url
	 * @since   1.0.0
	 */
	public static $api_url;

	/**
	 * Instance of the class.
	 *
	 * @var     object  $instance  Instance of the class.
	 * @since   1.0.0
	 */
	protected static $instance = null;

	/**
	 * Main Mwb_Cf7_Integration_Insightly_Api_Base Instance.
	 *
	 * Ensures only one instance of Mwb_Cf7_Integration_Insightly_Api_Base is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @static
	 * @return Mwb_Cf7_Integration_Insightly_Api_Base - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		self::initialize();
		return self::$instance;
	}

	/**
	 * Initialize properties.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $token_data Saved token data.
	 */
	private static function initialize( $token_data = array() ) {
		self::$api_key = get_option( 'mwb-cf7-' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '-api-key', '' );
		self::$api_url = get_option( 'mwb-cf7-' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '-api-url', '' );
	}

	/**
	 * Get api domain.
	 *
	 * @since 1.0.0
	 *
	 * @return string Site redirecrt Uri.
	 */
	public function get_redirect_uri() {
		return admin_url();
	}

	/**
	 * Get Api key.
	 *
	 * @since 1.0.0
	 *
	 * @return string Api key.
	 */
	public function get_api_key() {
		return ! empty( self::$api_key ) ? self::$api_key : false;
	}

	/**
	 * Get Request headers.
	 *
	 * @return array headers.
	 */
	public function get_auth_header() {
		$headers = array(
			'Accept'        => 'application/json',
			'Content-type'  => 'application/json',
			'Authorization' => sprintf( 'Basic %s', base64_encode( self::$api_key ) ), //phpcs:ignore
		);

		return $headers;
	}

	/**
	 * Get all module data.
	 *
	 * @param  boolean $force Fetch from api.
	 * @return array          Module data.
	 */
	public function get_modules_data( $force = false ) {

		return $this->get_modules();
	}

	/**
	 * Perform cf7 sync.
	 *
	 * @param    string $object      CRM object name.
	 * @param    array  $record_data Request data.
	 * @param    array  $log_data    Data to create log.
	 * @param    bool   $manual_sync If synced manually.
	 * @since    1.0.0
	 * @return   array
	 */
	public function perform_form_sync( $object, $record_data, $log_data = array(), $manual_sync = false ) {

		$result = array(
			'succes' => false,
			'msg'    => __( 'Something went wrong', 'mwb-cf7-integration-with-insightly' ),
		);

		$feed_id            = ! empty( $log_data['feed_id'] ) ? $log_data['feed_id'] : false;
		$log_data['crm_id'] = $this->maybe_update_object( $object, $feed_id, $record_data );

		if ( isset( $log_data['crm_id'] ) && ! empty( $log_data['crm_id'] ) ) {

			// Send a update request.
			$result = $this->update_single_record(
				$feed_id,
				$object,
				$record_data,
				false,
				$log_data
			);

		} else {
			$result = $this->handle_single_record(
				'post',
				$object,
				$record_data,
				false,
				$log_data
			);
		}

		return $result;
	}

	/**
	 * Check if record already exists or not
	 *
	 * @param    string $record_type       CRM object.
	 * @param    string $feed_id           Feed ID.
	 * @param    array  $request_data      Request data.
	 * @since    1.0.0
	 * @return   bool
	 */
	public function maybe_update_object( $record_type, $feed_id, $request_data ) {

		$result = false;
		if ( ! empty( $feed_id ) ) {
			$duplicate_check_fields = get_post_meta( $feed_id, 'mwb-' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '-cf7-primary-field', true );
			$primary_field          = ! empty( $duplicate_check_fields ) ? $duplicate_check_fields : false;
		}

		if ( $primary_field ) {
			$query           = 'field_name=' . $primary_field . '&field_value=' . $request_data[ $primary_field ];
			$search_response = $this->search_record( $record_type, $query );

		}

		$result = ! empty( $search_response ) ? $search_response : false;
		return $result;
	}

	/**
	 * Get Objects from local options or from quickbooks
	 *
	 * @return array
	 */
	public function get_modules() {

		$objects = apply_filters(
			'mwb_cf7_' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '_objects_list',
			array(
				'Contacts'      => 'Contacts',
				'Organisations' => 'Organisations',
				'Opportunities' => 'Opportunities',
				'Leads'         => 'Leads',
				'Tasks'         => 'Tasks',
				'Projects'      => 'Projects',
				'Prospects'     => 'Prospects',
			)
		);

		return $objects;
	}

	/**
	 * Create single record on CRM.
	 *
	 * @param  string  $action      API action.
	 * @param  string  $module      CRM Module name.
	 * @param  array   $record_data Request data.
	 * @param  boolean $is_bulk     Is a bulk request.
	 * @param  array   $log_data    Data to create log.
	 *
	 * @since 1.0.0
	 *
	 * @return array Response data.
	 */
	public function handle_single_record( $action = 'get', $module, $record_data, $is_bulk = false, $log_data = array() ) {
		$data = array();

		// Remove empty values.
		if ( 'post' === $action ) {
			$response = $this->create_or_update_record( $module, $record_data, $is_bulk, $log_data, 'create' );
		} else {
			$response = $this->get_record( $module, $record_data, $is_bulk, $log_data );
		}

		if ( $this->is_success( $response ) ) {
			$response['data']['mwb-event'] = 'Create';

			$data = $response['data'];
		} else {
			$data = $response;
		}

		return $data;
	}

	/**
	 * Update single record on CRM.
	 *
	 * @param  string $feed_id     CRM Module feed id.
	 * @param  string $module      CRM Module name.
	 * @param  array  $record_data Request data.
	 * @param  bool   $is_bulk     Is bulk request.
	 * @param  array  $log_data    Data to create log.
	 *
	 * @since 1.0.0
	 *
	 * @return array Response data.
	 */
	public function update_single_record( $feed_id, $module, $record_data, $is_bulk = false, $log_data = array() ) {

		$data = array();

		// Remove empty values.
		if ( is_array( $record_data ) ) {
			$record_data = array_filter( $record_data );
		}

		$response = $this->create_or_update_record( $module, $record_data, $is_bulk, $log_data, true );

		if ( $this->is_success( $response ) ) {
			$response['data']['mwb-event'] = 'Update';

			$data = $response['data'];

		} else {
			$data = $response;
		}

		return $data;
	}

	/**
	 * Create batch record on Insightly
	 *
	 * @param  array $record_data Request data.
	 * @param  array $log_data    Data to create log.
	 *
	 * @since 1.0.0
	 *
	 * @return array Response data.
	 */
	public function create_batch_record( $record_data, $log_data = array() ) {

		$data = array();
		// Remove empty values.
		if ( is_array( $record_data ) ) {
			$record_data = array_filter( $record_data );
		}

		$response = $this->create_or_update_record( 'batch', $record_data, true, $log_data );
		if ( $this->is_success( $response ) ) {
			$data = $response['data'];
		} else {
			$data = $response;
		}
		return $response;
	}

	/**
	 * Check if resposne has success code.
	 *
	 * @param  array $response  Response data.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean true|false.
	 */
	private function is_success( $response ) {
		if ( ! empty( $response['code'] ) ) {
			return in_array( $response['code'], array( '200', '201', '204', '202', 200, 201, 204, 202 ), true );
		}
		return true;
	}

	/**
	 * Create of update record data.
	 *
	 * @param  string  $module     Module name.
	 * @param  array   $record_data Module data.
	 * @param  boolean $is_bulk    Is a bulk request.
	 * @param  array   $log_data   Data to create log.
	 * @param  bool    $is_update  Is update request or not.
	 *
	 * @return array               Response data.
	 */
	private function create_or_update_record( $module, $record_data, $is_bulk, $log_data, $is_update = false ) {

		if ( empty( $module ) || empty( $record_data ) ) {
			return;
		}

		if ( isset( $log_data['method'] ) && ! empty( $log_data['method'] ) ) {
			$event = $log_data['method'];
		} else {
			$event = __FUNCTION__;
		}

		$this->base_url = self::$api_url;
		$headers        = $this->get_auth_header();
		$endpoint       = '/v3.1/' . $module;

		$crm_id = ! empty( $log_data['crm_id'] ) ? $log_data['crm_id'] : '';
		unset( $log_data['crm_id'] );

		if ( true === $is_update ) {
			if ( empty( $crm_id ) ) {
				return;
			} else {

				$id_string   = self::get_id_param_with_object( $module );
				$record_id   = array(
					$id_string => $crm_id,
				);
				$record_data = array_merge( $record_id, $record_data );
			}
		}

		// This POST Request is a query or a CRUD operation.
		if ( is_array( $record_data ) ) {

			// Format the request.
			$record_data  = self::format_request_structure( $record_data );
			$request_data = wp_json_encode( $record_data );
		}

		if ( true === $is_update ) {
			$response = $this->put( $endpoint, $request_data, $headers );
		} else {
			$response = $this->post( $endpoint, $request_data, $headers );
		}

		$this->log_request_in_db( $event, $module, $record_data, $response, $log_data, $is_update );

		return $response;

	}

	/**
	 * Update record data.
	 *
	 * @param    string $module           Module name.
	 * @param    array  $record_data      Module request.
	 * @param    array  $module_id        Module id.
	 * @param    array  $log_data         Data to create log.
	 * @since    1.0.0
	 * @return   array                    Response data.
	 */
	private function get_record( $module, $record_data = false, $module_id = false, $log_data = array() ) {

		if ( empty( $module ) ) {
			return false;
		}

		$this->base_url = self::$api_url;
		$headers        = $this->get_auth_header();
		$endpoint       = '/v3.1/' . $module;

		if ( ! empty( $module_id ) ) {
			$module .= '/' . $module_id;
		}
		$response = $this->get( $endpoint, array(), $headers );

		if ( ! empty( $log_data ) ) {
			$this->log_request_in_db( __FUNCTION__, $module, $record_data, $response, $log_data );
		}

		return $response;
	}

	/**
	 * Search record data without Id.
	 *
	 * @param  string $module      Module name.
	 * @param  array  $record_data Module data.
	 * @param  array  $log_data    Data to create log.
	 *
	 * @return array               Response data.
	 */
	public function search_record( $module, $record_data = false, $log_data = array() ) {

		if ( empty( $module ) ) {
			return;
		}
		$record_id = '';
		// This GET Request is a query or a CRUD operation.
		$this->base_url = self::$api_url;
		$headers        = $this->get_auth_header();
		$endpoint       = '/v3.1/' . $module . '/Search?' . $record_data;
		$response       = $this->get( $endpoint, array(), $headers );

		$temp = reset( $response['data'] );

		$temp_response = array(
			'code'    => 200,
			'message' => 'OK',
			'data'    => ! empty( $response['data'][0] ) ? $response['data'][0] : $temp,
		);

		if ( ! empty( $response['data'][0] ) ) {
			$id_string = self::get_id_param_with_object( $module );
			$record_id = ! empty( $response['data'][0][ $id_string ] ) ? $response['data'][0][ $id_string ] : '';
		}
		return $record_id;
	}

	/**
	 * Get the request structured.
	 *
	 * @since 1.0.0
	 *
	 * @param array $record_data The request.
	 *
	 * @return array
	 */
	public static function format_request_structure( $record_data = array() ) {
		foreach ( $record_data as $key => $value ) {
			if ( ! empty( strpos( $key, '__' ) ) ) {
				$array_assoc = explode( '__', $key );
				$array_assoc = array_reverse( $array_assoc );

				$result_array = array();
				$temp_value   = array();

				foreach ( $array_assoc as $k => $single_key ) {
					$temp_value = array(
						$single_key => ! empty( $temp_value ) ? $temp_value : $value,
					);

					$result_array = $temp_value;
				}

				if ( ! empty( $record_data[ $key ] ) ) {
					unset( $record_data[ $key ] );
				}

				if ( ! empty( $result_array ) ) {
					// Same key already resolved. May be billing/shipping one.
					if ( ! empty( $record_data[ key( $result_array ) ] ) ) {
						$duplicate_key      = key( $result_array );
						$existing_value     = $record_data[ $duplicate_key ];
						$new_resolved_value = $result_array[ $duplicate_key ];

						// Resolved_value.
						$record_data[ $duplicate_key ] = array_merge( $existing_value, $new_resolved_value );
					} else {
						$record_data = array_merge( $record_data, $result_array );
					}
				}
			}
		}

		return $record_data;
	}

	/**
	 * Get the Insightly api request format.
	 *
	 * @since 1.0.0
	 *
	 * @param string $module The module of crm.
	 *
	 * @return string|bool The request json for module.
	 */
	public function get_module_request( $module = false ) {

		$json = array();

		$json_url = MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'mwb-crm-fw/framework/jsons/' . $module . '.json';

		$response = wp_remote_get( $json_url );

		if ( ! empty( $response['response']['code'] ) && ( 200 === $response['response']['code'] || '200' === $response['response']['code'] ) ) {
			$json[ $module ] = $response['body'];
		}

		if ( ! empty( $module ) && ! empty( $json[ $module ] ) ) {
			return $json[ $module ];
		} else {
			return array();
		}
	}

	/**
	 * Get fields from quickbooks
	 *
	 * @since 1.0.0
	 *
	 * @param  string $object The request object type.
	 * @param  bool   $is_force The request object type.
	 *
	 * @return array  CRM fields w.r.t. API.
	 */
	public function get_module_fields( $object, $is_force = false ) {

		$module_json = $this->get_module_request( $object );

		if ( empty( $module_json ) ) {
			$arr = array();
		} else {
			$arr = json_decode( $module_json, 1 );
		}

		if ( empty( $arr ) ) {
			return array();
		}

		return $arr;
	}

	/**
	 * Get test format for quickbooks request.
	 *
	 * @param    string $module   Data to get.
	 * @since    1.0.0
	 * @return   array.
	 */
	public function get_test_request( $module = 'Users' ) {
		return $this->get_record( $module );
	}

	/**
	 * Get Owner from all users for quickbooks request.
	 *
	 * @since 1.0.0
	 *
	 * @return array.
	 */
	public function get_owner_account() {

		$response = $this->get_test_request();

		if ( 200 === $response['code'] ) {
			$result = ! empty( $response['data'] ) ? $response['data'] : array();
			foreach ( $result as $key => $account ) {
				if ( true === $account['ADMINISTRATOR'] ) {
					$_account[] = $account['FIRST_NAME'];
					$_account[] = $account['LAST_NAME'];
					break;
				}
			}
		} else {
			$_account = array();
		}

		update_option( 'mwb-cf7-' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '-owner-account', implode( ' ', $_account ) );
		return ! empty( $_account ) ? implode( ' ', $_account ) : '';
	}

	/**
	 * Get Owner from all users for quickbooks request.
	 *
	 * @param bool $force fetch from api or not.
	 * @since 1.0.0
	 *
	 * @return array.
	 */
	public function get_users_account( $force = false ) {

		if ( true === $force ) {
			$response = $this->get_test_request();

			if ( 200 === $response['code'] ) {
				$result = ! empty( $response['data'] ) ? $response['data'] : array();
				foreach ( $result as $key => $account ) {
					$_account[ $account['USER_ID'] ] = $account['EMAIL_ADDRESS'];
				}
			} else {
				$_account = array();
			}
		} else {
			$_account = get_option( 'mwb-cf7-' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '-user-accounts', array() );

			if ( empty( $_account ) ) {
				$this->get_users_account( true );
			}
		}

		return ! empty( $_account ) ? $_account : array();
	}

	/**
	 * Get test format for quickbooks request.
	 *
	 * @since 1.0.0
	 *
	 * @return array.
	 */
	public function perform_auth_trial() {

		$result = $this->get_test_request();
		return $result;
	}


	/**
	 * Log request and response in database.
	 *
	 * @param  string $event       Event of which data is synced.
	 * @param  string $crm_object  Update or create crm object.
	 * @param  array  $request     Request data.
	 * @param  array  $response    Api response.
	 * @param  array  $log_data    Extra data to be logged.
	 * @param  bool   $is_update    is update request.
	 */
	public function log_request_in_db( $event, $crm_object, $request, $response, $log_data, $is_update = false ) {

		$feed    = ! empty( $log_data['feed_name'] ) ? $log_data['feed_name'] : false;
		$feed_id = ! empty( $log_data['feed_id'] ) ? $log_data['feed_id'] : false;
		$event   = ! empty( $event ) ? $event : false;

		$insightly_object = $crm_object;
		$insightly_id     = $this->get_object_id_from_response( $response, $insightly_object );

		if ( '-' == $insightly_id ) { // phpcs:ignore
			if ( ! empty( $log_data['id'] ) ) {
				$insightly_id = $log_data['id'];
			}
		}

		$request    = serialize( $request ); //phpcs:ignore
		$response   = serialize( $response ); //phpcs:ignore

		switch ( $is_update ) {
			case true === $is_update:
				$operation = 'Update';
				break;

			case 'search':
				$operation = 'Search';
				break;

			case 'create':
			default:
				$operation = 'Create';
				break;
		}

		$log_data = array(
			'event'    => $event,
			'feed_id'  => $feed_id,
			'feed'     => $feed,
			'request'  => $request,
			'response' => $response,
			Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '_id' => $insightly_id,
			Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '_object' => $insightly_object . ' - ' . $operation,
			'time'     => time(),
		);

		// Structure them!
		$this->insert_log_data( $log_data );
	}

	/**
	 * Check if resposne has success code.
	 *
	 * @param  array $response  Response data.
	 * @return boolean          Success.
	 */
	public function is_success_response( $response ) {

		if ( ! empty( $response['code'] ) && ( 200 === $response['code'] || 'OK' === $response['message'] ) ) {
			return true;
		} elseif ( ! empty( $response['code'] ) && ( ! empty( $response['data'] ) && 'SUCCESS' === $response['data'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Fetch object id of created record.
	 *
	 * @param  array  $response Api response.
	 * @param  string $object  Api object.
	 * @return string           Id of object.
	 */
	public function get_object_id_from_response( $response = array(), $object = '' ) {

		$id = '';
		// If a operation response.
		if ( isset( $response['data'] ) && ! isset( $response['data']['QueryResponse'] ) ) {
			$data = ! empty( $response['data'] ) ? $response['data'] : array();
			$id   = reset( $data );
			return ! empty( $id ) && is_numeric( $id ) ? $id : '';
		}

		return $id;
	}

	/**
	 * Insert data into database.
	 *
	 * @param  array $log_data Log data.
	 */
	private function insert_log_data( $log_data ) {

		$connect         = 'Mwb_Cf7_Integration_Connect_' . Mwb_Cf7_Integration_With_Insightly::get_current_crm() . '_Framework';
		$connect_manager = $connect::get_instance();

		if ( 'yes' != $connect_manager->get_settings_details( 'logs' ) ) { // phpcs:ignore
			return;
		}

		global $wpdb;
		$table = $wpdb->prefix . 'mwb_' . Mwb_Cf7_Integration_With_Insightly::get_current_crm( 'slug' ) . '_cf7_log';
		$wpdb->insert( $table, $log_data ); // phpcs:ignore

	}

	/**
	 *  Get object id string.
	 *
	 * @param   string $crm_object     CRM Module.
	 * @since    1.0.0
	 * @return  array               Response data.
	 */
	public static function get_id_param_with_object( $crm_object = false ) {

		if ( ! $crm_object ) {
			return;
		}

		switch ( $crm_object ) {
			case 'Projects':
				$string = 'Project_id';
				break;

			case 'Opportunities':
				$string = 'Opportunity_id';
				break;

			case 'Tasks':
				$string = 'Task_id';
				break;

			case 'Contacts':
				$string = 'Contact_id';
				break;
			case 'Organisations':
				$string = 'Organisation_id';
				break;

			case 'Leads':
				$string = 'Lead_id';
				break;

			default:
				$string = '';
				break;
		}

		$id_string = strtoupper( $string );
		return $id_string;
	}

	/**
	 * Retrieve category from insightly.
	 *
	 * @param    bool   $force     Fetch data from API.
	 * @param    string $object    Insightly object.
	 * @since    1.0.0
	 * @return   mixed
	 */
	public function get_crm_category( $force = false, $object ) {

		if ( empty( $object ) ) {
			return;
		}

		if ( 'Tasks' == $object ) { //phpcs:ignore
			$object = 'Task';
		} elseif ( 'Opportunities' == $object ) { //phpcs:ignore
			$object = 'Opportunity';
		} elseif ( 'Projects' == $object ) { //phpcs:ignore
			$object = 'Project';
		}

		$category_data = get_transient( 'mwb_' . $this->crm_slug . '_cf7_' . $object . '_category_data', '' );
		if ( ! $force && ! empty( $category_data ) ) {
			return $category_data;
		}

		$this->base_url = self::$api_url;
		$headers        = $this->get_auth_header();
		$endpoint       = '/v3.1/' . $object . 'Categories';
		$response       = $this->get( $endpoint, '', $headers );

		if ( isset( $response['code'] ) && 200 == $response['code'] && 'OK' == $response['message'] ) { // phpcs:ignore
			if ( ! empty( $response['data'] ) ) {
				foreach ( $response['data'] as $key => $category ) {
					if ( isset( $category['ACTIVE'] ) && true === $category['ACTIVE'] ) {
						$category_data[ $category['CATEGORY_ID'] ] = $category['CATEGORY_NAME'];
					}
				}
				set_transient( 'mwb_' . $this->crm_slug . '_cf7_' . $object . '_category_data', $category_data );
			}
		}

	}

	// End of class.
}
