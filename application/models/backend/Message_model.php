<?php  
    class Message_model extends CI_Model{
        public function __construct(){
           
        }
        public function getmessages(){
 			$this->db->select('*');
	        $this->db->from('contact');  
	        $this->db->order_by('id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getmessage($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('contact');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('contact',array('contact.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_message($id){
            $this->db->where('id', $id);
            $query = $this->db->get('contact');
            return $query->row();
        }
        public function deletemessage($id){
            $this->db->where('id',$id);
            $this->db->delete('contact',array('id'=>$id));
            return TRUE;
        }
        public function countmessages(){
            $this->db->from('contact');
            return $count = $this->db->count_all_results();
        }
    } 