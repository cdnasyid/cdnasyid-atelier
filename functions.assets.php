<?php

// ASSETS
$asset_version = '1.1.1';

function cdns_base_stylesheets() {
  global $asset_version;

}


function cdns_stylesheets() {
  global $asset_version;

  if ( is_admin() ) return;

  echo '<link rel="stylesheet" href="' . cdns_uri() . '/css/cdnasyid.css?ver=' . $asset_version . '" type="text/css" media="all">';
}
add_action('wp_head', 'cdns_stylesheets', 200);


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

  // smoother parallax
  // wp_enqueue_script('cdns-parallax', cdns_uri() . '/js/parallax.js', array(), $asset_version, true);

  // main cdnaysid's js
  wp_enqueue_script('cdnasyid', cdns_uri() . '/js/cdnasyid.js', array(), $asset_version, true);
  wp_enqueue_script('cdnasyid');
}
add_action( 'wp_enqueue_scripts', 'cdns_scripts', 999 );


function cdns_admin_scripts() {
  global $asset_version;

  wp_enqueue_script('cdns-admin', cdns_uri() . '/js/cdnasyid-admin.js', array(), $asset_version, true);
}
add_action( 'admin_enqueue_scripts', 'cdns_admin_scripts', 999 );
