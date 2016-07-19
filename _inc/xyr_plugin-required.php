<?


function xyr_contactmethods( $contactmethods ) {
	
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['google'] = 'Google+';
	$contactmethods['linkedin'] = 'Linked in';
	$contactmethods['pinterest'] = 'Pinterest';
	$contactmethods['instagram'] = 'Instagram';
	$contactmethods['google'] = 'Google+';
	$contactmethods['link'] = 'Any Link';
	
	return $contactmethods;
}
add_filter('user_contactmethods','xyr_contactmethods',10,1);

