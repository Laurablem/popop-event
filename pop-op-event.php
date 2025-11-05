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
                'heading' => 'Beach Clean-up',
                'date' => '15. December 2025, kl 12.30, Løkken',
                'description' => 'Kom i julestemning på stranden! Hjælp os med at samle affald, inden vinterstormene skyller det ud i havet. Vi slutter af med varm kakao og hyggesnak.',
                'color' => '#26376B'
            ),
            array(
                'heading' => 'Beach Clean-up',
                'date' => '10. Januar 2026, , kl 12.30, Aarhus',
                'description' => 'Start året med en god gerning! Sammen gør vi stranden klar til et grønnere 2026. Tag familien med, så vi sørger for handsker og kaffe og kakao.',
                'color' => '#26376B'
            ),
            array(
                'heading' => 'Beach Clean-up',
                'date' => '20. Februar 2026, kl 10.30, Hirtshals',
                'description' => 'Frisk luft, gode mennesker og en ren strand! kom og giv naturen en hånd!',
                'color' => '#26376B'
            ),
        ),
        '2' => array(
            array(
                'heading' => 'Beach Walk & Talk & Clean-up',
                'date' => '13. december 2025, kl 12.30, Løkken',
                'description' => 'Tag en pause fra juleræset og gå en tur langs stranden med os! Vi samler skrald, får frisk luft og gode snakke undervejs.',
                'color' => '#8bc8e5'
            ),
            array(
                'heading' => 'Beach Walk & Talk & Clean-up',
                'date' => '17. Januar 2026, kl 12.00, Aarhus',
                'description' => 'Nyt år - nye skridt for naturen! Gå med os langs kysten, snak om alt mellem himmel og hav, og hjælp med at rydde op i strandkanten.',
                'color' => '#8bc8e5'
            ),
            array(
                'heading' => 'Beach Walk & Talk & Clean-up',
                'date' => '14. Februar 2026, kl 12.30, Løkken',
                'description' => 'Gør noget kærligt for både planeten og hinanden! Kom til vores Valentine’s Beach Walk & Talk Clean-up – en hyggelig tur med samtaler, frisk luft og mening.',
                'color' => '#8bc8e5'
            ),
        ),
        '3' => array(
            array(
                'heading' => 'Ploggin Run- 5km',
                'date' => '1. December 2025, kl 12.30, Aarhus',
                'description' => 'Løb for både kroppen og planeten! Tag med på en frisk ploggingtur og saml skrald undervejs',
                'color' => '#b2d1d6'
            ),
            array(
                'heading' => 'Ploggin Run- 7km',
                'date' => '16. Januar 2026, kl 11.30, Løkken',
                'description' => 'Frisk luft, fællesskab og et renere hav. Tag løbeskoene på vi plogger for planeten!.',
                'color' => '#b2d1d6'
            ),
            array(
                'heading' => 'Ploggin Run- 10km',
                'date' => '29. Febuar 2026, kl 10.30, Løkken',
                'description' => 'Et hurtigt løb - en stor forskel. Saml skrald, få puls på og hjælp miljøet!',
                'color' => '#b2d1d6'
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
