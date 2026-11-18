<?php
/**
 * Plugin Name: Offer Loop Gallery for Elementor
 * Description: Infinite, draggable offer image gallery for Elementor with individual overlay buttons.
 * Version: 1.1.0
 * Author: Framework Web
 * Text Domain: offer-loop-gallery
 */

if (!defined('ABSPATH')) {
    exit;
}

define('OLG_VERSION', '1.1.0');
define('OLG_PATH', plugin_dir_path(__FILE__));
define('OLG_URL', plugin_dir_url(__FILE__));

add_action('plugins_loaded', function () {

    if (!did_action('elementor/loaded')) {
        return;
    }

    // ======================================
    // REGISTER ELEMENTOR WIDGET
    // ======================================

    add_action('elementor/widgets/register', function ($widgets_manager) {

        require_once OLG_PATH . 'includes/class-offer-loop-gallery.php';

        $widgets_manager->register(
            new \OLG_Offer_Loop_Gallery()
        );

    });

    // ======================================
    // REGISTER CSS AND JAVASCRIPT
    // ======================================

    add_action('wp_enqueue_scripts', function () {

        wp_register_style(
            'olg-gallery',
            OLG_URL . 'assets/css/offer-loop-gallery.css',
            [],
            OLG_VERSION
        );

        wp_register_script(
            'olg-gallery',
            OLG_URL . 'assets/js/offer-loop-gallery.js',
            [],
            OLG_VERSION,
            true
        );

    });

});
