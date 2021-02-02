<?php

namespace TNP\API\V2\Subscriptions\Validators;

use Exception;
use Newsletter;
use TNP_Profile_Service;
use TNP_Subscription_Data;

class AcceptOnlyPublicExtraProfileFields implements ValidatorI {
	/**
	 * @param TNP_Subscription_Data $subscriber
	 *
	 * @throws Exception
	 */
	public function validate( $subscriber ) {

		$extra_profiles = TNP_Profile_Service::get_profiles();

		foreach ( $extra_profiles as $key => $profile ) {
			if ( isset( $subscriber->profiles[ $profile->id ] )
			     && $subscriber->profiles[ $profile->id ] != ''
			     && $profile->is_private() ) {
				throw new Exception( 'Only public extra profile fields are accepted' );
			}
		}

	}
}
