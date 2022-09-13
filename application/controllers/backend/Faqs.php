<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Faqs extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Faqs_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | faqs';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['faqs'] = $this->Faqs_model->getfaqs();
            
            $this ->load->view('backend/faqs/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create faq';
            $this->form_validation->set_rules('question','Question','required|trim|is_unique[faqs.question]',
            ['is_unique'=>'This question already exists.']
            );
            $this->form_validation->set_rules('answer','Answer','required|trim');
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/faqs/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $data=[
                    'question' => htmlspecialchars($this->input->post('question')),
                    'answer' => htmlspecialchars($this->input->post('answer')),
                    'slug' =>   $this->generate_slug($this->input->post('question')),
                    'date_created' => date("Y-m-d H:i:s"),
                ];

                $this->db->insert('faqs',$data);
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Frequently asked question has been created.</div>');
                redirect('admin/faqs');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['faq'] = $this->Faqs_model->getfaq($slug);
            if(empty($data['faq'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit Frequently asked question';
            
            $this->form_validation->set_rules('question','Question','required|trim');   
            $this->form_validation->set_rules('answer','Answer','required|trim');    

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/faqs/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $id=$this->input->post('id');
                $question=$this->input->post('question');
                $answer=$this->input->post('answer');
                $slug = $this->generate_slug($this->input->post('question'));
                $datetime = date("Y-m-d H:i:s");

                $this->db->set('question',$question);
                $this->db->set('answer',$answer);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('id',$id);

                $this->db->update("faqs");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The frequently asked question has been updated.</div>');
                return redirect('admin/faqs');
            endif;
        }
        public function delete($id){
            $data = $this->Faqs_model->get_faq($id);
           
            if($this->Faqs_model->deletefaq($id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The faq has been deleted.</div>');
                return redirect('admin/faqs');
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