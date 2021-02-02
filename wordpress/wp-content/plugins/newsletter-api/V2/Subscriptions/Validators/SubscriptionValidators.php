<?php

namespace TNP\API\V2\Subscriptions\Validators;

use Exception;
use TNP_Subscription_Data;

class SubscriptionValidators {

	/**
	 * @var ValidatorI[]
	 */
	private $validator_list = [];

	/**
	 * SubscriptionValidators constructor.
	 *
	 * @param ValidatorI ...$validators
	 */
	public function __construct( ...$validators ) {
		$this->validator_list = $validators;
	}

	/**
	 * @param TNP_Subscription_Data $subscriber
	 *
	 * @throws Exception
	 */
	public function validate( $subscriber ) {
		foreach ( $this->validator_list as $validator ) {
			$validator->validate( $subscriber );
		}
	}

}
