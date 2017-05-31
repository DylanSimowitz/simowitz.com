<?php
/*
Plugin Name:  Custom Post Types 
Plugin URI:   https://dylan.simowitz.com/
Description:  Custom post types for simowitz.com.
Version:      1.0.0
Author:       Dylan Simowitz
Author URI:   https://dylan.simowitz.com/
License:      MIT License
*/

use PostTypes\PostType;

$cases = new PostType('case');
$cases->icon('dashicons-portfolio');

$testimonials = new PostType('testimonial');
$testimonials->icon('dashicons-testimonial');
$testimonials->columns()->add([
    'rating' => __('Rating')
]);
$testimonials->columns()->populate('rating', function($column, $post_id) {
    echo get_post_meta($post_id, 'rating') . '/5';
});

$awards = new PostType('award');
$awards->icon('dashicons-awards');


// Register Custom Taxonomy
function wp_lawyer_attorneys_practicearea() {

	$labels = array(
		'name'                       => _x( 'Areas of Practice', 'Taxonomy General Name', 'wp-lawyer' ),
		'singular_name'              => _x( 'Area of Practice', 'Taxonomy Singular Name', 'wp-lawyer' ),
		'menu_name'                  => __( 'Areas of Practice', 'wp-lawyer' ),
		'all_items'                  => __( 'All Practices', 'wp-lawyer' ),
		'parent_item'                => __( 'Parent Practice', 'wp-lawyer' ),
		'parent_item_colon'          => __( 'Parent Practice:', 'wp-lawyer' ),
		'new_item_name'              => __( 'New Practice', 'wp-lawyer' ),
		'add_new_item'               => __( 'Add New Practice', 'wp-lawyer' ),
		'edit_item'                  => __( 'Edit Practice', 'wp-lawyer' ),
		'update_item'                => __( 'Update Practice', 'wp-lawyer' ),
		'separate_items_with_commas' => __( 'Separate Practices with commas', 'wp-lawyer' ),
		'search_items'               => __( 'Search Practices', 'wp-lawyer' ),
		'add_or_remove_items'        => __( 'Add or remove Practices', 'wp-lawyer' ),
		'choose_from_most_used'      => __( 'Choose from the most used Practice', 'wp-lawyer' ),
		'not_found'                  => __( 'No Practice Found', 'wp-lawyer' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite' => array('slug'=>'attorneys/area-of-practice', 'with_front' => false)
	);
	register_taxonomy( 'wplawyer-practice-area', array( 'post' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'wp_lawyer_attorneys_practicearea', 0 );

function wp_lawyer_insert_practiceareas() {
  $practices = [
    'Auto Accidents',
    'Bicycle Accidents',
    'Medical Malpractice',
    'Motorcycle Accidents',
    'Products Liability',
    'Slip & Fall',
    'Trucking Accidents',
    'Wrongful Death'
  ];
  foreach ($practices as $term) {
    wp_insert_term( $term, 'wplawyer-practice-area' );
  }
}

add_action( 'init', 'wp_lawyer_insert_practiceareas' );
