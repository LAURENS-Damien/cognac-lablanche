<?php

/*
  Plugin Name: Newsletter - API v1 and v2-beta
  Plugin URI: https://www.thenewsletterplugin.com/developers/api
  Description: Access programmatically to The Newsletter Plugin via REST API
  Version: 2.1.4
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if ($version < '6.9.4') {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required for API Addon.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterApi('2.1.4');
    }
});
