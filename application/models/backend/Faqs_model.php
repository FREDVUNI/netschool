<?php  
    class Faqs_model extends CI_Model{
        public function __construct(){
           
        }
        public function getfaqs(){
 			$this->db->select('*');
	        $this->db->from('faqs');  
	        $this->db->order_by('id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getfaq($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('faqs');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('faqs',array('faqs.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_faq($id){
            $this->db->where('id', $id);
            $query = $this->db->get('faqs');
            return $query->row();
        }
        public function deletefaq($id){
            $this->db->where('id',$id);
            $this->db->delete('faqs',array('id'=>$id));
            return TRUE;
        }
        public function countfaqs(){
            $this->db->from('faqs');
            return $count = $this->db->count_all_results();
        }
    } 