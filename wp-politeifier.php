<?php 
/* 
Plugin Name: WP- Politeifier 
Plugin URI: 
Description: Cleans up commenters' bad language.
Author: 
Author URI: 
Version: 1.2

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/ 

function politeify_callback($matches){
	return '<acronym title="'. $matches[1] .'">' . str_pad("", strlen($matches[1]), "*") . '</acronym>';
}

function politeify($text) { 
	global $politeify_words; 

	if(empty($politeify_words)){
		$name = ABSPATH . "wp-content/plugins/badwords.txt";
		$file = file("$name");
		
		$politeify_words = array();
		foreach($file as $word){
			$politeify_words[]= '/(\b' . trim($word) . '\b)/si';
		}
	}
	
	return preg_replace_callback($politeify_words, "politeify_callback", $text);
} 

add_filter('comment_author', 'politeify', 19);
add_filter('comment_email', 'politeify', 19);
add_filter('comment_excerpt', 'politeify', 19);
add_filter('comment_url', 'politeify', 19);
add_filter('comment_text', 'politeify', 19);
?>