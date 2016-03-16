<?php

function cdns_single_product_image_html( $html, $post_ID ) {
  $video_url = get_post_meta( $post_ID, '_video_url', true );
  $product_image_width = apply_filters('sf_product_image_width', 700);
  $image_id      = get_post_thumbnail_id();
  $image_meta     = sf_get_attachment_meta( $image_id );

  $image_caption = $image_alt = $image_title = $caption_html = "";
  if ( isset($image_meta) ) {
    $image_caption     = esc_attr( $image_meta['caption'] );
    $image_title     = esc_attr( $image_meta['title'] );
    $image_alt       = esc_attr( $image_meta['alt'] );
  }

  $image = wp_get_attachment_image_src( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
  $thumb = wp_get_attachment_image_src( $image_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

  $image_link  = $image[0];
  $thumb_image = $thumb[0];

  // $image_link      = wp_get_attachment_url( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
  // $thumb_image = wp_get_attachment_url( $image_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

  if ( $image_caption != "" ) {
    $caption_html = '<div class="img-caption">' . $image_caption . '</div>';
  }

  $image_html = '<img class="product-slider-image" data-zoom-image="'.$image_link.'" src="'.$image_link.'" alt="'.$image_alt.'" title="'.$image_title.'" />';

  if ( $video_url != '' ) {
    return '<div class="video-wrap" data-thumb="' . $thumb_image . '">' . $html . '</div>';
  } else {
    return sprintf( '<li itemprop="image" data-thumb="%s">%s%s<a href="%s" itemprop="image" class="woocommerce-main-image zoom lightbox" data-rel="ilightbox[product]" data-caption="%s" title="%s" alt="%s"><i class="fa-search-plus"></i></a></li>', $thumb_image, $caption_html, $image_html, $image_link, $image_caption, $image_title, $image_alt );
  }
}
add_filter('woocommerce_single_product_image_html', 'cdns_single_product_image_html', 99, 2);

function cdns_single_product_image_thumbnail_html( $html, $attachment_id, $post_ID, $image_class ) {
  $image = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
  $thumb = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

  $image_link  = $image[0];
  $thumb_image = $thumb[0];

  // $image_link  = wp_get_attachment_url( $attachment_id, 'full' );
  // $thumb_image = wp_get_attachment_url( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
  $image_meta     = sf_get_attachment_meta( $attachment_id );
  $image_caption = $image_alt = $image_title = $caption_html = "";
  if ( isset($image_meta) ) {
    $image_caption     = esc_attr( $image_meta['caption'] );
    $image_title     = esc_attr( $image_meta['title'] );
    $image_alt       = esc_attr( $image_meta['alt'] );
  }
  if ( $image_caption != "" ) {
    $caption_html = '<div class="img-caption">' . $image_caption . '</div>';
  }
  $image_html = '<img class="product-slider-image" data-zoom-image="'.$image_link.'" src="'.$image_link.'" alt="'.$image_alt.'" title="'.$image_title.'" />';
  return '<li itemprop="image" data-thumb="'.$thumb_image.'">' . $image_html . '' . $caption_html . '<a href="'.$image_link.'" itemprop="image" class="woocommerce-main-image zoom lightbox" data-rel="ilightbox[product]" data-caption="'.$image_caption.'" title="'.$image_title.'" alt="'.$image_alt.'"><i class="fa-search-plus"></i></a></li>';
}
add_filter('woocommerce_single_product_image_thumbnail_html', 'cdns_single_product_image_thumbnail_html', 99, 4);

function sf_get_tweets($twitterID, $count, $type = '', $item_class = 'col-sm-4') {
  global $sf_options;
  $enable_twitter_rts = false;
  if (isset($sf_options['enable_twitter_rts'])) {
    $enable_twitter_rts = $sf_options['enable_twitter_rts'];
  }

  $content = '';
  $blog_grid_count = 0;
  if (function_exists('getTweets')) {
    $options = array(
      'trim_user' => true,
      'exclude_replies' => false,
      'include_rts' => $enable_twitter_rts,
    );
    $tweets = getTweets($twitterID, $count, $options);
    if (is_array($tweets)) {
      if (isset($tweets['error']) && $tweets['error'] != '') {
        return '<li>' . $tweets['error'] . '</li>';
      }
      else {
        foreach($tweets as $tweet) {
          if ($type == 'blog-grid') {
            $content.= '<li class="blog-item col-sm-sf-5" data-date="' . strtotime($tweet['created_at']) . '" data-sortid="' . $blog_grid_count . '">';
            $content.= '<a class="grid-link" href="https://twitter.com/' . $twitterID . '/status/' . $tweet['id_str'] . '" target="_blank"></a>';
            $content.= '<div class="grid-no-image">';
            $content.= '<h6>' . __('Twitter', 'swiftframework') . '</h6>';
            $blog_grid_count = $blog_grid_count + 2;
          }
          elseif ($type == 'blog') {
            $content.= '<li class="blog-item ' . $item_class . '" data-date="' . strtotime($tweet['created_at']) . '">';
            $content.= '<a class="grid-link" href="https://twitter.com/' . $twitterID . '/status/' . $tweet['id_str'] . '" target="_blank"></a>';
            $content.= '<div class="details-wrap">';
            $content.= '<h6>' . __('Twitter', 'swiftframework') . '</h6>';
          }
          elseif ($type == 'blog-fw') {
            $content.= '<li class="blog-item ' . $item_class . '" data-date="' . strtotime($tweet['created_at']) . '">';
            $content.= '<a class="grid-link" href="https://twitter.com/' . $twitterID . '/status/' . $tweet['id_str'] . '" target="_blank"></a>';
            $content.= '<div class="details-wrap">';
            $content.= '<h6>' . __('Twitter', 'swiftframework') . '</h6>';
          }
          else {
            $content.= '<li>';
          }

          if (isset($tweet['text']) && $tweet['text']) {
            if ($type == 'blog' || $type == 'blog-grid' || $type == 'blog-fw') {
              $content.= '<h2 class="tweet-text">';
            }
            else {
              $content.= '<div class="tweet-text slide-content-wrap">';
            }

            $the_tweet = apply_filters('sf_tweet_text', $tweet['text']);
            /*
            Twitter Developer Display Requirements
            https://dev.twitter.com/terms/display-requirements
            2.b. Tweet Entities within the Tweet text must be properly linked to their appropriate home on Twitter. For example:
            i. User_mentions must link to the mentioned user's profile.
            ii. Hashtags must link to a twitter.com search with the hashtag as the query.
            iii. Links in Tweet text must be displayed using the display_url
            field in the URL entities API response, and link to the original t.co url field.
            */

            // i. User_mentions must link to the mentioned user's profile.

            if (isset($tweet['entities']['user_mentions']) && is_array($tweet['entities']['user_mentions'])) {
              foreach($tweet['entities']['user_mentions'] as $key => $user_mention) {
                $the_tweet = preg_replace('/@' . $user_mention['screen_name'] . '/i', '<a href="http://www.twitter.com/' . $user_mention['screen_name'] . '" target="_blank">@' . $user_mention['screen_name'] . '</a>', $the_tweet);
              }
            }

            // ii. Hashtags must link to a twitter.com search with the hashtag as the query.

            if (isset($tweet['entities']['hashtags']) && is_array($tweet['entities']['hashtags'])) {
              foreach($tweet['entities']['hashtags'] as $key => $hashtag) {
                $the_tweet = preg_replace('/#' . $hashtag['text'] . '/i', '<a href="https://twitter.com/search?q=%23' . $hashtag['text'] . '&amp;src=hash" target="_blank">#' . $hashtag['text'] . '</a>', $the_tweet);
              }
            }

            // iii. Links in Tweet text must be displayed using the display_url
            //      field in the URL entities API response, and link to the original t.co url field.

            if (isset($tweet['entities']['urls']) && is_array($tweet['entities']['urls'])) {
              foreach($tweet['entities']['urls'] as $key => $link) {
                $link_url = '';
                if (isset($link['expanded_url'])) {
                  $link_url = $link['expanded_url'];
                }
                else {
                  $link_url = $link['url'];
                }

                $the_tweet = preg_replace('`' . $link['url'] . '`', '<a href="' . $link_url . '" target="_blank">' . $link_url . '</a>', $the_tweet);
              }
            }

            // Custom code to link to media

            if (isset($tweet['entities']['media']) && is_array($tweet['entities']['media'])) {
              foreach($tweet['entities']['media'] as $key => $media) {
                $the_tweet = preg_replace('`' . $media['url'] . '`', '<a href="' . $media['url'] . '" target="_blank">' . $media['url'] . '</a>', $the_tweet);
              }
            }

            $content.= $the_tweet;
            if ($type == 'blog' || $type == 'blog-grid' || $type == 'blog-fw') {
              $content.= '</h2>';
            }
            else {
              $content.= '</div>';
            }

            // 3. Tweet Actions
            //    Reply, Retweet, and Favorite action icons must always be visible for the user to interact with the Tweet. These actions must be implemented using Web Intents or with the authenticated Twitter API.
            //    No other social or 3rd party actions similar to Follow, Reply, Retweet and Favorite may be attached to a Tweet.
            // 4. Tweet Timestamp
            //    The Tweet timestamp must always be visible and include the time and date. e.g., "3:00 PM - 31 May 12".
            // 5. Tweet Permalink
            //    The Tweet timestamp must always be linked to the Tweet permalink.

            $content.= '<div class="twitter_intents">' . "\n";
            $content.= '<a class="reply" href="https://twitter.com/intent/tweet?in_reply_to=' . $tweet['id_str'] . '"><i class="fa-reply"></i></a>' . "\n";
            $content.= '<a class="retweet" href="https://twitter.com/intent/retweet?tweet_id=' . $tweet['id_str'] . '"><i class="fa-retweet"></i></a>' . "\n";
            $content.= '<a class="favorite" href="https://twitter.com/intent/favorite?tweet_id=' . $tweet['id_str'] . '"><i class="fa-star"></i></a>' . "\n";
            $date = strtotime($tweet['created_at']); // retrives the tweets date and time in Unix Epoch terms
            // $blogtime = current_time('U'); // retrives the current browser client date and time in Unix Epoch terms
            // WANSALEH CHANGE
            $blogtime = time(); // retrives the current browser client date and time in Unix Epoch terms
            $dago = human_time_diff($date, $blogtime) . ' ' . sprintf(__('ago', 'swiftframework')); // calculates and outputs the time past in human readable format
            $content.= '<a class="timestamp" href="https://twitter.com/' . $twitterID . '/status/' . $tweet['id_str'] . '" target="_blank">' . $dago . '</a>' . "\n";
            $content.= '<a class="twitter-id" href="http://twitter.com/' . $twitterID . '" target="_blank">@' . $twitterID . '</a>';
            $content.= '</div>' . "\n";
          }
          else {
            $content.= '<a href="http://twitter.com/' . $twitterID . '" target="_blank">@' . $twitterID . '</a>';
          }

          if ($type == 'blog' || $type == 'blog-grid' || $type == 'blog-fw') {
            $content.= '<data class="date" data-date="' . $date . '" value="' . $date . '">' . $dago . '</data>';
            $content.= '<div class="author"><span>@' . $twitterID . '</span></div>';
            $content.= '<div class="tweet-icon"><i class="fa-twitter"></i></div>' . "\n";
            $content.= '</div>';
          }

          $content.= '</li>';
        }
      }

      return $content;
    }
  }
  else {
    return '<li><div class="tweet-text">Please install the oAuth Twitter Feed Plugin and follow the theme documentation to set it up.</div></li>';
  }
}
