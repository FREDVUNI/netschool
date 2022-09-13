<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Teacher extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Teacher_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Teachers';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['teachers'] = $this->Teacher_model->getteachers();
            
            $this ->load->view('backend/teacher/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
        }
        public function status(){
            $data['teachers'] = $this->Teacher_model->getteachers();
            if(empty($data['teachers'])):
                return redirect('admin/404');
            endif;
            $teacher_id=$this->input->post('teacher_id');
            $status=$this->input->post('status');

            $this->db->set('status',$status);
            $this->db->where('teacher_id',$teacher_id);

            $this->db->update('teachers');
            $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                The teacher\'s status has been changed.</div>');
            redirect(base_url('admin/teachers'));
        }
        public function register(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Register Teacher';
            
            $this->form_validation->set_rules('firstname','First name','required|trim|min_length[3]|callback_name_check');
            $this->form_validation->set_rules('lastname','Last name','required|trim|callback_name_check');
            $this->form_validation->set_rules('phone','Phone number','required|callback_phone_check|is_unique[teachers.phone]',
            ['is_unique'=>'This phone number is already taken.']
            );
            $this->form_validation->set_rules('school','School name','trim');
            $this->form_validation->set_rules('subjects','Subjects','required|trim');
            $this->form_validation->set_rules('about','About teacher','required|trim');
            $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[teachers.email]',
                ['is_unique'=>'This email is already registered.']
            );    
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/teacher/register',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $email= htmlspecialchars($this->input->post('email'));
                $data=[
                    'firstname' => htmlspecialchars($this->input->post('firstname')),
                    'lastname' => htmlspecialchars($this->input->post('lastname')),
                    'school' => htmlspecialchars($this->input->post('school')),
                    'subjects' => htmlspecialchars($this->input->post('subjects')),
                    'about' => htmlspecialchars($this->input->post('about')),
                    'phone' => htmlspecialchars($this->input->post('phone')),
                    'email' => $email,
                    'is_active'=>0,
                    'slug' => $this->generate_slug($this->input->post('lastname')),
                    'date_created' => date("Y-m-d H:i:s"),
                ];
                if($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/teachers/';
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
                        $data['image'] = $fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    Invalid image.please try again.</div>');
                    return redirect('admin/teacher/create');   
                endif;

                //creating the token to be used to verify the email address
                $token =base64_encode(mt_rand());
                $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' =>time()
                ];
            
            $this->db->insert('teachers',$data);
            $this->db->insert('user_token', $user_token);
            
            $this->_sendEmail($token,'verify');
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                 Teacher account has been created.</div>');
                redirect('admin/teachers');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['teacher'] = $this->Teacher_model->getteacher($slug);
            if(empty($data['teacher'])):
                return redirect('admin/404');
            endif;

            $data['title'] ='Netschoolug | Edit Teacher';
            
            $this->form_validation->set_rules('firstname','First name','required|trim|min_length[3]|callback_name_check');
            $this->form_validation->set_rules('lastname','Last name','required|trim|callback_name_check');
            $this->form_validation->set_rules('phone','Phone number','required|callback_phone_check');
            $this->form_validation->set_rules('school','School name','trim');
            $this->form_validation->set_rules('subjects','Subjects','required|trim');
            $this->form_validation->set_rules('about','About teacher','required|trim');
            $this->form_validation->set_rules('email','Email','required|trim');   

            if($this->form_validation->run() == FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/teacher/edit',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $teacher_id=$this->input->post('teacher_id');
                $firstname=$this->input->post('firstname');
                $lastname=$this->input->post('lastname');
                $email=$this->input->post('email');
                $phone=$this->input->post('phone');
                $school=$this->input->post('school');
                $about=$this->input->post('about');
                $subjects=$this->input->post('subjects');
                $slug = $this->generate_slug($this->input->post('firstname')." ".$this->input->post('lastname'));
                $datetime = date("Y-m-d H:i:s");

                if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/teachers/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['file_name'] =$image;
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['teacher']['image'];
                        if ($old_image != 'default.png') :
                            unlink(FCPATH . './assets/backend/images/uploads/teachers/' . $old_image);
                        endif;
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;
                endif;

                $this->db->set('firstname',$firstname);
                $this->db->set('lastname',$lastname);
                $this->db->set('email',$email);
                $this->db->set('phone',$phone);
                $this->db->set('school',$school);
                $this->db->set('subjects',$subjects);
                $this->db->set('about',$about);
                $this->db->set('slug',$slug);
                $this->db->set('date_created',$datetime);
                $this->db->where('teacher_id',$teacher_id);

                $this->db->update("teachers");
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The teacher has been updated.</div>');
                return redirect('admin/teachers');
            endif;
        }
        public function delete($teacher_id){
            $data = $this->Teacher_model->get_teacher($teacher_id);
            $path = './assets/backend/images/uploads/teachers/';

            @unlink($path . $data->image);
            if($this->Teacher_model->deleteteacher($teacher_id)):
                $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    The teacher has been deleted.</div>');
                return redirect('admin/teachers');
            endif;
        }
        public function verify(){
            $email= $this ->input->get('email');
            $token =$this ->input->get('token');
            $user=$this ->db->get_where('admins',['email' =>$email])->row_array();
            
            if($user):
            $user_token=$this ->db->get_where('user_token',['token' =>$token])->row_array();
                if( $user_token):
                    if(time() - $user_token['date_created'] < (60*60*24)):
                       $this->db->set('is_active',1);
                       $this->db->where('email',$email);
                       $this->db->update('teachers');
                       
                       $this->db->delete('user_token',['email'=>$email]);
                       $this->session->set_flashdata('message','
                    <div class="alert alert-success" role="alert">
                        '.$email.' has been verified.Welcome to netschoolug.
                    </div>
                    ');
                     redirect('admin/login');
                    else:
                       $this->db->delete('admins',['email'=>$email]);
                       $this->db->delete('user_token',['email'=>$email]);
                       
                       $this->session->set_flashdata('message','
                    <div class="alert alert-danger" role="alert">
                        Token has expired.
                    </div>
                    ');
                    redirect('admin/login');
                    
                    endif;
                else:
                $this->session->set_flashdata('message','
                <div class="alert alert-danger" role="alert">
                    Your account activation has failed.
                </div>
                ');
                redirect('admin/login');
                endif;
            else:
                $this->session->set_flashdata('message','
                <div class="alert alert-danger" role="alert">
                    Your account activation has failed.
                </div>
                ');
                redirect('admin/login');
            endif;
        }
        private function _sendEmail($token,$type){
            require_once(APPPATH.'libraries/mailer/mailer_config.php');
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();

            $mail->isSMTP();
            $mail->Host     = HOST;
            $mail->SMTPAuth = true;
            $mail->Username = GUSER;
            $mail->Password = GPWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port     = PORT;

            $mail->setFrom('info@netschoolug.com', 'NET SCHOOL UG');
            $mail->addReplyTo('netschoolug@gmail.com', 'NET SCHOOL UG');
        
                if($type == 'verify'):
                    $mail->addAddress($this->input->post('email'));
                    $mail->Subject = 'NET SCHOOL UG-ACCOUNT ACTIVATION';
                    $mail->isHTML(true);
    
                    $mailContent ='
                        <!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><meta name="viewport" content="width=device-width, initial-scale=1"><meta http-equiv="X-UA-Compatible" content="IE=edge" /><style type="text/css">body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}img{-ms-interpolation-mode:bicubic}img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important}@media screen and (max-width:600px){h1{font-size:32px !important;line-height:32px !important}}div[style*="margin: 16px 0;"]{margin:0 !important}</style><style type="text/css"></style></head><body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;"><div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> Account verification</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td bgcolor="#f4f4f4" align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> <a href="http://m.earlcommunications.com" > <img alt="Logo" src="http://m.earlcommunications.com/assets/frontend/img/earl.png" width="169" height="40" style="display: block; width: 169px; max-width: 169px; min-width: 169px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0"> </a></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;"><h1 style="font-size: 28px; font-weight: 400; margin: 0; letter-spacing: 0px;">Verify your account</h1></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">We\'re excited to have you get started. First, you need to confirm your account. Just click the button below.</p></td></tr><tr><td bgcolor="#ffffff" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;"><table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="border-radius: 3px;" > <a data-click-track-id="37" href=" '.base_url().'verify?email=' . $this->input->post('email') .'&token='.urlencode($token).'" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px;background-color:#ED502E; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank"> Activate account </a></tr></table></td></tr></table></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;"></p><p style="margin: 0;">You can also reach us via our <a data-click-track-id="1053" href="https://m.earlcommunications.com/contact-us" style="font-weight: 500; color: #EEB31E" target="_blank">Help Center</a>.</p></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">Cheers, <br>The NET SCHOOL Team</p></td></tr></table></td></tr><tr><td background-color="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;"></td></tr></table></td></tr></table></body></html>
                    ';
                    $mail->Body = $mailContent;
    
                    if(!$mail->send()):
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                            Your account activation has failed.</div>');
                        redirect('admin/teachers');
                    else:
                        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                            We\'ve sent an email to ' .$this->input->post('email').'.Open it up to activate your account.</div>');
                        redirect('admin/register');
                    endif;
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
            public function phone_check($str){
                if (!preg_match('/^(?:256|\+256|0)?(7(?:(?:[0127589][0-9])|(?:0[0-8])|(4[0-1]))[0-9]{6})$/',$str)){
                    $this->form_validation->set_message('phone_check', 'The phone number is invalid.');
                    return FALSE;
                }else{
                    return TRUE;
                }
            }
            public function name_check($str){
                if (!preg_match('/^[a-zA-Z ]*$/',$str)){
                    $this->form_validation->set_message('name_check', 'This name appears to be invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
    }