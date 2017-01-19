<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // Add class if sidebar is active
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
array_map(function ($type) {
    add_filter("{$type}_template_hierarchy", function ($templates) {
        return call_user_func_array('array_merge', array_map(function ($template) {
            $normalizedTemplate = str_replace('.', '/', sage('blade')->normalizeViewPath($template));
            return ["{$normalizedTemplate}.blade.php", "{$normalizedTemplate}.php"];
        }, $templates));
    });
}, [
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'front_page', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
]);

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    echo template($template, apply_filters('sage/template_data', []));

    // Return a blank file to make WordPress happy
    return get_template_directory() . '/index.php';
}, 1000);

/**
 * Tell WordPress how to find the compiled path of comments.blade.php
 */
add_filter('comments_template', 'App\\template_path');


/**
 * Allow SVG uploads through the WordPress uploader
 */
add_filter( 'upload_mimes', function ($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
});

/**
 * Allow gravityform labels to be hidden 
 */
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

/**
 * Replace minit paths
 */
add_filter( 'minit-asset-local-path', 'minit_custom_content_dir', 10, 2 );
function minit_custom_content_dir( $local_path, $item_url ) {

    // Bail out if get_local_path_from_url() succeeded
    if ( false !== $local_path ) {
        return $local_path;
    }

    // Replace custom MU plugin URL
    $full_path = str_replace( WPMU_PLUGIN_URL, WPMU_PLUGIN_DIR, $item_url );
    // Replace custom plugin URL
    $full_path = str_replace( plugins_url(), WP_PLUGIN_DIR, $full_path );
    // Replace custom theme URL
    $full_path = str_replace( get_theme_root_uri(), get_theme_root(), $full_path );
    // Replace remaining custom wp-content URL
    $full_path = str_replace( content_url(), WP_CONTENT_DIR, $full_path );

    if ( file_exists( $full_path ) ) {
        return $full_path;
    }

    return false;

}
