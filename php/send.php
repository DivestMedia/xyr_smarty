<?php
//extract data from the post
//set POST variables

$url = 'http://buzzmeter.net/gigsmanila-api/mail-relay.php';

echo phpinfo();
$_data = array(
	'lname' => 'alagao',
	'fname' => 'jenner'
	'title' => 'mr.'
	'company' => 'onlypinoy ltd'
	'age' => '22'
	'email' => 'jenner.alagao@gmail.com'
	'phone' => '09300990999'
);

$fields = array(
	'lname' => urlencode($_data['last_name']),
	'fname' => urlencode($_data['first_name']),
	'title' => urlencode($_data['title']),
	'company' => urlencode($_data['institution']),
	'age' => urlencode($_data['age']),
	'email' => urlencode($_data['email']),
	'phone' => urlencode($_data['phone'])
);


echo 'done';

exit;
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_data, count($fields));
curl_setopt($ch,CURLOPT_dataFIELDS, $fields_string);


echo 'sending...<br/>';

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);


print_r($result);

echo 'success sent.';