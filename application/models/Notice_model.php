<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notice_model extends CI_Model {

    public function __construct()
    {
		$this->load->database();
	}

    public function getNotices($data = [])
    {
		$query = $this->db->get_where('notices',$data);
		return $query->result_array();
	}

    public function getNotice($data)
    {
		$query = $this->db->get_where('notices',$data);
		return $query->row_array();
	}

    public function addNotice($data)
    {
	    $this->db->insert('notices',$data);
	    return $this->db->insert_id();
	}

    public function editNotice($id, $data)
    {
		$this->db->where('id', $id);
		return $this->db->update('notices', $data);
    }
    
    public function deleteNotice($data)
    {
        return $this->db->delete('notices', $data);
    }
}
