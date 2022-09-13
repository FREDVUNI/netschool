<?php  
    class Subscription_model extends CI_Model{
        public function __construct(){
           
        }
        public function getsubscriptions(){
	        $this->db->from('subscriptions');  
	        $this->db->order_by('id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getsubscription($id = FALSE){
            if($id  === FALSE):
        		$query  = $this->db->get('subscriptions');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('subscriptions',array('subscriptions.id'=>$id));
        	return $query->row_array();
        }
        public function get_subscription($id){
            $this->db->where('id', $id);
            $query = $this->db->get('subscriptions');
            return $query->row();
        }
        public function deletesubscription($id){
            $this->db->where('id',$id);
            $this->db->delete('subscriptions',array('id'=>$id));
            return TRUE;
        }
        public function countsubscriptions(){
            $this->db->from('subscriptions');
            return $count = $this->db->count_all_results();
        }
    } 