<?php

// USE SMTP OR mail()
// SMTP is recommended, mail() is disabled on most shared hosting servers.
// IF false : SMTP host/port/user/pass/ssl not used, leave empty or as it is!
$config['use_smtp']				= false;						// true|false

// SMTP Server Settings
$config['smtp_host'] 			= 'smtp.gmail.com';   		// eg.: smtp.gmail.com
$config['smtp_port'] 			= 587;						// eg.: 587
$config['smtp_user'] 			= ''; 						// you@gmail.com
$config['smtp_pass'] 			= '';						// password
$config['smtp_ssl']				= false;					// should remain false

// Who receive all emails?
$config['send_to']				= 'charlie@divestmedia.com';	// destination of all emails sent throught contact form

// Email Subject
$config['subject']				= 'Contact Us';	// subject of emails you receive

// Always set content-type when sending HTML email
$config['headers'] = "MIME-Version: 1.0" . "\r\n";
$config['headers'] .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$config['headers'] .= 'From: DivestMedia Form <no-reply@divestmedia.com>' . "\r\n";


/** ******************************************************* MISC ******************************************************* **/

//localhost
if($_SERVER['SERVER_ADDR'] == '127.0.0.1'){
	define('UPLOAD_FOLDER',		'C:\__local__\__wordpress__\wp-content\uploads\user-poster'); //let the upload dir default										// upload folder path - slash at the end!
	define('UPLOAD_FOLDER_URL',	'http://wordpress.pc/wp-content/uploads/user-poster/');	// Full url path to upload folder (used for contact files) - slash at the end!
	define('UPLOAD_MAX_SIZE',	5000000);	// 1000000 = 10Mb
}else{
	define('UPLOAD_FOLDER',		'/home/gigsmanila/web/gigsmanila.com/public_html/resources/uploads/user-poster/');										// upload folder path - slash at the end!
	define('UPLOAD_FOLDER_URL',	'http://www.gigsmanila.com/resources/uploads/user-poster/');	// Full url path to upload folder (used for contact files) - slash at the end!
	define('UPLOAD_MAX_SIZE',	5000000); // 1000000 = 10Mb
}

		
		



/** ****************************************************** CACHE ******************************************************* **/
define('CACHE_ENABLED', 	true);			// cache (example usage: twitter widget)
define('CACHE_LIFETIME', 	3600); 			// in seconds




/** ************************************************** TWITTER WIDGET ************************************************** **/
/** 
	First, you need a consumer key and secret keys. 
	Get one from dev.twitter.com/apps

	Please note, the keys already used here - are for demo purpose only!
	Please use your own twitter keys!
**/


// Consumer Key
define('CONSUMER_KEY', 		'4OEtaqfomSIhGxzsdOIO7Z5sH');
define('CONSUMER_SECRET', 	'avL0m45pva3U5zGD5hJwaiBSFRBkqGRjT2PiXX3yRfJwDtZB3Y');

// User Access Token
define('ACCESS_TOKEN', 		'477243933-21loPkRFjsUU49shFEFQKD0KTIqfCKk1L4gOh1rP');
define('ACCESS_SECRET', 	'Wl7WIK4MuAkuzLiI5hmBTKqVGPQIAnHy7BUhrVU6sh6rf');
/** ******************************************************************************************************************** **/


define('reCAPTCHA_KEY',			'6LcryB0TAAAAAIPriI72fEAKa6kcCpB_FLfUn9Ox');
define('reCAPTCHA_SECRETKEY',	'6LcryB0TAAAAAKh6STYtD3lITyW4IeMGOvcrN9mZ');

?>