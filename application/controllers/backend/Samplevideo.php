<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Samplevideo extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Samplevideo_model');
            $this->load->model('backend/Subject_model');
            $this->load->model('backend/Payment_model');

        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Sample videos';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['samplevideos'] = $this->Samplevideo_model->getsamplevideos();
            $this ->load->view('backend/samplevideo/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create sample video';
            
            $this->form_validation->set_rules('title','Video title','required|trim|min_length[3]');
            $this->form_validation->set_rules('video','Video url','required|trim');
            $this->form_validation->set_rules('subject','Subject','required|trim');
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                
                $data['subjects'] = $this->Subject_model->getsubjects();

                $data["subject_list"] = $this->input->get("subject_id");

                $this->load->view('backend/samplevideo/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $data=[
                    'subject_id' => htmlspecialchars($this->input->post('subject')),
                    'title' => htmlspecialchars($this->input->post('title')),
                    'video' => htmlspecialchars($this->input->post('video')),
                    'slug' => $this->generate_slug($this->input->post('title')),
                    'date_created' => date("Y-m-d H:i:s")
                ];

                /*if(isset($_FILES['video']['name'])  && $_FILES['video']['name'] != ''):

                    //uploading the video link to the database.
                    $config['upload_path'] = './assets/backend/videos/uploads/samplevideos/';
                    $config['max_size'] = '50240';
                    $config['allowed_types'] = 'avi|flv|mkv|mp4|wma';
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $video_name = $_FILES['video']['name'];
                    $config['file_name'] = $video_name;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('video')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['video']['name'] = 'dubai.mp4';
                    else:
                        $fileData = $this->upload->data();
                        $data['video'] = $fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    Invalid video.please try again.</div>');
                    return redirect('admin/samplevideo/store');   
                endif;*/

            $this->db->insert('samplevideos',$data);            
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                 samplevideo has been created.</div>');
                redirect('admin/samplevideos');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['samplevideo'] = $this->Samplevideo_model->getsamplevideo($slug);
            if(empty($data['samplevideo'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit sample video';
            
            $this->form_validation->set_rules('subject','Subject','required|trim');
            $this->form_validation->set_rules('title','Video title','required|trim|min_length[3]');
            $this->form_validation->set_rules('video','Video url','required|trim');
            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                
                $data['subjects'] = $this->Subject_model->getsubjects();

                $data["subject_list"] = $this->input->get("subject_id");

                $this->load->view('backend/samplevideo/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $samplevideo_id=$this->input->post('samplevideo_id');
                $subject=$this->input->post('subject');
                $title=$this->input->post('title');
                $video=$this->input->post('video');
                $slug = $this->generate_slug($this->input->post('title'));
                $datetime = date("Y-m-d H:i:s");

                /*if($_FILES['video']['size'] != 0  || $_FILES['video']['name'] != ''):

                    //uploading the video link to the database.
                    $config['upload_path'] = './assets/backend/videos/uploads/samplevideos/';
                    $config['max_size'] = '50240';
                    $config['allowed_types'] = 'avi|flv|mkv|mp4|wma';
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $video_name = $_FILES['video']['name'];
                    $config['file_name'] = $video_name;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('video')) :
                        $old_video = $data['samplevideo']['video'];
                        if ($old_video != 'dubai.mp4') :
                            unlink(FCPATH . './assets/backend/videos/uploads/samplevideos/' . $old_video);
                        endif;
                        $new_video = $this->upload->data('file_name');
                        $this->db->set('video', $new_video);
                    else :
                        echo $this->upload->display_errors();
                    endif; 
                endif;*/

                $this->db->set('subject_id',$subject);
                $this->db->set('title',$title);
                $this->db->set('video',$video);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                
                $this->db->where('samplevideo_id',$samplevideo_id);

                $this->db->update("samplevideos");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The sample video has been updated.</div>');
                return redirect('admin/samplevideos');
            endif;
        }
        public function delete($samplevideo_id){
            $data = $this->Samplevideo_model->getsamplevideo($samplevideo_id);
            //$videopath = './assets/backend/videos/uploads/samplevideos/';

            //@unlink($videopath . $data->video);
            if($this->Samplevideo_model->deletesamplevideo($samplevideo_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The sample video has been deleted.</div>');
                return redirect('admin/samplevideos');
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
            public function title_check($str){
                if (!preg_match('/^[a-zA-Z ]*$/',$str)){
                    $this->form_validation->set_message('title_check', 'This title appears to be invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
    }