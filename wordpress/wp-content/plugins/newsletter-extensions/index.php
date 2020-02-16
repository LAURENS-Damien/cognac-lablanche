<?php
@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterExtensions::$instance;
$extensions = $module->get_extensions_catalog();
$license_key = Newsletter::instance()->get_license_key();

$license_data = null;
if (!empty($license_key)) {
    $license_data = $module->check_license($license_key);
}

if ($controls->is_action('install')) {

    $extension = null;
    foreach ($extensions as $e) {
        if ($e->id == $_GET['id']) {
            $extension = $e;
            break;
        }
    }

    $id = $extension->id;
    $slug = $extension->slug;

    $source = 'http://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/get.php?f=' . $id .
            '&k=' . $license_key;

    if (!class_exists('Plugin_Upgrader', false)) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    }

    $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());

    $result = $upgrader->install($source);
    if (!$result || is_wp_error($result)) {
        $controls->errors = __('Error while installing', 'newsletter');
        if (is_wp_error($result)) {
            $controls->errors .= ': ' . $result->get_error_message();
        }
    } else {
        $result = activate_plugin($extension->wp_slug);
        if (is_wp_error($result)) {
            $controls->errors .= __('Error while activating:', 'newsletter') . " " . $result->get_error_message();
        } else {
            $controls->messages .= __('Installed and activated', 'newsletter');
        }
    }
    wp_clean_plugins_cache(false);
    //wp_redirect(admin_url('admin.php') . '?page=newsletter_main_extensions');
    //die();
}

if ($controls->is_action('activate')) {
    $extension = null;
    foreach ($extensions as $e) {
        if ($e->id == $_GET['id']) {
            $extension = $e;
            break;
        }
    }
    $result = activate_plugin($extension->wp_slug);
    if (is_wp_error($result)) {
        $controls->errors .= __('Error while activating:', 'newsletter') . " " . $result->get_error_message();
    } else {
        $controls->messages .= __('Activated', 'newsletter');
    }
    wp_clean_plugins_cache(false);
    wp_redirect(admin_url('admin.php') . '?page=newsletter_extensions_index');
    die();
}

if ($controls->is_action('save')) {

    if (!empty($controls->data['contract_key'])) {

        $license_key = trim($controls->data['contract_key']);

        $validation = Newsletter::check_license($license_key);

		if (is_wp_error($validation)) {
			$controls->errors .= $validation->get_error_message();
			$controls->data['licence_expires'] = "";
			$license_key = false;
		} else {
			$controls->data['licence_expires'] = $validation['expires'];
			$controls->messages = 'Your license is valid and expires on ' . esc_html(date('Y-m-d', $validation['expires']));
			$option = get_option('newsletter_main');
			$option['contract_key'] = $license_key;
			update_option('newsletter_main', $option);
			delete_transient("tnp_extensions_json");
                        $extensions = $module->get_extensions_catalog();
			$controls->js_redirect('admin.php?page=newsletter_extensions_index');
		}
    }
}

if (is_wp_error($license_data)) {
    $controls->errors = $license_data->get_error_message();
    $controls->errors .= ' <a href="admin.php?page=newsletter_main_main">Check it on main settings</a>';
}

