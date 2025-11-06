<?php
/*
 * Plugin Name: Popup Event
 * Plugin URI: http://localhost
 * Description: Tre bokse med events, der glider ned med en blød animation
 * Version: 3.6.0
 * Author: LAURA BLEM VINKLER
 * Author URI: http://localhost
 * License: GPL2
 */

// Sikkerhed: sørger for, at filen kun kan tilgås via WordPress og ikke direkte i browseren
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Indlæs pluginets CSS og JS
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
 * set="1", set="2" eller set="3" vælger hvilket event-sæt der skal vises
 */
function popup_event_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'set' => '1', // Hvilket event-sæt der skal vises (1, 2 eller 3)
        ),
        $atts,
        'popup_event'
    );

    $set = $atts['set'];
    $uid = uniqid( 'event-boxes-' );

    // Billeder/eventillustration til hvert sæt (ét triggerbillede/eventillustration pr. set)
    $images = array(
        '1' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang1.jpg',
        '2' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang2.jpg',
        '3' => plugin_dir_url( __FILE__ ) . 'assets/images/kalenderlang3.jpg',
    );

    // Event-data til hvert sæt (overskrift, dato, tekst og farve)
    $events = array(
        '1' => array(
            array(
                'heading' => 'Beach Clean-up',
                'date' => '15. December 2025, 12.30 PM, Løkken',
                'description' => 'Get into the Christmas spirit at the beach! Help us collect litter before the winter storms wash it out to sea. We’ll finish with hot cocoa and cozy chats.',
                'color' => '#26376B'
            ),
            array(
                'heading' => 'Beach Clean-up',
                'date' => '10. January 2026, 12.30 PM, Aarhus',
                'description' => 'Start the year with a good deed! Together, we’ll get the beach ready for a greener 2026. Bring your family, we’ll provide gloves, coffee, and cocoa.',
                'color' => '#26376B'
            ),
            array(
                'heading' => 'Beach Clean-up',
                'date' => '1. February 2026, 10.30 PM, Hirtshals',
                'description' => 'Fresh air, great people, and a clean beach! Come and give nature a hand!',
                'color' => '#26376B'
            ),
        ),
        '2' => array(
            array(
                'heading' => 'Beach Walk & Talk & Clean-up',
                'date' => '13. December 2025, 12.30 PM, Løkken',
                'description' => 'Take a break from the holiday rush and join us for a walk along the beach! We’ll pick up litter, enjoy the fresh air, and have some great conversations along the way.',
                'color' => '#8bc8e5'
            ),
            array(
                'heading' => 'Beach Walk & Talk & Clean-up',
                'date' => '17. January 2026, 12.00 PM, Aarhus',
                'description' => 'New year – new steps for nature! Walk with us along the coast, chat about everything between sky and sea, and help clean up the shoreline.',
                'color' => '#8bc8e5'
            ),
            array(
                'heading' => 'Beach Walk & Talk & Clean-up',
                'date' => '14. February 2026, 12.30 PM, Løkken',
                'description' => 'Do something loving for both the planet and each other! Join our Valentine’s Beach Walk & Talk Clean-up. A cozy walk filled with conversations, fresh air, and purpose.',
                'color' => '#8bc8e5'
            ),
        ),
        '3' => array(
            array(
                'heading' => 'Ploggin Run- 5km',
                'date' => '1. December 2025, 12.30 PM, Aarhus',
                'description' => 'Run for both your body and the planet! Join us for a refreshing plogging tour and collect litter along the way.',
                'color' => '#b2d1d6'
            ),
            array(
                'heading' => 'Ploggin Run- 7km',
                'date' => '16. January 2026, 11.30 AM, Løkken',
                'description' => 'Fresh air, community, and a cleaner sea. Put on your running shoes, we’re plogging for the planet!',
                'color' => '#b2d1d6'
            ),
            array(
                'heading' => 'Ploggin Run- 10km',
                'date' => '29. February 2026, 10.30 AM, Løkken',
                'description' => 'A quick run - a big difference. Collect litter, get your heart rate up, and help the environment!',
                'color' => '#b2d1d6'
            ),
        ),
    );

    // Finder det rigtige billede/eventillustration og de rigtige events ud fra valgt set
    $img_url = isset($images[$set]) ? $images[$set] : $images['1'];
    $event_list = isset($events[$set]) ? $events[$set] : $events['1'];

    // Jeg samler al HTML’en først, så alt kan sendes ud samlet, når shortcoden kaldes
    ob_start();
    ?>
    <div class="event-wrapper">
        <!-- Klikbart trigger-billede som åbner/lukker eventboksene -->
        <img src="<?php echo esc_url( $img_url ); ?>"
             alt="Se kommende events"
             class="event-trigger"
             data-target="<?php echo esc_attr( $uid ); ?>">

        <!-- Container som indeholder de tre eventbokse -->
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
    // Returnerer det samlede HTML-output, så det vises der, hvor shortcoden indsættes
    return ob_get_clean();
}
add_shortcode( 'popup_event', 'popup_event_shortcode' );
