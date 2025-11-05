<?php
/*
 * Plugin Name: Popup Event
 * Plugin URI: http://localhost
 * Description: Popup med datoer til events
 * Version: 1.2.0
 * Author: LAURA BLEM VINKLER
 * Author URI: http://localhost
 * License: GPL2
 */

// Sikkerhed: stop direkte adgang
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Indlæs CSS og JS til popup
 */
function popup_event_enqueue_assets() {
    wp_enqueue_style(
        'popup-event-style',
        plugin_dir_url( __FILE__ ) . 'assets/css/style.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'popup-event-script',
        plugin_dir_url( __FILE__ ) . 'assets/js/script.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'popup_event_enqueue_assets' );

/**
 * Shortcode: [popup_event img="URL-TIL-BILLEDE" title="Min titel"]Indhold her[/popup_event]
 */
function popup_event_shortcode( $atts, $content = null ) {
    // Standardværdier
    $atts = shortcode_atts(
        array(
            'img'   => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang1.jpg', // fallback-billede
            'title' => 'Kommende events',
        ),
        $atts,
        'popup_event'
    );

    // Unikt ID til denne popup-instance
    $uid = uniqid( 'popup-event-' );

    // Klargør indhold (tillad linjeskift osv.)
    $content = wpautop( do_shortcode( $content ) );

    ob_start();
    ?>
    <div class="popup-event-wrapper">
        <!-- Billedet der åbner popup'en -->
        <img src="<?php echo esc_url( $atts['img'] ); ?>"
             alt="<?php echo esc_attr( $atts['title'] ); ?>"
             class="popup-event-trigger"
             data-popup-target="<?php echo esc_attr( $uid ); ?>"
             style="cursor:pointer; max-width:200px;">

        <!-- Selve popup'en (overlay) -->
        <div id="<?php echo esc_attr( $uid ); ?>" class="popup-event-overlay popup-hidden">
            <div class="popup-content">
                <button type="button" class="popup-close" aria-label="Luk popup">×</button>
                <h2><?php echo esc_html( $atts['title'] ); ?></h2>
                <div class="popup-body">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'popup_event', 'popup_event_shortcode' );
