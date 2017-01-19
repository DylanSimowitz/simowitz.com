<?php

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
/**
 * Do not edit anything in this file unless you know what you're doing
 */

/**
 * Require Composer autoloader if installed on it's own
 */
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    require_once $composer;
}

/**
 * Here's what's happening with these hooks:
 * 1. WordPress detects theme in themes/sage
 * 2. When we activate, we tell WordPress that the theme is actually in themes/sage/templates
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage
 *
 * We do this so that the Template Hierarchy will look in themes/sage/templates for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/templates
 */
add_filter('template', function ($stylesheet) {
    return dirname($stylesheet);
});
add_action('after_switch_theme', function () {
    $stylesheet = get_option('template');
    if (basename($stylesheet) !== 'templates') {
        update_option('template', $stylesheet . '/templates');
    }
});

/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 */
$sage_includes = [
    'src/helpers.php',
    'src/setup.php',
    'src/filters.php',
    'src/admin.php',
    'src/acf.php'
];
array_walk($sage_includes, function ($file) {
    if (!locate_template($file, true, true)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }
});
