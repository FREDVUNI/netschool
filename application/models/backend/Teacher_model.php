<?php  
    class Teacher_model extends CI_Model{
        public function __construct(){
           
        }
        public function getteachers(){
 			 $this->db->select('*');
	        $this->db->from('teachers');  
	        $this->db->order_by('teacher_id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getteacher($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('teachers');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('teachers',array('teachers.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_teacher($teacher_id){
            $this->db->where('teacher_id', $teacher_id);
            $query = $this->db->get('teachers');
            return $query->row();
        }
        public function deleteteacher($teacher_id){
            $this->db->where('teacher_id',$teacher_id);
            $this->db->delete('teachers',array('teacher_id'=>$teacher_id));
            return TRUE;
        }
        public function countteachers(){
            $this->db->from('teachers');
            return $count = $this->db->count_all_results();
        }
    } 