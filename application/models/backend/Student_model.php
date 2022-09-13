<?php  
    class Student_model extends CI_Model{
        public function __construct(){
           
        }
        public function getstudents(){
	        $this->db->from('students');  
	        $this->db->order_by('student_id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getstudent($student_id = FALSE){
            if($student_id  === FALSE):
        		$query  = $this->db->get('students');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('students',array('students.student_id'=>$student_id));
        	return $query->row_array();
        }
        public function get_student($student_id){
            $this->db->where('student_id', $student_id);
            $query = $this->db->get('students');
            return $query->row();
        }
        public function get_data(){
            $this->db->select("MONTHNAME(date_created) as y, COUNT(student_id) as a FROM students where date(date_created) > DATE_SUB(NOW(), INTERVAL 1 WEEK) AND MONTH(date_created) = '".date('m')."' AND YEAR(date_created) = '".date('Y')."' GROUP BY DAYNAME(date_created)");
            $result = $this->db->get('');
            return $result;
        }
        public function deletestudent($student_id){
            $this->db->where('student_id',$student_id);
            $this->db->delete('students',array('student_id'=>$student_id));
            return TRUE;
        }
        public function countstudents(){
            $this->db->from('students');
            return $count = $this->db->count_all_results();
        }
    } 