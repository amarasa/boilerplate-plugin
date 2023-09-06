<?php
// Hook into WordPress' update mechanism
add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');

function check_for_plugin_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    $plugin_slug = plugin_basename(__FILE__);
    $remote_url = 'https://api.github.com/repos/amarasa/boilerplate-plugin/releases/latest';

    $response = wp_remote_get($remote_url);

    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $remote = json_decode(wp_remote_retrieve_body($response));

        if ($remote && version_compare($remote->tag_name, $transient->checked[$plugin_slug], '>')) {
            $obj = new stdClass();
            $obj->slug = $plugin_slug;
            $obj->new_version = $remote->tag_name;
            $obj->url = $remote->html_url;
            $obj->package = $remote->zipball_url;
            $transient->response[$plugin_slug] = $obj;
        }
    }

    return $transient;
}
