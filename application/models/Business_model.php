<?php

	class Business_model extends CI_Model {

	    protected $table = 'business';
		protected $key = 'id';


	    function __construct()
	    {
	        parent::__construct();
	    }

	    public function get_business()
	    {

            $this->db->select('*');
			$this->db->from($this->table);
			$this->db->order_by('name', 'asc');

            $dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}
	    }

	    public function get_verified_business() {

	    	$this->db->select('*');
	    	$this->db->from($this->table);
	    	$this->db->where('status', 1);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}

	    }

	    public function get_business_from_id($id) {

	    	$this->db->select('*');
	    	$this->db->from($this->table);
	    	$this->db->where('id', $id);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}

	    }

	    public function validate_slug($slug)
	    {

	    	$this->db->select('*');
	    	$this->db->from($this->table);
	    	$this->db->where('slug', $slug);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}

	    }

	    public function submit_business($data){

	        return $this->db->insert($this->table, $data);

		}

		public function delete_business($id) {

			$this->db->where('id', $id);

			return $this->db->delete($this->table);

		}

		public function void_business($id, $date) {

			$data = array('status' => 2, 'confirmed_at' => $date);

			$this->db->where('id', $id);

			return $this->db->update($this->table, $data);

		}

		public function verify_business($id, $date) {

			$data = array('status' => 1, 'confirmed_at' => $date);

			$this->db->where('id', $id);

			return $this->db->update($this->table, $data);

		}

	}