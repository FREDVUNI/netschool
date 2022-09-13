<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Topic extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Topic_model');
            $this->load->model('backend/Level_model');
            $this->load->model('backend/Subject_model');
            $this->load->model('backend/Payment_model');
            $this->load->model('backend/Lesson_model');
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Topics';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $topics = $this->Topic_model->gettopics();
            foreach ($topics as $key => $topic) {
                # count topic's lessons
                $topics[$key]['lessonsCount'] = $this->Lesson_model->countQueryLessons(['topic_id' => $topic['topic_id']]);
                $topics[$key]['theSubject'] = $this->Subject_model->getSubject1(['subject_id' => $topic['subject_id']]);
            }

            $data['topics'] = $topics;
            
            $this ->load->view('backend/topic/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create topic';
            
            $this->form_validation->set_rules('topic','Topic','required|trim'); 
            $this->form_validation->set_rules('level','Level','required|trim');
            $this->form_validation->set_rules('subject','Subject','required|trim');
            
            if($this->form_validation->run() == FALSE):
                
                $this->load->view('templates/backend/header',$data);
                
                $data['levels'] = $this->Level_model->getlevels();
                $data['subjects'] = $this->Subject_model->getsubjects();
                $data["level_list"] = $this->input->get("level_id");
                $data["subject_list"] = $this->input->get("subject_id");
                
                $this->load->view('backend/topic/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $data=[
                    'level_id' => htmlspecialchars($this->input->post('level')),
                    'subject_id' => htmlspecialchars($this->input->post('subject')),
                    'topic' => htmlspecialchars($this->input->post('topic')),
                    'slug' => $this->generate_slug($this->input->post('topic')),
                    'date_created' => date("Y-m-d H:i:s"),
                ];

                $this->db->insert('topics',$data);
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                The topic has been created.</div>');
                redirect('admin/topics');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['topic'] = $this->Topic_model->gettopic($slug);
            if(empty($data['topic'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit topic';
            
            $this->form_validation->set_rules('topic','Topic','required|trim'); 
            $this->form_validation->set_rules('level','Level','required|trim');
            $this->form_validation->set_rules('subject','Subject','required|trim');    

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                
                $data['levels'] = $this->Level_model->getlevels();
                $data['subjects'] = $this->Subject_model->getsubjects();
                $data["level_list"] = $this->input->get("level_id");
                $data["subject_list"] = $this->input->get("subject_id");
                
                $this->load->view('backend/topic/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $topic_id=$this->input->post('topic_id');
                $level=$this->input->post('level');
                $subject=$this->input->post('subject');
                $topic=$this->input->post('topic');
                $slug = $this->generate_slug($this->input->post('topic'));
                $datetime = date("Y-m-d H:i:s");
                
                $this->db->set('level_id',$level);
                $this->db->set('subject_id',$subject);
                $this->db->set('topic',$topic);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('topic_id',$topic_id);

                $this->db->update("topics");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The topic has been updated.</div>');
                return redirect('admin/topics');
            endif;
        }
        public function delete($topic_id){
            $data = $this->Topic_model->get_topic($topic_id);
           
            if($this->Topic_model->deletetopic($topic_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The topic has been deleted.</div>');
                return redirect('admin/topics');
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