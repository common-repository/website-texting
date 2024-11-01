<?php

namespace LeadSMS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax Handler Class
 * @since 1.0.24
 */
class Settings
{
    // private $hostURL = 'https://connect.localtextmarketers.net'; //prod
    // private $hostURL = 'https://connect.ltmdev.net'; //dev
    // private $hostURL = 'https://connect8.ltmdev.net'; //dev with php v8
    private $hostURL = 'https://connectsms.ca'; //new host url
    public function bootAjaxActions()
    {
        add_action('wp_ajax_validate_license', function () {

            check_admin_referer('leadsms_admin_nonce');

            $licensekey = sanitize_text_field($_POST['licensekey']);

            $hostURL = $this->hostURL;

            $response = wp_remote_post($hostURL . "/_LEADsms_LK_validate.php", [
                'body' => [
                    'licensekey' => $licensekey,
                    'leadsmsaccess' => '3Txtea6BDo6naRjDwm3pUM42z8Udr7EC'
                ]
            ]);

            $output = wp_remote_retrieve_body($response);
            $validation = json_decode($output);

            // save the key
            update_option('leadsms_licensekey', [
                'licensekey' => $licensekey,
                'valid' => $validation->valid,
                'error' => $validation->error,
                'last_checked' => date("Y-m-d H:i:s"),
                'hide_powered_by' => $validation->hide_powered_by
            ]);

            wp_send_json($output);
        });

        add_action('wp_ajax_get_license_info', function () {
            check_admin_referer('leadsms_admin_nonce');

            $info = get_option('leadsms_licensekey', [
                'licensekey' => "",
                'valid' => null,
                'error' => "",
                'last_checked' => null,
                'hide_powered_by' => false
            ]);

            $info['host'] = $this->hostURL;
            wp_send_json($info);
        });

        add_action('wp_ajax_nopriv_send_message', array($this, 'sendMessage'));
        add_action('wp_ajax_send_message', array($this, 'sendMessage'));

        add_action('wp_ajax_nopriv_get_plugin_options', array($this, 'getPluginOptions'));
        add_action('wp_ajax_get_plugin_options', array($this, 'getPluginOptions'));

        add_action('wp_ajax_save_plugin_options', function () {

            check_admin_referer('leadsms_admin_nonce');

            // save visibility opts
            $visibility_opts = [
                'inAllPages' => wp_validate_boolean($_POST['visibility']['inAllPages']),
                'homepageOnly' => wp_validate_boolean($_POST['visibility']['homepageOnly']),
                'pagesOnly' => wp_validate_boolean($_POST['visibility']['pagesOnly']),
                'postsOnly' => wp_validate_boolean($_POST['visibility']['postsOnly'])
            ];

            update_option('leadsms_visibility', $visibility_opts);

            $colors_opts = [
                'header' => [
                    'bg' => sanitize_hex_color($_POST['appearance']['colors']['header']['bg']),
                    'text' => sanitize_hex_color($_POST['appearance']['colors']['header']['text'])
                ],
                'body' => [
                    'bg' => sanitize_hex_color($_POST['appearance']['colors']['body']['bg']),
                ],
                'button' => [
                    'outline' => sanitize_hex_color($_POST['appearance']['colors']['button']['outline']),
                    'text' => sanitize_text_field($_POST['appearance']['colors']['button']['text']),
                    'color' => sanitize_hex_color($_POST['appearance']['colors']['button']['color']),
                    'type' => sanitize_text_field($_POST['appearance']['colors']['button']['type'])
                ],
                'textUsButton' => [
                    'bg' => sanitize_hex_color($_POST['appearance']['colors']['textUsButton']['bg']),
                    'text' => sanitize_text_field($_POST['appearance']['colors']['textUsButton']['text']),
                    'color' => sanitize_hex_color($_POST['appearance']['colors']['textUsButton']['color']),
                ]
            ];

            $appearance_opts = [
                'headerText' => sanitize_textarea_field($_POST['appearance']['headerText']),
                'width' => intval($_POST['appearance']['width']),
                'height' => intval($_POST['appearance']['height']),
                'colors' => $colors_opts,
                'hidePoweredBy' => wp_validate_boolean($_POST['appearance']['hidePoweredBy']),
                'popoverEnabled' => wp_validate_boolean($_POST['appearance']['popoverEnabled']),
                'popoverText' => sanitize_textarea_field($_POST['appearance']['popoverText']),
                'popoverDelay' => intval($_POST['appearance']['popoverDelay'])
            ];

            update_option('leadsms_appearance', $appearance_opts);

            wp_send_json(['success' => true]);
        });
    }

