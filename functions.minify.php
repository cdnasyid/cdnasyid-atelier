<?php

$css = 'html {
  font-size: 16px;
}

body {
  font-family: $body-fonts;
}

body, p {
  font-size: 1em;
  line-height: 1.5;
}

small {
  line-height: 1;
}';

function cdns_css_minify($code) {
  // create temp file
  $temp_dir = WP_CONTENT_DIR . '/uploads/cdnasyid-temp';
  $temp_file = $temp_dir . '/autoptimize.css';

  $cleancss_exec = '/Users/wan/.nvm/versions/node/v5.8.0/bin/cleancss';

  if (!is_dir($temp_dir))
    wp_mkdir_p($temp_dir);

  file_put_contents($temp_file, trim($code));

  // exec("$cleancss_exec --s0 $temp_file 2>&1", $output);
  //
  // echo "$cleancss_exec --s0 $temp_file";
  // print_r($output);

  return `$cleancss_exec --s0 $temp_file 2>&1`;
}

echo cdns_css_minify($css);
// add_filter('autoptimize_css_after_minify', 'cdns_css_minify', 999);