?>
<style>
    #tnp-promo {
        text-align: left;
        background-color: #222b36;
        margin: 20px;
        border-radius: 5px;
        padding: 20px 40px;
    }
    #tnp-promo .tnp-promo-how-to {
        width: 50%;
        padding: 5px 20px;
        margin-top: 30px;
        margin-bottom: 30px;
        border-left: 2px solid #F1C40F;
    }

    #tnp-promo .tnp-promo-how-to h3  {
        color: #ECF0F1;
        margin: 0px;
        line-height: 36px;
    }

    #tnp-promo .tnp-promo-how-to p  {
        color: #ECF0F1;
        margin: 0px;
        font-size: 16px;
        line-height: 26px;
    }

    #tnp-promo .tnp-promo-buttons {
        margin: 50px 0px;
    }

    #tnp-promo .tnp-promo-button {
        background: #27AE60;
        text-decoration: none;
        color: white;
        padding: 15px 20px;
        font-size: 15px;
        border-radius: 2px;
    }

    #tnp-promo .tnp-promo-button:hover {
        background: #2ECC71;
        color: white;
    }

    #tnp-promo .tnp-promo-button i {
        margin-right: 3px;
    }

    #tnp-promo #tnp-email, #tnp-promo #tnp-license-key {
        margin: 20px 0px;
        padding: 10px;
        width: 300px;
        border: none;
        color: #656565;
    }

    #tnp-promo .tnp-button {
        border: none;
        padding: 11px 15px;
    }

    #tnp-promo .tnp-button:hover {
        cursor: pointer;
        background-color: #5d9fcc;
    }

    #tnp-promo .tnp-notes {
        background-color: #272f3a;
        padding: 10px;
        border-left: 2px solid green;
        color: white;
    }

    #tnp-promo .tnp-promo-one-third, #tnp-promo .tnp-promo-two-third, #tnp-promo .tnp-promo-third-third {
        display: inline-block;
        vertical-align: middle;
    }

    #tnp-promo .tnp-promo-one-third {
        width: 15%;
        margin-right: 20px;
    }

    #tnp-promo .tnp-promo-two-third {
        width: 30%;
        margin-right: 20px;
    }

    #tnp-promo .tnp-promo-third-third {
        width: 45%;
    }

    .tnp-promo-insert {
        padding: 0px 40px !important;
    }

    .tnp-promo-insert #tnp-license-key {
        padding: 3px 15px !important;
    }

    .tnp-promo-insert .tnp-button {
        padding: 4px 10px !important;
        background-color: #27AE60 !important;
    }

    .tnp-promo-insert .tnp-button:hover {
        background-color: #2ECC71 !important;
    }

</style>

<script>
    function tnp_register() {
        jQuery.post(ajaxurl, {
            action: "tnp_addons_register",
            _wpnonce: "<?php echo wp_create_nonce("register") ?>",
            email: document.getElementById("tnp-email").value
        }, function (data) {
            alert(data.message);
            if (data.reload)
                location.reload();

        });
    }
    function tnp_license() {
        jQuery.post(ajaxurl, {
            action: "tnp_addons_license",
            _wpnonce: "<?php echo wp_create_nonce("license") ?>",
            license_key: document.getElementById("tnp-license-key").value
        }, function (data) {
            alert(data.message);
            if (data.reload)
                location.reload();

        });
    }

