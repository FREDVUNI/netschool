<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }
    public function get_students($params = array()){
        $this->db->select('*');
        $this->db->from('students');
        if(array_key_exists("conditions",$params)):
            foreach($params["conditions"] as $key => $value):
                $this->db->where($key,$value);  
            endforeach;
        endif;
        if(array_key_exists("student_id",$params)):
            $this->db->where("student_id",$params["student_id"]);
            $query = $this->db->get();
            $result = $query->row_array();
        else:
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)):
                $this->db->limit($params["limit"],$params["start"]);
            elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)):
                $this->db->limit($params["limit"]);
            endif;
            if(array_key_exists("returnType",$params) && $params["returnType"] == "count"):
                $result = $this->db->count_all_results();
            elseif(array_key_exists("returnType",$params) && $params["returnType"] == "single"):
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            endif;
        endif;
        return $result;
    }
    public function insert($data){
        $insert = $this->db->insert("students");
        return $insert?$this->db->insert_id():FALSE;
    }
    public function update($data,$student_id){
        $update =$this->db->update("students",$data,array("student_id" => $student_id));
        return $update?TRUE:FALSE;
    }
    public function delete($student_id){
        $delete = $this->db->delete("students",array("student_id" => $student_id));
        return $delete?TRUE:FALSE;
    }
    
}