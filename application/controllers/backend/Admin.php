<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Lesson_model');
            $this->load->model('backend/Student_model');
            $this->load->model('backend/Teacher_model');
            $this->load->model('backend/Subject_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();
            
            $data['pay'] = $this->Payment_model->recent();

            $data['title'] = 'Netschoolug | Dashboard';

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar',$data);
            $data["lessons"] = $this->Lesson_model->countlessons();
            $data["students"] = $this->Student_model->countstudents();
            $data["teachers"] = $this->Teacher_model->countteachers();
            $data["subjects"] = $this->Subject_model->countsubjects();
            $jsondata = $this->Student_model->get_data()->result();
            $data['graphdata'] = json_encode($jsondata);
            $this->load->view('backend/index',$data);
            
            $this->load->view('templates/backend/footer',$data);
        }
    } 