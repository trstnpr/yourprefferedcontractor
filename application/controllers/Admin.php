<?php

	class Admin extends CI_Controller {

		public function __construct() {
            parent::__construct();
            
            $this->load->helper('general');
			$this->load->model('State_model');
			$this->load->model('City_model');
            $this->load->model('Page_model');
            $this->load->model('Business_model');
            $this->load->model('User_model');
            $this->load->model('Category_model');
            $this->load->model('Configuration_model');
            $this->load->model('Industry_model');
            $this->load->library(array('session'));
            $this->load->helper(array('url'));
            $this->load->library('upload');

        }

        public function index() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                header('Location:'.base_url('admin/dashboard'));

            } else {

                header('Location:'.base_url('admin/login'));

            }

        }

        public function login($page = 'login') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                redirect(base_url('admin/dashboard'));

            } else {

                if(!$this->uri->segment(3)) {

                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Admin | '.the_config('site_name');
                        $this->load->view('admin/'.$page, $data);
                    }

                } else {
                    $process = $this->uri->segment(3);
                    
                    if($process == 'process') {

                        $request = $this->input->post();
                        $username = $request['username'];
                        $password = md5($request['password']);

                        if($this->User_model->resolve_user_login($username, $password)) {

                            $user_id = $this->User_model->get_user_id_from_username($username);
                            $user    = $this->User_model->get_user($user_id);

                            $_SESSION['user_id'] = (int)$user->id;
                            $_SESSION['username'] = (string)$user->username;
                            $_SESSION['email'] = (string)$user->email;
                            $_SESSION['password'] = (string)$user->password;
                            $_SESSION['is_admin'] = (bool)true;
                            $_SESSION['logged_in'] = (bool)true;

                            $response = json_encode(array('result' => 'success', 'message' => 'Successfully Logged In', 'redirect' => base_url('admin/dashboard')));

                            echo $response;

                        } else {
                            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Something wrong with credentials'));
                            echo $response;
                        }


                    } else {
                        show_404();
                    }
                }

            }
        }

        public function dashboard($page = 'dashboard') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                    show_404();
                } else {

                    $data['title'] = 'Dashboard - Admin | '.the_config('site_name');
                    
                    $this->load->view('admin/templates/header', $data);
                    $this->load->view('admin/'.$page, $data);
                    $this->load->view('admin/templates/footer', $data);
                }

            } else {
                redirect(base_url());
            }

        }

        public function pages($string = '') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if(empty($string)) {

                    $page = 'pages';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Pages - Admin | '.the_config('site_name');

                        $pages = $this->Page_model->get_active_pages();

                        if($pages != 0) {
                            $data['pages'] = $pages;
                        } else {
                            $data['pages'] = 0;
                        }
                        
                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }

                } else {

                    if($string == 'trash') {

                        $page = 'trash_pages';
                        if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                            show_404();
                        } else {

                            $data['title'] = 'Trash Pages - Admin | '.the_config('site_name');

                            $pages = $this->Page_model->get_trash_pages();

                            // dump($pages);
                            // exit;

                            if($pages != 0) {
                                $data['pages'] = $pages;
                            } else {
                                $data['pages'] = 0;
                            }
                            
                            $this->load->view('admin/templates/header', $data);
                            $this->load->view('admin/'.$page, $data);
                            $this->load->view('admin/templates/footer', $data);
                        }

                    } else {

                        redirect(base_url('admin/pages'));

                    }

                }

            } else {
                redirect(base_url());
            }
        }

        public function page($string) {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($string == 'new') { // READ HERE publish(1) & draft(2) list
                    $page = 'add_page';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Add New Page - Admin | '.the_config('site_name');
                        
                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }
                } else if($string == 'add') { // POST HERE

                    if($this->input->post()) {

                        $req = $this->input->post();

                        if(!empty($_FILES['featured_image']['name'])) {
                            $date = date('Y');
                            $path = APPPATH.'../uploads/images/page/';
                            if(!file_exists($path.$date)) {
                                mkdir($path.$date, 0777, true);
                            }

                            $config['upload_path'] = 'uploads/images/page/'.$date.'/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name'] = $_FILES['featured_image']['name'];
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            
                            if($this->upload->do_upload('featured_image')){
                                $uploadData = $this->upload->data();
                                $featured_image = $uploadData['file_name'];
                                $photo_dir = $config['upload_path'].$featured_image;
                            } else {
                                // $featured_image = NULL;
                                $photo_dir = NULL;
                            }
                        } else {
                            // $featured_image = NULL;
                            $photo_dir = NULL;
                        }

                        $data = array(
                                'title' => $req['title'],
                                'slug' => slugify($req['slug']),
                                'content' => $req['content'],
                                'excerpt' => $req['excerpt'],
                                'layout' => $req['layout'],
                                'meta_keyword' => $req['meta_keyword'],
                                'meta_description' => $req['meta_description'],
                                // 'featured_image' => $config['upload_path'].$featured_image,
                                'featured_image' => $photo_dir,
                                'author' => $_SESSION['username'],
                                'status' => $req['status'],
                                'created_at' => datetime_now()
                            );

                        $put_data = $this->Page_model->add_page($data);

                        if($put_data == 1) {
                            $response = json_encode(array('result' => 'success', 'message' => 'Successfully Posted', 'redirect' => base_url('admin/pages')));
                        } else {
                            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                        }

                        echo $response;
                    } else {
                        redirect(base_url('admin/pages'));
                    }

                } else {
                    redirect(base_url('admin/pages'));
                }

            } else {
                redirect(base_url());
            }

        }

        public function page_update($page = 'update_page') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                $slug_uri = $this->uri->segment(4, 0);

                $res = $this->Page_model->get_page_from_slug($slug_uri);

                if($res != 0) {
                    $data['page'] = $res[0];
                } else {
                    redirect(base_url('admin/pages'));
                }

                $data['title'] = 'Update Page - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);

            } else {

                redirect(base_url());

            }

        }

        public function page_update_process() {
            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();
                    $current_img = ($this->input->post('current_img')) ? $this->input->post('current_img') : NULL;
                    $current_status = ($this->input->post('current_status')) ? $this->input->post('current_status') : NULL;

                    if(!empty($_FILES['featured_image']['name'])) {
                        $date = date('Y');
                        $path = APPPATH.'../uploads/images/page/';
                        if(!file_exists($path.$date)) {
                            mkdir($path.$date, 0777, true);
                        }

                        $config['upload_path'] = 'uploads/images/page/'.$date.'/';
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['file_name'] = $_FILES['featured_image']['name'];
                        
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        
                        if($this->upload->do_upload('featured_image')){

                            if($current_img != NULL) {
                                if(file_exists($current_img)) {
                                    unlink($current_img);
                                }
                            }

                            $uploadData = $this->upload->data();
                            $featured_image = $uploadData['file_name'];
                            $photo_dir = $config['upload_path'].$featured_image;
                        } else {
                            $photo_dir = NULL;
                        }
                    } else {
                        if($current_img != NULL) {
                            $photo_dir = $current_img;
                        } else {
                            if(file_exists($current_status)) {
                                unlink($current_status);
                            }
                            $photo_dir = NULL;
                        }
                    }

                    $id = $req['id'];
                    $data = array(
                            'title' => $req['title'],
                            'slug' => slugify($req['slug']),
                            'content' => $req['content'],
                            'excerpt' => $req['excerpt'],
                            'layout' => $req['layout'],
                            'meta_keyword' => $req['meta_keyword'],
                            'meta_description' => $req['meta_description'],
                            'featured_image' => $photo_dir,
                            'author' => $_SESSION['username'],
                            'status' => $req['status'],
                            'updated_at' => datetime_now()
                        );

                    $res = $this->Page_model->update_page($id, $data);

                   if($res != 0) {
                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated', 'data' => $data['slug']));
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

        public function posts($string = '') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if(empty($string)) {

                    $page = 'posts';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Posts - Admin | '.the_config('site_name');

                        $posts = $this->Page_model->get_active_posts();

                        if($posts != 0) {
                            $data['posts'] = $posts;
                        } else {
                            $data['posts'] = 0;
                        }
                        
                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }

                } else {

                    if($string == 'trash') {

                        $page = 'trash_posts';
                        if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                            show_404();
                        } else {

                            $data['title'] = 'Trash Posts - Admin | '.the_config('site_name');

                            $pages = $this->Page_model->get_trash_posts();

                            // dump($pages);
                            // exit;

                            if($pages != 0) {
                                $data['pages'] = $pages;
                            } else {
                                $data['pages'] = 0;
                            }
                            
                            $this->load->view('admin/templates/header', $data);
                            $this->load->view('admin/'.$page, $data);
                            $this->load->view('admin/templates/footer', $data);
                        }

                    } else {

                        redirect(base_url('admin/pages'));

                    }

                }

            } else {
                redirect(base_url());
            }
        }

        public function post($string) {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($string == 'new') {
                    $page = 'add_post';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Add New Post - Admin | '.the_config('site_name');

                        $data['category'] = $this->Category_model->get_categories();

                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }

                } else if($string == 'add') { // POST HERE

                    if($this->input->post()) {

                        $req = $this->input->post();
                        if(!empty($_FILES['featured_image']['name'])) {
                            $date = date('Y');
                            $path = APPPATH.'../uploads/images/page/';
                            if(!file_exists($path.$date)) {
                                mkdir($path.$date, 0777, true);
                            }

                            $config['upload_path'] = 'uploads/images/page/'.$date.'/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name'] = $_FILES['featured_image']['name'];
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            
                            if($this->upload->do_upload('featured_image')){
                                $uploadData = $this->upload->data();
                                $featured_image = $uploadData['file_name'];
                                $photo_dir = $config['upload_path'].$featured_image;
                            } else {
                                // $featured_image = NULL;
                                $photo_dir = NULL;
                            }
                        } else {
                            $photo_dir = NULL;
                        }

                        $category = ($this->input->post('category')) ? $this->input->post('category') : array('Uncategorized');

                        $data = array(
                                'title' => $req['title'],
                                'slug' => slugify($req['slug']),
                                'content' => $req['content'],
                                'excerpt' => $req['excerpt'],
                                'layout' => $req['layout'],
                                'meta_keyword' => $req['meta_keyword'],
                                'meta_description' => $req['meta_description'],
                                'category' => serialize($category),
                                'tag' => $req['tag'],
                                // 'featured_image' => $config['upload_path'].$featured_image,
                                'featured_image' => $photo_dir,
                                'author' => $_SESSION['username'],
                                'status' => $req['status'],
                                'created_at' => datetime_now()
                            );

                        $put_data = $this->Page_model->add_post($data);

                        if($put_data == 1) {
                            $response = json_encode(array('result' => 'success', 'message' => 'Successfully Posted', 'redirect' => base_url('admin/posts')));
                        } else {
                            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                        }

                        echo $response;

                    } else {
                        redirect(base_url('admin/posts'));
                    }

                } else {
                    redirect(base_url('admin/posts'));
                }

            } else {
                redirect(base_url());
            }

        }

        public function post_update($page = 'update_post') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                $slug_uri = $this->uri->segment(4, 0);

                $data['category'] = $this->Category_model->get_categories();

                $res = $this->Page_model->get_page_from_slug($slug_uri);

                if($res != 0) {
                    $data['post'] = $res[0];
                } else {
                    redirect(base_url('admin/pages'));
                }

                $data['title'] = 'Update Post - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);

            } else {

                redirect(base_url());

            }

        }

        public function post_update_process() {
            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();
                    $current_img = ($this->input->post('current_img')) ? $this->input->post('current_img') : NULL;
                    $current_status = ($this->input->post('current_status')) ? $this->input->post('current_status') : NULL;
                    $category = ($this->input->post('category')) ? $this->input->post('category') : array('Uncategorized');

                    if(!empty($_FILES['featured_image']['name'])) {
                        $date = date('Y');
                        $path = APPPATH.'../uploads/images/page/';
                        if(!file_exists($path.$date)) {
                            mkdir($path.$date, 0777, true);
                        }

                        $config['upload_path'] = 'uploads/images/page/'.$date.'/';
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['file_name'] = $_FILES['featured_image']['name'];
                        
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        
                        if($this->upload->do_upload('featured_image')){

                            if($current_img != NULL) {
                                if(file_exists($current_img)) {
                                    unlink($current_img);
                                }
                            }

                            $uploadData = $this->upload->data();
                            $featured_image = $uploadData['file_name'];
                            $photo_dir = $config['upload_path'].$featured_image;
                        } else {
                            $photo_dir = NULL;
                        }
                    } else {
                        if($current_img != NULL) {
                            $photo_dir = $current_img;
                        } else {
                            if(file_exists($current_status)) {
                                unlink($current_status);
                            }
                            $photo_dir = NULL;
                        }
                    }

                    $id = $req['id'];
                    $data = array(
                            'title' => $req['title'],
                            'slug' => slugify($req['slug']),
                            'content' => $req['content'],
                            'excerpt' => $req['excerpt'],
                            'layout' => $req['layout'],
                            'meta_keyword' => $req['meta_keyword'],
                            'meta_description' => $req['meta_description'],
                            'category' => serialize($category),
                            'tag' => $req['tag'],
                            'featured_image' => $photo_dir,
                            'author' => $_SESSION['username'],
                            'status' => $req['status'],
                            'updated_at' => datetime_now()
                        );

                    $res = $this->Page_model->update_page($id, $data);

                   if($res != 0) {
                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated', 'data' => $data['slug']));
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

        public function trash_page_post() {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $trash = $this->Page_model->trash_page_post($id);

                    if($trash != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Transferred to trash'));

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

        public function recover_page_post() {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $trash = $this->Page_model->recover_page_post($id);

                    if($trash != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Recovered'));

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

        public function delete_page_post() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $entry = $this->Page_model->get_page_from_id($id);

                    $photo = $entry[0]->featured_image;

                    if($photo != NULL) {
                        if(file_exists($photo)) {
                            unlink($photo);
                        }
                    }

                    $trash = $this->Page_model->delete_page_post($id);

                    if($trash != 0) {

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

        public function empty_page_post_trash() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $type = $req['type'];

                    $empty = $this->Page_model->empty_page_post_trash($type);

                    if($empty != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Trash is now Empty'));

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

        public function states($page = 'states') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                    show_404();
                } else {

                    $data['title'] = 'States - Admin | '.the_config('site_name');

                    $states = $this->State_model->get_states();
                    if($states != 0) {
                        $data['states'] = $states;
                    } else {
                        $data['states'] = 0;
                    }

                    $this->load->view('admin/templates/header', $data);
                    $this->load->view('admin/'.$page, $data);
                    $this->load->view('admin/templates/footer', $data);
                }
            } else {
                redirect(base_url());
            }
        }

        public function state($string) {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($string == 'new') { // READ HERE publish(1) & draft(2) list
                    $page = 'add_state';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Add New State - Admin | '.the_config('site_name');
                        
                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }
                } else if($string == 'add') { // POST HERE

                    if($this->input->post()) {

                        $req = $this->input->post();

                        $data = array(
                                'state' => $req['state'],
                                'abbrev' => $req['abbrev'],
                                'slug' => slugify($req['slug']),
                                'description' => $req['description'],
                                'meta_keyword' => $req['meta_keyword'],
                                'meta_description' => $req['meta_description'],
                                'author' => $_SESSION['username'],
                                'created_at' => datetime_now()
                            );

                        $put_data = $this->State_model->add_state($data);

                        if($put_data == 1) {
                            $response = json_encode(array('result' => 'success', 'message' => 'Successfully Posted', 'redirect' => base_url('admin/states')));
                        } else {
                            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                        }

                        echo $response;

                    } else {
                        redirect(base_url('admin/pages'));
                    }

                } else {
                    redirect(base_url('admin/pages'));
                }

            } else {
                redirect(base_url());
            }

        }

        public function state_update($page = 'update_state') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                $slug_uri = $this->uri->segment(4, 0);

                $res = $this->State_model->get_state_from_slug($slug_uri);

                if($res != 0) {
                    $data['state'] = $res[0];
                } else {
                    redirect(base_url('admin/pages'));
                }

                $data['title'] = 'Update State - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);

            } else {

                redirect(base_url());

            }

        }

        public function state_update_process() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();

                    $id = $req['id'];
                    $data = array(
                            'state' => $req['state'],
                            'abbrev' => $req['abbrev'],
                            'slug' => slugify($req['slug']),
                            'description' => $req['description'],
                            'meta_keyword' => $req['meta_keyword'],
                            'meta_description' => $req['meta_description'],
                            'author' => $_SESSION['username'],
                            'updated_at' => datetime_now()
                        );

                    $res = $this->State_model->update_state($id, $data);

                    if($res != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated', 'data' => $data['slug'], 'redirect' => base_url('admin/states')));

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

        public function delete_state() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $delete = $this->State_model->delete_state($id);

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

        public function delete_all_state() {
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $delete = $this->State_model->delete_all_state();

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

        public function state_import($page = 'import_state') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                $data['title'] = 'Import States - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function state_import_process() {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if(!empty($_FILES['states']['tmp_name'])) {

                    $fh = fopen($_FILES['states']['tmp_name'], 'r+');
                    $success_ctr = 0;
                    $duplicate_ctr = 0;
                    $failed_ctr = 0;
                    $result = array();
                    $x = 1;
                    while(($row = fgetcsv($fh, 8192)) !== FALSE ) {
                        $cdata = array(
                            'state' => $row[1],
                            'abbrev' => strtoupper($row[2]),
                            'description' => $row[3],
                            'slug' => slugify($row[2]),
                            'meta_keyword' => $row[4],
                            'meta_description' => $row[5],
                            'author' => $_SESSION['username'],
                            'created_at' => datetime_now()
                        );

                        if(!$this->State_model->get_state_from_slug($cdata['abbrev'])) {

                            if($this->State_model->add_state($cdata)) {

                                $result[] = "<strong>(Log: $x) </strong><span class='text-success'>Success Importing: </span>{$cdata['state']}. Slug set to `{$cdata['slug']}`.<br><hr style='margin: 2px'>";

                                $success_ctr++;

                            } else {

                                $result[] = "<strong>(Log: $x) </strong><span class='text-danger'>Failed Importing: </span>{$cdata['state']}<br><hr style='margin: 2px'>";

                                $failed_ctr++;
                            }

                        } else {

                            $result[] = "<strong>(Log: $x) </strong><span class='text-warning'>Duplicate Data: </span>{$cdata['state']}<br><hr style='margin: 4px'>";

                            $duplicate_ctr++;
                        }

                        $x++;
                    }

                    fclose($fh);
                    $result[] = "<strong>Report</strong><br/>";
                    $result[] = "<strong> ".$success_ctr."</strong> successfull imported records.<br>";
                    $result[] = "<strong> ".$duplicate_ctr."</strong> duplicated records.<br>";
                    $result[] = "<strong> ".$failed_ctr."</strong> failed importing records.<br>";

                    $log = implode('', $result);
                    $response = json_encode(array('result' => 'success', 'message' => 'Successfully Imported', 'log' => $log));

                    echo $response;
                    
                } else {

                    $response = json_encode(array('result' => 'error', 'message' => 'Something went wrong'));

                    echo $response;

                }
                
            } else {
                
                redirect(base_url());
                
            }
        }

        public function cities($page = 'cities') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                    show_404();
                } else {

                    $cities = $this->City_model->get_cities();
                    if($cities != 0) {
                        $data['cities'] = $cities;
                    } else {
                        $data['cities'] = 0;
                    }

                    $data['title'] = 'Cities - Admin | '.the_config('site_name');
                    
                    $this->load->view('admin/templates/header', $data);
                    $this->load->view('admin/'.$page, $data);
                    $this->load->view('admin/templates/footer', $data);
                }

            } else {

                redirect(base_url());
            }

        }

        public function city($string) {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($string == 'new') { // READ HERE publish(1) & draft(2) list
                    $page = 'add_city';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Add New City - Admin | '.the_config('site_name');
                        $data['states'] = $this->State_model->get_states();
                        $data['industry'] = $this->Industry_model->get_industry();
                        
                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }
                } else if($string == 'add') { // POST HERE

                    if($this->input->post()) {

                        $req = $this->input->post();
                        $zip_code = clean_zip_list($req['zip_code']);
                        
                        $data = array(
                            'name' => $req['name'],
                            'state' => $req['state'],
                            'description' => $req['description'],
                            'industry' => $req['industry'],
                            'area_code' => $req['area_code'],
                            'phone' => $req['phone'],
                            'zip_code' => $zip_code,
                            'meta_keyword' => $req['meta_keyword'],
                            'meta_description' => $req['meta_description'],
                            'lat' => ($this->input->post('lat')) ? $req['lat'] : NULL,
                            'lng' => ($this->input->post('lng')) ? $req['lng'] : NULL,
                            'slug' => $req['slug'],
                            'is_popular' => ($this->input->post('is_popular')) ? $req['is_popular'] : 0,
                            'created_at' => datetime_now()
                        );

                        $put_data = $this->City_model->add_city($data);

                        if($put_data == 1) {
                            $response = json_encode(array('result' => 'success', 'message' => 'Successfully Posted', 'redirect' => base_url('admin/cities')));
                        } else {
                            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                        }

                        echo $response;

                    } else {
                        redirect(base_url('admin/cities'));
                    }

                } else {
                    redirect(base_url('admin/cities'));
                }

            } else {
                redirect(base_url());
            }

        }

        public function city_import($page = 'import_city') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                $data['title'] = 'Import City - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function city_import_process() {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if(!empty($_FILES['city']['tmp_name'])) {

                    $fh = fopen($_FILES['city']['tmp_name'], 'r+');
                    $success_ctr = 0;
                    $duplicate_ctr = 0;
                    $failed_ctr = 0;
                    $result = array();
                    $x = 1;
                    while(($row = fgetcsv($fh, 8192)) !== FALSE ) {

                        $slug = industry_slug($row[4]).'/'.slugify($row[1].'-'.$row[2]);
                        $zip_code = clean_zip_list($row[7]);

                        $cdata = array(
                            'name' => $row[1],
                            'state' => strtoupper($row[2]),
                            'description' => $row[3],
                            'industry' => $row[4],
                            'phone' => $row[5],
                            'area_code' => $row[6],
                            'zip_code' => $zip_code,
                            'lat' => $row[8],
                            'lng' => $row[9],
                            'slug' => $slug,
                            'is_popular' => $row[10],
                            'created_at' => datetime_now()
                        );

                        if(!$this->City_model->get_city_from_slug($cdata['slug'])) {

                            if($this->City_model->add_city($cdata)) {

                                $result[] = "<strong>(Log: $x) </strong><span class='text-success'>Success Importing: </span>{$cdata['name']}, {$cdata['state']}. Slug set to `{$cdata['slug']}`.<br><hr style='margin: 2px'>";

                                $success_ctr++;

                            } else {

                                $result[] = "<strong>(Log: $x) </strong><span class='text-danger'>Failed Importing: </span>{$cdata['name']}, {$cdata['state']}<br><hr style='margin: 2px'>";

                                $failed_ctr++;
                            }

                        } else {

                            $result[] = "<strong>(Log: $x) </strong><span class='text-warning'>Duplicate Data: </span>{$cdata['name']}, {$cdata['state']}. Slug `{$cdata['slug']}`.<br><hr style='margin: 4px'>";

                            $duplicate_ctr++;
                        }

                        $x++;
                    }

                    fclose($fh);
                    $result[] = "<strong>Report</strong><br/>";
                    $result[] = "<strong> ".$success_ctr."</strong> successfull imported records.<br>";
                    $result[] = "<strong> ".$duplicate_ctr."</strong> duplicated records.<br>";
                    $result[] = "<strong> ".$failed_ctr."</strong> failed importing records.<br>";

                    $log = implode('', $result);
                    $response = json_encode(array('result' => 'success', 'message' => 'Successfully Imported', 'log' => $log));

                    echo $response;
                    
                } else {

                    $response = json_encode(array('result' => 'error', 'message' => 'Something went wrong'));

                    echo $response;

                }
                
            } else {
                
                redirect(base_url());
                
            }
        }

        public function city_update($page = 'update_city') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                    show_404();
                } else {

                    $data['title'] = 'Update City - Admin | '.the_config('site_name');

                    $data['industry'] = $this->Industry_model->get_industry();

                    $slug_industry = $this->uri->segment(4, 0);
                    $slug_city = $this->uri->segment(5, 0);
                    $slug = $slug_industry.'/'.$slug_city;

                    $data['states'] = $this->State_model->get_states();
                    $res = $this->City_model->get_city_from_slug($slug);

                    if($res != 0) {
                        $data['city'] = $res[0];
                    } else {
                        redirect(base_url('admin/cities'));
                    }
                    
                    $this->load->view('admin/templates/header', $data);
                    $this->load->view('admin/'.$page, $data);
                    $this->load->view('admin/templates/footer', $data);
                }

            } else {

                redirect(base_url());

            }

        }

        public function city_update_process() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();
                    $zip_code = clean_zip_list($req['zip_code']);

                    $id = $req['id'];
                    $data = array(
                            'name' => $req['name'],
                            'state' => $req['state'],
                            'description' => $req['description'],
                            'industry' => $req['industry'],
                            'area_code' => $req['area_code'],
                            'phone' => $req['phone'],
                            'zip_code' => $zip_code,
                            'meta_keyword' => $req['meta_keyword'],
                            'meta_description' => $req['meta_description'],
                            'lat' => ($this->input->post('lat')) ? $req['lat'] : NULL,
                            'lng' => ($this->input->post('lng')) ? $req['lng'] : NULL,
                            'slug' => $req['slug'],
                            'is_popular' => ($this->input->post('is_popular')) ? $req['is_popular'] : 0,
                            'updated_at' => datetime_now()
                        );

                    $res = $this->City_model->update_city($id, $data);

                    if($res != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated', 'data' => $data['slug'], 'redirect' => base_url('admin/cities')));

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

        public function delete_city() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $delete = $this->City_model->delete_city($id);

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

        public function delete_all_city() {
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $delete = $this->City_model->delete_all_city();

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

        public function logout() {
            
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                
                redirect(base_url('admin'));
                
            } else {
                
                redirect(base_url());
                
            }
            
        }

        public function validateslug() {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->get()) {

                    if($this->input->get('type') == 'page' OR $this->input->get('type') == 'post') {

                        $req = array(
                            'slug' => $this->input->get('slug'),
                            'layout' => $this->input->get('type')
                            );

                        $result = $this->Page_model->validate_slug($req['slug']);

                        if($result == 0) {
                            $slug = slugify($req['slug']);
                            $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                        } else {
                            $slug = slugify($req['slug'].'-'.strtotime('now'));
                            $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                        }

                        echo $response;

                    } else if($this->input->get('type') == 'category') {

                        $req = array(
                            'slug' => $this->input->get('slug')
                            );

                        $result = $this->Category_model->cat_validate_slug($req['slug']);

                        if($result == 0) {
                            $slug = slugify($req['slug']);
                            $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                        } else {
                            $slug = slugify($req['slug'].'-'.strtotime('now'));
                            $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                        }

                        echo $response;

                    } else if($this->input->get('type') == 'state') {

                        $req = array(
                            'slug' => $this->input->get('slug')
                            );

                        $result = $this->State_model->state_validate_slug($req['slug']);

                        if($result == 0) {
                            $slug = slugify($req['slug']);
                            $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                        } else {
                            $slug = slugify($req['slug'].'-'.strtotime('now'));
                            $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                        }

                        echo $response;

                    } else if($this->input->get('type') == 'city') {

                        $req = array(
                            'slug' => $this->input->get('slug')
                            );

                        // dump($req);
                        // exit;

                        $result = $this->City_model->get_city_from_slug($req['slug']);

                        if($result == 0) {
                            $slug = $req['slug'];
                            $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $req['slug']));
                        } else {
                            $slug = $req['slug'].'-'.strtotime('now');
                            $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                        }

                        echo $response;

                    } else {
                        redirect(base_url('admin/dashboard'));
                    }

                } else {
                    redirect(base_url('admin/dashboard'));
                }
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function validatenewslug() {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->get()) {

                    if($this->input->get('type') == 'page' OR $this->input->get('type') == 'post') {

                        $req = array(
                            'slug' => $this->input->get('slug'),
                            'permalink' => $this->input->get('permalink'),
                            'layout' => $this->input->get('type')
                        );

                        if($req['slug'] != $req['permalink']) {

                            $result = $this->Page_model->validate_slug($req['slug']);

                            if($result == 0) {
                                $slug = slugify($req['slug']);
                                $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                            } else {
                                $slug = slugify($req['slug'].'-'.strtotime('now'));
                                $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                            }

                        } else {
                            $response = json_encode(array('result' => 'success', 'message' => 'No Change', 'data' => $req['permalink']));
                        }

                        echo $response;

                    } else if($this->input->get('type') == 'category') {

                        $req = array(
                            'slug' => $this->input->get('slug'),
                            'permalink' => $this->input->get('permalink')
                            );

                        if($req['slug'] != $req['permalink']) {

                            $result = $this->Category_model->cat_validate_slug($req['slug']);

                            if($result == 0) {
                                $slug = slugify($req['slug']);
                                $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                            } else {
                                $slug = slugify($req['slug'].'-'.strtotime('now'));
                                $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                            }

                        } else {
                            $response = json_encode(array('result' => 'success', 'message' => 'No Change', 'data' => $req['permalink']));
                        }

                        echo $response;

                    } else if($this->input->get('type') == 'state') {

                        $req = array(
                            'slug' => $this->input->get('slug'),
                            'permalink' => $this->input->get('permalink')
                            );

                        if($req['slug'] != $req['permalink']) {

                            $result = $this->State_model->state_validate_slug($req['slug']);

                            if($result == 0) {
                                $slug = slugify($req['slug']);
                                $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                            } else {
                                $slug = slugify($req['slug'].'-'.strtotime('now'));
                                $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                            }

                        } else {
                            $response = json_encode(array('result' => 'success', 'message' => 'No Change', 'data' => $req['permalink']));
                        }

                        echo $response;

                    } else if($this->input->get('type') == 'city') {

                        $req = array(
                            'slug' => $this->input->get('slug'),
                            'permalink' => $this->input->get('permalink')
                            );

                        if($req['slug'] != $req['permalink']) {

                            $result = $this->City_model->city_validate_slug($req['slug']);

                            if($result == 0) {
                                // $slug = slugify($req['slug']);
                                $slug = $req['slug'];
                                $response = json_encode(array('result' => 'success', 'message' => 'Slug Available', 'data' => $slug));
                            } else {
                                // $slug = slugify($req['slug'].'-'.strtotime('now'));
                                $slug = $req['slug'].'-'.strtotime('now');
                                $response = json_encode(array('result' => 'success', 'message' => 'New Slug', 'data' => $slug));
                            }

                        } else {
                            $response = json_encode(array('result' => 'success', 'message' => 'No Change', 'data' => $req['permalink']));
                        }

                        echo $response;

                    } else {
                        redirect(base_url('admin/dashboard'));
                    }

                } else {
                    redirect(base_url('admin/dashboard'));
                }
                
            } else {
                
                redirect(base_url());
                
            }
        }

        public function category($string = '') {
            
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($string != NULL) {

                    if($string == 'add') {

                        if($this->input->post()) {

                            $req = $this->input->post();

                            $data = array(
                                'name' => $req['name'],
                                'slug' => slugify($req['slug']),
                                'description' => $req['description']
                                );

                            $put_data = $this->Category_model->add_category($data);

                            if($put_data == 1) {
                                $response = json_encode(array('result' => 'success', 'message' => 'Successfully Posted', 'redirect' => base_url('admin/category')));
                            } else {
                                $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                            }

                            echo $response;

                        } else {

                            redirect(base_url('admin/dashboard'));

                        }

                    }

                } else {

                    $page = 'category';
                    if(!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
                        show_404();
                    } else {

                        $data['title'] = 'Category - Admin | '.the_config('site_name');

                        $data['categories'] = $this->Category_model->get_categories();
                        
                        $this->load->view('admin/templates/header', $data);
                        $this->load->view('admin/'.$page, $data);
                        $this->load->view('admin/templates/footer', $data);
                    }
                }

            } else {

                redirect(base_url());
            }

        }

        public function delete_category() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {
                    
                    $req = $this->input->post();

                    $id = $req['id'];

                    $trash = $this->Category_model->delete_category($id);

                    if($trash != 0) {

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

        public function category_update($page = 'update_category') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                $slug_uri = $this->uri->segment(4, 0);

                $data['categories'] = $this->Category_model->get_categories();

                $res = $this->Category_model->get_category_from_slug($slug_uri);

                if($res != 0) {
                    $data['cat'] = $res[0];
                } else {
                    redirect(base_url('admin/dashboard'));
                }

                $data['title'] = 'Update Category - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);

            } else {

                redirect(base_url());

            }

        }

        public function category_update_process() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();

                    $id = $req['id'];
                    $data = array(
                            'name' => $req['name'],
                            'slug' => slugify($req['slug']),
                            'description' => $req['description'],
                            'updated_at' => datetime_now()
                        );

                    $res = $this->Category_model->update_category($id, $data);

                    if($res != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated', 'data' => $data['slug'], 'redirect' => base_url('admin/category')));

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

        public function business($page = 'business') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                $data['title'] = 'Business - Admin | '.the_config('site_name');

                $business = $this->Business_model->get_business();

                if($business != 0) {
                    $data['business'] = $business;
                } else {
                    $data['business'] = 0;
                }

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);

            } else {
                redirect(base_url());
            }

        }

        public function configuration($page = 'configuration') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {
                
                $data['title'] = 'Configurations - Admin | '.the_config('site_name');

                $data['config'] = $this->Configuration_model->get_config();

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function config_update() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {
                
                if($this->input->post()) {

                    $config = $this->input->post('config');
                    $config_reponse = array();
                    foreach($config as $key => $conf) {
                        $config_response[] = $this->Configuration_model->set_config($key, $conf[0]);
                    }

                    if($config_response) {
                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated'));
                    } else {
                        $response = json_encode(array('result' => 'error', 'message' => 'Something went wrong'));
                    }

                    echo $response;

                } else {
                    redirect(base_url('admin/configuration'));
                }
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function user($page = 'user') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                
                $data['title'] = 'User Account - Admin | '.the_config('site_name');

                $data['user'] = $this->User_model->get_user($_SESSION['user_id']);

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function user_detail_update() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {
                
                if($this->input->post()) {

                    $data = $this->input->post();
                    $id = $_SESSION['user_id'];

                    $res = $this->User_model->update_user($id, $data);

                    if($res != 0) {

                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated'));

                    } else {

                        $response = json_encode(array('result' => 'error', 'message' => 'Oops! Something went wrong.'));

                    }

                   echo $response;

                } else {
                    redirect(base_url('admin/configuration'));
                }
                
            } else {
                
                redirect(base_url());
                
            }

        }
        public function user_password_update() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {
                
                if($this->input->post()) {

                    $req = $this->input->post();
                    $id = $_SESSION['user_id'];

                    $match_pass = $this->User_model->match_password($id, $req['password']);

                    if($match_pass) {

                        if($req['new_pass'] == $req['conf_pass']) {
                           
                            if($req['password'] == $req['new_pass']) {
                                $response = json_encode(array('result' => 'success', 'message' => 'Password changed!', 'redirect' => base_url('admin/logout')));
                            } else {
                                $data['password'] = md5($req['new_pass']);
                                $res = $this->User_model->update_password($id, $data);
                                if($res) {
                                    $response = json_encode(array('result' => 'success', 'message' => 'Password changed', 'redirect' => base_url('admin/logout')));
                                } else {
                                    $response = json_encode(array('error' => 'success', 'message' => 'Something went wrong!'));
                                }
                                
                            }

                        } else {
                            $response = json_encode(array('result' => 'error', 'message' => 'Password didn\'t match!'));
                        }

                    } else {

                        $response = json_encode(array('result' => 'error', 'message' => 'Incorrect password!'));

                    }

                   echo $response;                 

                } else {
                    redirect(base_url('admin/configuration'));
                }
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function industry($page = 'industry') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                
                $data['title'] = 'Industry - Admin | '.the_config('site_name');

                $industry = $this->Industry_model->get_industry();

                if($industry) {
                    $data['industry'] = $industry;
                } else {
                    $data['industry'] = 0;
                }

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function add_industry($page = 'add_industry') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                
                $data['title'] = 'Add New Industry - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function add_industry_process($page = 'add_industry') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();
                    $slug = ($req['slug']) ? slugify($req['slug']) : slugify($req['industry']);

                    $data = array(
                        'industry' => $req['industry'],
                        'label' => $req['label'],
                        'slug' => $slug,
                        'created_at' => datetime_now()
                    );

                    $res = $this->Industry_model->add_industry($data);

                    if($res == 1) {
                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Added', 'redirect' => base_url('admin/industry')));
                    } else {
                        $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                    }

                    echo $response;

                } else {
                    redirect(base_url('admin/industry'));
                }
                
            } else {
                
                redirect(base_url());
                
            }

        }

        public function update_industry($page = 'update_industry') {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                $slug_uri = $this->uri->segment(3, 0);

                $res = $this->Industry_model->get_industry_from_slug($slug_uri);

                if($res != 0) {

                    $data['industry'] = $res[0];

                } else {

                    redirect(base_url('admin/industry'));

                }

                $data['title'] = 'Update Industry - Admin | '.the_config('site_name');

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/'.$page, $data);
                $this->load->view('admin/templates/footer', $data);

            } else {

                redirect(base_url());

            }

        }

        public function update_industry_process() {

            if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    $req = $this->input->post();
                    $id = $req['id'];
                    $slug = ($req['slug']) ? slugify($req['slug']) : slugify($req['industry']);

                    

                    $data = array(
                        'industry' => $req['industry'],
                        'label' => $req['label'],
                        'slug' => $slug,
                        'updated_at' => datetime_now()
                    );

                    $res = $this->Industry_model->update_industry($id, $data);

                    if($res == 1) {
                        $response = json_encode(array('result' => 'success', 'message' => 'Successfully Updated', 'redirect' => base_url('admin/industry')));
                    } else {
                        $response = json_encode(array('result' => 'error', 'message' => 'Oops! Please try again later.'));
                    }

                    echo $response;

                } else {
                    redirect(base_url('admin/industry'));
                }

            } else {

                redirect(base_url());

            }

        }

        public function delete_industry($page = 'add_industry') {

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                if($this->input->post()) {

                    if($this->input->post()) {
                    
                        $req = $this->input->post();

                        $id = $req['id'];

                        $res = $this->Industry_model->delete_industry($id);

                        if($res == 1) {

                            $response = json_encode(array('result' => 'success', 'message' => 'Successfully Deleted'));

                       } else {

                            $response = json_encode(array('result' => 'error', 'message' => 'Oops! Something went wrong.'));

                       }

                       echo $response;

                    } else {

                        redirect(base_url());
                    }

                } else {
                    redirect(base_url('admin/industry'));
                }
                
            } else {
                
                redirect(base_url());
                
            }

        }

	}