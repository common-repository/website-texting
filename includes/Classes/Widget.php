<?php

namespace LeadSMS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax Handler Class
 * @since 1.0.0
 */
class Widget
{
    public function getHtml()
    {
        $appearance = get_option('leadsms_appearance', [
            'popoverText' => esc_html("Hi there, have a question? Text us here."),
            'popoverEnabled' => true,
            'popoverDelay' => 1
        ]);

        $popoverEnabled = isset($appearance['popoverEnabled']) && filter_var($appearance['popoverEnabled'], FILTER_VALIDATE_BOOLEAN);
        $popoverText = isset($appearance['popoverText']) ? wp_unslash($appearance['popoverText']) : "Hi there, have a question? Text us here.";
        $popoverDelay = isset($appearance['popoverDelay']) ? $appearance['popoverDelay'] : 1;
        $textUsButtonBg = isset($appearance['colors']['textUsButton']['bg']) ? $appearance['colors']['textUsButton']['bg'] : '#2A9AD6';
        $textUsButtonColor = isset($appearance['colors']['textUsButton']['color']) ? $appearance['colors']['textUsButton']['color'] : '#FFFFFF';
        $textUsButtonText = isset($appearance['colors']['textUsButton']['text']) ? $appearance['colors']['textUsButton']['text'] : 'Text us';


        $html = '
        <div class="leadsms-widget-container" data-prompt-delay="' . esc_attr($popoverDelay) . '" data-prompt-enabled="' . esc_attr($popoverEnabled ? '1' : '0') . '">
            <div id="LEADSMS_widget"><Widget /></div>
            <div class="leadsms-widget-launcher">
                <div class="leadsms-widget-prompt hidden">
                    <div class="content">
                    <div>' . esc_html($popoverText) . '</div>
                        <span class="close-button"><svg
                    width="12"
                    height="12"
                    viewBox="0 0 26 26"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M1 25L25 1M25 25L1 1"
                      stroke="#a1a1a1"
                      stroke-width="2.57753"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg></span>
                    </div>
                </div>
                <div class="leadsms-widget-bubble" style="background-color: ' . esc_attr($textUsButtonBg) . '">
                    <div class="leadsms-widget-launcher-icon">
                        <div class="leadsms-widget-launcher-icon-message">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_607_117)">
                                    <path d="M20 2.00006H4C2.9 2.00006 2.01 2.90006 2.01 4.00006L2 22.0001L6 18.0001H20C21.1 18.0001 22 17.1001 22 16.0001V4.00006C22 2.90006 21.1 2.00006 20 2.00006ZM17 14.0001H7C6.45 14.0001 6 13.5501 6 13.0001C6 12.4501 6.45 12.0001 7 12.0001H17C17.55 12.0001 18 12.4501 18 13.0001C18 13.5501 17.55 14.0001 17 14.0001ZM17 11.0001H7C6.45 11.0001 6 10.5501 6 10.0001C6 9.45006 6.45 9.00006 7 9.00006H17C17.55 9.00006 18 9.45006 18 10.0001C18 10.5501 17.55 11.0001 17 11.0001ZM17 8.00006H7C6.45 8.00006 6 7.55006 6 7.00006C6 6.45006 6.45 6.00006 7 6.00006H17C17.55 6.00006 18 6.45006 18 7.00006C18 7.55006 17.55 8.00006 17 8.00006Z" fill="' . $textUsButtonColor . '"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_607_117">
                                        <rect width="24" height="24" fill="' . esc_attr($textUsButtonColor) . '"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="leadsms-widget-launcher-icon-close hidden">
                            <svg width="16" height="16" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 25L25 1M25 25L1 1" stroke="' . esc_attr($textUsButtonColor) . '" stroke-width="2.57753" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <label style="color: ' . esc_attr($textUsButtonColor) . '">' . esc_html($textUsButtonText) . '</label>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }
}