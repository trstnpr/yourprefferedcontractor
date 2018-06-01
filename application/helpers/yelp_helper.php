<?php

    function globaldata() {
    	$CLIENT_ID = '8D1KcnnF5ZSm5mZJ6PVNZA';
    	$CLIENT_SECRET = 'NU8c64CXtapsx5HjdUu9BgiqAb2d9VBZNzeL3YBJEy1qApiNlfk5kVYvER2aIWF2';

    	$API_HOST = "https://api.yelp.com";
	    $SEARCH_PATH = "/v3/businesses/search";
	    $BUSINESS_PATH = "/v3/businesses/";  // Business ID will come after slash.
	    $TOKEN_PATH = "/oauth2/token";
	    $GRANT_TYPE = "client_credentials";

	    // Defaults for our simple example.
	    $DEFAULT_TERM = "dinner";
	    $DEFAULT_LOCATION = "San Francisco, CA";
	    $SEARCH_LIMIT = 20;

	    $data = array(
	    		'client_id' => '8D1KcnnF5ZSm5mZJ6PVNZA',
	    		'client_secret' => 'NU8c64CXtapsx5HjdUu9BgiqAb2d9VBZNzeL3YBJEy1qApiNlfk5kVYvER2aIWF2',
	    		'api_host' => 'https://api.yelp.com',
	    		'search_path' => '/v3/businesses/search',
	    		'business_path' => '/v3/businesses/',
	    		'token_path' => '/oauth2/token',
	    		'grant_type' => 'client_credentials',
	    		'default_term' => 'dinner',
	    		'default_location' => 'San Francisco, CA',
	    		'search_limit' => 10

	    	);

	    return $data;
    }

    /**
     * Given a bearer token, send a GET request to the API.
     * 
     * @return   OAuth bearer token, obtained using client_id and client_secret.
     */

    function obtain_bearer_token() {

    	$globaldata = globaldata();


        try {
            # Using the built-in cURL library for easiest installation.
            # Extension library HttpRequest would also work here.
            $curl = curl_init();
            if (FALSE === $curl)
                throw new Exception('Failed to initialize');

            $postfields = "client_id=" . $globaldata['client_id'] .
                "&client_secret=" . $globaldata['client_secret'] .
                "&grant_type=" . $globaldata['grant_type'];

            curl_setopt_array($curl, array(
                CURLOPT_URL => $globaldata['api_host'] . $globaldata['token_path'],
                CURLOPT_RETURNTRANSFER => true,  // Capture response.
                CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 50, // default 30
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postfields,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                ),
            ));

            $response = curl_exec($curl);

            if (FALSE === $response)
                throw new Exception(curl_error($curl), curl_errno($curl));
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $http_status)
                throw new Exception($response, $http_status);

            curl_close($curl);
        } catch(Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }

        $body = json_decode($response);
        $bearer_token = $body->access_token;
        return $bearer_token;
    }


    /** 
     * Makes a request to the Yelp API and returns the response
     * 
     * @param    $bearer_token   API bearer token from obtain_bearer_token
     * @param    $host    The domain host of the API 
     * @param    $path    The path of the API after the domain.
     * @param    $url_params    Array of query-string parameters.
     * @return   The JSON response from the request      
     */
    function request($bearer_token, $host, $path, $url_params = array()) {
        // Send Yelp API Call
        try {
            $curl = curl_init();
            if (FALSE === $curl)
                throw new Exception('Failed to initialize');

            $url = $host . $path . "?" . http_build_query($url_params);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,  // Capture response.
                CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer " . $bearer_token,
                    "cache-control: no-cache",
                ),
            ));

            $response = curl_exec($curl);

            if (FALSE === $response)
                throw new Exception(curl_error($curl), curl_errno($curl));
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $http_status)
                throw new Exception($response, $http_status);

            curl_close($curl);
        } catch(Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }

        return $response;
    }

    /**
     * Query the Search API by a search term and location 
     * 
     * @param    $bearer_token   API bearer token from obtain_bearer_token
     * @param    $term        The search term passed to the API 
     * @param    $location    The search location passed to the API 
     * @return   The JSON response from the request 
     */
    function search($term, $location) {

        //$place = $location.' USA';
        $place = (empty($location)) ? 'USA' : $location.' USA';

    	$bearer_token = obtain_bearer_token();

    	$globaldata = globaldata();

        $url_params = array();
        
        $url_params['term'] = $term;
        $url_params['location'] = $place;
        $url_params['limit'] = $globaldata['search_limit'];
        
        $req = request($bearer_token, $globaldata['api_host'], $globaldata['search_path'], $url_params);


        $biz = json_decode($req);

        return $biz->businesses;
    }

    function ads($term, $location) {

        //$place = $location.' USA';
        $place = (empty($location)) ? 'USA' : $location.' USA';

        $bearer_token = obtain_bearer_token();

        $globaldata = globaldata();

        $url_params = array();
        
        $url_params['term'] = $term;
        $url_params['location'] = $place;
        $url_params['limit'] = 3;
        
        $req = request($bearer_token, $globaldata['api_host'], $globaldata['search_path'], $url_params);


        $biz = json_decode($req);

        return $biz->businesses;
    }

    function featured_locksmith($term, $location) {

        //$place = $location.' USA';
        $place = (empty($location)) ? 'USA' : $location.' USA';

        $bearer_token = obtain_bearer_token();

        $globaldata = globaldata();

        $url_params = array();
        
        $url_params['term'] = $term;
        $url_params['location'] = $place;
        $url_params['limit'] = 4;
        
        $req = request($bearer_token, $globaldata['api_host'], $globaldata['search_path'], $url_params);


        $biz = json_decode($req);

        return $biz->businesses;
    }

    function featured_locksmith_fl($term, $location) {

        //$place = $location.' USA';
        $place = (empty($location)) ? 'USA' : $location.' USA';

        $bearer_token = obtain_bearer_token();

        $globaldata = globaldata();

        $url_params = array();
        
        $url_params['term'] = $term;
        $url_params['location'] = $place;
        $url_params['limit'] = 4;
        
        $req = request($bearer_token, $globaldata['api_host'], $globaldata['search_path'], $url_params);


        $biz = json_decode($req);

        return $biz->businesses;
    }

    /**
     * Query the Business API by business_id
     * 
     * @param    $bearer_token   API bearer token from obtain_bearer_token
     * @param    $business_id    The ID of the business to query
     * @return   The JSON response from the request 
     */
    function get_business($bearer_token, $business_id) {
        
    	$globaldata = globaldata();
        $business_path = $globaldata['business_path'] . urlencode($business_id);
        
        $req = request($bearer_token, $globaldata['api_host'], $business_path);

        $biz = json_decode($req);

        return $biz;
    }

    /**
     * Queries the API by the input values from the user 
     * 
     * @param    $term        The search term to query
     * @param    $location    The location of the business to query
     */
    function get_business_all($term, $location) {     
        $bearer_token = obtain_bearer_token();

        $response = get_business($bearer_token, $term, $location);

        return $response;
       
    }