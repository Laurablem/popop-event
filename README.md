# Popup Event Plugin (Storyscaping Eksamen)
## Laura Blem Vinkler
## Multimediedesigner-studerende, Erhvervsakademiet Aarhus 2025

Jeg har udviklet plugin’et til at give et overskueligt og visuelt indbydende overblik over kommende events.
Plugin’et indeholder tre forskellige typer events, hvor man klikker på eventillustrationen/billedet, og de tilhørende eventbokse folder sig ud med bløde animationer.
Hver boks viser dato, sted og en kort beskrivelse af det enkelte event.

Boksene lukker igen ved klik, eller automatisk, når man scroller forbi sektionen.
Det giver en overskuelig, levende og visuelt spændende måde at præsentere events på, som fx Beach Clean-ups, Walk & Talk, Plogging Runs og generelt fællesaktiviteter.

![Skærmoptagelse 2025-11-06 kl  12 07 18](https://github.com/user-attachments/assets/930fb3da-c725-4eac-9555-9534244719cc)

## Opbygning

* En klikbar eventillustration/billede fungerer som udløser (trigger) for at vise eventinformation.

* Når man klikker, glider tre bokse ned med slide-down-effekt.

* Bokse kan lukkes igen ved at klikke på billedet eller ved at scrolle ud af sektionen.

* Der findes tre sæt events (set="1", "2", "3"), som kan skiftes via shortcode.

## PHP - struktur og funktion
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

## Shortcode og brug
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
I PHP registrerer jeg shortcoden sådan her:
```
add_shortcode('popup_event', 'popup_event_shortcode');
```

Jeg bruger ```ob_start()``` til at samle HTML’en i en buffer, så alt output returneres samlet med ```ob_get_clean()```.
Det gør koden både mere effektiv og lettere at læse, i stedet for at skulle bygge HTML’en manuelt i en variabel, som fx ```$content```.

```
ob_start();
// HTML output...
return ob_get_clean();
```

Jeg bruger også ```shortcode_atts()``` til at sætte en standardværdi for ```set```, og ```uniqid()``` til at give hver shortcode et unikt ID.
Det sikrer, at jeg kan bruge flere eventsektioner på samme side, uden at de konflikter med hinanden.
```
$atts = shortcode_atts(array('set' => '1'), $atts, 'popup_event');
$uid = uniqid('event-boxes-');
```
Hvert *set* henter sit eget **triggerbillede** samt de tre tilhørende **eventbokse** med overskrift, dato, tekst og farve fra et array i PHP.

## CSS - styling og animation

Jeg har holdt designet enkelt og roligt med små bevægelser og tilpasset det til sitets farver og de enkelte events/trigger-billeder.

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

### Interaktivitet med jQuery (JavaScript)

Jeg bruger jQuery til at styre den interaktive del af plugin’et.
Når man klikker på billedet, toggler scriptet mellem klasserne ```.event-visible``` og ```.event-hidden``` for at styre animationen, altså om eventboksene skal være synlige eller skjulte.
```
$(document).on('click', '.event-trigger', function() {
  var targetId = $(this).data('target');
  $('#' + targetId).toggleClass('event-visible event-hidden');
});
```
Derudover lytter scriptet på scroll, og hvis sektionen kommer helt ud af skærmen, lukker boksene automatisk igen. Det har jeg gjort for at gøre oplevelsen mere flydende og brugervenlig.

### Design og udtryk

Som tidligere nævnt i “CSS - styling og animation” har jeg visuelt fokuseret på, at designet skal være enkelt, overskueligt og fortællende.
Billedet fungerer som blikfang og viser med tekst og illustrationer, hvilke forskellige events man kan deltage i.

De tre bokse under billedet viser de kommende datoer for det tilhørende event og giver et tydeligt og let forståeligt overblik, både over beskrivelse, dato, tid og sted.

Hver boks matcher, i farve og hovereffekt, sit tilhørende triggerbillede/event, hvilket gør oplevelsen mere brugervenlig og hjælper med at minimere kognitiv friktion for brugeren.

### Brug af AI
AI er blevet brugt som sparringsværktøj til struktur og optimering af kode, men idéudvikling, design og implementering er udført af mig selv.

### Konklusion

Jeg har udviklet dette plugin for at skabe en mere interaktiv og engagerende måde at præsentere events på i WordPress.

Ved at kombinere PHP, CSS og jQuery har jeg opnået et let, responsivt og brugervenligt plugin, der både er funktionelt og visuelt tiltalende.
Processen har givet mig en bedre forståelse for, hvordan backend og frontend hænger sammen i WordPress-udvikling.
