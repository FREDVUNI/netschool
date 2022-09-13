<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Message extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Message_model');
            $this->load->model('backend/Payment_model');
            $this->load->model('backend/Payment_model');

        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | messages';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['messages'] = $this->Message_model->getmessages();
            
            $this ->load->view('backend/message/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function view($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['message'] = $this->Message_model->getmessage($slug);
            if(empty($data['message'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | view message';
            
            $this->load->view('templates/backend/header',$data);
                
            $this->load->view('backend/message/view',$data);
            $this->load->view('templates/backend/sidebar');
                
            $this->load->view('templates/backend/footer');
        }
        public function delete($id){
            $data = $this->Message_model->get_message($id);
            if($this->Message_model->deletemessage($id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The message has been deleted.</div>');
                return redirect('admin/messages');
            endif;
        }
        public function generate_slug($slug, $separator = '-'){
            $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
            $special_cases = array( '&' => 'and', "'" => '');
            $slug = mb_strtolower( trim( $slug ), 'UTF-8' );
            $slug = str_replace( array_keys($special_cases), array_values( $special_cases), $slug );
            $slug = preg_replace( $accents_regex, '$1', htmlentities( $slug, ENT_QUOTES, 'UTF-8' ) );
            $slug = preg_replace("/[^a-z0-9]/u", "$separator", $slug);
            $slug = preg_replace("/[$separator]+/u", "$separator", $slug);
            return $slug;
            }

    }