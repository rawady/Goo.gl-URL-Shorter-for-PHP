<?
	include 'gg.class/googl.url.class.php';


	$gl = new GooglCl(array(
			'API_KEY'	=>	'',											// (*필수) 구글 API 키 
			'URL'		=>	'https://www.google.com',					// default logn url (default : null)
			'DEBUG'		=>	true										// debug mode enalbe (defulat: false,   optional: true)
		));



	echo '<b>일반 사용</b><br/>';	
	echo '클래스 초기화시 지정한 URL로 바로 단축 : <br/>';
	print_r($gl->shorten());


	echo '<br/>';
	echo '<br/>';

	// inline
	echo 'URL 직접 지정해서 단축 : <br/>';
	print_r($gl->shorten('https://www.google.com'));


	echo '<br/>';
	echo '<br/>';

	// inline
	echo '원본 URL 획득 : <br/>';
	echo $gl->expand('http://goo.gl/Njku');

	

	echo '<br/>';
	echo '<br/>';	
	echo '<br/>';
	echo "<b>클래스 생성없이 사용가능 ( 단, 클래스파일내에 'GOOGLE_API_KEY' 등록 필요 )</b>";

	echo '<br/>';

	// inline
	echo 'URL 직접 지정하여 단축 :<br/>';
	echo GooglCl::shorten('https://www.google.com');

	
	echo '<br/>';
	echo '<br/>';

	// inline
	echo '원본 URL 획득<br/>';
	echo GooglCl::expand('http://goo.gl/Njku');

		
	echo '<br/>';
	echo '<br/>';
	echo '<br/>';

	// inline
	echo '<b>단축 URL 정보</b><br/>';
	print_r((array)GooglCl::getInfo('http://goo.gl/Njku'));

	// 전체 데이타 확인
	//print_r((array)GooglCl::getInfo('http://goo.gl/Njku', true));

	

?>