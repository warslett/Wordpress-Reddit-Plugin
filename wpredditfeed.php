<?php

/*
  Plugin Name: Wordpress Reddit Feed
  Description: The Wordpress Reddit Feed loads popular content from Reddit.
  Version: 1.0
  Author: William Arslett
  Author URI: http://www.williamarslett.com
 */

include "RedditFeed.php";

//SETUP
function super_plugin_install() {
    //Do some installation work
}

register_activation_hook(__FILE__, 'super_plugin_install');

function feed_insert($content) {
    if (preg_match('/\[redditlatest*.+\]/', $content)) {
        $feed = new RedditFeed;
        $content = preg_replace(
                        '/\[redditlatest*.+\]/', 
                        $feed->getHeadlines(), 
                        $content);
    }
    return $content;
}

add_filter('the_content', 'feed_insert');
