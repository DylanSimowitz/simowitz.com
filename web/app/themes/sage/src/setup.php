<?php

namespace App;

use Illuminate\Contracts\Container\Container as ContainerContract;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Config;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), array('jquery', 'wp-api'), null, true);
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Rufina|Montserrat|Andada', false, null);
}, 100);

/**
 * Load non-critical CSS in footer
 */
add_action('get_footer', function () {
    wp_enqueue_style('font-awesome', 'https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css', false, null);
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Practices', 'sage'),
        'id'            => 'sidebar-practices',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Sage config
     */
    $paths = [
        'dir.stylesheet' => get_stylesheet_directory(),
        'dir.template'   => get_template_directory(),
        'dir.upload'     => wp_upload_dir()['basedir'],
        'uri.stylesheet' => get_stylesheet_directory_uri(),
        'uri.template'   => get_template_directory_uri(),
    ];
    $viewPaths = collect(preg_replace('%[\/]?(templates)?[\/.]*?$%', '', [STYLESHEETPATH, TEMPLATEPATH]))
        ->flatMap(function ($path) {
            return ["{$path}/templates", $path];
        })->unique()->toArray();
    config([
        'assets.manifest' => "{$paths['dir.stylesheet']}/dist/assets.json",
        'assets.uri'      => "{$paths['uri.stylesheet']}/dist",
        'view.compiled'   => WP_CONTENT_DIR . "/uploads/cache/compiled",
        'view.namespaces' => ['App' => WP_CONTENT_DIR],
        'view.paths'      => $viewPaths,
    ] + $paths);

    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (ContainerContract $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view'], $app);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return '<?= App\\asset_path(\''.trim($asset, '\'"').'\'); ?>';
    });
    /**
     * Create @posts Blade directive
     */
    sage('blade')->compiler()->directive('posts', function () {
        return '<?php while(have_posts()) : the_post(); ?>';
    });

    /**
     * Create @endposts Blade directive
     */
    sage('blade')->compiler()->directive('endposts', function () {
        return '<?php endwhile; ?>';
    });

    /**
     * Create @query() Blade directive
     */
    sage('blade')->compiler()->directive('query', function ($args) {
        $output = '<?php $bladeQuery = new WP_Query($args); ?>';
        $output .= '<?php while ($bladeQuery->have_posts()) : ?>';
        $output .= '<?php $bladeQuery->the_post(); ?>';

        return $output;
    });

    /**
     * Create @endquery Blade directive
     */
    sage('blade')->compiler()->directive('endquery', function () {
        return '<?php endwhile; ?>';
    });
});
/**
 * Attach a random image from unsplash if no featured image is set
 */
function simowitz_random_unsplash( $post_id ) {
    // If no featured image set, grab one from unsplash
    if(!has_post_thumbnail($post_id)) {
        // Get a random image from the nature collection
        $image = get_headers('https://source.unsplash.com/collection/384050/1600x900', 1)['Location'].'.jpg';
        $media = media_sideload_image($image, $post_id);
        if(!empty($media) && !is_wp_error($media)){
            $args = array(
                'post_type' => 'attachment',
                'posts_per_page' => 1,
                'post_status' => 'any',
                'post_parent' => $post_id
            );

            // Reference new image to set as featured
            $attachments = get_posts($args);

            if($attachments){
                foreach($attachments as $attachment){
                    set_post_thumbnail($post_id, $attachment->ID);
                    // Only want one image
                    break;
                }
            }
        }
    }
}
add_action( 'save_post', 'App\\simowitz_random_unsplash' );
/**
 * Init config
 */
sage()->bindIf('config', Config::class, true);
