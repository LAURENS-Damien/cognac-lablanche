<?php

namespace TNP\API\V2\Subscriptions\Validators;

use Exception;
use TNP_Subscription_Data;

interface ValidatorI {
	/**
	 * @param TNP_Subscription_Data $subscriber
	 *
	 * @throws Exception
	 */
	public function validate( $subscriber );
}
