<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Term extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Term_model');
            $this->load->model('backend/Level_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Terms';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['terms'] = $this->Term_model->getterms();
            
            $this ->load->view('backend/term/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create term';
            
            $this->form_validation->set_rules('term','Term','required|trim'); 
            $this->form_validation->set_rules('level','Class','required|trim');

            if($this->form_validation->run() == FALSE):
                
                $this->load->view('templates/backend/header',$data);
                $data['levels'] = $this->Level_model->getlevels();
                $data["level_list"] = $this->input->get("level_id");
                $this->load->view('backend/term/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $level_id = $this->input->post("level");
                
                $level = $this->db->get_where('levels',['level_id'=>
                $level_id])->row_array();
                
                $data=[
                    'term' => htmlspecialchars($this->input->post('term')),
                    'level_id' => htmlspecialchars($this->input->post('level')),
                    'slug' =>   $this->generate_slug($level['level']." ".$this->input->post('term')),
                    'date_created' => date("Y-m-d H:i:s"),
                ];

                $this->db->insert('terms',$data);
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                The term has been created.</div>');
                redirect('admin/terms');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['term'] = $this->Term_model->getterm($slug);
            if(empty($data['term'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit term';
            
            $this->form_validation->set_rules('term','term','required|trim');
            $this->form_validation->set_rules('level','Class','required|trim');

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                
                $data['levels'] = $this->Level_model->getlevels();
                $data["level_list"] = $this->input->get("level_id");
                
                $this->load->view('backend/term/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $s = $this->input->post("level");
                
                $subjectlevel = $this->db->get_where('levels',['level_id'=>
                $s])->row_array();
                
                $term_id=$this->input->post('term_id');
                $term=$this->input->post('term');
                $level=$this->input->post('level');
                $slug = $this->generate_slug($this->generate_slug($subjectlevel['level']." ".$this->input->post('term')));
                $datetime = date("Y-m-d H:i:s");
                
                $this->db->set('term',$term);
                $this->db->set('level_id',$level);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('term_id',$term_id);

                $this->db->update("terms");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The term has been updated.</div>');
                return redirect('admin/terms');
            endif;
        }
        public function delete($term_id){
            $data = $this->Term_model->get_term($term_id);
           
            if($this->Term_model->deleteterm($term_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The term has been deleted.</div>');
                return redirect('admin/terms');
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