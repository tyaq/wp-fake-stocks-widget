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
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];   
        } else {
            $title = 'Stock Quotes';
        }
        if ( isset( $instance['api_key'] ) ) {
            $api_key = $instance['api_key'];   
        } else {
            $api_key = '';
        }
        if ( isset( $instance['num'] ) ) {
            $num = $instance['num'];   
        } else {
            $num = 3;
        }
        if ( isset( $instance['symbols'] ) ) {
            $symbols = $instance['symbols'];   
        } else {
            $symbols = 'AAPL, MSFT, INTC, GILD, AAL';
        }
        
         //Widget Title Field
         echo '<p><label for="' . $this ->get_field_id('title') . '">Title:</label>';
         echo '<input class="widefat" type="text" value="'. esc_attr( $title ) . '" id="' . $this->get_field_id( 'title' ) . 
                '" name="' . $this->get_field_name( 'title' ) . '"></p>';
          
         //API Key Field      
         echo '<p><label for="' . $this ->get_field_id('api_key') . '">Your API Key:</label>';
         echo '<input class="widefat" type="text" value="'. esc_attr( $api_key ) . '" id="' . $this->get_field_id( 'api_key' ) . 
                '" name="' . $this->get_field_name( 'api_key' ) . '"></p>';
                
         //Number of Stocks Field      
         echo '<p><label for="' . $this ->get_field_id('num') . '">Number of stocks quotes to show:</label>';
         echo '<input class="tiny-text" type="number" step="1" min="1" value="'. esc_attr( $num ) . '" size="3" id="' .
                $this->get_field_id( 'num' ) . '" name="' . $this->get_field_name( 'num' ) . '"></p>';
                
         //Stock Symbols Field      
         echo '<p><label for="' . $this ->get_field_id('symbols') . '">NASDAQ ticker symbols (separated by commas):</label>';
         echo '<input class="widefat" type="text" value="'. esc_attr( $symbols ) . '" id="' . $this->get_field_id( 'symbols' ) . 
                '" name="' . $this->get_field_name( 'symbols' ) . '"></p>';
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        $instance['title'] = strip_tags( $new_instance['title'] );
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'AI_Fake_Stocks' );
});
?>