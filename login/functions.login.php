<?php

function cdns_login_logo() {
  echo '<style type="text/css">
    .login h1 a {
      background-image: url(' . cdns_uri() . '/images/cdn-new-v2.svg) !important;
      background-position: center center;
    }
  </style>';
}
add_action('login_head', 'cdns_login_logo', 9999);


function cdns_login_url() {
  return '/';
}
add_filter('login_headerurl', 'cdns_login_url');

function cdns_login_css() {
  wp_enqueue_style('login-styles', cdns_uri() . '/login/style.css');
}
add_action('login_enqueue_scripts', 'cdns_login_css');
