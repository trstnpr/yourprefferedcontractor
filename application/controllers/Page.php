<?php

	class Page extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            
            $this->load->helper('general');
			$this->load->model('State_model');
			$this->load->model('City_model');
			$this->load->model('Page_model');
			$this->load->model('Configuration_model');
			$this->load->model('Industry_model');
        }

		public function slug() {

			$slug = $this->uri->segment(1, 0);

			$x_segments = array('state', 'city', 'zip'); // escape unvailable slug/segment

			$res_page = $this->Page_model->get_page($slug);

			if($res_page) {

				$data['page'] = $res_page[0];

				$layout = $data['page']->layout;

				$data['title'] = $data['page']->title.' - '.the_config('site_name');

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
					$data['blogs'] = $blogs;
				} else {
					$data['blogs'] = 0;
				}

				$data['gr_data'] = gr_keys();

				// META
				$data['meta_title'] = $data['page']->title;
				$data['meta_keyword'] = $data['page']->meta_keyword;
				$data['meta_description'] = $data['page']->meta_description;
				
				$this->load->view('templates/header', $data);
				if($slug == 'contact-us') {
					$this->load->view('pages/contact-us', $data);
				} else if ($slug == 'join-business') {
					$this->load->view('pages/local_business_request', $data);
				} else {
					$this->load->view('pages/'.$layout, $data);
				}
				$this->load->view('templates/footer'); 

			} else if (in_array($slug, $x_segments)) {

				header('Location: '.base_url('states'));
				
			} else {
				show_404();
			}
			
		}
		
	}