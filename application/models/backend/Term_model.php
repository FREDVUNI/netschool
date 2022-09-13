<?php  
    class Term_model extends CI_Model{
        public function __construct(){
           
        }
        public function getterms(){
 			$this->db->select('levels.level,terms.*');
            $this->db->join('levels', 'terms.level_id = levels.level_id');
	        $this->db->from('terms');  
	        $this->db->order_by('term_id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getterm($slug = FALSE){
            $this->db->select('levels.level,terms.*');
            $this->db->join('levels', 'terms.level_id = levels.level_id');
            if($slug  === FALSE):
        		$query  = $this->db->get('terms');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('terms',array('terms.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_term($term_id){
            $this->db->where('term_id', $term_id);
            $query = $this->db->get('terms');
            return $query->row();
        }
        public function deleteterm($term_id){
            $this->db->where('term_id',$term_id);
            $this->db->delete('terms',array('term_id'=>$term_id));
            return TRUE;
        }
        public function countterms(){
            $this->db->from('terms');
            return $count = $this->db->count_all_results();
        }

        public function getTerms1($data){
            $query = $this->db->get_where('terms', $data);
            return $query->result_array();
        }
    } 