</script>
<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>




    <div id="tnp-body">

        <?php if (is_wp_error($license_data)) { ?>
        <p>There are problems to contact the license validator. Check the status panel for more information.</p>
        
        <?php } else if (empty($license_key)) { ?>
            <div id="tnp-promo" class="tnp-promo-create">
                <h1>Almost done. Get a free license key to install our free addons!</h1>

                <input id="tnp-email" type="email" name="email" value="<?php echo esc_attr($current_user->user_email) ?>" placeholder="Your email address">
<!--                <input class="tnp-button" type="button" value="Create account" onclick="tnp_register()">-->
                <button class="tnp-button" onclick="tnp_register()">Create account  <i class="fas fa-arrow-right"></i></button>
                <br>
                <div class="tnp-notes">A free account will be created on <a href="https://www.thenewsletterplugin.com" target="_blank">thenewsletterplugin.com</a> and a free license key generated. See
                    the privacy policy and terms of use on our site.</div>
            </div>


            <div id="tnp-promo" class="tnp-promo-insert">
                <div class="tnp-promo-one-third">
                    <h2>Already have a license?</h2>
                </div>

                <div class="tnp-promo-two-third">
                    <input id="tnp-license-key" type="text" name="license" value="" placeholder="Your license key">
                    <button class="tnp-button" onclick="tnp_license()">Save</button>
                </div>
                <div class="tnp-promo-third-third">
                    <div class="tnp-notes">Tip: if you registered on <a href="https://www.thenewsletterplugin.com" target="_blank">thenewsletterplugin.com</a>
                        get it on <a href="https://www.thenewsletterplugin.com/account" target="_blank">your account</a>.
                    </div>
                </div>
               

            </div>
        <?php } else if ($license_data->expire == -1) { // Free license ?>
        
        <h1>Are you enjoying our free addons?</h1>
        <h2><a href="https://www.thenewsletterplugin.com/premium" target="_blank">Check out how to jump up to a pro level with our premium addons</a></h2>
        
        <?php } ?>

        <?php if (is_array($extensions)) { ?>

            <!-- Extensions -->
            <?php foreach ($extensions AS $e) { ?>

                <?php
                $e->activate_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=activate&id=' . $e->id, 'save');
                $e->install_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=install&id=' . $e->id, 'save');
                ?>

                <?php if ($e->type == "extension" || $e->type == "premium") { ?>
                    <?php if ($e->free) { ?>
                        <div class="tnp-extension-free-box <?php echo $e->slug ?>">
                        <?php } else { ?>
                            <div class="tnp-extension-premium-box <?php echo $e->slug ?>">
                            <?php } ?>
                            <?php if ($e->free) { ?>
                                <img class="tnp-extensions-free-badge" src="<?php echo plugins_url('newsletter') ?>/images/extension-free.png">
                            <?php } ?>
                            <div class="tnp-extensions-image"><img src="<?php echo $e->image ?>" alt="" /></div>
                            <h3><?php echo $e->title ?></h3>
                            <p><?php echo $e->description ?></p>
                            <div class="tnp-extension-premium-action">
                                <?php if (is_plugin_active($e->wp_slug)) { ?>
                                    <span><i class="fa fa-check" aria-hidden="true"></i> <?php _e('Plugin active', 'newsletter') ?></span>
                                <?php } elseif (file_exists(WP_PLUGIN_DIR . "/" . $e->wp_slug)) { ?>
                                    <a href="<?php echo $e->activate_url ?>" class="tnp-extension-activate">
                                        <i class="fa fa-power-off" aria-hidden="true"></i> <?php _e('Activate', 'newsletter') ?>
                                    </a>
                                <?php } elseif ($e->downloadable) { ?>
                                        <?php if (empty($license_key)) { ?>
                                            <a href="#tnp-promo" class="tnp-extension-install">
                                                <i class="fa fa-download" aria-hidden="true"></i> Get a free license
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo $e->install_url ?>" class="tnp-extension-install">
                                                <i class="fa fa-download" aria-hidden="true"></i> Install Now
                                            </a>
                                        <?php } ?>
                                    
                                <?php } else { ?>
                                    <a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" class="tnp-extension-buy" target="_blank">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now
                                    </a>
                                <?php } ?>
                                <!--  
                                <?php if ($e->url) { ?>
                                            <br><br>
                                            <a href="<?php echo $e->url ?>" class="tnp-extension-details" target="_blank">
                                                View details
                                            </a>
                                <?php } ?>
                                -->
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>


                <!-- Integrations -->
                <?php foreach ($extensions AS $e) { ?>

                    <?php
                    $e->activate_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=activate&id=' . $e->id, 'save');
                    $e->install_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=install&id=' . $e->id, 'save');
                    ?>
                    <?php if ($e->type == "integration") { ?>
                        <?php if ($e->free) { ?>
                            <div class="tnp-extension-free-box <?php echo $e->slug ?>">
                            <?php } else { ?>
                                <div class="tnp-integration-box <?php echo $e->slug ?>">
                                <?php } ?>
                                <?php if ($e->free) { ?>
                                    <img class="tnp-extensions-free-badge" src="<?php echo plugins_url('newsletter') ?>/images/extension-free.png">
                                <?php } ?>
                                <div class="tnp-extensions-image"><img src="<?php echo $e->image ?>"></div>
                                <h3><?php echo $e->title ?></h3>
                                <p><?php echo $e->description ?></p>
                                <div class="tnp-extension-free-action">
                                    <?php if (is_plugin_active($e->wp_slug)) { ?>
                                        <span><i class="fa fa-check" aria-hidden="true"></i> <?php _e('Plugin active', 'newsletter') ?></span>
                                    <?php } elseif (file_exists(WP_PLUGIN_DIR . "/" . $e->wp_slug)) { ?>
                                        <a href="<?php echo $e->activate_url ?>" class="tnp-extension-activate">
                                            <i class="fa fa-power-off" aria-hidden="true"></i> <?php _e('Activate', 'newsletter') ?>
                                        </a>
                                    <?php } elseif ($e->downloadable) { ?>
                                        <?php if (empty($license_key)) { ?>
                                            <a href="#tnp-promo" class="tnp-extension-install">
                                                <i class="fa fa-download" aria-hidden="true"></i> Get a free license
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo $e->install_url ?>" class="tnp-extension-install">
                                                <i class="fa fa-download" aria-hidden="true"></i> Install Now
                                            </a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" class="tnp-extension-buy" target="_blank">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now
                                        </a>
                                    <?php } ?>
                                    <!--      
                                    <?php if ($e->url) { ?>
                                                <br><br>
                                                <a href="<?php echo $e->url ?>" class="tnp-extension-details" target="_blank">
                                                    View details
                                                </a>
                                    <?php } ?>
                                    -->
                                </div>
                            </div>
                        <?php } ?>

                    <?php } ?>


                    <!-- Delivery -->
                    <?php foreach ($extensions AS $e) { ?>

                        <?php
                        $e->activate_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=activate&id=' . $e->id, 'save');
                        $e->install_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=install&id=' . $e->id, 'save');
                        ?>

                        <?php if ($e->type == "delivery") { ?>
                            <?php if ($e->free) { ?>
                                <div class="tnp-extension-free-box <?php echo $e->slug ?>">
                                <?php } else { ?>
                                    <div class="tnp-integration-box <?php echo $e->slug ?>">
                                    <?php } ?>
                                    <?php if ($e->free) { ?>
                                        <img class="tnp-extensions-free-badge" src="<?php echo plugins_url('newsletter') ?>/images/extension-free.png">
                                    <?php } ?>
                                    <div class="tnp-extensions-image"><img src="<?php echo $e->image ?>" alt="" /></div>
                                    <h3><?php echo $e->title ?></h3>
                                    <p><?php echo $e->description ?></p>
                                    <div class="tnp-integration-action">
                                        <?php if (is_plugin_active($e->wp_slug)) { ?>
                                            <span><i class="fa fa-check" aria-hidden="true"></i> <?php _e('Plugin active', 'newsletter') ?></span>
                                        <?php } elseif (file_exists(WP_PLUGIN_DIR . "/" . $e->wp_slug)) { ?>
                                            <a href="<?php echo $e->activate_url ?>" class="tnp-extension-activate">
                                                <i class="fa fa-power-off" aria-hidden="true"></i> <?php _e('Activate', 'newsletter') ?>
                                            </a>
                                        <?php } elseif ($e->downloadable) { ?>
                                            <?php if (empty($license_key)) { ?>
                                            <a href="#tnp-promo" class="tnp-extension-install">
                                                <i class="fa fa-download" aria-hidden="true"></i> Get a free license
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo $e->install_url ?>" class="tnp-extension-install">
                                                <i class="fa fa-download" aria-hidden="true"></i> Install Now
                                            </a>
                                        <?php } ?>
                                        <?php } else { ?>
                                            <a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" class="tnp-extension-buy" target="_blank">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now
                                            </a>
                                        <?php } ?>
                                        <!--      
                                        <?php if ($e->url) { ?>
                                                    <br><br>
                                                    <a href="<?php echo $e->url ?>" class="tnp-extension-details" target="_blank">
                                                        View details
                                                    </a>
                                        <?php } ?>
                                        -->
                                    </div>
                                </div>
                            <?php } ?>

                        <?php } ?>


                    <?php } else { ?>

                        <p style="color: white;">No addons available. Could be a connection problem, try later.</p>

                    <?php } ?>


                    <p class="clear"></p>

                </div>

                <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

            </div>
