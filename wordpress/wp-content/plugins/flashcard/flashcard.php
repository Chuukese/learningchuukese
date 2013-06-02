<?php

/* 
 * Plugin Name: Flashcard Plugin
 * Plugin URI: http://www.myapps4ipad.com/flashcard-wp-plugin/
 * Version: 0.1
 * Author: Liang Shao
 * Author URI: http://www.myapps4ipad.com
 * Description: a WordPress plugin that enables your website to display a series of flashcards that can flip over to show the content on the other side when hovered.
 * 
 */

/*  Copyright 2011 Liang Shao  (email : curious.furious@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 
/*
 * enqueue all the javascripts
 */
wp_enqueue_script('jquery1.7', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js');
wp_enqueue_script('jquery-css-transform', WP_PLUGIN_URL.'/flashcard/rotate3Di/jquery-css-transform/jquery-css-transform.js', array('jquery1.7'));
wp_enqueue_script('rotate3Di', WP_PLUGIN_URL.'/flashcard/rotate3Di/rotate3Di.js', array('jquery-css-transform'));
wp_enqueue_script('flashcard', WP_PLUGIN_URL.'/flashcard/flashcard.js', array('rotate3Di'));

/*
 * settings for Flashcard plugin
 */
include_once('plugin-options.php');

/*
 * add stylesheet
 */
add_action('wp_print_styles', 'add_flashcard_stylesheet');

/*
 * add shortcode
 */
add_shortcode( 'flashcard', 'flashcard_initialize' );


/*
 * Enqueue style-file, if it exists.
 */
function add_flashcard_stylesheet() {
   	$styleUrl = plugins_url('flashcard.css', __FILE__); 
        $styleFile = WP_PLUGIN_DIR . '/flashcard/flashcard.css';
        if ( file_exists($styleFile) ) {
            wp_register_style('flashcardStyle', $styleUrl);
            wp_enqueue_style( 'flashcardStyle');
        }
}

/*
 * Parse the UTF8 text file into array
 */
function parseUTF8Text($filename){
	$handle = @fopen($filename, "r");
	$delimiter = ';';
	$arr = array();
	if ($handle) {
    		while (($buffer = fgets($handle, 4096)) !== false) {
			$buffer = str_replace("\t", $delimiter, $buffer);
			$arr[] = explode($delimiter, $buffer);
    		}
    		if (!feof($handle)) {
        		echo "Error: unexpected fgets() fail\n";
    		}
    		fclose($handle);
	}
	return $arr;
}


/*
 * initialize flash card interface. load csv file from media library
 */
function flashcard_initialize($attr){

	//define default appearance
	$padding = 10;
	$width = 130;
	$height = 130;
	$front_bg_color = "lightGray";
	$front_text_color = "black";
	$front_text_size = 20;
	$back_bg_color = "black";
	$back_text_color = "white";
	$back_text_size = 20;

	$fc_content = '';
	
	//get CSV file from shortcode paramter
	if (! isset( $attr['source'] ) ) {
		$fc_content .= 'Please indicate the CSV file to read from. This is a sample CSV file.';
		$filename = WP_PLUGIN_URL."/flashcard/sample.txt";
	}else {
		$filename = $attr['source'];
	}

	//get maximum number of cards to load from shortcode parameter
	if (isset( $attr['max'] ) ) {
		$max = $attr['max'];
	}

	//get the display order from shortcode parameter
	if (isset( $attr['order'] ) ) {
		$order = $attr['order'];
	}

	//get which side to show first
	if (isset( $attr['show'] ) && $attr['show']=="back" ) {
		$flip = true;
	}
	
	//load user settings
	$options = get_option('posk_options');
	if(is_numeric($options['width'])) $width = $options['width'];
	if(is_numeric($options['height'])) $height = $options['height'];
	$outerWidth = $width+$padding*2;
	$outerHeight = $height+$padding*2;
	if(isset($options['front_bg_color'])) $front_bg_color = $options['front_bg_color'];
	if(isset($options['front_text_color'])) $front_text_color = $options['front_text_color'];
	if(is_numeric($options['front_text_size'])) $front_text_size= $options['front_text_size'];
	if(isset($options['back_bg_color'])) $back_bg_color = $options['back_bg_color'];
	if(isset($options['back_text_color'])) $back_text_color = $options['back_text_color'];
	if(is_numeric($options['back_text_size'])) $back_text_size= $options['back_text_size'];

	//make sure the source file exists
	$file_headers = @get_headers($filename);
	if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    		echo 'The file you specified does not exist.';
		return;
	}

	//parse the UTF8 text file into array
	$result = array();
	$result = parseUTF8Text($filename);
	if(count($result)==0) return;

	//reverse or randomize array if requested
	if(isset($order)){
		if ($order == "reverse"){
			$result = array_reverse($result);
		}else if ($order == "random"){
			shuffle($result);
		}
	}

	//print out the flashcard interface
	$fc_content .= '<ul class="flashcard-container">';
	$i = 0;
	foreach ($result as $r){
		$fc_content .= '<li style="width:'.$outerWidth.'px;height:'.$outerHeight.'px;">';

		//flip sides if requested
		if($flip == true){
			$front = $r[1];
			$back = $r[0];
		}else{
			$front = $r[0];
			$back = $r[1];
		}
		$fc_content .= '<div class="front" style="width:'.$width.'px;height:'.$height.'px;background:'.$front_bg_color.';"><h2 style="font-size:'.$front_text_size.'px;color:'.$front_text_color.';">'.$front.'</h2></div>';
		$fc_content .= '<div class="back" style="width:'.$width.'px;height:'.$height.'px;background:'.$back_bg_color.';"><h2 style="font-size:'.$back_text_size.'px;color:'.$back_text_color.';">'.$back.'</h2></div>';
		$fc_content .= '</li>';
		
		//stop printing if exceeds the maximum number
		if($max>0){
			$i++;
			if($i==$max) break;
		}
	}
	$fc_content .= '</ul>';
	return $fc_content;

}


?>