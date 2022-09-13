<?php  
    class Level_model extends CI_Model{
        public function __construct(){
           
        }
        public function getlevels(){
 			$this->db->select('*');
	        $this->db->from('levels');  
	        $this->db->order_by('level_order', 'ASC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function getlevel($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('levels');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('levels',array('levels.slug'=>$slug));
        	return $query->row_array();
        }
        public function get_level($level_id){
            $this->db->where('level_id', $level_id);
            $query = $this->db->get('levels');
            return $query->row();
        }
        public function deletelevel($level_id){
            $this->db->where('level_id',$level_id);
            $this->db->delete('levels',array('level_id'=>$level_id));
            return TRUE;
        }
        public function countlevels(){
            $this->db->from('levels');
            return $count = $this->db->count_all_results();
        }

        public function getLevel1($data){
            $query = $this->db->get_where('levels', $data);
            return $query->row_array();
        }

        public function getLevels1($data = []){
            $this->db->order_by('level_id', 'ASC');
            $query = $this->db->get_where('levels', $data);
            return $query->result_array();
        }

        public function addLevel($data){
            $lastLevel = $this->getLatestLevel();
            $lastCode = ($lastLevel) ? $lastLevel['level_order'] : 0;
    
            $data['level_order'] = ($lastCode + 1);

            $this->db->insert('levels', $data);
            return $this->db->insert_id();
        }

        public function getLatestLevel($data = []){
            $this->db->order_by('level_order', 'ASC');
            $query = $this->db->get_where('levels', $data);
            $row = $query->last_row('array');
            return $row;
        }

        public function updateLevel($id, $data){
            $this->db->where('level_id', $id);
            return $this->db->update('levels', $data);
        }
    } 