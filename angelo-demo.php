<?php
/*
Plugin Name: Angelo Demo
Description: 
Version: 1.0.1
Author: Angelo Marasa
Author URI: https://hrefcreative.com
*/

require_once('lib/version-control.php');

function angelo_demo_enqueue_scripts()
{
    wp_enqueue_style('angelo-demo-style', plugin_dir_url(__FILE__) . 'src/css/angelo-demo.css');
    wp_enqueue_script('angelo-demo-script', plugin_dir_url(__FILE__) . 'src/js/angelo-demo.js', array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'angelo_demo_enqueue_scripts');

function angelo_demo_add_menu()
{
    add_menu_page('Angelo Demo Options', 'Angelo Demo', 'manage_options', 'angelo-demo', 'angelo_demo_options_page');
}

function angelo_demo_options_page()
{
    echo '<h1>Angelo Demo Options</h1>';
}

add_action('admin_menu', 'angelo_demo_add_menu');

// Add the filter to add a link to the options page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_plugin_page_settings_link');

// Function to add the "Settings" link
function add_plugin_page_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=angelo-demo">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
