<?php

namespace TNP\API\V2\Subscriptions;

use Exception;
use NewsletterSubscription;
use TNP\API\V2\Subscribers\Subscribers_Controller;
use TNP\API\V2\Subscriptions\Validators\AcceptOnlyPublicExtraProfileFields;
use TNP\API\V2\Subscriptions\Validators\AcceptOnlyPublicLists;
use TNP\API\V2\Subscriptions\Validators\SubscriptionValidators;
use WP_REST_Response;
use WP_REST_Server;

class Subscriptions_Controller extends Subscribers_Controller {

	public function __construct() {
		parent::__construct();
		$this->rest_base = 'subscriptions';
	}

	/**
	 * Registers the subscriptions routes
	 */
	public function register_routes() {

		register_rest_route( $this->namespace, "/$this->rest_base",
			array(
				// POST /subscriptions
				array(
					'methods'  => WP_REST_Server::CREATABLE,
					'args'     => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
					'callback' => array( $this, 'create_item' ),
					'permission_callback' => '__return_true',
				)
			)
		);

	}

	public function create_item( $request ) {

		$subscription_module = NewsletterSubscription::instance();

		$subscription       = $subscription_module->get_default_subscription();
		$subscription->data = $this->create_subscription_data_from_request( $request );

		try {

			$validators = new SubscriptionValidators( new AcceptOnlyPublicLists(), new AcceptOnlyPublicExtraProfileFields() );
			$validators->validate( $subscription->data );

		} catch ( Exception $exception ) {
			return new WP_REST_Response( $exception->getMessage(), 400 );
		}

		$subscription_ret = $subscription_module->subscribe2( $subscription );

		if ( is_wp_error( $subscription_ret ) ) {
			return $subscription_ret;
		}

		$response = new WP_REST_Response();
		$response->set_status( 201 );

		return $response;
	}

}
