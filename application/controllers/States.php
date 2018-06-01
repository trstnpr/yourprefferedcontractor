<?php

	class States extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            
            $this->load->helper('general');
			$this->load->model('State_model');
			$this->load->model('City_model');
			$this->load->model('Business_model');
			$this->load->model('Page_model');
			$this->load->library('pagination');
			$this->load->helper('url');
			$this->load->model('Industry_model');
			$this->load->model('Configuration_model');
			
        }

		public function page($page = 'states', $offset = 0) {

			$offset = $this->uri->segment(2, 0);

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			} else {
				//how many blogs will be shown in a page
		        $limit = 12;
		        $result = $this->State_model->get_state_offset($limit, $offset);

		        $data['states'] = $result['data'];
		        $data['count'] = $result['count'];
		        
		        $config = array();
		        $config['base_url'] = site_url('states');
		        $config['total_rows'] = $data['count'];
		        $config['per_page'] = $limit;

		        //which uri segment indicates pagination number
		        $config['uri_segment'] = 2;
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

				$data['title'] = ucwords($page).' - '.the_config('site_name');
				$data['meta_title'] = '';
				$data['meta_keyword'] = '';
				$data['meta_description'] = '';
				
				$this->load->view('templates/header', $data);
				$this->load->view('pages/'.$page, $data);
				$this->load->view('templates/footer');

			}

		}

		public function city($page = 'state', $offset = 0) {

			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			} else {

				$abbr = $this->uri->segment(2, 0);
				$offset = $this->uri->segment(3, 0);

				$data['state_arr'] = $this->State_model->get_state_from_abbrev($abbr);

				if($data['state_arr'] != 0) {

					$data_state = $data['state_arr'][0];
		 			$data['state'] = $data_state;

					//how many blogs will be shown in a page
			        $limit = 10;

			        $city = $this->City_model->get_city_from_abbrev($abbr);
		        	$data['count'] = count($city);

			        $result = $this->City_model->get_city_from_state($abbr, $limit, $offset);
			        $data['cities'] = $result['data'];

			        $config = array();
			        $config['base_url'] = base_url('state/'.$abbr);
			        $config['total_rows'] = $data['count'];
			        $config['per_page'] = $limit;

			        //which uri segment indicates pagination number
			        $config['uri_segment'] = 3;
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

    }