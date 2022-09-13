<?php  
    class Payment_model extends CI_Model{
        public function __construct(){
           
        }
        public function getpayment(){
	        $this->db->from('payment');  
	        $this->db->order_by('id', 'DESC');     
	        $query = $this->db->get();
	        return $query->result_array();
	        //DELETE FROM messages WHERE created < (NOW() - INTERVAL 30 SECOND)
        }
        public function getstudents($id = FALSE){
            $this->db->select('payment.*,students.*');
            $this->db->join('students', 'payment.student_id = students.student_id');

            if($id  === FALSE):
        		$query  = $this->db->get('payment');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('payment',array('payment.id'=>$id));
        	return $query->row_array();
        }
        public function getstudent($id = FALSE){
            $this->db->select('payment.*,students.student_id,firstname,lastname');
            $this->db->join('students', 'payment.student_id = students.student_id');

            if($id  === FALSE):
        		$query  = $this->db->get('payment');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('payment',array('payment.id'=>$id));
        	return $query->row_array();
        }
        public function getrecentpayments($q = NULL){
            $this->db->from('payment');
            $this->db->join('students', 'payment.student_id = students.student_id');
            
            $this->db->like('id',$q);
            //$this->db->where("DAY(payment.date_created)",date('d'));
            $this->db->where("payment_status",0);
            
            return $count = $this->db->count_all_results(); 
        }
        public function expirepayment($id){
            $this->db->from('payment');
            $this->db->join('students', 'payment.student_id = students.student_id');
            $datetime = date("Y-m-d H:i:s");

            $this->db->set('payment_status',0);
            $this->db->set('date_created',$datetime);
            
            $this->db->where('id',$id);
            $this->db->where('date BETWEEN DATE_SUB(NOW(), INTERVAL 32 DAY) AND NOW()');
            $this->db->where("payment_status",1);
            
            return $payment = $this->db->update("payment");; 
        }
        public function getrecent($q = NULL,$highest=TRUE){
            $payment = $highest ? "DESC":"ASC";
            $this->db->from('payment');
            $this->db->select('payment');
            $this->db->join('students', 'payment.student_id = students.student_id');
            
            $this->db->like('id',$q);
            //$this->db->where("DAY(payment.date_created)",date('d'));
            $this->db->where("payment_status",0);
            
            $this->db->group_by('payment.id');
            $this->db->limit(3);
            $this->db->order_by('payment.id',$payment);
            
            $query = $this->db->get();
            return $query->result_array(); 
        }
        public function recent(){
            return $this->db->select('*')
                ->from('payment')
                ->order_by('id', 'DESC')
                ->limit(5)
                ->join('students', 'payment.student_id = students.student_id')
                ->get()
                ->result();
        }
        public function get_student($id){
            $this->db->where('id', $id);
            $query = $this->db->get('payment');
            return $query->row();
        }
        public function deletepayment($id){
            $this->db->where('id',$id);
            $this->db->delete('payment',array('id'=>$id));
            return TRUE;
        }
        public function countpayments(){
            $this->db->from('payment');
            return $count = $this->db->count_all_results();
        }
    } 