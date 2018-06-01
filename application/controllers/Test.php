<?php

    class Test extends CI_Controller
    {
        public function  __construct() {

            parent::__construct();
            $this->load->model('Test_model');

        }
        
        public function add() {

            if($this->input->post('userSubmit')){
                
                //Check whether user upload picture
                if(!empty($_FILES['picture']['name'])){
                    $date = date('Y');
                    $path = APPPATH.'../uploads/images/business/';

                    if(!file_exists($path.$date)) {
                        mkdir($path.$date, 0777, true);
                    }


                    $config['upload_path'] = 'uploads/images/business/'.$date.'/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['file_name'] = $_FILES['picture']['name'];
                    
                    //Load upload library and initialize configuration
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    
                    if($this->upload->do_upload('picture')){
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                    } else {
                        $picture = '';
                    }
                }else{
                    $picture = '';
                }
                
                //Prepare array of user data
                $userData = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'picture' => $config['upload_path'].$picture
                );
                
                //Pass user data to model
                $insertUserData = $this->Test_model->insert($userData);
                
                //Storing insertion status message.
                if($insertUserData){
                    $this->session->set_flashdata('success_msg', 'User data have been added successfully.');
                }else{
                    $this->session->set_flashdata('error_msg', 'Some problems occured, please try again.');
                }
            }
            //Form for adding user data
            $this->load->view('test/add');

        }

        public function folder() {
            $dir = APPPATH.'../uploads';

            if (file_exists($dir)) {
                echo "The file directory exists";
            } else {
                echo "The file directory does not exist";
            }

        }
    }