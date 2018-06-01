<?php

	class Business extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            
            $this->load->helper('general');
			$this->load->model('State_model');
			$this->load->model('City_model');
			$this->load->model('Business_model');
			$this->load->model('Industry_model');
			$this->load->library(array('session'));
			$this->load->model('Configuration_model');

        }

		public function post($request = 'process') {

			if($request == 'process') {

				if($this->input->post()) {

					$post_data = $this->input->post();
					$gr_data = gr_keys();
					$site_key = $gr_data['site_key'];
					$secret_key = $gr_data['secret_key'];
					$site_verify = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$post_data['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
					$res_content = file_get_contents($site_verify);
					$g_response = json_decode($res_content);

					if($g_response->success == 1) {

						if(!empty($_FILES['photo']['name'])) {
		                    $date = date('Y');
		                    $path = APPPATH.'../uploads/images/business/';
		                    if(!file_exists($path.$date)) {
		                        mkdir($path.$date, 0777, true);
		                    }

		                    $config['upload_path'] = 'uploads/images/business/'.$date.'/';
		                    $config['allowed_types'] = 'jpg|jpeg|png';
		                    $config['file_name'] = $_FILES['photo']['name'];
		                    
		                    //Load upload library and initialize configuration
		                    $this->load->library('upload',$config);
		                    $this->upload->initialize($config);
		                    
		                    if($this->upload->do_upload('photo')){
		                        $uploadData = $this->upload->data();
		                        $photo = $uploadData['file_name'];
		                    } else {
		                        $photo = NULL;
		                    }
		                } else {
		                    $photo = NULL;
		                }

						$slug = slugify($post_data['name']);
						$slug_check = $this->Business_model->validate_slug($slug);

						$data = array(
							'name' => $post_data['name'],
							'industry' => $post_data['industry'],
							'city' => $post_data['city'],
							'state' => $post_data['state'],
							'zip' => sprintf('%05u', $post_data['zip']),
							'email' => $post_data['email'],
							'contact' => $post_data['contact'],
							'photo' => $config['upload_path'].$photo,
							'slug' => ($slug_check == 0) ? $slug : $slug.'-'.strtotime('now'),
							'submitted_at' => datetime_now()
						);

						

						$dataset = $this->Business_model->submit_business($data);

						if($dataset == 1) {
							$response = json_encode(array('result' => 'success', 'message' => 'Your business is successfully submitted.'));
						} else {
							$response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
						}

					} else {
						$response = json_encode(array('result' => 'error', 'message' => 'Invalid Captcha!'));
					}

					echo $response;

				} else {
					show_404();
				}

			} else {
				show_404();
			}

		}

		public function delete() {

			if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $business = $this->Business_model->get_business_from_id($id);

                    $photo = $business[0]->photo;

                    if($photo != NULL) {
                    	if(file_exists($photo)) {
                    		unlink($photo);
                    	}
                    }

                    $delete = $this->Business_model->delete_business($id);

                    if($delete != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Deleted'));

                   } else {

                        $response = json_encode(array('result' => 'error', 'message' => 'Oops! Something went wrong.'));

                   }

                   echo $response;

                } else {

                    redirect(base_url());
                }

            } else {
                redirect(base_url());
            }

		}

		public function void() {

			if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

				if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];
      				$date = NULL;

                    $void = $this->Business_model->void_business($id, $date);

                    if($void != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Business was voided'));

                   } else {

                        $response = json_encode(array('result' => 'error', 'message' => 'Oops! Something went wrong.'));

                   }

                   echo $response;

                } else {

                    redirect(base_url());
                }

			} else {
				redirect(base_url());
			}

		}

		public function verify() {

			if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

				if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];
                    $date = datetime_now();

                    $void = $this->Business_model->verify_business($id, $date);

                    if($void != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Business was voided'));

                   } else {

                        $response = json_encode(array('result' => 'error', 'message' => 'Oops! Something went wrong.'));

                   }

                   echo $response;

                } else {

                    redirect(base_url());
                }

			} else {
				redirect(base_url());
			}

		}

	}