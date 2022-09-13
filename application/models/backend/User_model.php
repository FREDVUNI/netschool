<?php  
    class User_model extends CI_Model{
        public function __construct(){
           
        }
        public function getusers(){
 			 $this->db->select(array('a.id','a.username', 'a.email', 'a.role_id','a.image','a.is_active','a.date_created'));
	        $this->db->from('admins a');  
	        $this->db->order_by('a.id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
        }
        public function get_user($id){
            $this->db->where('id', $id);
            $query = $this->db->get('admins');
            return $query->row();
        }

        public function updateUsers($where, $data)
        {
            $this->db->where($where);
            return $this->db->update('admins', $data);
        }

        public function deleteToken($data)
        {
            return $this->db->delete('user_token', $data);
        }
    } 