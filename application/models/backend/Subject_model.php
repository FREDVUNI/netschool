<?php  
    class Subject_model extends CI_Model{
        public function __construct(){
           
        }
        public function getsubjects(){
 			$this->db->select('levels.level,subjects.*');
            $this->db->join('levels', 'subjects.level_id = levels.level_id');
	        $this->db->from('subjects');  
	        $this->db->order_by('subject_id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getsubject($slug = FALSE){
            $this->db->select('levels.level,subjects.*');
            $this->db->join('levels', 'subjects.level_id = levels.level_id');
            if($slug  === FALSE):
        		$query  = $this->db->get('subjects');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('subjects',array('subjects.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_subject($subject_id){
            $this->db->where('subject_id', $subject_id);
            $query = $this->db->get('subjects');
            return $query->row();
        }
        public function deletesubject($subject_id){
            $this->db->where('subject_id',$subject_id);
            $this->db->delete('subjects',array('subject_id'=>$subject_id));
            return TRUE;
        }
        public function countsubjects(){
            $this->db->from('subjects');
            return $count = $this->db->count_all_results();
        }

        public function getSubjects1($data = []){
            $query = $this->db->get_where('subjects', $data);
            return $query->result_array();
       }

        public function getSubject1($data){
            $query = $this->db->get_where('subjects', $data);
            return $query->row_array();
        }
    } 