<?php  
    class Topic_model extends CI_Model{
        public function __construct(){
           
        }
        public function gettopics(){
 			$this->db->select('levels.level,subjects.subject,topics.*');
            $this->db->join('levels', 'topics.level_id = levels.level_id');
            $this->db->join('subjects', 'topics.subject_id = subjects.subject_id');
	        $this->db->from('topics');  
	        $this->db->order_by('topic_id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function gettopic($slug = FALSE){
            $this->db->select('levels.level,subjects.subject,topics.*');
            $this->db->join('levels', 'topics.level_id = levels.level_id');
            $this->db->join('subjects', 'topics.subject_id = subjects.subject_id');
            if($slug  === FALSE):
        		$query  = $this->db->get('topics');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('topics',array('topics.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_topic($topic_id){
            $this->db->where('topic_id', $topic_id);
            $query = $this->db->get('topics');
            return $query->row();
        }
        public function deletetopic($topic_id){
            $this->db->where('topic_id',$topic_id);
            $this->db->delete('topics',array('topic_id'=>$topic_id));
            return TRUE;
        }
        public function counttopics(){
            $this->db->from('topics');
            return $count = $this->db->count_all_results();
        }
    } 