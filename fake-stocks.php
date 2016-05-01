<?php 
/*
Plugin Name: Fake Stocks Quotes
Plugin URI: https://github.com/alleyinteractive/test_project_ish
Description: A widget that provides fake stock quotes.
Version: 0.1
Author: Ishtyaq Habib
License: GNU General Public Licenese
*/
?>
<style>
    .stock {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -webkit-justify-content: space-between;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
}

.price {
  -webkit-box-flex: 1;
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
  margin-right: 5px;
  text-align: right;
}

.change {
  padding: 5px 10px;
  border-radius: 5px;
  background-color: #dd4b39;
  color: #fff;
  text-align: center;
}

</style>
<?php
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
        $title = apply_filters( 'widget_title', $instance['title'] );
        $symbols = get_quotes($instance['symbols'],$instance['number']);
        
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        foreach ($symbols as $stock) {
            echo '<div class="stock"><p class="ticker">' . $stock[0] . '</p><p class="price">' . $stock[1] .
                '</p><p class="change">' . round(100*$stock[2]/($stock[1]-$stock[2]),2) . '%</p></div>';
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
        $instance['symbols'] = sanitize_text_field( $new_instance['symbols'] );
        return $instance;
	}
    
}

/**
 * Requests ticker data from api
 *
 * @param string $str_symbols The admin's symbol list
 */
function get_quotes($str_symbols, $number) {
    //Requests ticker data from api
    $symbols = parse_symbols($str_symbols);
    if (count($symbols) < $number) { // If input stock tickers are less then input number display as many as you have
        $number = count($symbols);
    }
    
    $results = []; //empty array for data
    for ($i = 0; $i < $number; $i++) {
        $request = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20csv%20where%20url%3D'" .
         "http%3A%2F%2Fdownload.finance.yahoo.com%2Fd%2Fquotes.csv%3Fs%3D" . $symbols[$i]  ."%26f%3Dsl1d1t1c1ohgv%26e%3D.csv'" .
         "%20and%20columns%3D'symbol%2Cprice%2Cdate%2Ctime%2Cchange%2Ccol1%2Chigh%2Clow%2Ccol2'&format=json&env=store%3A%2F%2Fdatatables.org" .
         "%2Falltableswithkeys";
         $response = wp_remote_get( $request ); // NEEDS TO BE ASYNCH IT SLOWS EVERYTHING DOWN!
         print_r($i);
         if( is_array($response) ) { //Error Handling
            $header = $response['headers']; // array of http header lines
            $body = $response['body']; // use the content
            $json = json_decode($body);
            $results["$i"] = [$json->{'query'}->{'results'}->{'row'}->{'symbol'},$json->{'query'}->{'results'}->{'row'}->{'price'},$json->{'query'}->{'results'}->{'row'}->{'change'}];
          } else {
            $results["$i"] = 'error';
          }
    }
    return $results;
    
 }

/**
 * Parses admin forms symbols string into array of ticker symbols
 *
 * @param string $str_symbols The admin's symbol list
 */
function parse_symbols($str_symbols) {
    //Parses admin forms symbols string into array of ticker symbols
    return preg_split("/[^a-z^A-Z]+/", $str_symbols);
 }

add_action( 'widgets_init', function(){
	register_widget( 'AI_Fake_Stocks' );
});
?>