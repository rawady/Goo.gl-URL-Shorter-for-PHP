<?
/**
*	Goo.gl-URL-Shorter-for-PHP Class 1.0
*   class : GooglCl
*   Author : Rawady corp. Jung Jintae
*   date : 2014.5.11 
*	https://github.com/rawady/Goo.gl-URL-Shorter-for-PHP
	
	! required PHP 5.x Higher
	! required curl enable


The MIT License (MIT)

Copyright (c) 2014 Jung Jintae

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


*/


	define('GOOGLE_API_KEY', '');	// (옵션-Static 사용하거나, 초기화시 미입력시 필요) GOOGLE API KEY
	


	class GooglCl{
		var $API_KEY = NULL;
		var $URL = NULL;
		var $DEBUG = false;
		var $loadClass = false;


		// constructor 
		function GooglCL($parameters = array()){

			if(!function_exists('curl_version')){
				echo "cURL is NOT enabled on this server";
				return null;
			}
			
			foreach($parameters as $key => $value) {
				$this->$key = $value;
			}

			if(!isset($this->API_KEY) || !$this->API_KEY){
				if(!GOOGLE_API_KEY){
					echo '[API_KEY] are required';
					return null;
				}else{
					$this->API_KEY = GOOGLE_API_KEY;
				}
			}
			$this->loadClass = true;
		}

		function shorten($url = NULL, $classLoader = false){
			
			$_API_KEY = '';
			$_URL = '';
			$_ENDPOINT = '';
			
			if(!isset($this)) { $classLoader = true; }

			if($classLoader){
				if(GOOGLE_API_KEY != ''){
					$_API_KEY = GOOGLE_API_KEY;
				}else{
					echo 'please define [API_KEY]';
					return null;
				}
				$_ENDPOINT = self::api_url();
			
			}else{

				$_API_KEY = $this->API_KEY;
				$_ENDPOINT = $this->api_url();
				$_URL = $this->URL;
			}

			if($_URL || $url && $url != ''){
				
				if($url){
					$_URL = $url;
				}

				
				$ch = curl_init( 
					sprintf('%s/url?key=%s', $_ENDPOINT, $_API_KEY)
				);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$requestData = array( 'longUrl' => $_URL);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
				$result = curl_exec($ch);
				curl_close($ch);

				$retVar = json_decode($result, true);

				if(isset($retVar['id']) && $retVar['id'] != ''){
					return $retVar['id'];
				}else {
					if(!$clasLoader){
						if(isset($this) && $this->DEBUG){
							print_r($retVar);
						}
					}else{
						return null;
					}
				}
				
			}else{
				echo 'url not found';
				return null;
			}
		}

		function expand($url = ''){
			if($url && $url != ''){
				$_ENDPOINT = self::api_url();
				
				if($url){
					$_URL = $url;
				}
				
				$ch = curl_init( 
					sprintf('%s/url?shortUrl=%s', $_ENDPOINT, $_URL)
				);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				$result = curl_exec($ch);
				curl_close($ch);

				$retVar = json_decode($result, true);
				if(isset($retVar['longUrl']) && $retVar['longUrl'] != ''){
					return $retVar['longUrl'];
				}else {
					if(!$clasLoader){
						if(isset($this) && $this->DEBUG){
							print_r($retVar);
						}
					}else{
						return null;
					}
				}	
			}else{
				echo 'url not found';
				return null;
			}
		}


		function getInfo($url = '', $useReffer = false){
			if($url && $url != ''){
				$_ENDPOINT = self::api_url();
				
				if($url){
					$_URL = $url;
				}
				
				$ch = curl_init( 
					sprintf('%s/url?shortUrl=%s&projection=FULL', $_ENDPOINT, $_URL)
				);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				$result = curl_exec($ch);
				curl_close($ch);

				$retVar = json_decode($result, true);
				if(isset($retVar['kind'])) {unset($retVar['kind']);}
				
				if(!$useReffer){ 
					$extx['shortUrlClicks'] = $retVar['analytics']['allTime']['shortUrlClicks'];
					$extx['longUrlClicks'] = $retVar['analytics']['allTime']['longUrlClicks'];
					$extx['created'] = $retVar['created'];
					
					return $extx;		
				}else{
					return $retVar;
				}
				
			}else{
				echo 'url not found';
				return null;
			}
		}

		// Get google API Link
		function api_url(){
			return 'https://www.googleapis.com/urlshortener/v1';
		}
	}
?>