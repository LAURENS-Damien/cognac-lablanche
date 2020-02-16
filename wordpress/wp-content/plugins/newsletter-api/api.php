<?php

/*
  Plugin Name: Newsletter - API
  Plugin URI: https://www.thenewsletterplugin.com/developers/api
  Description:
  Version: 2.0.2
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

class NewsletterApi {

    /**
     * @var NewsletterApi
     */
    static $instance;
    static $required_nl_version = "5.2.6";
    var $prefix = 'newsletter_api';
    var $slug = 'newsletter-api';
    var $plugin = 'newsletter-api/api.php';
    var $id = 77;
    var $options;
    var $logger;

    function __construct() {
        self::$instance = $this;
        $this->options = get_option($this->prefix, array());
        add_action('init', array($this, 'hook_init'));
    }

    function hook_init() {

        if (!class_exists('Newsletter')) {
            return;
        }

        if (NEWSLETTER_VERSION < NewsletterApi::$required_nl_version) {
            if (is_admin()) {
                add_action('admin_notices', array($this, 'api_admin_notice__warning'));
            }
        } else {
            require_once __DIR__ . '/TNP_REST_Controller.php';
            add_action('rest_api_init', function () {
                new TNP_REST_Controller($this->options);
            });
        }

        if (empty($this->options)) {
            $this->options['key'] = Newsletter::instance()->options['api_key'];
            $this->save_options($this->options);
        }

        add_filter('site_transient_update_plugins', array($this, 'hook_site_transient_update_plugins'));
        if (is_admin()) {
            add_action('admin_menu', array($this, 'hook_admin_menu'), 100);
            add_filter('newsletter_menu_settings', array($this, 'hook_newsletter_menu_settings'));
        }
    }

    function hook_newsletter_menu_settings($entries) {
        $entries[] = array('label' => '<i class="fa fa-exchange"></i> API', 'url' => '?page=newsletter_api_index', 'description' => '');
        return $entries;
    }

    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'API', '<span class="tnp-side-menu">API</span>', 'manage_options', 'newsletter_api_index', array($this, 'menu_page_index'));
    }

    function menu_page_index() {
        global $wpdb;
        require dirname(__FILE__) . '/index.php';
    }

    function hook_site_transient_update_plugins($value) {
        if (!method_exists('Newsletter', 'set_extension_update_data')) {
            return $value;
        }

        return Newsletter::instance()->set_extension_update_data($value, $this);
    }

    function api_admin_notice__warning() {
        echo('<div class="notice notice-warning"><p>The new JSON and PHP API requires at least Newsletter version '
        . NewsletterApi::$required_nl_version . ' to work, <a href="' . site_url('/wp-admin/plugins.php') . '">please update</a>.</p></div>');
    }

    /**
     * 
     * @return NewsletterLogger
     */
    function get_logger() {
        if ($this->logger) {
            return $this->logger;
        }
        $this->logger = new NewsletterLogger('api');
        return $this->logger;
    }

    function save_options($options) {
        $this->options = $options;
        update_option($this->prefix, $options);
    }

}

new NewsletterApi();
