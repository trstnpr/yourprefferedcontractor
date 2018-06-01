<?php

	class City_model extends CI_Model {

		public $name;
	    public $state;
	    public $area_code;
	    public $zip_code;
	    public $slug;

	    protected $table = 'cities';
		protected $key = 'id';


	    function __construct()
	    {
	        parent::__construct();
	    }

	    public function get_cities()
	    {

            $this->db->select('*');
			$this->db->from($this->table);

            $dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}
	    }

	    public function get_city_from_state_industry($state, $industry, $limit, $offset) {
	        if ($offset > 0) {
	            $offset = ($offset - 1) * $limit;
	        }

	        $this->db->where('state', $state);
	        $this->db->where('industry', $industry);
	        $this->db->order_by('name', 'ASC');

	        
	        $result['data'] = $this->db->get($this->table, $limit, $offset);
	        // $result['count'] = $this->db->count_all_results($this->table);

	        return $result;
	    }

	    public function get_city_from_abbrev($abbrev) {

	    	$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('state', $abbrev);

			$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}

	    }

	    public function get_city_from_abbrev_industry($abbrev, $id) {

	    	$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('state', $abbrev);
			$this->db->where('industry', $id);

			$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}

	    }

	    public function get_rand_city_from_state($state)
	    {
	    	$this->db->select('*');
	    	$this->db->from($this->table);
	    	$this->db->where('state', $state);
	    	$this->db->order_by('rand()');

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}
	    }

	    public function get_city_from_slug($slug)
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

	    public function get_city_from_slug_industry($slug, $industry) // For search
	    {	
	    	$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('slug', $slug);
			$this->db->where('industry', $industry);

			$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}
	    }
	    
	    public function get_city_from_zip_industry($zip, $industry)
	    {	
	    	$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('industry', $industry);
			$this->db->like('zip_code', $zip);

			$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			} else {
				return FALSE;
			}
	    }

	    public function search_city($keyword, $industry) {

	    	$this->db->select('*');
	    	$this->db->from($this->table);
	    	$this->db->like('name', $keyword);
	    	$this->db->or_like('state', $keyword);
	    	$this->db->where('industry', $industry);
	    	$this->db->limit(10);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}
	    }

	    public function search_zip($keyword) {

	    	$this->db->select('*');

	    	$this->db->from($this->table);

	    	$this->db->like('zip_code', $keyword);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}
	    }

	    public function search_city_from_name_state($city, $state) {

	    	$this->db->select('*');

	    	$this->db->from($this->table);

	    	$this->db->where('name', $city);

	    	$this->db->where('state', $state);

	    	$this->db->limit(10);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}

	    }

	    public function search_city_from_name_state_zip($location) {

	    	$this->db->select('*');

	    	$this->db->from($this->table);

	    	$this->db->like('name', $location);

	    	$this->db->or_like('state', $location);

	    	$this->db->or_like('zip_code', $location);

	    	$this->db->limit(10);

	    	$dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}

	    }

	    public function get_popular_city() {

	    	$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('is_popular', 1);

            $dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}

	    }

	    public function get_random_popular_city() {

	    	$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('is_popular', 1);
			$this->db->order_by('rand()');
			$this->db->limit(1);

            $dataset = $this->db->get();

			if($dataset->num_rows()){
				return $dataset->result();
			}else{
				return FALSE;
			}

	    }

	    public function major_city($id, $data) {

	    	$this->db->where('id', $id);
			
			return $this->db->update($this->table, $data);
	    	
	    }

	    public function delete_city($id) {

			$this->db->where('id', $id);

			return $this->db->delete($this->table);

		}

		public function delete_all_city() {

			return $this->db->empty_table($this->table);

		}

		public function add_city($data) {

	        return $this->db->insert($this->table, $data);

		}

		public function update_city($id, $data) {

			$this->db->where('id', $id);
			
			return $this->db->update($this->table, $data);

		}

		public function city_validate_slug($slug) {
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

	}