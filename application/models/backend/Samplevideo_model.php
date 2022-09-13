<?php  
    class Samplevideo_model extends CI_Model{
        public function __construct(){
           
        }
        public function getsamplevideos(){
            $this->db->select('samplevideos.*,subjects.subject');
            $this->db->join('subjects', 'samplevideos.subject_id = subjects.subject_id');

	        $this->db->from('samplevideos');  
	        $this->db->order_by('samplevideo_id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getsamplevideo($slug = FALSE){
            $this->db->select('samplevideos.*,subjects.subject');
            $this->db->join('subjects', 'samplevideos.subject_id = subjects.subject_id');
            
            if($slug  === FALSE):
        		$query  = $this->db->get('samplevideos');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('samplevideos',array('samplevideos.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_samplevideo($samplevideo_id){
            $this->db->where('samplevideo_id', $samplevideo_id);
            $query = $this->db->get('samplevideos');
            return $query->row();
        }
        public function deletesamplevideo($samplevideo_id){
            $this->db->where('samplevideo_id',$samplevideo_id);
            $this->db->delete('samplevideos',array('samplevideo_id'=>$samplevideo_id));
            return TRUE;
        }
        public function countsamplevideos(){
            $this->db->from('samplevideos');
            return $count = $this->db->count_all_results();
        }
    } 