<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Payment extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Payment_model');

        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | student payments';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['payments'] = $this->Payment_model->getstudents();
            
            $this ->load->view('backend/payment/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function status(){
            $data['students'] = $this->Payment_model->getstudents();
            
            if(empty($data['students'])):
                return redirect('admin/404');
            endif;
            $id=$this->input->post('id');
            $status=$this->input->post('payment_status');
            
            if($status == 1):
                $this->db->set('payment_status',$status);
                $this->db->where('id',$id);
    
                $this->db->update('payment');
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The student\'s payment has been confirmed.</div>');
                redirect(base_url('admin/payments'));
            else:
                $this->db->set('payment_status',$status);
                $this->db->where('id',$id);
    
                $this->db->update('payment');
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The student has been blocked.</div>');
                redirect(base_url('admin/payments'));
            endif;
        }
        public function notification(){
            $payments = $this->Payment_model->getrecentpayments();
            $result["payments"] = $payments;
            $result["message"] = "This is to notify you.";
            echo json_encode($result);
        }
        public function expired(){
             $payments = $this->Payment_model->expirepayment($id);
            $result["payments"] = $payments;
            $result["message"] = "Period for lesson has expired.";
            echo json_encode($result);
        }
        public function delete($id){
            $data = $this->Payment_model->get_student($id);
            if($this->Payment_model->deletepayment($id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The payment has been deleted.</div>');
                return redirect('admin/payment');
            endif;
        }
    }