    public function sendMessage()
    {
        check_ajax_referer('leadsms_nonce');

        $license = get_option('leadsms_licensekey', [
            'licensekey' => "",
            'valid' => null,
            'error' => "",
            'last_checked' => null,
            'hide_powered_by' => false
        ]);

        if (isset($_POST['form'])) {
            $sender = isset($_POST['form']['name']) ? sanitize_text_field($_POST['form']['name']) : "";
            $phone = isset($_POST['form']['phone']) ? sanitize_text_field($_POST['form']['phone']) : "";
            $message = isset($_POST['form']['message']) ? sanitize_textarea_field($_POST['form']['message']) : "";

            if ($sender && $phone && $message) {

                $fromPhone = str_replace(array("(", ")", " "), "-", $phone);

                $hostURL = $this->hostURL;
                // All inbound messages will be validating against this.
                $response = wp_remote_post($hostURL . "/_LEADsms_in_Wrapper.php", [
                    'body' => [
                        'AccountSid' => "AC23ac30f38763217a1d1c039661015050",
                        'AccountID' => $license['licensekey'],
                        'Body' => $message,
                        'From' => '+' . $fromPhone,
                        'Name' => $sender
                    ]
                ]);

                $body = wp_remote_retrieve_body($response);
                wp_send_json($body);
            } else {
                wp_send_json(['success' => false, 'message' => 'invalid form']);
            }
        } else {
            wp_send_json(['success' => false, 'message' => 'empty form']);
        }
        wp_die();
    }

    public function getPluginOptions()
    {
        check_ajax_referer('leadsms_nonce');

        $options = [];
        $hidePoweredBy = false;

        $license = get_option('leadsms_licensekey', [
            'licensekey' => "",
            'valid' => null,
            'error' => "",
            'last_checked' => null,
            'hide_powered_by' => false
        ]);

        if (isset($license['hide_powered_by']) && ($license['hide_powered_by'] == "1" || $license['hide_powered_by'] === true)) {
            $hidePoweredBy = true;
        }

        $options['visibility'] = get_option('leadsms_visibility', [
            'inAllPages' => true,
            'homepageOnly' => false,
            'pagesOnly' => false,
            'postsOnly' => false
        ]);

        $appearanceColors = $this->appearanceColorsDefaultOpts();

        $appearance = get_option('leadsms_appearance', $this->appearanceDefaultOpts());

        $options['appearance']['headerText'] = isset($appearance['headerText']) ? wp_unslash($appearance['headerText']) : "Send us a message and we'll text you back!";
        $options['appearance']['width'] = isset($appearance['width']) ? $appearance['width'] : 400;
        $options['appearance']['height'] = isset($appearance['height']) ? $appearance['height'] : 580;
        $options['appearance']['hidePoweredBy'] = $hidePoweredBy;
        $options['appearance']['popoverEnabled'] = isset($appearance['popoverEnabled']) && filter_var($appearance['popoverEnabled'], FILTER_VALIDATE_BOOLEAN);
        $options['appearance']['popoverText'] = isset($appearance['popoverText']) ? wp_unslash($appearance['popoverText']) : "Hi there, have a question? Text us here.";
        $options['appearance']['popoverDelay'] = isset($appearance['popoverDelay']) ? $appearance['popoverDelay'] : 1;

        if (!isset($appearance['colors'])) {
            $options['appearance']['colors'] = $appearanceColors;
        } else {
            $options['appearance']['colors'] = $appearance['colors'];
        }

        if (!isset($options['appearance']['colors']['button']['color'])) {
            $options['appearance']['colors']['button']['color'] = $appearanceColors['button']['color'];
        }
        if (!isset($options['appearance']['colors']['button']['type'])) {
            $options['appearance']['colors']['button']['type'] = $appearanceColors['button']['type'];
        }

        if (!isset($options['appearance']['colors']['textUsButton']['color'])) {
            $options['appearance']['colors']['textUsButton']['color'] = $appearanceColors['textUsButton']['color'];
        }
        if (!isset($options['appearance']['colors']['textUsButton']['bg'])) {
            $options['appearance']['colors']['textUsButton']['bg'] = $appearanceColors['textUsButton']['bg'];
        }
        if (!isset($options['appearance']['colors']['textUsButton']['text'])) {
            $options['appearance']['colors']['textUsButton']['text'] = $appearanceColors['textUsButton']['text'];
        }

        echo wp_json_encode($options);

        wp_die();
    }

    private function appearanceDefaultOpts()
    {
        return [
            'headerText' => "Send us a message and we'll text you back!",
            'width' => 400,
            'height' => 580,
            'colors' => $this->appearanceColorsDefaultOpts(),
            'hidePoweredBy' => false,
            'popoverEnabled' => true,
            'popoverText' => "Hi there, have a question? Text us here.",
            'popoverDelay' => 1,
        ];
    }

    private function appearanceColorsDefaultOpts()
    {
        return [
            'header' => [
                'bg' => '#2A9AD6',
                'text' => '#FFFFFF'
            ],
            'body' => [
                'bg' => '#F7F7F9',
            ],
            'button' => [
                'outline' => '#2A9AD6',
                'text' => 'Submit',
                'color' => '#2A9AD6',
                'type' => 'outline'
            ],
            'textUsButton' => [
                'bg' => '#2A9AD6',
                'text' => 'Text us',
                'color' => '#FFFFFF',
            ]
        ];
    }
}