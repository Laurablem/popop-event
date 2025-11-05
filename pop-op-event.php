<?php
/*
 * Plugin Name: Popup Event
 * Plugin URI: http://localhost
 * Description: 3 event boxes that slide down smoothly
 * Version: 3.0.0
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
        '3.0.0'
    );

    wp_enqueue_script(
        'popup-event-script',
        plugin_dir_url( __FILE__ ) . 'assets/js/script.js',
        array( 'jquery' ),
        '3.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'popup_event_enqueue_assets' );

/**
 * Shortcode: [popup_event set="1"]
 * Use set="1", set="2", or set="3" to show different event sets
 */
function popup_event_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'set' => '1', // Which event set to display (1, 2, or 3)
        ),
        $atts,
        'popup_event'
    );

    $set = $atts['set'];
    $uid = uniqid( 'event-boxes-' );

    // Define images for each set
    $images = array(
        '1' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang1.jpg',
        '2' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang2.jpg',
        '3' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang3.jpg',
    );

    // Define events for each set
    $events = array(
        '1' => array(
            array(
                'heading' => 'Beach Clean-up 2025',
                'date' => '15. December 2025',
                'description' => 'Kom og vær med til at gøre en forskel! Vi samler affald på stranden og nyder naturen sammen.',
                'color' => '#26376B'
            ),
            array(
                'heading' => 'Beach Clean-up 2026',
                'date' => '10. Januar 2026',
                'description' => 'Start det nye år med at hjælpe miljøet. Sammen gør vi strandens renere og smukkere.',
                'color' => '#26376B'
            ),
            array(
                'heading' => 'Beach Clean-up 2026',
                'date' => '14. Februar 2026',
                'description' => 'En dag ved havet med fokus på bæredygtighed. Tag familien med til en meningsfuld dag.',
                'color' => '#26376B'
            ),
        ),
        '2' => array(
            array(
                'heading' => 'Sommerfest 2025',
                'date' => '20. Juni 2025',
                'description' => 'Fejr sommeren med musik, mad og gode venner. Hele dagen fyldt med sjove aktiviteter.',
                'color' => '#8bc8e5'
            ),
            array(
                'heading' => 'Grillaften',
                'date' => '5. Juli 2025',
                'description' => 'Hyggelig grillaften under åben himmel. Kom og nyd god mad og godt selskab.',
                'color' => '#8bc8e5'
            ),
            array(
                'heading' => 'Havnefest',
                'date' => '15. August 2025',
                'description' => 'Store havnefest med livemusik, god mad og festlig stemning ved vandet.',
                'color' => '#8bc8e5'
            ),
        ),
        '3' => array(
            array(
                'heading' => 'Julemarked',
                'date' => '1. December 2025',
                'description' => 'Besøg vores hyggelige julemarked med håndlavede gaver, varm kakao og julemusik.',
                'color' => '#ede0ca'
            ),
            array(
                'heading' => 'Julekoncert',
                'date' => '15. December 2025',
                'description' => 'Smuk julekoncert i kirken med kor, solister og traditionelle julesange.',
                'color' => '#ede0ca'
            ),
            array(
                'heading' => 'Nytårsshow',
                'date' => '31. December 2025',
                'description' => 'Spektakulært nytårsshow med fyrværkeri, underholdning og champagne ved midnat.',
                'color' => '#ede0ca'
            ),
        ),
    );

    // Get the image and events for this set
    $img_url = isset($images[$set]) ? $images[$set] : $images['1'];
    $event_list = isset($events[$set]) ? $events[$set] : $events['1'];

    ob_start();
    ?>
    <div class="event-wrapper">
        <!-- Trigger billede -->
        <img src="<?php echo esc_url( $img_url ); ?>"
             alt="Se kommende events"
             class="event-trigger"
             data-target="<?php echo esc_attr( $uid ); ?>">

        <!-- Event boxes container -->
        <div id="<?php echo esc_attr( $uid ); ?>" class="event-boxes-container event-hidden">
            
            <?php foreach ( $event_list as $event ) : ?>
            <div class="event-box" data-color="<?php echo esc_attr( $event['color'] ); ?>">
                <h3 class="event-heading" style="color: <?php echo esc_attr( $event['color'] ); ?>">
                    <?php echo esc_html( $event['heading'] ); ?>
                </h3>
                <p class="event-date" style="color: <?php echo esc_attr( $event['color'] ); ?>">
                    <?php echo esc_html( $event['date'] ); ?>
                </p>
                <p class="event-description"><?php echo esc_html( $event['description'] ); ?></p>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'popup_event', 'popup_event_shortcode' );
