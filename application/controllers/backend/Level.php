<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Level extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Level_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Levels';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['levels'] = $this->Level_model->getlevels();
            
            $this ->load->view('backend/level/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create level';
            $this->form_validation->set_rules('level','Level name','required|trim|is_unique[levels.level]',
            ['is_unique'=>'This level already exists.']
            );      
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/level/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $data=[
                    'level' => htmlspecialchars($this->input->post('level')),
                    'slug' =>   $this->generate_slug($this->input->post('level')),
                    'date_created' => date("Y-m-d H:i:s"),
                ];

                $this->Level_model->addLevel($data);
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Level has been created.</div>');
                redirect('admin/levels');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['level'] = $this->Level_model->getlevel($slug);
            if(empty($data['level'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit level';
            
            $this->form_validation->set_rules('level','Level name','required|trim');    

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/level/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $level_id=$this->input->post('level_id');
                $level=$this->input->post('level');
                $slug = $this->generate_slug($this->input->post('level'));
                $datetime = date("Y-m-d H:i:s");

                $this->db->set('level',$level);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('level_id',$level_id);

                $this->db->update("levels");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The level has been updated.</div>');
                return redirect('admin/levels');
            endif;
        }
        public function delete($level_id){
            $data = $this->Level_model->get_level($level_id);
           
            if($this->Level_model->deletelevel($level_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The level has been deleted.</div>');
                $this->rearrangeLevels();
                return redirect('admin/levels');
            endif;
        }

        public function moveUp($level_id)
        {
            $theLevel = $this->Level_model->getLevel1(['level_id' => $level_id]);

            $lesserLevel = $this->Level_model->getLevel1([
                'level_order' => $theLevel['level_order'] - 1
            ]);

            if($lesserLevel){
                $this->Level_model->updateLevel(
                    $lesserLevel['level_id'],
                    ['level_order' => $lesserLevel['level_order'] + 1]
                );

                $this->Level_model->updateLevel(
                    $theLevel['level_id'],
                    ['level_order' => $theLevel['level_order'] - 1]
                );
            }

            return redirect("admin/levels");
        }

        public function moveDown($level_id)
        {
            $theLevel = $this->Level_model->getLevel1(['level_id' => $level_id]);

            $greaterLevel = $this->Level_model->getLevel1([
                'level_order' => $theLevel['level_order'] + 1
            ]);

            if($greaterLevel){
                $this->Level_model->updateLevel(
                    $greaterLevel['level_id'],
                    ['level_order' => $greaterLevel['level_order'] - 1]
                );

                $this->Level_model->updateLevel(
                    $theLevel['level_id'],
                    ['level_order' => $theLevel['level_order'] + 1]
                );
            }
            
            return redirect("admin/levels");
        }

        private function rearrangeLevels()
        {
            $levels = $this->Level_model->getlevels();

            foreach ($levels as $key => $level) {
                $this->Level_model->updateLevel($level['level_id'], ['level_order' => $key+1]);
            }
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