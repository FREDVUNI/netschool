<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class User extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/User_model');
            $this->load->model('backend/Payment_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Profile';

             $this->form_validation->set_rules('username','Username','required|trim');
             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this ->load->view('backend/user/profile',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('templates/backend/footer');
             else:
                $id = $this->input->post('id');
                $username=$this->input->post('username');
                $email=$this->input->post('email');
                $image=$this->input->post('image');
                $role_id=$this->input->post('role_id');
                $datetime = date("Y-m-d H:i:s");

                if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/admins/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['file_name'] =$image;
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['user']['image'];
                        if ($old_image != 'default.png') :
                            unlink(FCPATH . './assets/backend/images/uploads/admins/' . $old_image);
                        endif;
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;
                endif;
                $this->db->set('username', $username);
                $this->db->set('role_id', $role_id);
                $this->db->set('date_created',$datetime);
                
                $this->db->where('id', $id);   
                $this->db->update('admins');
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                           Your profile has been updated.</div>');
                redirect(base_url('admin/profile'));
             endif;
        }
        public function users(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Users';

            if(empty($data['user'])):
                return redirect('admin/404');
            endif;
    
            $this->load->view('templates/backend/header',$data);
            $data['users'] = $this->User_model->getusers();
            
            $this ->load->view('backend/user/index',$data);
            $this->load->view('templates/backend/sidebar');
            $this->load->view('templates/backend/footer');
    
        }

        public function register(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Register';
            
            $this->form_validation->set_rules('username','Username','required|trim');
            $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[admins.email]',
                ['is_unique'=>'This email is already registered.']
            );
            $this->form_validation->set_rules('role_id','Role','required|trim');
            $this->form_validation->set_rules('password','Password','required|trim|min_length[8]|matches[confirm]',
                ['matches'=>'The passwords didnot match'],
                ['min_length'=>'The password should atleast be 8 characters long.']
            );
            $this->form_validation->set_rules('confirm','Confirm password','required|trim|matches[password]',
                ['matches'=>'The passwords didnot match']
            );
    
    
            if($this->form_validation->run() == false):
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data["list"] = $this->input->get("role_id");
    
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/user/register',$data);
                $this->load->view('templates/backend/sidebar');
                
                $this->load->view('templates/backend/footer');
            else:
                $email= htmlspecialchars($this->input->post('email'));
                $data=[
                    'username' => htmlspecialchars($this->input->post('username')),
                    'email' => $email,
                    'image' => 'default.png',
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role_id' => $this->input->post('role_id'),
                    'is_active'=>1,
                    'date_created' => date("Y-m-d H:i:s"),
                ];
                //creating the token to be used to verify the email address
                $token =base64_encode(mt_rand());
                $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' =>time()
                ];
            
            $this->db->insert('admins',$data);
            $this->db->insert('user_token', $user_token);
            
            $this->_sendEmail($token,'verify');
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                 The user account has been created.</div>');
                redirect('admin/register');
            endif;
        }
        public function changePassword(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ='Netschoolug | Change password';

            $this->form_validation->set_rules('current','current password','required|trim|min_length[8]',
            ['min_length'=>'The password should atleast be 8 characters long.']
            );
            $this->form_validation->set_rules('new','new password','required|trim|min_length[8]',
            ['min_length'=>'The password should atleast be 8 characters long.']
            );
            $this->form_validation->set_rules('confirm','Confirm password','required|trim|matches[new]',
                ['min_length'=>'The password should atleast be 8 characters long.'],
                ['matches'=>'The new password and confirm password didnot match']
            );

            if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('backend/user/change-password',$data);
                $this->load->view('templates/backend/sidebar');
                    
                $this->load->view('templates/backend/footer');
            else:
                $current = $this->input->post("current");
                $new = $this->input->post("new");
                $datetime = date("Y-m-d H:i:s");

                if(! password_verify($current,$data['user']['password'])):
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                     The current password is wrong.</div>');
                    redirect('admin/change-password');
                else:
                    if($current == $new):
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                         The new password cannot be the same as the current password.</div>');
                        redirect('admin/change-password');
                    else:
                        $hash = password_hash($new,PASSWORD_DEFAULT);

                        $this->db->set('password',$hash);
                        $this->db->set('date_created',$datetime);
                        $this->db->where("email",$this->session->userdata('email'));
                        $this->db->update('admins');

                        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                            Your Password Has Been Changed.</div>');
                        redirect('admin/change-password');
                    endif;
                endif;
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
                       $this->db->update('admins');
                       
                       $this->db->delete('user_token',['email'=>$email]);
                       $this->session->set_flashdata('message','
                    <div class="alert alert-success" role="alert">
                        '.$email.' has been verified.You can login.
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
                        redirect('admin/register');
                    else:
                        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                            We\'ve sent an email to ' .$this->input->post('email').'.Open it up to activate your account.</div>');
                        redirect('admin/register');
                    endif;
                endif;
            }
       
    }