<?php

// ASSETS
$asset_version = '1.1.2';

function cdns_google_fonts() {
  $query_args = array(
    'family' => 'Lato:300,300italic,900,900italic,400italic,400,700,700italic|Oswald:300,400,700|Montserrat:400,700'
  );
  wp_enqueue_style( 'cdns-googlefonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
}
add_action('wp_enqueue_scripts', 'cdns_google_fonts', 9999);

function cdns_main_style() {
  global $asset_version;

  if ( is_admin() ) return;

  echo '<link rel="stylesheet" id="cdnasyid-styles" href="' . cdns_uri() . '/css/cdnasyid.min.css?ver=' . $asset_version . '" type="text/css" media="all">';
}
add_action('wp_footer', 'cdns_main_style');


function cdns_scripts() {
  global $asset_version;

  if ( is_admin() ) return;

  // select2
  if ( !is_checkout() ) {
    wp_enqueue_style('cdns-select2', cdns_uri() . '/js/select2/css/select2.min.css');
    wp_enqueue_script('cdns-select2', cdns_uri() . '/js/select2/js/select2.min.js', array(), $asset_version, true);
  }

  // tinycolor
  wp_enqueue_script('cdns-tinycolor', cdns_uri() . '/js/tinycolor-min.js', array(), $asset_version, true);

  // color-thief
  wp_enqueue_script('color-cdns-thief', cdns_uri() . '/js/color-thief.min.js', array(), $asset_version, true);

  // succint
  wp_enqueue_script('cdns-succinct', cdns_uri() . '/js/jquery.succinct.min.js', array(), $asset_version, true);

  // match height
  wp_enqueue_script('cdns-matchheight', cdns_uri() . '/js/jquery.matchHeight-min.js', array(), $asset_version, true);

  // long shadow
  wp_enqueue_script('cdns-longshadow', cdns_uri() . '/js/jquery.longShadow.min.js', array(), $asset_version, true);

  // smoother parallax
  // wp_enqueue_script('cdns-parallax', cdns_uri() . '/js/parallax.js', array(), $asset_version, true);

  // main cdnaysid's js
  wp_enqueue_script('cdnasyid', cdns_uri() . '/js/cdnasyid.min.js', array(), $asset_version, true);
  wp_enqueue_script('cdnasyid');
}
add_action('wp_enqueue_scripts', 'cdns_scripts', 9999);


function cdns_admin_scripts() {
  global $asset_version;

  wp_enqueue_script('cdns-admin', cdns_uri() . '/js/cdnasyid-admin.js', array(), $asset_version, true);
}
add_action('admin_enqueue_scripts', 'cdns_admin_scripts', 9999);
