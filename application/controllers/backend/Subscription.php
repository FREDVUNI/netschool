<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Subscription extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Subscription_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschool | subscriptions';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['subscriptions'] = $this->Subscription_model->getsubscriptions();
            
            $this ->load->view('backend/subscription/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function delete($id){
            $data = $this->Subscription_model->get_subscription($id);
           
            if($this->Subscription_model->deletesubscription($id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The subscription has been deleted.</div>');
                return redirect('admin/subscriptions');
            endif;
        }
    }