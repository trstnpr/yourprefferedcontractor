<?php

    class Industry_model extends CI_Model {

        protected $table = 'industry';
        protected $key = 'id';


        function __construct()
        {
            parent::__construct();
        }

        public function get_industry()
        {

            $this->db->select('*');
            $this->db->from($this->table);

            $dataset = $this->db->get();

            if($dataset->num_rows()){
                return $dataset->result();
            } else {
                return FALSE;
            }
        }

        public function get_industry_from_slug($data)
        {

            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('slug', $data);
            
            $dataset = $this->db->get();

            if($dataset->num_rows()){
                return $dataset->result();
            } else {
                return FALSE;
            }
        }

        public function get_industry_from_id($id)
        {

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

        public function add_industry($data) {

            return $this->db->insert($this->table, $data);

        }

        public function update_industry($id, $data) {

            $this->db->where('id', $id);
            
            return $this->db->update($this->table, $data);

        }

        public function delete_industry($id) {

            $this->db->where('id', $id);

            return $this->db->delete($this->table);

        }

    }