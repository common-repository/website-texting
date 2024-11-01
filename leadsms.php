<?php

/**
 * Plugin Name: LEADsms
 * Plugin URI: https://localtextmarketers.com/introducing-leadsms-wordpress-sms-plugin/
 * Description: LEADsms offers WordPress webmasters an easy way to support their site visitors and generate leads and new business via SMS / text message.
 * Author: localtextmarketers
 * Author URI: https://localtextmarketers.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.0.24
 */
if (!defined('ABSPATH')) {
    exit;
}
define('LEADSMS_URL', plugin_dir_url(__FILE__));
define('LEADSMS_DIR', plugin_dir_path(__FILE__));
define('LEADSMS_VERSION', '1.0.24');

class LeadSMS
{
    public function boot()
    {
        $this->loadClasses();
        $this->registerPublic();
        $this->registerShortCodes();
        $this->renderMenu();
        $this->renderWidget();


        add_action('admin_notices', function () {
            $currentScreen = get_current_screen();
            // check license validity
            $license = get_option('leadsms_licensekey', [
                'licensekey' => "",
                'valid' => null,
                'error' => "",
                'last_checked' => null
            ]);

            if (!$license['valid'] && $currentScreen->parent_file !== 'wp-lead-sms-admin.php') {
                $class = 'notice notice-error';
                $message = __('To activate the LEADsms plugin, you will need to obtain your license key from your CONNECTsms account.', 'website-texting');

                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
                //To activate this plugin you will need to obtain your license key from your CONNECTsms account
            }
        });
    }

    public function loadClasses()
    {
        require LEADSMS_DIR . 'includes/autoload.php';
    }

    public function registerPublic()
    {
        add_action('wp_enqueue_scripts', function () {
            if (!is_admin()) {
                wp_enqueue_style('LEADSMS-widget-styling', LEADSMS_URL . 'assets/css/widget.css', array (), LEADSMS_VERSION);
            }
        }, 1); //load as first priority so any tailwind css would be overriden by the theme css
    }

    public function renderMenu()
    {
        add_action('admin_menu', function () {
            if (!current_user_can('manage_options')) {
                return;
            }
            add_menu_page(
                'LEADsms',
                'LEADsms',
                'manage_options',
                'wp-lead-sms-admin.php',
                array ($this, 'renderAdminPage'),
                'dashicons-editor-code',
                25
            );
        });
    }

    public function renderAdminPage()
    {
        wp_enqueue_script('LEADSMS-script-boot', LEADSMS_URL . 'assets/admin/js/start.js', array('jquery'), LEADSMS_VERSION, false);
        wp_enqueue_style('LEADSMS-global-styling', LEADSMS_URL . 'assets/css/element.css', array(), LEADSMS_VERSION);
        wp_enqueue_script('LEADSMS-spectrum', LEADSMS_URL . 'assets/js/spectrum.min.js', array('jquery'), LEADSMS_VERSION, false);
        wp_enqueue_style('LEADSMS-spectrum-styling', LEADSMS_URL . 'assets/css/spectrum.min.css', array(), LEADSMS_VERSION);
        wp_enqueue_style('LEADSMS-widget-styling', LEADSMS_URL . 'assets/css/widget.css', array(), LEADSMS_VERSION);

        $LEADSMS = apply_filters(
            'LEADSMS/admin_app_vars',
            array(
                'assets_url' => LEADSMS_URL . 'assets/',
                'ajaxurl' => admin_url('admin-ajax.php'),
                '_wpnonce' => wp_create_nonce('leadsms_nonce'),
                '_wpnonce_admin' => wp_create_nonce('leadsms_admin_nonce'),
            )
        );

        wp_localize_script('LEADSMS-script-boot', 'LEADSMSAdmin', $LEADSMS);

        echo '<div class="LEADSMS-admin-page" id="LEADSMS_app">
            <router-view></router-view>
        </div>';
    }

    public function getWidgetHTML()
    {
        wp_enqueue_script('leadsms_widget_shortcodejs', LEADSMS_URL . 'assets/js/shortcode.js', array('jquery'), LEADSMS_VERSION, false);
        wp_enqueue_script('leadsms_widget_script', LEADSMS_URL . 'assets/admin/js/widget.js', array('jquery', 'leadsms_widget_shortcodejs'), LEADSMS_VERSION, false);

        $LEADSMS = apply_filters(
            'LEADSMS/admin_app_vars',
            array(
                'assets_url' => LEADSMS_URL . 'assets/',
                'ajaxurl' => admin_url('admin-ajax.php'),
                '_wpnonce' => wp_create_nonce('leadsms_nonce'),
                '_wpnonce_widget' => wp_create_nonce('leadsms_widget_nonce'),
            )
        );

        wp_localize_script('leadsms_widget_script', 'LEADSMSAdmin', $LEADSMS);

        require_once (LEADSMS_DIR . 'includes/Classes/Widget.php');
        $widget = new \LeadSMS\Classes\Widget();

        return $widget->getHtml();
    }

    public function registerShortCodes()
    {
        // your shortcode here
        add_shortcode('leadsms_widget', function () {
            return $this->getWidgetHTML();
        });
    }

    public function renderWidget()
    {
        add_action('wp_footer', function ($content) {

            // check license validity
            $license = get_option('leadsms_licensekey', [
                'licensekey' => "",
                'valid' => null,
                'error' => "",
                'last_checked' => null
            ]);

            if ($license['valid']) {
                // check visibility option
                $visibility = get_option('leadsms_visibility', [
                    'inAllPages' => true,
                    'homepageOnly' => false,
                    'pagesOnly' => false,
                    'postsOnly' => false
                ]);

                $shown = false;
                if ($visibility['inAllPages']) {
                    $shown = true;
                } else {
                    if ($visibility['homepageOnly'] && is_front_page()) {
                        $shown = true;
                    }
                    if ($visibility['pagesOnly'] && !is_front_page() && is_page()) {
                        $shown = true;
                    }
                    if ($visibility['postsOnly'] && !is_front_page() && is_single()) {
                        $shown = true;
                    }
                }

                if ($shown) {
                    echo $this->getWidgetHTML();
                }
            }
        });
    }
}

(new LeadSMS())->boot();