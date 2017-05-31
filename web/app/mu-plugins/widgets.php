<?php
/*
Plugin Name:  Custom Widgets 
Plugin URI:   https://dylan.simowitz.com/
Description:  Custom widgets for simowitz.com.
Version:      1.0.0
Author:       Dylan Simowitz
Author URI:   https://dylan.simowitz.com/
License:      MIT License
*/

class ACF_Address_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'acf_address_widget',
			esc_html__( 'Address', '' ),
			array( 'description' => esc_html__( 'Displays address from ACF fields', 'custom_widgets' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
?>
<div class="contact-widget">
  <div>
    <i class="fa fa-balance-scale fa-fw" aria-hidden="true"></i> 
    <span><?php the_field('company_name', 'options')?></span>
  </div>
  <div>
    <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
    <a href="tel:<?php the_field('phone', 'options') ?>">
      <span><?php the_field('phone', 'options') ?></span>
    </a>
  </div>
  <address>
    <div>
      <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
    </div>
    <div>
      <span><?php the_field('street', 'options') ?></span>
      <br>
      <span><?php the_field('city', 'options') ?></span>
      <span><?php the_field('state', 'options') ?></span>
      <span><?php the_field('zipcode', 'options') ?></span>
    </div>
  </address>
</div>
  <?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'custom_widgets' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

add_action( 'widgets_init', function(){
	register_widget( 'ACF_Address_Widget' );
});
