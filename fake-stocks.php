<?php 
/*
Plugin Name: Fake Stocks Quotes
Plugin URI: https://github.com/alleyinteractive/test_project_ish
Description: A widget that provides fake stock quotes.
Version: 0.1
Author: Ishtyaq Habib
License: GNU General Public Licenese
*/

class AI_Fake_Stocks extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'fake_stocks',
			'description' => 'A widget that provides fake stock quotes.',
		);
		parent::__construct( 'fake_stocks', 'Fake Stock Quotes', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'AI_Fake_Stocks' );
});
?>