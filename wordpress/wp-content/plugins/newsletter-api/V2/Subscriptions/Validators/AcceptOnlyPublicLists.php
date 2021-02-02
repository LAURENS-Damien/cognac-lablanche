<?php

namespace TNP\API\V2\Subscriptions\Validators;

use Exception;
use Newsletter;
use TNP_Subscription_Data;

class AcceptOnlyPublicLists implements ValidatorI {
	/**
	 * @param TNP_Subscription_Data $subscriber
	 *
	 * @throws Exception
	 */
	public function validate( $subscriber ) {

		$lists = Newsletter::instance()->get_lists();

		foreach ( $lists as $key => $list ) {
			if ( isset( $subscriber->lists[ $list->id ] )
			     && $subscriber->lists[ $list->id ] == 1
			     && $list->is_private()
			     && ! $list->forced ) {
				throw new Exception( 'Only public lists are accepted' );
			}
		}

	}
}
