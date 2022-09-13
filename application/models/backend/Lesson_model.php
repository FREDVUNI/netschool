<?php  
    class Lesson_model extends CI_Model{
        public function __construct(){
           
        }
        public function getlessons($query = []){
            $this->db->select('lessons.*,topics.topic_id,topic,levels.level_id,level,subjects.subject_id,subject,teachers.teacher_id,firstname,lastname,terms.term_id,term');
            $this->db->where($query);
            $this->db->join('levels', 'lessons.level_id = levels.level_id');
            $this->db->join('subjects', 'lessons.subject_id = subjects.subject_id');
            $this->db->join('teachers', 'lessons.teacher_id = teachers.teacher_id');
            $this->db->join('topics', 'lessons.topic_id = topics.topic_id');
            $this->db->join('terms', 'lessons.term_id = terms.term_id');

	        $this->db->from('lessons');  
            // $this->db->order_by('lesson_id', 'DESC');
            $this->db->order_by('lesson_order', 'ASC');
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getlesson($slug = FALSE){
            $this->db->select('lessons.*,topics.topic,levels.level,subjects.subject,teachers.firstname,lastname,terms.term');
            $this->db->join('levels', 'lessons.level_id = levels.level_id');
            $this->db->join('subjects', 'lessons.subject_id = subjects.subject_id');
            $this->db->join('teachers', 'lessons.teacher_id = teachers.teacher_id');
            $this->db->join('topics', 'lessons.topic_id = topics.topic_id');
            $this->db->join('terms', 'lessons.term_id = terms.term_id');
            
            if($slug  === FALSE):
        		$query  = $this->db->get('lessons');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('lessons',array('lessons.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_lesson($lesson_id){
            $this->db->where('lesson_id', $lesson_id);
            $query = $this->db->get('lessons');
            return $query->row();
        }
        public function deletelesson($lesson_id){
            $this->db->where('lesson_id',$lesson_id);
            $this->db->delete('lessons',array('lesson_id'=>$lesson_id));
            return TRUE;
        }
        public function countlessons(){
            $this->db->from('lessons');
            return $count = $this->db->count_all_results();
        }

        public function countQueryLessons($query){
            $query = $this->db->get_where('lessons', $query);
            return $query->num_rows();
        }

        public function addLesson($data){
            $lastLesson = $this->getLatestLesson(
                ['topic_id' 	=> $data['topic_id'],]
            );
            $lastCode = ($lastLesson) ? $lastLesson['lesson_order'] : 0;
    
            $data['lesson_order'] = ($lastCode + 1);

            $this->db->insert('lessons', $data);
            return $this->db->insert_id();
        }

        public function updateLesson($id, $data){
            $this->db->where('lesson_id', $id);
            return $this->db->update('lessons', $data);
        }

        public function getLesson1($data = []){
            $this->db->order_by('lesson_id', 'ASC');
            $query = $this->db->get_where('lessons', $data);
            return $query->row_array();
        }

        public function getLessons1($data = []){
            $this->db->order_by('lesson_id', 'ASC');
            $query = $this->db->get_where('lessons', $data);
            return $query->result_array();
        }

        public function getLatestLesson($data){
            $this->db->order_by('lesson_order', 'ASC');
            $query = $this->db->get_where('lessons', $data);
            $row = $query->last_row('array');
            return $row;
        }
    }
