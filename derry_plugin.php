<?php
/**
 * Plugin Name:       DERRY API 
 * Plugin URI:        http://github.com/hyperking/derry-api.git
 * Description:       This plugin grabs posts from aggregate sites
 * Version:           1.0
 * Author:            Derry Spann
 * Author URI:        http://derryspann.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       derry-api
 * Domain Path:       /languages
 */

/* Load templating engine */
require_once 'vendor/autoload.php';


/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function derry_api_dashboard_widget() {

	wp_add_dashboard_widget(
                 'derry_api',         // Widget slug.
                 'Derry API widget',         // Title.
                 'derry_api_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'derry_api_dashboard_widget' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function derry_api_function() {
	$loader 	= new Twig_Loader_Filesystem( plugin_dir_path( __FILE__ ).'/templates');
	$twig   	= new Twig_Environment($loader,[
			'auto_escape' => true,
			]);
	function fetch_json ($endpoint, $type, $limit) {
		$api = $endpoint.'/'.$type.'?number='.$limit;
		$options = [
			'http'=>['ignore_errors'=> true ]
		];

		$context  = stream_context_create( $options );
		$response = file_get_contents($api, false, $context );
		$response = json_decode( $response );
		if($response->found){
			return $response->posts;
		}
		return $response;
	}
	//get json 
	$query = $_GET['get_site'];

	if(isset($query)){
		$sites = ['derry_one'=>'https://public-api.wordpress.com/rest/v1/sites/derryone.wordpress.com',
				'derry_two'=>'https://public-api.wordpress.com/rest/v1/sites/derrytwo.wordpress.com'];
		$endpoint = $sites[$query];
		$type = 'posts';
		$limit = 10;
		$feed = fetch_json($endpoint, $type, $limit);
		// Display feed
		$html = $twig->render('index.html', ['feed'=> $feed]);
		echo $html;
	}else{
		echo $twig->render('index.html', ['feed'=> false]);
	}
}