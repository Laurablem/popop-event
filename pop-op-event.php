<?php
/*
 * Plugin Name: Popup Event
 * Plugin URI: http://localhost
 * Description: 3 event boxes that slide down smoothly
 * Version: 3.3.0
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
 * Shortcode: [popup_event section="1"]
 * Use section="1", section="2", or section="3"
 */
function popup_event_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'img' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang1.jpg',
            'section' => '1', // Which section (1, 2, or 3)
        ),
        $atts,
        'popup_event'
    );

    $uid = uniqid( 'event-boxes-' );
    $section = $atts['section'];

    // Define content for each section
    $events = array(
        '1' => array(
            array(
                'heading' => 'Beach Clean-up 2025',
                'date' => '15. December 2025',
                'description' => 'Kom og fejr julen med os! Der vil være god mad, sjov underholdning og hyggelig stemning. Alle er velkomne.',
            ),
            array(
                'heading' => 'Beach Clean-up 2026',
                'date' => '10. Januar 2026',
                'description' => 'Ring det nye år ind med stil! Gallamiddag, champagne ved midnat og festlig musik hele aftenen.',
            ),
            array(
                'heading' => 'Beach Clean-up 2026',
                'date' => '14. Februar 2026',
                'description' => 'En hyggelig vinteraften med varme drikke, levende musik og masser af hygge. Tag familien med!',
            ),
        ),
        '2' => array(
            array(
                'heading' => 'Sommerfest',
                'date' => '15. Juni 2025',
                'description' => 'Nyd sommeren med os! Grillmad, musik og aktiviteter for hele familien.',
            ),
            array(
                'heading' => 'Havnelys',
                'date' => '20. Juli 2025',
                'description' => 'En magisk aften ved havnen med levende lys, musik og hygge.',
            ),
            array(
                'heading' => 'Outdoor Cinema',
                'date' => '10. August 2025',
                'description' => 'Se film under stjernerne! Medbring tæpper og nyd aftenen.',
            ),
        ),
        '3' => array(
            array(
                'heading' => 'Høstmarked',
                'date' => '15. September 2025',
                'description' => 'Lokale varer, håndværk og underholdning. Kom og støt lokalområdet!',
            ),
            array(
                'heading' => 'Halloween Fest',
                'date' => '31. Oktober 2025',
                'description' => 'Uhyggelig fest med kostumer, konkurrencer og slik til børnene.',
            ),
            array(
                'heading' => 'Lysfest',
                'date' => '15. November 2025',
                'description' => 'Tænd vinteren med tusindvis af lys og varme drikke.',
            ),
        ),
    );

    // Get events for this section (default to section 1 if invalid)
    $section_events = isset($events[$section]) ? $events[$section] : $events['1'];

    ob_start();
    ?>
    <div class="event-wrapper" data-section="<?php echo esc_attr($section); ?>">
        <!-- Trigger billede -->
        <img src="<?php echo esc_url( $atts['img'] ); ?>"
             alt="Se kommende events"
             class="event-trigger event-trigger-section-<?php echo esc_attr($section); ?>"
             data-target="<?php echo esc_attr( $uid ); ?>">

        <!-- Event boxes container -->
        <div id="<?php echo esc_attr( $uid ); ?>" class="event-boxes-container event-boxes-section-<?php echo esc_attr($section); ?> event-hidden">
            
            <?php foreach ($section_events as $event): ?>
            <div class="event-box event-box-section-<?php echo esc_attr($section); ?>">
                <h3 class="event-heading"><?php echo esc_html($event['heading']); ?></h3>
                <p class="event-date"><?php echo esc_html($event['date']); ?></p>
                <p class="event-description"><?php echo esc_html($event['description']); ?></p>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'popup_event', 'popup_event_shortcode' );
