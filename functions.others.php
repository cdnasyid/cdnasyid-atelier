<?php

function remove_base_url($uri) {
  global $wp_scripts, $wp_styles;

  $base_url = $wp_scripts->base_url;
  $uri = preg_replace('/^'.preg_quote($base_url, '/').'/', '', $uri);

  $base_url = preg_replace('/(http(s)?\:)?/', '', $wp_scripts->base_url);
  $uri = preg_replace('/^'.preg_quote($base_url, '/').'/', '', $uri);

  return $uri;
}

function list_all_assets() {
  global $wp_scripts, $wp_styles;

  $exclude = ['admin-bar', 'dashicons'];

  echo "<!--\n";

  $base_url = $wp_scripts->base_url;

  $scripts_queue = array(
    'header' => array(),
    'footer' => array()
  );

  $styles_queue = array(
    'header' => array()
  );

  foreach ($wp_scripts->done as $slug) {
    if (in_array($slug, $wp_scripts->to_do)) {
      continue;
    }
    $scripts_queue[!in_array($slug, $wp_scripts->in_footer) ? 'header' : 'footer'][$slug] = remove_base_url($wp_scripts->registered[$slug]->src);
  }

  foreach ($wp_styles->done as $slug) {
    if (in_array($slug, $wp_styles->to_do)) {
      continue;
    }
    $src = $wp_styles->registered[$slug]->src;
    if (strpos($src, 'googleapis.com') === false)
      $styles_queue['header'][$slug] = remove_base_url($src);
  }


  print_r($scripts_queue);
  print_r($styles_queue);

  echo "-->";
}
add_action('shutdown', 'list_all_assets', 9999);
