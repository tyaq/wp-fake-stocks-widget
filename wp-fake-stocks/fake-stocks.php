<?php 
/*
Plugin Name: Fake Stocks Quotes
Plugin URI: https://github.com/tyaq/wp-fake-stocks-widget
Description: A widget that provides fake stock quotes.
Version: 0.1
Author: Ishtyaq Habib
Author URI: https://github.com/tyaq/
License: GNU General Public Licenese
*/

class Fake_Stocks extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'fake_stocks',
			'description' => 'A widget that provides fake stock quotes.',
		);
		parent::__construct( 'fake_stocks', 'Fake Stock Quotes', $widget_ops );
		// Register style sheet.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		$title = apply_filters( 'widget_title', $instance['title'] );
        $symbols = get_quotes( $instance['symbols'], $instance['number'], $instance['api_key'] );
        
        echo $args['before_widget'];
        if ( !empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        if ( !empty( $symbols ) ) {
            foreach ( $symbols as $stock ) {
                if ( !empty($stock) && round($stock[1],2 ) != 0) { // Error Handling
                    echo '<div class="stock"><p class="ticker" title="' . $stock[3] . '">' . $stock[0] .
                     '</p><p class="price">' . round($stock[1],2) . '</p><p class="change';
                    if( $stock[2]>0) {echo ' positive';}
                    echo '">' . round(100*$stock[2]/($stock[1]-$stock[2]),2) . '%</p></div>';
                }
            }
        }
        
        echo $args['after_widget'];
        
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
        if ( isset( $instance['number'] ) ) {
            $number = $instance['number'];   
        } else {
            $number = 3;
        }
        if ( isset( $instance['symbols'] ) ) {
            $symbols = $instance['symbols'];   
        } else {
            $symbols = 'MSFT, ARAY, COKE, AMGN, BIIB';
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
         echo '<p><label for="' . $this ->get_field_id('number') . '">Number of stocks quotes to show:</label>';
         echo '<input class="tiny-text" type="number" step="1" min="1" value="'. esc_attr( $number ) . '" size="3" id="' .
                $this->get_field_id( 'number' ) . '" name="' . $this->get_field_name( 'number' ) . '"></p>';
                
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
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['api_key'] = sanitize_text_field( $new_instance['api_key'] );
        $instance['number'] = sanitize_text_field( $new_instance['number'] );
        $instance['symbols'] = strtoupper ( sanitize_text_field( $new_instance['symbols'] ) );
        return $instance;

	}

	/**
	 * Register and enqueue style sheet.
	 */
	public function register_plugin_styles() {
		wp_register_style( 'fake-stocks', plugins_url( 'ai-fake-stocks/css/fake-stocks.css' ) );
		wp_enqueue_style( 'fake-stocks' );
	}
}

/**
 * Requests ticker data from api
 *
 * @param string $str_symbols The admin's symbol list
 * @param int $number The admin's number of stocks to show
 * @param string $API_SECRET The admin's API key
 */
function get_quotes($str_symbols, $number, $API_SECRET) {
    //Requests ticker data from api
    $symbols = parse_symbols($str_symbols);
    if (count($symbols) < $number) { // If input stock symbols are less in size then input number, then display as many as you have
        $number = count($symbols);
    }
    
    $results = []; //empty array for data
    for ( $i = 0; $i < $number; $i++ ) {
        
        if ( false === ( $results[ $i ] = get_transient( $symbols[ $i ] ) ) ) {
            // It wasn't there, so regenerate the data and save the transient
            
            // Alley Interactive API
            $time = time();
            $sig = md5( "$API_SECRET" . 'quote' . "$symbols[$i]" . "$time" );
            $request = "http://apidemo.alley.ws/api.php?action=quote&symbol=$symbols[$i]&time=$time&signature=$sig";
            
            $response = wp_remote_get( $request ); // This is the slowest part, it should be made asynchronously

            if( is_array($response)) { //Error Handling
                $header = $response['headers']; // array of http header lines
                $body = $response['body']; // use the content
                $json = json_decode($body);
                if ($json != false) { //Bad server message
                    
                    if ($json->{'error'} === 0) { //Error Handling for bad requests
                    // Alley Interactive API // $results[$i] = [symbol, price, change];
                        $start = $json->{'data'}->{'starting_price'};
                        $price = $json->{'data'}->{'current_price'};
                        $name = $json->{'data'}->{'name'};
                        $results[ $i ] = [$symbols[ $i ], $price, ($start-$price), $name];
                        set_transient( $symbols[ $i ], $results[ $i ] , 1 * MINUTE_IN_SECONDS ); // Set 1 min Cache
                    }
                }
            } 
        } else {
            $results[ $i ] = get_transient( $symbols[$i] );
        }
    }
    return $results;
    
 }

/**
 * Parses admin forms symbols string into array of ticker symbols
 *
 * @param string $str_symbols The admin's symbol list
 */
function parse_symbols( $str_symbols ) {
    //Parses admin forms symbols string into array of ticker symbols
    return preg_split( "/[^a-z^A-Z]+/", $str_symbols );
 }

add_action( 'widgets_init', function(){
	register_widget( 'Fake_Stocks' );
});
?>