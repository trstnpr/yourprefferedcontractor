<?php

	class Industry extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            
            $this->load->helper('citygrid');
            $this->load->helper('general');
			$this->load->model('State_model');
			$this->load->model('City_model');
			$this->load->model('Business_model');
			$this->load->model('Industry_model');
			$this->load->model('Page_model');
			$this->load->library('pagination');
			$this->load->helper('url');
			$this->load->model('Configuration_model');

        }

        public function state($page = 'states') {

        	$offset = $this->uri->segment(3, 0);

        	if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {

				show_404();

			} else {

	        	$data['industry'] = $this->uri->segment(2, 0);

	        	if($data['industry']) { // validate if segment exist

	        		$slug = $this->Industry_model->get_industry_from_slug($data['industry']);

	        		if($slug) {

	        			//how many blogs will be shown in a page
				        $limit = 12;
				        $result = $this->State_model->get_state_offset($limit, $offset);

				        $data['states'] = $result['data'];
				        $data['count'] = $result['count'];
				        
				        $config = array();
				        $config['base_url'] = site_url('industry/'.$data['industry']);
				        $config['total_rows'] = $data['count'];
				        $config['per_page'] = $limit;

				        //which uri segment indicates pagination number
				        $config['uri_segment'] = 3;
				        $config['use_page_numbers'] = TRUE;

				        //max links on a page will be shown
				        $config['num_links'] = 4;

				        //various pagination configuration
				        $config['full_tag_open'] = '<nav><ul class="pager">';

				        $config['prev_tag_open'] = '<li>';
				        $config['prev_link'] = '&laquo;';
				        $config['prev_tag_close'] = '</li>';

				        $config['cur_tag_open'] = '<li class="active"><a href="#"><strong>';
				        $config['cur_tag_close'] = '</strong></a></li>';

				        $config['num_tag_open'] = '<li>';
				        $config['num_tag_close'] = '</li>';

				        $config['next_tag_open'] = '<li>';
				        $config['next_link'] = '&raquo;';
				        $config['next_tag_close'] = '</li>';		        

				        $config['full_tag_close'] = '</ul></nav>';

				        $this->pagination->initialize($config);
				        $data['pagination'] = $this->pagination->create_links();

				        $popular_cities = $this->City_model->get_popular_city();
						if($popular_cities != 0) {
							$data['popular_city'] = array('result' => 'success', 'message' => 'Has Popular City', 'data' => $popular_cities);
						} else {
							$data['popular_city'] = array('result' => 'error', 'message' => 'No Popular City');
						}

						$rand_pop_city = $this->City_model->get_random_popular_city();
						$data['promo_ad'] = $rand_pop_city[0];

						// Blog Data
						$blogs = $this->Page_model->get_published_post();
						if($blogs != 0) {
							$data['recent_blogs'] = $blogs;
						} else {
							$data['recent_blogs'] = 0;
						}

						$data['title'] = ucwords($data['industry']).' - '.the_config('site_name');
						$data['meta_title'] = '';
						$data['meta_keyword'] = '';
						$data['meta_description'] = '';
						
						$this->load->view('templates/header', $data);
						$this->load->view('pages/'.$page, $data);
						$this->load->view('templates/footer');

	        		} else {

	        			show_404();

	        		}

	        	}

	        }

        }

        public function city($page = 'state') {

        	$offset = $this->uri->segment(4, 0);

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {

				show_404();

			} else {

				$abbr = $this->uri->segment(3, 0);

				$data['industry'] = $this->uri->segment(2, 0);
				$industry = $this->Industry_model->get_industry_from_slug($data['industry']);
				$industry_id = $industry[0]->id;

				$data['state_arr'] = $this->State_model->get_state_from_abbrev($abbr);

				if($data['state_arr'] != 0) {

					$data_state = $data['state_arr'][0];
		 			$data['state'] = $data_state;

					//how many blogs will be shown in a page
			        $limit = 10;

			        $city = $this->City_model->get_city_from_abbrev_industry($abbr, $industry_id);
		        	$data['count'] = count($city);

			        $result = $this->City_model->get_city_from_state_industry($abbr, $industry_id, $limit, $offset);
			        $data['cities'] = $result['data'];

			        $config = array();
			        $config['base_url'] = base_url('industry/'.$data['industry'].'/'.$abbr);
			        $config['total_rows'] = $data['count'];
			        $config['per_page'] = $limit;

			        //which uri segment indicates pagination number
			        $config['uri_segment'] = 4;
			        $config['use_page_numbers'] = TRUE;

			        //max links on a page will be shown
			        $config['num_links'] = 2;

			        //various pagination configuration
			        $config['full_tag_open'] = '<nav><ul class="pager">';

			        $config['prev_tag_open'] = '<li>';
			        $config['prev_link'] = '&laquo;';
			        $config['prev_tag_close'] = '</li>';

			        $config['cur_tag_open'] = '<li class="active"><a href="#"><strong>';
			        $config['cur_tag_close'] = '</strong></a></li>';

			        $config['num_tag_open'] = '<li>';
			        $config['num_tag_close'] = '</li>';

			        $config['next_tag_open'] = '<li>';
			        $config['next_link'] = '&raquo;';
			        $config['next_tag_close'] = '</li>';		        

			        $config['full_tag_close'] = '</ul></nav>';

			        $this->pagination->initialize($config);
			        $data['pagination'] = $this->pagination->create_links();

			        // Blog Data
					$blogs = $this->Page_model->get_published_post();
					if($blogs != 0) {
						$data['recent_blogs'] = $blogs;
					} else {
						$data['recent_blogs'] = 0;
					}

			        $data['title'] = $data_state->state.' - '.the_config('site_name');
					$data['meta_title'] = $data['title'];
					$data['meta_keyword'] = '';
					$data['meta_description'] = '';
					
					$this->load->view('templates/header', $data);
					$this->load->view('pages/'.$page, $data);
					$this->load->view('templates/footer');


				} else {
					header('Location: '.base_url('states'));
				}
			}

		}

		public function city_business($page = 'city') {

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			} else {

				$data['industry'] = $this->uri->segment(2, 0);
				$data['area'] = $this->uri->segment(3, 0);
				$slug = $data['industry'].'/'.$data['area'];

				$industry_data = $this->Industry_model->get_industry_from_slug($data['industry']);
				$city_data = $this->City_model->get_city_from_slug($slug);

				if($city_data != 0) {

					$data['city_data'] = $city_data[0];
					$data['industry_data'] = $industry_data[0];

					$city = $data['city_data']->name;

					$state_abbrev = strtoupper($data['city_data']->state);

					$state = $this->State_model->get_state_from_abbrev($state_abbrev);

					$data['state'] = $state[0];


					$data['term'] = $data['industry'];
					$data['location'] = $city.', '.$data['state']->abbrev;

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

					// Blog Data
					$blogs = $this->Page_model->get_published_post();
					if($blogs != 0) {
						$data['recent_blogs'] = $blogs;
					} else {
						$data['recent_blogs'] = 0;
					}

					if($data['business'] != 0) {
						$sys_loc = slugify($data['location']);
						$exact = array();
						$business = array();
						foreach($data['business'] as $res) {
							$i = 0;
							$res_loc = (isset($res->address->city) and isset($res->address->state)) ? slugify($res->address->city.', '.$res->address->state) : NULL ;
							
							if($res_loc == $sys_loc) {
								$i = $i + 1;
							}

							$exact[] = $i;

							$business[] = $res->name;
						}
						$result_count = (array_sum($exact) != 0) ? array_sum($exact).' Exact Results' : count($data['yelp']).' Suggestions';
						$top_res = join(', ', array_slice($business, 0, 10));

						// Meta Values
						$title_tag = 'Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' - '.$result_count.' Results as of '.recent_my();
						$mtitle_tag = $title_tag;
						$mkeyword_tag = '';
						$mdescription = 'Find the Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' - '.$top_res;
					} else {
						// Meta Values
						$title_tag = 'Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' - As of '.recent_my();
						$mtitle_tag = $title_tag;
						$mkeyword_tag = '';
						$mdescription = 'Find the Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' - As of '.recent_my().'. Get garage door company addresses, contact numbers, maps, directions and more.';
					}


					// META
					$data['title'] = $title_tag;
					$data['meta_title'] = $mtitle_tag;
					$data['meta_keyword'] = $mkeyword_tag ;
					$data['meta_description'] = $mdescription;

					
					$this->load->view('templates/header', $data);
					$this->load->view('pages/'.$page, $data);
					$this->load->view('templates/footer');
				} else {

					show_404();

				}

			}			

		}

		public function zip_business($page = 'zip') {

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			} else {

				$data['industry'] = $this->uri->segment(2, 0);
				$data['zip'] = $this->uri->segment(3, 0);

				$industry_data = $this->Industry_model->get_industry_from_slug($data['industry']);

				if($industry_data) {

					$data['industry_data'] = $industry_data[0];

					if(is_numeric($data['zip']) AND strlen($data['zip']) == 5) {

						$city_data = $this->City_model->get_city_from_zip_industry($data['zip'], $data['industry_data']->id);

						if($city_data != 0) {

							$data['city_data'] = $city_data[0];

							$data['state'] = $this->State_model->get_state_from_abbrev($data['city_data']->state)[0];

							$data['term'] = $data['industry'];
							$data['location'] = $data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'];

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

							// Blog Data
							$blogs = $this->Page_model->get_published_post();
							if($blogs != 0) {
								$data['recent_blogs'] = $blogs;
							} else {
								$data['recent_blogs'] = 0;
							}

							if($data['business'] != 0) {
								$sys_loc = slugify($data['zip'].', '.$data['city_data']->state);
								$exact = array();
								$business = array();
								foreach($data['business'] as $res) {
									$i = 0;
									$res_loc = (isset($res->address->postal_code) and isset($res->address->state)) ? slugify($res->address->postal_code.', '.$res->address->state) : NULL ;

									if($res_loc == $sys_loc) {
										$i = $i + 1;
									}

									$exact[] = $i;

									$business[] = $res->name;
								}
								
								$result_count = (array_sum($exact) != 0) ? array_sum($exact).' Exact Results' : count($data['yelp']).' Suggestions';
								$top_res = join(', ', array_slice($business, 0, 10));

								// Meta Values
								$title_tag = 'Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'].' - '.$result_count.' Results as of '.recent_my();
								$mtitle_tag = $title_tag;
								$mkeyword_tag = '';
								$mdescription = 'Find the Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'].' - '.$top_res;
							} else {
								// Meta Values
								$title_tag = 'Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'].' - As of '.recent_my();
								$mtitle_tag = $title_tag;
								$mkeyword_tag = '';
								$mdescription = 'Find the Best Automotive '.ucwords($data['term']).' in '.$data['city_data']->name.', '.strtoupper($data['city_data']->state).' '.$data['zip'].' - As of '.recent_my().'. Get garage door company addresses, contact numbers, maps, directions and more.';
							}

							// META
							$data['title'] = $title_tag;
							$data['meta_title'] = $mtitle_tag;
							$data['meta_keyword'] = $mkeyword_tag ;
							$data['meta_description'] = $mdescription;
							
							$this->load->view('templates/header', $data);
							$this->load->view('pages/'.$page, $data);
							$this->load->view('templates/footer');

						} else {

							header('Location:'. base_url('industry/'.$data['industry_data']->slug));

						}

					} else {
						show_404();
					}
				} else {
					show_404();
				}
			}			

		}

	}