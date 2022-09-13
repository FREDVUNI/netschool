<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Lesson extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Lesson_model');
            $this->load->model('backend/Level_model');
            $this->load->model('backend/Teacher_model');
            $this->load->model('backend/Subject_model');
            $this->load->model('backend/Topic_model');
            $this->load->model('backend/Term_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Lessons';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['lessons'] = $this->Lesson_model->getlessons();
            $this ->load->view('backend/lesson/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }

        public function topicLessons($topicSlug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Lessons';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;

            $theTopic = $this->Topic_model->gettopic($topicSlug);
    
            $this->load->view('templates/backend/header',$data);
            $data['lessons'] = $this->Lesson_model->getlessons(['lessons.topic_id' => $theTopic['topic_id']]);
            $data['theTopic'] = $theTopic;
            $this ->load->view('backend/topic/lessons',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }

        public function store(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create lesson';
            
            $this->form_validation->set_rules('topic','Topic','required|trim|min_length[3]|callback_topic_check');
            $this->form_validation->set_rules('level','Level','required|trim');
            $this->form_validation->set_rules('subject','Subject','required|trim');
            $this->form_validation->set_rules('teacher','Instructor','required|trim');  
            $this->form_validation->set_rules('topic','Topic','required|trim');
            $this->form_validation->set_rules('term','Term','required|trim');
            $this->form_validation->set_rules('subtopic','Subtopic','required|trim');
            $this->form_validation->set_rules('videotitle','Video title','required|trim');
            $this->form_validation->set_rules('video','Video url','required|trim');
            
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                
                $data['lessons'] = $this->Lesson_model->getlessons();
                $data['levels'] = $this->Level_model->getlevels();
                $data['terms'] = $this->Term_model->getterms();
                $data['subjects'] = $this->Subject_model->getsubjects();
                $data['teachers'] = $this->Teacher_model->getteachers();
                $data['topics'] = $this->Topic_model->gettopics();

                $data["level_list"] = $this->input->get("level_id");
                $data["term_list"] = $this->input->get("term_id");
                $data["subject_list"] = $this->input->get("subject_id");
                $data["teacher_list"] = $this->input->get("teacher_id");
                $data["topic_list"] = $this->input->get("topic_id");

                $this->load->view('backend/lesson/store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $topic = $this->db->get_where('topics',['topic_id'=>
                $this->input->post('topic')])->row_array();
                
                $level = $this->db->get_where('levels',['level_id'=>
                $this->input->post('level')])->row_array();
                
                $title = $topic['topic'];
                $topiclevel = $level['level'];
                
                $data=[
                    'topic_id' => htmlspecialchars($this->input->post('topic')),
                    'level_id' => htmlspecialchars($this->input->post('level')),
                    'term_id' => htmlspecialchars($this->input->post('term')),
                    'subject_id' => htmlspecialchars($this->input->post('subject')),
                    'teacher_id' => htmlspecialchars($this->input->post('teacher')),
                    'title' => htmlspecialchars($this->input->post('videotitle')),
                    'video' => htmlspecialchars($this->input->post('video')),
                    'subtopic' => htmlspecialchars($this->input->post('subtopic')),
                    'slug' => $this->generate_slug($this->input->post('videotitle')." ".$topiclevel),
                    'date_created' => date("Y-m-d H:i:s"),
                ];
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/lessons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('image')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['image']['name'] = 'default.png';
                    else:
                        $fileData = $this->upload->data();
                        $data['image'] = "https://console.netschoolug.com/assets/backend/images/uploads/lessons/".$fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    Invalid image.please try again.</div>');
                    return redirect('admin/lesson/create');   
                endif;

                /*if(isset($_FILES['video']['name'])  && $_FILES['video']['name'] != ''):

                    //uploading the video link to the database.
                    $config['upload_path'] = './assets/backend/videos/uploads/lessons/';
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
                    return redirect('admin/lesson/create');   
                endif;*/

            $this->db->insert('lessons',$data);            
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                 Lesson has been created.</div>');
                redirect('admin/lessons');
            endif;
        }

        public function storeTopicLesson($topicSlug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Create lesson';
            $theTopic = $this->Topic_model->gettopic($topicSlug);
            $this->form_validation->set_rules('teacher','Instructor','required|trim');
            $this->form_validation->set_rules('term','Term','required|trim');
            $this->form_validation->set_rules('subtopic','Subtopic','required|trim');
            $this->form_validation->set_rules('videotitle','Video title','required|trim');
            $this->form_validation->set_rules('video','Video url','required|trim');
            
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                $data['terms'] = $this->Term_model->getTerms1(['level_id' => $theTopic['level_id']]);
                $data['teachers'] = $this->Teacher_model->getteachers();
                $data['theTopic'] = $theTopic;

                $this->load->view('backend/topic/lesson_store',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                
                $theLevel = $this->Level_model->getLevel1(['level_id' => $theTopic['level_id']]);
                
                // $title = $topic['topic'];
                $topiclevel = $theLevel['level'];
                
                $data=[
                    'topic_id' => $theTopic['topic_id'],
                    'level_id' => $theTopic['level_id'],
                    'term_id' => htmlspecialchars($this->input->post('term')),
                    'subject_id' => $theTopic['subject_id'],
                    'teacher_id' => htmlspecialchars($this->input->post('teacher')),
                    'title' => htmlspecialchars($this->input->post('videotitle')),
                    'video' => htmlspecialchars($this->input->post('video')),
                    'subtopic' => htmlspecialchars($this->input->post('subtopic')),
                    'slug' => $this->generate_slug($this->input->post('videotitle')." ".$topiclevel),
                    'date_created' => date("Y-m-d H:i:s"),
                ];
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/lessons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('image')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['image']['name'] = 'default.png';
                    else:
                        $fileData = $this->upload->data();
                        $data['image'] = "https://console.netschoolug.com/assets/backend/images/uploads/lessons/".$fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    Invalid image.please try again.</div>');
                    return redirect('admin/lesson/create');   
                endif;

            $this->Lesson_model->addLesson($data);

            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                 Lesson has been created.</div>');
                redirect("admin/$topicSlug/topic/lessons");
            endif;
        }

        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['lesson'] = $this->Lesson_model->getlesson($slug);
            if(empty($data['lesson'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit lesson';
            
            $this->form_validation->set_rules('topic','Topic','required|trim|min_length[3]|callback_topic_check');
            $this->form_validation->set_rules('level','Level','required|trim');
            $this->form_validation->set_rules('subject','Subject','required|trim');
            $this->form_validation->set_rules('teacher','Instructor','required|trim');  
            $this->form_validation->set_rules('topic','Topic','required|trim');
            $this->form_validation->set_rules('term','Term','required|trim');
            $this->form_validation->set_rules('subtopic','Subtopic','required|trim');
            $this->form_validation->set_rules('title','Video title','required|trim');
             $this->form_validation->set_rules('video','Video url','required|trim');

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                
                $data['lessons'] = $this->Lesson_model->getlessons();
                $data['levels'] = $this->Level_model->getlevels();
                $data['terms'] = $this->Term_model->getterms();
                $data['subjects'] = $this->Subject_model->getsubjects();
                $data['teachers'] = $this->Teacher_model->getteachers();
                $data['topics'] = $this->Topic_model->gettopics();

                $data["level_list"] = $this->input->get("level_id");
                $data["subject_list"] = $this->input->get("subject_id");
                $data["teacher_list"] = $this->input->get("teacher_id");
                $data["term_list"] = $this->input->get("term_id");
                $data["topic_list"] = $this->input->get("topic_id");

                $this->load->view('backend/lesson/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $topic = $this->db->get_where('topics',['topic_id'=>
                $this->input->post('topic')])->row_array();
                
                $level = $this->db->get_where('levels',['level_id'=>
                $this->input->post('level')])->row_array();
                
                $titlevideo = $topic['topic'];
                $topiclevel = $level['level'];
                    
                $lesson_id=$this->input->post('lesson_id');
                $topic=$this->input->post('topic');
                $term=$this->input->post('term');
                $title=$this->input->post('title');
                $video=$this->input->post('video');
                $subtopic=$this->input->post('subtopic');
                $level=$this->input->post('level');
                $subject=$this->input->post('subject');
                $instructor=$this->input->post('teacher');
                $slug = $this->generate_slug($title." ".$topiclevel);

                if($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/lessons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['lesson']['image'];
                        if ($old_image != 'default.png') :
                            unlink(FCPATH . './assets/backend/images/uploads/lessons/' . $old_image);
                        endif;
                        $new_image = "https://console.netschoolug.com/assets/backend/images/uploads/lessons/".$this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;   
                endif;

                /*if($_FILES['video']['size'] != 0  || $_FILES['video']['name'] != ''):

                    //uploading the video link to the database.
                    $config['upload_path'] = './assets/backend/videos/uploads/lessons/';
                    $config['max_size'] = '50240';
                    $config['allowed_types'] = 'avi|flv|mkv|mp4|wma';
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $video_name = $_FILES['video']['name'];
                    $config['file_name'] = $video_name;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('video')) :
                        $old_video = $data['lesson']['video'];
                        if ($old_video != 'dubai.mp4') :
                            unlink(FCPATH . './assets/backend/videos/uploads/lessons/' . $old_video);
                        endif;
                        $new_video = $this->upload->data('file_name');
                        $this->db->set('video', $new_video);
                    else :
                        echo $this->upload->display_errors();
                    endif; 
                endif;*/
                
                $datetime = date("Y-m-d H:i:s");
                $this->db->set('topic_id',$topic);
                $this->db->set('level_id',$level);
                $this->db->set('subject_id',$subject);
                $this->db->set('term_id',$term);
                $this->db->set('subtopic',$subtopic);
                $this->db->set('teacher_id',$instructor);
                $this->db->set('title',$title);
                $this->db->set('video',$video);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('lesson_id',$lesson_id);

                $this->db->update("lessons");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The lesson has been updated.</div>');
                return redirect('admin/lessons');
            endif;
        }

        public function editTopicLesson($topicSlug, $lessonSlug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $theTopic = $this->Topic_model->gettopic($topicSlug);
            $theLesson = $this->Lesson_model->getlesson($lessonSlug);

            if(empty($theLesson)):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit lesson';

            $this->form_validation->set_rules('teacher','Instructor','required|trim');
            $this->form_validation->set_rules('term','Term','required|trim');
            $this->form_validation->set_rules('subtopic','Subtopic','required|trim');
            $this->form_validation->set_rules('title','Video title','required|trim');
            $this->form_validation->set_rules('video','Video url','required|trim');

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                
                $data['terms'] = $this->Term_model->getterms();
                $data['teachers'] = $this->Teacher_model->getteachers();
                $data['theTopic'] = $theTopic;
                $data['lesson'] = $theLesson;

                $this->load->view('backend/topic/lesson_edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $theLevel = $this->Level_model->getLevel1(['level_id' => $theTopic['level_id']]);
                
                // $title = $topic['topic'];
                $topiclevel = $theLevel['level'];
                    
                $term=$this->input->post('term');
                $title=$this->input->post('title');
                $video=$this->input->post('video');
                $subtopic=$this->input->post('subtopic');
                $instructor=$this->input->post('teacher');
                $slug = $this->generate_slug($title." ".$topiclevel);

                if($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/lessons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['lesson']['image'];
                        if ($old_image != 'default.png') :
                            unlink(FCPATH . './assets/backend/images/uploads/lessons/' . $old_image);
                        endif;
                        $new_image = "https://console.netschoolug.com/assets/backend/images/uploads/lessons/".$this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;   
                endif;
                
                $datetime = date("Y-m-d H:i:s");
                $this->Lesson_model->updateLesson($theLesson['lesson_id'], [
                    'term_id'       => $term,
                    'subtopic'      => $subtopic,
                    'teacher_id'    => $instructor,
                    'title'         => $title,
                    'video'         => $video,
                    'slug'          => $slug,
                    'date_created'  => $datetime
                ]);
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The lesson has been updated.</div>');
                return redirect("admin/$topicSlug/topic/lessons");
            endif;
        }

        public function delete($lesson_id){
            $data = $this->Lesson_model->get_lesson($lesson_id);
            $imagepath = './assets/backend/images/uploads/lessons/';
            //$videopath = './assets/backend/videos/uploads/lessons/';

            @unlink($imagepath . $data->image);
            //@unlink($videopath . $data->video);
            if($this->Lesson_model->deletelesson($lesson_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The lesson has been deleted.</div>');
                return redirect('admin/lessons');
            endif;
        }

        public function deleteTopicLesson($topicSlug, $lesson_id){
            $data = $this->Lesson_model->get_lesson($lesson_id);
            $imagepath = './assets/backend/images/uploads/lessons/';
            //$videopath = './assets/backend/videos/uploads/lessons/';

            @unlink($imagepath . $data->image);
            //@unlink($videopath . $data->video);
            if($this->Lesson_model->deletelesson($lesson_id)):
                
                $this->rearrangeLessons($topicSlug);

                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The lesson has been deleted.</div>');
                return redirect("admin/$topicSlug/topic/lessons");
            endif;
        }

        public function moveUp($topicSlug, $lesson_id)
        {
            $theLesson = $this->Lesson_model->getLesson1(['lesson_id' => $lesson_id]);

            $lesserLesson = $this->Lesson_model->getLesson1([
                'topic_id' => $theLesson['topic_id'],
                'lesson_order' => $theLesson['lesson_order'] - 1
            ]);

            if($lesserLesson){
                $this->Lesson_model->updateLesson(
                    $lesserLesson['lesson_id'],
                    ['lesson_order' => $lesserLesson['lesson_order'] + 1]
                );

                $this->Lesson_model->updateLesson(
                    $theLesson['lesson_id'],
                    ['lesson_order' => $theLesson['lesson_order'] - 1]
                );
            }

            return redirect("admin/$topicSlug/topic/lessons");
        }

        public function moveDown($topicSlug, $lesson_id)
        {
            $theLesson = $this->Lesson_model->getLesson1(['lesson_id' => $lesson_id]);

            $greaterLesson = $this->Lesson_model->getLesson1([
                'topic_id' => $theLesson['topic_id'],
                'lesson_order' => $theLesson['lesson_order'] + 1
            ]);

            if($greaterLesson){
                $this->Lesson_model->updateLesson(
                    $greaterLesson['lesson_id'],
                    ['lesson_order' => $greaterLesson['lesson_order'] - 1]
                );

                $this->Lesson_model->updateLesson(
                    $theLesson['lesson_id'],
                    ['lesson_order' => $theLesson['lesson_order'] + 1]
                );
            }
            
            return redirect("admin/$topicSlug/topic/lessons");
        }

        private function rearrangeLessons($topicSlug){
            $theTopic = $this->Topic_model->gettopic($topicSlug);

            $lessons = $this->Lesson_model->getlessons(['lessons.topic_id' => $theTopic['topic_id']]);

            foreach ($lessons as $key => $lesson) {
                $this->Lesson_model->updateLesson($lesson['lesson_id'], ['lesson_order' => $key+1]);
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

        public function topic_check($str){
            if (!preg_match('/^[a-zA-Z ]*$/',$str)){
                $this->form_validation->set_message('topic_check', 'This topic appears to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
    }