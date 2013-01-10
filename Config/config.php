<?php
/**
 * CakePHP Akismet Behavior for CakePHP 2.x
 *
 * @copyright Copyright 2012, coryjthompson.com (http://coryjthompson.com/)
 * @link http://github.com/coryjthompson/akismet-behavior
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */


$config['akismet'] = array(
	'key' => 'keyhere', // your akismet api key
	'blog' => 'http://coryjthompson.com', // your blog url
	'fields' => array(
		'spam' => 'spam', //field to mark as 1 if spam
		'author' => 'name',  //name of the comment author
		'email' => 'email',  //email of the comment author
		'url' => 'url',      //url of the comment author
		'content' => 'content',  //content of the comment
		'ip_address' => 'ip_address', //ip address of commenter
		'user_agent' => 'user_agent' //user agent of commenter
	)
);

