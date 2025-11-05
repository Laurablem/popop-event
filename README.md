### hej

# Popup Event Plugin (Storyscaping Eksamen)
## Laura Blem Vinkler
## Multimediedesigner-studerende, Erhvervsakademiet Aarhus 2025

Jeg har udviklet plugin’et til at vise et overskueligt og visuelt pænt overblik over kommende events.
Plugin’et indeholder tre forskellige events, hvor eventboksene folder sig ud med bløde animationer, når man klikker på billedet.
Hver boks viser dato og en kort beskrivelse af det enkelte event.

Boksene lukker igen ved klik – eller automatisk, når man scroller forbi sektionen.
Det giver en levende og visuelt spændende måde at præsentere events på – som fx Beach Clean-ups, Walk & Talk, Plogging Runs og generelt fællesaktiviteter.

## Opbygning

* Et klikbart billede fungerer som udløser (trigger) for at vise eventinformation.

* Når man klikker, glider tre bokse ned med slide-down-effekt.

* Bokse kan lukkes igen ved at klikke på billedet eller ved at scrolle ud af sektionen.

* Der findes tre sæt events (set="1", "2", "3"), som kan skiftes via shortcode.

## PHP – struktur og funktion
Jeg sørger for her, at man ikke kan tilgå plugin-filen direkte uden om WordPress.
```
if (!defined('ABSPATH')) { exit; }
```
## Indlæsning af CSS og JavaScript

Jeg har oprettet en funktion, der loader mine filer korrekt ind i WordPress:
```
function popup_event_enqueue_assets() {
    wp_enqueue_style(
        'popup-event-style',
        plugin_dir_url(__FILE__) . 'assets/css/style.css',
        array(),
        '3.0.0'
    );

    wp_enqueue_script(
        'popup-event-script',
        plugin_dir_url(__FILE__) . 'assets/js/script.js',
        array('jquery'),
        '3.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'popup_event_enqueue_assets');
```
Her bruges ```plugin_dir_url(__FILE__)``` til at finde filstierne automatisk,
og ```true``` i ```wp_enqueue_script``` sørger for, at scriptet bliver loadet i footeren,
så siden kan indlæses hurtigere, og jQuery først kører, når hele HTML’en er klar.

## Shortcode
Selve indholdet vises via en shortcode:
```
[popup_event set="1"]
```
Man kan vælge mellem tre forskellige *sets*, som hver indeholder deres eget billede, farver og events:
```
[popup_event set="1"]  
[popup_event set="2"]  
[popup_event set="3"]
```
Jeg bruger ```ob_start()``` til at samle HTML’en, så jeg kan returnere det hele på én gang i stedet for at printe det direkte ud.
```
ob_start();
// HTML output...
return ob_get_clean();
```
Hvert *set* genereres ud fra arrays i PHP med billede, overskrift, dato, tekst og farve.
Der laves et unikt ID til hver instans, så flere events kan ligge på samme side uden at konflikte.

## CSS – styling og animation

Jeg har holdt designet enkelt og roligt med små bevægelser og tilpasset sitets farver, og de enkelte events/trigger-billeder.

### Trigger-billede
```
.event-trigger {
  width: 100%;
  max-width: 1500px;
  cursor: pointer;
  transition: transform 0.3s ease, opacity 0.3s ease;
}
.event-trigger:hover {
  transform: translateY(-4px) scale(1.02);
  opacity: 0.95;
}
```
Når man holder musen over billedet, får det et lille “løft” for at vise brugeren, at det er klikbart.

### Event-container
```
.event-boxes-container {
  max-height: 0;
  opacity: 0;
  overflow: hidden;
  transition: max-height 0.6s ease, opacity 0.5s ease;
}
.event-boxes-container.event-visible {
  max-height: 2000px;
  opacity: 1;
}
```
Her bruger jeg ```max-height``` og ```opacity``` til at skabe en **smooth fold-ud animation**.

### Eventbokse
```
.event-box {
  background: #fff;
  border: 2px solid #e0e0e0;
  padding: 25px;
  margin-bottom: 20px;
  transform: translateY(-20px);
  opacity: 0;
  transition: transform 0.5s ease, opacity 0.5s ease;
}
```
Jeg har lavet en **staggered animation**, så hver boks dukker op med små forsinkelser.
Farverne hentes direkte fra PHP via ```data-color```, så hvert event-set får sit eget udtryk.
