<?php

	function api_data() {

		$data = array(
				'endpoint' => 'http://api.citygridmedia.com/content/places/v2/',
				'publisher' => 'publisher=10000021548',
				'format' => 'format=json',
				'what' => 'what=locksmith',
				'rpp' => 'rpp=30'
			);

		return $data;

	}

	function api_search($what, $location) {

		$data = api_data();
		$where = 'where='.preg_replace('/\s/', '%20', $location);
		$endpoint = $data['endpoint'].'search/where?what='.$what.'&'.$where.'&'.$data['rpp'].'&'.$data['format'].'&'.$data['publisher'];

		$request_url = $endpoint;
		$user_agent = 'useragent=Mozilla%2F5.0+%28Macintosh%3B+Intel+Mac+OS+X+10_8_5%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F31.0.1650.63+Safari%2F537.36';

		$ch = curl_init($request_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_USERAGENT, $user_agent);
		$result = curl_exec($ch);
		curl_close($ch);

		if(!empty($result)) {
			$json = json_decode($result);

			if(isset($json->results)) {
				$response = array('result' => 'success', 'data' => $json);
			} else {
				$response = array('result' => 'error', 'message' => 'Api Error');
			}

		} else {
			$response = array('result' => 'error', 'message' => 'Api Error');
		}

		return $response;
	}