<?php

	class App extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            

            $this->load->helper('citygrid');
            $this->load->helper('general');
			$this->load->model('State_model');
			$this->load->model('City_model');
			$this->load->model('Business_model');
			$this->load->model('Page_model');
			$this->load->model('Configuration_model');
			$this->load->model('Industry_model');
			$this->load->helper('url');
			$this->load->library('pagination');
        }

		public function index($page = 'home') {

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			} else {

				$data['title'] = the_config('site_name');
				$data['term'] = 'locksmith';
				$data['location'] = 'California';

				// API Process
				$result = api_search($data['term'], $data['location']);
				if($result['result'] == 'success') {
					$hits = $result['data']->results->total_hits;

					if($hits != 0) {
						$data['business'] = $result['data']->results->locations;

					} else {
						$data['business'] = 0;
					}

				} else {
					$data['business'] = 0;
				}

				$business = $this->Business_model->get_verified_business();
				$data['business_count'] = count($business);
				if($business != 0) {
					$data['local_business'] = $business;
				} else {
					$data['local_business'] = 0;
				}

				// Popular City
				$popular_cities = $this->City_model->get_popular_city();
				if($popular_cities != 0) {
					$data['popular_city'] = array('result' => 'success', 'message' => 'Has Popular City', 'data' => $popular_cities);
				} else {
					$data['popular_city'] = array('result' => 'error', 'message' => 'No Popular City');
				}

				// Blog Data
				$blogs = $this->Page_model->get_published_post();
				if($blogs != 0) {
					$data['blogs'] = $blogs;
				} else {
					$data['blogs'] = 0;
				}

				// META
				$data['meta_title'] = the_config('meta_title');
				$data['meta_keyword'] = the_config('meta_keyword');
				$data['meta_description'] = the_config('meta_description');

				$popular_cities = $this->City_model->get_popular_city();
				if($popular_cities != 0) {
					$data['popular_city'] = array('result' => 'success', 'message' => 'Has Popular City', 'data' => $popular_cities);
				} else {
					$data['popular_city'] = array('result' => 'error', 'message' => 'No Popular City');
				}
				
				$this->load->view('templates/header', $data);
				$this->load->view('pages/'.$page, $data);
				$this->load->view('templates/footer');
			}

		}

		// public function city($page = 'city') {

		// 	if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
		// 		show_404();
		// 	} else {
				
		// 		$slug = $this->uri->segment(2, 0);

		// 		$city_data = $this->City_model->get_city_from_slug($slug);

		// 		if($city_data != 0) {

		// 			$data['city_data'] = $city_data[0];

		// 			$city = $data['city_data']->name;

		// 			$state_abbrev = strtoupper($data['city_data']->state);

		// 			$state = $this->State_model->get_state_from_abbrev($state_abbrev);

		// 			$data['state'] = $state[0];


		// 			$data['term'] = 'locksmith';
		// 			$data['location'] = $city.', '.$data['state']->abbrev;

		// 			// API Process
		// 			$result = api_search($data['term'], $data['location']);
		// 			if($result['result'] == 'success') {
		// 				$hits = $result['data']->results->total_hits;

		// 				if($hits != 0) {
		// 					$data['business'] = $result['data']->results->locations;

		// 				} else {
		// 					$data['business'] = 0;
		// 				}

		// 			} else {
		// 				$data['business'] = 0;
		// 			}

		// 			$popular_cities = $this->City_model->get_popular_city();
		// 			if($popular_cities != 0) {
		// 				$data['popular_city'] = array('result' => 'success', 'message' => 'Has Popular City', 'data' => $popular_cities);
		// 			} else {
		// 				$data['popular_city'] = array('result' => 'error', 'message' => 'No Popular City');
		// 			}

		// 			// Blog Data
		// 			$blogs = $this->Page_model->get_published_post();
		// 			if($blogs != 0) {
		// 				$data['recent_blogs'] = $blogs;
		// 			} else {
		// 				$data['recent_blogs'] = 0;
		// 			}

		// 			// foreach($data['yelp'] as $res) {
		// 			// 	$i = 0;
		// 			// 	if($res->location->city == $city) {
		// 			// 		$i = $i + 1;
		// 			// 	}
		// 			// 	$exact[] = $i;
		// 			// }
		// 			// $yelp_count = (array_sum($exact) != 0) ? array_sum($exact).' Exact Results' : count($data['yelp']).' Suggestions';

		// 			// $ybiz = array();
		// 			// foreach($data['yelp'] as $ybiz) {
		// 			// 	$bizname[] = $ybiz->name;
		// 			// }
		// 			// $business = join(', ', $bizname);

		// 			// META
		// 			$data['title'] = $data['location'].' - '.the_config('site_name');
		// 			$data['meta_title'] = $data['title'];
		// 			$data['meta_keyword'] = '';
		// 			$data['meta_description'] = '';

		// 			// $data['title'] = 'Top Locksmith in '.$city.', '.$state_abbrev.' | '.$yelp_count.' | As of '.recent_my().' - '.the_config('site_name');
		// 			// $data['meta_title'] = $data['title'];
		// 			// $data['meta_keyword'] = '24 hour emergency locksmith in '.$city.', '.$state_abbrev.', residential locksmith service in '.$city.', '.$state_abbrev.', commercial locksmith service in '.$city.', '.$state_abbrev.', automotive locksmith service in '.$city.', '.$state_abbrev.', emergency locksmith service in '.$city.', '.$state_abbrev.', industrial locksmith service in '.$city.', '.$state_abbrev;
		// 			// $data['meta_description'] = 'List of Locksmith in '.$city.', '.$state_abbrev.' - '.$business;
					
		// 			$this->load->view('templates/header', $data);
		// 			$this->load->view('pages/'.$page, $data);
		// 			$this->load->view('templates/footer');
		// 		} else {

		// 			show_404();

		// 		}
		// 	}			

		// }

		// public function zip($page = 'zip') {

		// 	if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
		// 		show_404();
		// 	} else {

		// 		$data['zip'] = $this->uri->segment(2, 0);

		// 		if(is_numeric($data['zip']) AND strlen($data['zip']) == 5) {

		// 			$city_data = $this->City_model->get_city_from_zip($data['zip']);

		// 			$data['city_data'] = $city_data[0];

		// 			$data['state'] = $this->State_model->get_state_from_abbrev($data['city_data']->state)[0];

		// 			$data['term'] = 'locksmith';
		// 			$data['location'] = $data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'];

		// 			// API Process
		// 			$result = api_search($data['term'], $data['location']);
		// 			if($result['result'] == 'success') {
		// 				$hits = $result['data']->results->total_hits;

		// 				if($hits != 0) {
		// 					$data['business'] = $result['data']->results->locations;

		// 				} else {
		// 					$data['business'] = 0;
		// 				}

		// 			} else {
		// 				$data['business'] = 0;
		// 			}

		// 			$popular_cities = $this->City_model->get_popular_city();
		// 			if($popular_cities != 0) {
		// 				$data['popular_city'] = array('result' => 'success', 'message' => 'Has Popular City', 'data' => $popular_cities);
		// 			} else {
		// 				$data['popular_city'] = array('result' => 'error', 'message' => 'No Popular City');
		// 			}

		// 			// Blog Data
		// 			$blogs = $this->Page_model->get_published_post();
		// 			if($blogs != 0) {
		// 				$data['recent_blogs'] = $blogs;
		// 			} else {
		// 				$data['recent_blogs'] = 0;
		// 			}

		// 			// foreach($data['yelp'] as $res) {
		// 			// 	$i = 0;
		// 			// 	if($res->location->city == $data['city_data']->name) {
		// 			// 		$i = $i + 1;
		// 			// 	}
		// 			// 	$exact[] = $i;
		// 			// }
		// 			// $yelp_count = (array_sum($exact) != 0) ? array_sum($exact).' Exact Results' : count($data['yelp']).' Suggestions';

		// 			// $ybiz = array();
		// 			// foreach($data['yelp'] as $ybiz) {
		// 			// 	$bizname[] = $ybiz->name;
		// 			// }
		// 			// $business = join(', ', $bizname);

		// 			// META
		// 			$data['title'] = $data['location'].' - '.the_config('site_name');
		// 			$data['meta_title'] = $data['title'];
		// 			$data['meta_keyword'] = '';
		// 			$data['meta_description'] = '';

		// 			// $data['title'] = 'Expert Locksmith in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'].' | '.$yelp_count.' | As of '.recent_my().' - '.the_config('site_name');
		// 			// $data['meta_title'] = $data['title'];
		// 			// $data['meta_keyword'] = '24 hour emergency locksmith in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).', residential locksmith service in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).', commercial locksmith service in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).', automotive locksmith service in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).', emergency locksmith service in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).', industrial locksmith service in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state);
		// 			// $data['meta_description'] = 'Leading Locksmith in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'].' - '.$business;
					
		// 			$this->load->view('templates/header', $data);
		// 			$this->load->view('pages/'.$page, $data);
		// 			$this->load->view('templates/footer');

		// 		} else {
		// 			show_404();
		// 		}
		// 	}			

		// }

		public function contactProcess() {

			$mdata = $this->input->post();
			$gr_data = gr_keys();
			$site_key = $gr_data['site_key'];
			$secret_key = $gr_data['secret_key'];
			$site_verify = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$mdata['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
			$response = file_get_contents($site_verify);
			$g_response = json_decode($response);

			if($g_response->success == 1) {

				$emailConfig = mail_config();

		        $from = array(
		            'email' => $mdata['email'],
		            'name' => strtoupper($mdata['name']).' - '.the_config('site_name').' Contact Us'
		        );
		       
		        // $to = array($mdata['email']);
		        $to = $emailConfig['smtp_user'];
		        $subject = $mdata['subject'];
		      	$message = $mdata['message'];
		        $this->load->library('email', $emailConfig);
		        $this->email->set_newline("\r\n");
		        $this->email->from($from['email'], $from['name']);
		        $this->email->to($to);
		        $this->email->subject($subject);
		        $this->email->message($message);
		        if (!$this->email->send()) {
		            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
		        } else {
		            $response = json_encode(array('result' => 'success', 'message' => 'Message successfully sent!'));
		        }

			} else {
				$response = json_encode(array('result' => 'error', 'message' => 'Invalid Captcha!'));
			}

	        echo $response;

		}

		
	}