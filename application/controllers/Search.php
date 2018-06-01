<?php

	class Search extends CI_Controller {

		public function __construct()
        {
                parent::__construct();
                
                $this->load->helper('citygrid');
                $this->load->helper('general');
				$this->load->model('State_model');
				$this->load->model('City_model');
				$this->load->model('Page_model');
				$this->load->model('Industry_model');
				$this->load->model('Configuration_model');
        }

        public function index($page = 'search') {

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			} else {

				if($this->input->get('location') AND $this->input->get('industry')) {

					// Blog Data
					$blogs = $this->Page_model->get_published_post();
					if($blogs != 0) {
						$data['recent_blogs'] = $blogs;
					} else {
						$data['recent_blogs'] = 0;
					}

					$request = array(
						'location' => $this->input->get('location'),
						'industry' => $this->input->get('industry')
					);

					$data['location'] = $request['location'];
					

					$industry_data = $this->Industry_model->get_industry_from_id($request['industry']);

					if($industry_data) {

						$data['industry_data'] = $industry_data[0];

						// META
						$data['page_title'] = $data['industry_data']->label.' in '.$data['location'];
						$data['title'] = 'Results for '.$data['page_title'].' - '.the_config('site_name');
						$data['meta_title'] = $data['title'];
						$data['meta_keyword'] = '';
						$data['meta_description'] = '';


						$slug = $data['industry_data']->slug.'/'.slugify($request['location']);

						$search_slug = $this->City_model->get_city_from_slug_industry($slug, $data['industry_data']->id);

						if($search_slug != 0) {

							$search_data = $search_slug[0];
							$data['search_data'] = $search_slug[0];
							$data['redirect'] = base_url('city/'.$data['search_data']->slug);
							echo'<script>window.location.href = "'.$data['redirect'].'";</script>';

						} else if(is_numeric($request['location']) AND strlen($request['location']) == 5) {

							$search_zip = $this->City_model->search_zip($request['location']);
							if($search_zip != 0) {

								$data['search_data'] = $search_zip;
								$data['redirect'] = base_url('zip/'.$data['industry_data']->slug.'/'.$request['location']);
								echo'<script>window.location.href = "'.$data['redirect'].'";</script>';

							} else {

								$data['search_data'] = NULL;

								$this->load->view('templates/header', $data);
								$this->load->view('pages/'.$page, $data);
								$this->load->view('templates/footer');

							}

						} else {

							$search_free = $this->City_model->search_city($request['location'], $data['industry_data']->id);

							if($search_free != 0) {
								
								$data['search_data'] = $search_free;

							} else {
								
								$data['search_data'] = NULL;

							}

							$this->load->view('templates/header', $data);
							$this->load->view('pages/'.$page, $data);
							$this->load->view('templates/footer');
						}


					} else {

						// Industry not existing
						header('Location:'.base_url());

					}

				} else {

					show_404();

				}
			}

		}

		public function suggest() {

			$city_data = $this->City_model->get_cities();

			$result = array();

			foreach($city_data as $city) {

				$result[] = $city->name.', '.strtoupper($city->state);
				
				$zips = preg_split('/,([\s])+/', $city->zip_code);
				foreach ($zips as $zip) {
					// $result[] = $city->name.', '.strtoupper($city->state).' '.format_zip($zip);
					// $result[] = format_zip($zip).', '.strtoupper($city->state);
					$result[] = format_zip($zip);
				}

			}

			$array = array_unique($result);
			$json_data = json_encode(array_values($array));

			print_r($json_data);

		}

		// public function suggest() {

		// 	$city_data = $this->City_model->get_cities();

		// 	$result = array();

		// 	foreach($city_data as $city) {

		// 		$result[] = $city->name.', '.strtoupper($city->state);
				
		// 		$zips = preg_split('/,([\s])+/', $city->zip_code);
		// 		foreach ($zips as $zip) {
		// 			$result[] = $zip;
		// 		}

		// 	}

		// 	$json_data = json_encode($result);

		// 	print_r($json_data);

		// }

		public function validate() {

			$request = $this->input->get('location');

			if(isset($request) AND !empty($request)) {

				$key_data = explode(', ', $request);

				$vald_city = (isset($key_data[0])) ? $key_data[0] : NULL ;
				$vald_state = (isset($key_data[1])) ? $key_data[1] : NULL ;

				if($vald_city != NULL AND $vald_state != NULL) {
					$res_city = $this->City_model->search_city_from_name_state($vald_city, $vald_state);
					if($res_city != 0) {
						$response = json_encode(array('result' => 'success', 'message' => 'Data Exist'));
					} else {
						$response = json_encode(array('result' => 'error', 'message' => 'No results for "'.$request.'"'));
					}
				} else {
					$response = json_encode(array('result' => 'error', 'message' => 'No results for "'.$request.'"'));
				}


				echo $response;

			} else {
				show_404();
			}
		}

	}