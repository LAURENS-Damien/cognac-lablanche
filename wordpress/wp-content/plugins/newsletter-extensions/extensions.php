<?php

/*
  Plugin Name: Newsletter - Addons Manager
  xPlugin URI: http://www.thenewsletterplugin.com/documentation/extensions-extension
  Description: Manages all premium and free Newsletter addons directly from your blog
  Version: 1.1.1
  Author: The Newsletter Team
  Author URI: http://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

defined('ABSPATH') || exit;

class NewsletterExtensions {

    /**
     * @var NewsletterExtensions
     */
    static $instance;
    var $prefix = 'newsletter_extensions';
    var $slug = 'newsletter-extensions';
    var $plugin = 'newsletter-extensions/extensions.php';
    var $id = 85;
    static $required_nl_version = "6.3.5";

    function __construct() {
        self::$instance = $this;

        add_action('init', array($this, 'hook_init'), 1);
    }

    function hook_init() {
        if (!class_exists('Newsletter')) {
            return;
        } 
       
        if (NEWSLETTER_VERSION < NewsletterExtensions::$required_nl_version) {
            if (is_admin()) {
                add_action('admin_notices', array($this, 'extensions_admin_notice__error'));
            } else {
                return;
            }
        }

        if (is_admin()) {
            add_action('admin_menu', array($this, 'hook_admin_menu'), 50);
            add_filter('newsletter_menu_settings', array($this, 'hook_newsletter_menu_settings'));
            add_action('wp_ajax_tnp_addons_register', array($this, '_register'));
            add_action('wp_ajax_tnp_addons_license', array($this, 'license'));
        }
        
        //add_filter('site_transient_update_plugins', array($this, 'hook_site_transient_update_plugins'));
    }
    
    

    function _register() {
        $logger = new NewsletterLogger('extensions');
        
        check_ajax_referer('register');
        header('Content-Type: application/json');
        $email = $_POST['email'];
        if (!is_email($email)) {
            echo json_encode(array('message' => 'The email address is invalid.'));
            wp_die();
        }

        // Call to our API
        //$response = new WP_Error(); // From wp_remote_post
        //$response = array('body' => 'shdfjahgfjhdsafjd', 'response' => array('code' => 200)); // Wrong body
        //$response['response']['code']
        //$response = array('response' => array('code' => 403));

        //$response = array('body' => '{"license_key": "1234567890"}', 'response' => array('code' => 200)); // Wrong body

        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/new-account.php', array(
            'body' => array('email' => $email)
        ));

        if (is_wp_error($response)) {
            echo json_encode(array('message' => 'Unable to contact the registration service.'));
            // TODO: Logging
            wp_die();
        }

        if (wp_remote_retrieve_response_code($response) != '200') {
            echo json_encode(array('message' => 'Registration service error (code ' . wp_remote_retrieve_response_code($response) . ').'));
            // TODO: Logging
            wp_die();
        }

        $logger->debug(wp_remote_retrieve_body($response));
        // $response['body']
        $data = json_decode(wp_remote_retrieve_body($response));

        if (!is_object($data)) {
            $logger->debug($data);
            echo json_encode(array('message' => 'Invalid response from the registration service.'));
            // TODO: Logging
            die();
        }

        // That is a warning
        if (isset($data->message)) {
            echo json_encode(array('message' => $data->message));
            die();
        }

        // User registered
        $options = get_option('newsletter_main');
        $options['contract_key'] = $data->license_key;
        $options['licence_expires'] = -1;
        update_option('newsletter_main', $options);

        // Setup the license key      
        echo json_encode(array('message' => 'Registration completed', 'reload' => true));
        wp_die();
    }

    function check_license($license_key) {
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/license-check.php', array(
            'body' => array('k' => $license_key)
        ));
        if (is_wp_error($response))
            return $response;

        if (wp_remote_retrieve_response_code($response) != '200') {
            return new WP_Error(wp_remote_retrieve_response_code($response), 'License validation service error (code ' . wp_remote_retrieve_response_code($response) . ').');
        }
        $data = json_decode(wp_remote_retrieve_body($response));

        if (!is_object($data)) {
            return new WP_Error(1, 'Invalid response from the license validation service.');
        }

        // That is a warning
        if (isset($data->message)) {
            return new WP_Error(1, $data->message);
        }
        return $data;
    }

    function license() {
        check_ajax_referer('license');
        header('Content-Type: application/json');
        $license_key = trim($_POST['license_key']);

        // Call to our API
        $response = new WP_Error(); // From wp_remote_post
        $response = array('body' => 'shdfjahgfjhdsafjd', 'response' => array('code' => 200)); // Wrong body
        //$response['response']['code']
        $response = array('response' => array('code' => 403));

        $response = array('body' => '{"license_key": "1234567890"}', 'response' => array('code' => 200)); // Wrong body

        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/license-check.php', array(
            'body' => array('k' => $license_key)
        ));

        if (is_wp_error($response)) {
            echo json_encode(array('message' => 'Unable to contact the registration service.'));
            // TODO: Logging
            wp_die();
        }

        if (wp_remote_retrieve_response_code($response) != '200') {
            echo json_encode(array('message' => 'License validation service error (code ' . wp_remote_retrieve_response_code($response) . ').'));
            // TODO: Logging
            wp_die();
        }

        // $response['body']
        $data = json_decode(wp_remote_retrieve_body($response));

        if (!is_object($data)) {
            echo json_encode(array('message' => 'Invalid response from the license validation service.'));
            // TODO: Logging
            wp_die();
        }

        // That is a warning
        if (isset($data->message)) {
            echo json_encode(array('message' => $data->message));
            wp_die();
        }

        // User registered
        $options = get_option('newsletter_main');
        $options['contract_key'] = $license_key;
        update_option('newsletter_main', $options);

        // Setup the license key    
        if (!$data->expire) {
            echo json_encode(array('message' => 'The free license is valid, thank you!', 'reload' => true));
        } else {
            echo json_encode(array('message' => 'The professional license is valid, thank you!', 'reload' => true));
        }
        wp_die();
    }
    
    function hook_site_transient_update_plugins($value) {
        static $extra_response = array();
        
        //$this->logger->debug('Update plugins transient called');
        
        if (!$value || !is_object($value)) {
            //$this->logger->info('Empty object');
            return $value;
        }
        
        if (!isset($value->response) || !is_array($value->response)) {
            $value->response = array();
        }
        
        if ($extra_response) {
            //$this->logger->debug('Already updated');
            $value->response = array_merge($value->response, $extra_response);
            return $value;
        }

        $extensions = Newsletter::instance()->getTnpExtensions();
        
        if (!$extensions) return $value;
        
        foreach ($extensions as $extension) {
            unset($value->response[$extension->wp_slug]);
            unset($value->no_update[$extension->wp_slug]);
        }

        if (!NEWSLETTER_EXTENSION_UPDATE) {
            //$this->logger->info('Updates disabled');
            return $value;
        }

        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        if (!function_exists('get_plugin_data')) {
            //$this->logger->error('No get_plugin_data function available!');
            return $value;
        }
        
        $license_key = Newsletter::instance()->get_license_key();

        foreach ($extensions as $extension) {
            
            // Patch for names convention
            $extension->plugin = $extension->wp_slug;

            //$this->logger->debug('Processing ' . $extension->plugin);
            //$this->logger->debug($extension);

            $plugin_data = false;
            if (file_exists(WP_PLUGIN_DIR . '/' . $extension->plugin)) {
                $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $extension->plugin, false, false);
            } else if (file_exists(WPMU_PLUGIN_DIR . '/' . $extension->plugin)) {
                $plugin_data = get_plugin_data(WPMU_PLUGIN_DIR . '/' . $extension->plugin, false, false);
            }

            if (!$plugin_data) {
                //$this->logger->debug('Seems not installed');
                continue;
            }

            $plugin = new stdClass();
            $plugin->id = $extension->id;
            $plugin->slug = $extension->slug;
            $plugin->plugin = $extension->plugin;
            $plugin->new_version = $extension->version;
            $plugin->url = $extension->url;
            $plugin->package = $this->get_package($extension->id, $license_key);

//            [banners] => Array
//                        (
//                            [2x] => https://ps.w.org/wp-rss-aggregator/assets/banner-1544x500.png?rev=2040548
//                            [1x] => https://ps.w.org/wp-rss-aggregator/assets/banner-772x250.png?rev=2040548
//                        )
//            [icons] => Array
//                        (
//                            [2x] => https://ps.w.org/advanced-custom-fields/assets/icon-256x256.png?rev=1082746
//                            [1x] => https://ps.w.org/advanced-custom-fields/assets/icon-128x128.png?rev=1082746
//                        )
            if (version_compare($extension->version, $plugin_data['Version']) > 0) {
                //$this->logger->debug('There is a new version');
                $extra_response[$extension->plugin] = $plugin;
            } else {
                //$this->logger->debug('There is NOT a new version');
                $value->no_update[$extension->plugin] = $plugin;
            }
            //$this->logger->debug('Added');
        }
        
        $value->response = array_merge($value->response, $extra_response);
        
        return $value;
    }
    

    function extensions_admin_notice__error() {
        echo('<div class="notice notice-error"><p>Addons Manager requires at least Newsletter version '
        . NewsletterExtensions::$required_nl_version . ' to work, <a href="' . site_url('/wp-admin/plugins.php') . '">please update</a>.</p></div>');
    }

    /**
     * @deprecated
     */
    function get_extension_version($extension_id) {
        $versions = get_option('newsletter_extension_versions');
        if (!is_array($versions)) {
            return null;
        }
        foreach ($versions as $data) {
            if ($data->id == $extension_id) {
                return $data->version;
            }
        }

        return null;
    }

    function get_package($extension_id, $licence_key = '') {
        return 'http://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/get.php?f=' . urlencode($extension_id) .
                '&d=' . urlencode(home_url()) . '&k=' . urlencode($licence_key);
    }

    function hook_newsletter_menu_settings($entries) {
        $entries[] = array('label' => '<i class="fa fa-pencil-square-o"></i> Addons Manager', 'url' => '?page=newsletter_extensions_index', 'description' => 'Manager free and premium extensions for Newsletter');
        return $entries;
    }

    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'Addons Manager', '<span style="color:#27AE60; font-weight: bold;">Addons manager</span>', 'manage_options', 'newsletter_extensions_index', array($this, 'menu_page_index'));
    }

    function menu_page_index() {
        global $wpdb;
        require dirname(__FILE__) . '/index.php';
    }

    function register($extension) {
        if (empty($extension->plugin))
            return;
        $this->extensions[$extension->plugin] = $extension;
    }

    function get_extensions_catalog() {

        return Newsletter::instance()->getTnpExtensions();
    }

}

new NewsletterExtensions();
