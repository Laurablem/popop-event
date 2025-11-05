<?php
/*
 * Plugin Name: Popup Event
 * Plugin URI: http://localhost
 * Description: 3 event boxes that slide down smoothly
 * Version: 2.2.0
 * Author: LAURA BLEM VINKLER
 * Author URI: http://localhost
 * License: GPL2
 */

// Sikkerhed: stop direkte adgang
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Indlæs CSS og JS
 */
function popup_event_enqueue_assets() {
    wp_enqueue_style(
        'popup-event-style',
        plugin_dir_url( __FILE__ ) . 'assets/css/style.css',
        array(),
        '2.0.0'
    );

    wp_enqueue_script(
        'popup-event-script',
        plugin_dir_url( __FILE__ ) . 'assets/js/script.js',
        array( 'jquery' ),
        '2.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'popup_event_enqueue_assets' );

/**
 * Shortcode: [popup_event]
 */
function popup_event_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'img' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang1.jpg',
        ),
        $atts,
        'popup_event'
    );

    $uid = uniqid( 'event-boxes-' );

    ob_start();
    ?>
    <div class="event-wrapper">
        <!-- Trigger billede -->
        <img src="<?php echo esc_url( $atts['img'] ); ?>"
             alt="Se kommende events"
             class="event-trigger"
             data-target="<?php echo esc_attr( $uid ); ?>">

        <!-- Event boxes container -->
        <div id="<?php echo esc_attr( $uid ); ?>" class="event-boxes-container event-hidden">
            
            <!-- Event 1 -->
            <div class="event-box">
                <h3 class="event-heading">Beach Clean-up 2025</h3>
                <p class="event-date">15. December 2025</p>
                <p class="event-description">Kom og fejr julen med os! Der vil være god mad, sjov underholdning og hyggelig stemning. Alle er velkomne.</p>
            </div>

            <!-- Event 2 -->
            <div class="event-box">
                <h3 class="event-heading">Beach Clean-up 2026</h3>
                <p class="event-date">10. Januar 2026</p>
                <p class="event-description">Ring det nye år ind med stil! Gallamiddag, champagne ved midnat og festlig musik hele aftenen.</p>
            </div>

            <!-- Event 3 -->
            <div class="event-box">
                <h3 class="event-heading">Beach Clean-up 2026</h3>
                <p class="event-date">14. Februar 2026</p>
                <p class="event-description">En hyggelig vinteraften med varme drikke, levende musik og masser af hygge. Tag familien med!</p>
            </div>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'popup_event', 'popup_event_shortcode' );


