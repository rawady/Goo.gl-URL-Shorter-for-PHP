Goo.gl-URL-Shorter-for-PHP
==========================

PHP , Goo.gl 단축 주소 

문서 작성중...

	
! required PHP 5.x Higher
! required curl enable



>간단히 
GooglCl::shorten('https://www.google.com');
GooglCl::expand('http://goo.gl/Njku');

(array)GooglCl::getInfo('http://goo.gl/Njku');
(array)GooglCl::getInfo('http://goo.gl/Njku', true);



> 모든기능

$gl = new GooglCl(array(
	'API_KEY'	=>	'',								// (*필수) 구글 API 키 
	'URL'		=>	'https://www.google.com',					// default logn url (default : null)
	'DEBUG'		=>	false								// debug mode enalbe (defulat: false,   optional: true)
));



$gl->shorten();
$gl->shorten('https://www.google.com');
$gl->expand('http://goo.gl/Njku');

