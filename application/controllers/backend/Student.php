<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Student extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/student_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | students';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['students'] = $this->student_model->getstudents();
            
            $this ->load->view('backend/student/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function status(){
            $data['students'] = $this->student_model->getstudents();
            if(empty($data['students'])):
                return redirect('admin/404');
            endif;
            $student_id=$this->input->post('student_id');
            $status=$this->input->post('status');

            $this->db->set('status',$status);
            $this->db->where('student_id',$student_id);

            $this->db->update('students');
            $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                The student\'s status has been changed.</div>');
            redirect(base_url('admin/students'));
        }
        public function delete($student_id){
            $data = $this->student_model->get_student($student_id);
            $path = './assets/backend/images/uploads/students/';

            @unlink($path . $data->image);
            if($this->student_model->deletestudent($student_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The student has been deleted.</div>');
                return redirect('admin/students');
            endif;
        }
    }