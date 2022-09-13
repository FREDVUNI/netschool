<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Subject extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Subject_model');
            $this->load->model('backend/Level_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Subjects';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['subjects'] = $this->Subject_model->getSubjects1();
            
            $this ->load->view('backend/subject/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create subject';
            $this->form_validation->set_rules('subject','subject name','required|trim');  
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/subject/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $subject_id = $this->input->post("level");
                
                $subject = $this->db->get_where('levels',['level_id'=>
                $subject_id])->row_array();
                
                $data=[
                    'subject' => htmlspecialchars($this->input->post('subject')),
                    'slug' =>   $this->generate_slug($subject['level']." ".$this->input->post('subject')),
                    'date_created' => date("Y-m-d H:i:s"),
                ];
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/subjects/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('image')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['image']['name'] = 'noimage.png';
                    else:
                        $fileData = $this->upload->data();
                        $data['image'] = "https://console.netschoolug.com/assets/backend/images/uploads/subjects/".$fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    Invalid image.please try again.</div>');
                    return redirect('admin/subject/store');   
                endif;
                $subject_l = $data['slug'];
                $subject_level = $this->db->get_where('subjects',['slug'=>
                $subject_l])->row_array();
                if(!$subject_level):
                    $this->db->insert('subjects',$data);
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                    subject has been created.</div>');
                    redirect('admin/subjects');
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    This subject already exists at this level.</div>');
                    return redirect('admin/subject/store');  
                endif;
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['subject'] = $this->Subject_model->getSubject1(['slug' => $slug]);
            if(empty($data['subject'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit subject';
            
            $this->form_validation->set_rules('subject','subject','required|trim');    

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                
                $this->load->view('backend/subject/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $s = $this->input->post("level");
                
                $subjectlevel = $this->db->get_where('levels',['level_id'=>
                $s])->row_array();
                
                $subject_id=$this->input->post('subject_id');
                $subject=$this->input->post('subject');
                $slug = $this->generate_slug($this->generate_slug($this->input->post('subject')));
                $datetime = date("Y-m-d H:i:s");
                
                if($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/subjects/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['subject']['image'];
                        if ($old_image != 'noimage.png') :
                            unlink(FCPATH . './assets/backend/images/uploads/subjects/' . $old_image);
                        endif;
                        $new_image = "https://console.netschoolug.com/assets/backend/images/uploads/subjects/".$this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;   
                endif;

                $this->db->set('subject',$subject);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('subject_id',$subject_id);

                $this->db->update("subjects");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The subject has been updated.</div>');
                return redirect('admin/subjects');
            endif;
        }
        public function delete($subject_id){
            $data = $this->Subject_model->get_subject($subject_id);
            $imagepath = './assets/backend/images/uploads/subjects/';

            @unlink($imagepath . $data->image);
            if($this->Subject_model->deletesubject($subject_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The subject has been deleted.</div>');
                return redirect('admin/subjects');
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