<?php

/*
Plugin Name: Wordpress Reddit Feed
Description: The Wordpress Reddit Feed loads popular content from Reddit.
Version: 1.0
Author: William Arslett
Author URI: http://www.williamarslett.com
*/

//SETUP
function super_plugin_install(){
    //Do some installation work
}
register_activation_hook(__FILE__,'super_plugin_install');