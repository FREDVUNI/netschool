<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use SendGrid\Mail\Mail;
    class Auth extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->helper('text');
            $this->load->model("backend/User_model");
           
        }
        public function index(){
	        $this->form_validation->set_rules('email','Email','required|trim|valid_email');
	        $this->form_validation->set_rules('password','Password','required|trim');

	        if($this->form_validation->run() == false):
	            $this->load->view('backend/login');
	        else:
	           $this->_login();
	        endif;
        }
        private function _login(){
            $email = $this->input->post('email');
            $password =$this->input->post('password');
            $remember_me = $this->input->post('remember_me', true);
    
            $admins =$this->db->get_where('admins',['email' => $email])->row_array();
            if($admins):
            if($admins['is_active'] == 1):
                if(password_verify($password,$admins['password'])):
                    $data =[
                        'email' => $admins['email'],
                        'role_id' =>$admins['role_id'],
                    ];
                    $this->session->set_userdata($data);
                    redirect('admin/index');
                else:
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong Email Password combination.</div>');
                    redirect('admin/login');
                endif;
            else:
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email Address has not been activated.</div>');
                redirect('admin/login');
            endif;
            if ($remember_me == 1):
                $this->User_model->remember_me($admins["id"]);
            endif;
        else:
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong Email Password combination.</div>');
            redirect('admin/login');
        endif;
    }
    public function forgotpassword(){
        $this->form_validation->set_rules('email','Email','required|trim|valid_email');

	    if($this->form_validation->run() == false):
            $this->load->view('backend/forgot-password');
	    else:
	        $email = $this->input->post('email');
            $user = $this->db->get_where('admins',['email' =>$email])->row_array();
                if($user):
                    $token =base64_encode(mt_rand());
                    $user_token = [
                        'email' => $email,
                        'token' => $token,
                        'date_created' =>time()
                        ];
                    $this->db->insert('user_token', $user_token);
                    $this->_sendEmail($token,'forgot');
                    
                    $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
                    A link has been sent to email address "'.$email.'" .You can reset your password.Please check your email to reset your password.</div>');
                else:
                    $this->session->set_flashdata('message','<div class="alert alert-danger role="alert">
                     The email address '.$email.'
                    doesnot seem to be registered or activated.</div>');
                    return redirect('admin/forgot-password');
                endif;
	    endif;
        
    }
    public function resetpassword(){
        $email= $this ->input->get('email');
        $token =$this ->input->get('token');
        $user=$this ->db->get_where('admins',['email' =>$email])->row_array();
            
        if(!$user) {
            $this->session->set_flashdata('message','
            <div class="alert alert-danger" role="alert">Your password reset has failed.</div>
            ');
            redirect('admin/login');
        }

        $user_token=$this ->db->get_where('user_token',['token' =>$token])->row_array();
        if( ! $user_token){
            $this->session->set_flashdata('message','
            <div class="alert alert-danger" role="alert"><Span class="fas fa-times-circle"></span> 
            Your password reset has failed.</div>
            ');
            redirect('admin/login');
        }

        $this->session->set_userdata('reset_email',$email);
        $this->changePassword();
    }

    public function changePassword(){
        if(!$this->session->userdata('reset_email')):
            redirect('admin/login');
        endif;

        if (!$this->input->post()) {
            $this->load->view('backend/reset-password');
        } else {
            $query = $this->input->post();
            
            $this->form_validation->set_rules(
                'password',
                'Password',
                'required|min_length[8]',
                ['min_length' =>'password should be atleast 8 characters.']
            );

			if ($this->form_validation->run()) {
                $password = password_hash($query['password'], PASSWORD_DEFAULT);
                $email = $this->session->userdata('reset_email');
                $this->User_model->updateUsers(['email' => $email], ['password' => $password]);

                $this->session->unset_userdata('reset_email');

                $this->session->set_flashdata('message','
                    <div class="alert alert-success" role="alert"><Span class="fas fa-check-circle"></span> Your password has been reset successfully. You can now login.</div>
                ');
                // $this->User_model->deleteToken(['token' => $token]);
                redirect('admin/login');

            } else {
                $this->load->view('backend/reset-password');
            }
        }
    }
    // private function _sendEmail($token,$type){
    //     require_once(APPPATH.'libraries/mailer/mailer_config.php');
    //     $this->load->library('phpmailer_lib');
    //     $mail = $this->phpmailer_lib->load();

    //     $mail->isSMTP();
    //     $mail->Host     = HOST;
    //     $mail->SMTPAuth = true;
    //     $mail->Username = GUSER;
    //     $mail->Password = GPWD;
    //     $mail->SMTPSecure = 'ssl';
    //     $mail->Port     = PORT;
    //     $mail->setFrom('info@netschool.com', 'NET SCHOOL UG');
    //     $mail->addReplyTo('netschool@gmail.com', 'NET SCHOOL UG');
        
    //         if($type == 'forgot'):
    //             $mail->addAddress($this->input->post('email'));
    //             $mail->Subject = 'NET SCHOOL UG-RESET ADMIN PASSWORD';
    //             $mail->isHTML(true);
    //             $mailContent = '
    //                 <!DOCTYPE html><html><head><title></title><meta name="viewport" content="width=device-width, initial-scale=1"><meta http-equiv="X-UA-Compatible" content="IE=edge" /><style type="text/css">body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}img{-ms-interpolation-mode:bicubic}img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important}@media screen and (max-width:600px){h1{font-size:32px !important;line-height:32px !important}}div[style*="margin: 16px 0;"]{margin:0 !important}</style><style type="text/css"></style></head><body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;"><div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> Account verification</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td bgcolor="#f4f4f4" align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> <a href="http://m.thedeliveryguyug.com" > <img alt="Logo" src="http://m.thedeliveryguyug.com/assets/frontend/img/earl.png" width="169" height="40" style="display: block; width: 169px; max-width: 169px; min-width: 169px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0"> </a></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;"><h1 style="font-size: 28px; font-weight: 400; margin: 0; letter-spacing: 0px;">Reset your password</h1></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">You are receiving this e-mail because you have requested a password reset on your Earl account. Just click the button below to reset your password.</p></td></tr><tr><td bgcolor="#ffffff" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;"><table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="border-radius: 3px;" > <a data-click-track-id="37" href=" '.base_url().'reset-password?email=' . $this->input->post('email') .'&token='.urlencode($token).'" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px;background-color:#ED502E; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank"> Reset password </a></tr></table></td></tr></table></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;"></p><p style="margin: 0;">You can also reach us via our <a data-click-track-id="1053" href="https://m.thedeliveryguyug.com/contact-us" style="font-weight: 500; color: #EEB31E" target="_blank">Help Center</a>.</p></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">Cheers, <br>The Earl communications Team</p></td></tr></table></td></tr><tr><td background-color="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;"></td></tr></table></td></tr></table></body></html>

    //             ';
    //             $mail->Body = $mailContent;

    //             if(!$mail->send()):
    //                 $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert"><Span class="fas fa-check-circle"></span> Your password reset has failed.</div>');
    //                 redirect('admin/forgot-password');
    //             else:
    //                 $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"><Span class="fas fa-check-circle"></span> We\'ve sent an email to ' .$this->input->post('email').'.Open it up to reset password.</div>');
    //                 redirect('admin/forgot-password');
    //             endif;
    //         endif;
    // }

    private function _sendEmail($token, $type)
    {
        if($type == 'forgot'){
            $email = new Mail();
            $email->setFrom("info@netschool.com", "NET SCHOOL UG");
            $email->setSubject("NET SCHOOL UG-RESET ADMIN PASSWORD");
            $email->addTo($this->input->post('email'));
            $mailContent = '
                    <!DOCTYPE html><html><head><title></title><meta name="viewport" content="width=device-width, initial-scale=1"><meta http-equiv="X-UA-Compatible" content="IE=edge" /><style type="text/css">body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}img{-ms-interpolation-mode:bicubic}img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important}@media screen and (max-width:600px){h1{font-size:32px !important;line-height:32px !important}}div[style*="margin: 16px 0;"]{margin:0 !important}</style><style type="text/css"></style></head><body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;"><div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> Account verification</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td bgcolor="#f4f4f4" align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> <a href="http://m.thedeliveryguyug.com" > <img alt="Logo" src="http://m.thedeliveryguyug.com/assets/frontend/img/earl.png" width="169" height="40" style="display: block; width: 169px; max-width: 169px; min-width: 169px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0"> </a></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;"><h1 style="font-size: 28px; font-weight: 400; margin: 0; letter-spacing: 0px;">Reset your password</h1></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">You are receiving this e-mail because you have requested a password reset on your Netschool UG Admin account. Just click the button below to reset your password.</p></td></tr><tr><td bgcolor="#ffffff" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;"><table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="border-radius: 3px;" > <a data-click-track-id="37" href=" '.base_url().'admin/reset-password?email=' . $this->input->post('email') .'&token='.urlencode($token).'" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px;background-color:#ED502E; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank"> Reset password </a></tr></table></td></tr></table></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;"></p><p style="margin: 0;">You can also reach us via our <a data-click-track-id="1053" href="https://m.thedeliveryguyug.com/contact-us" style="font-weight: 500; color: #EEB31E" target="_blank">Help Center</a>.</p></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">Cheers, <br>The Earl communications Team</p></td></tr></table></td></tr><tr><td background-color="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;"></td></tr></table></td></tr></table></body></html>

                ';

            $email->addContent("text/html", $mailContent);

            $sendgrid = new \SendGrid('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');

            try {
                $response = $sendgrid->send($email);
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";

                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"><Span class="fas fa-check-circle"></span> We\'ve sent an email to ' .$this->input->post('email').'.Open it up to reset password.</div>');
                redirect('admin/forgot-password');

            } catch (Exception $e) {
                // echo 'Caught exception: '. $e->getMessage() ."\n";

                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert"><Span class="fas fa-check-circle"></span> Your password reset has failed.</div>');
                redirect('admin/forgot-password');
            }
        }
    }

    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message','<div class="alert alert-success role="alert">
        You have been logged out!</div>');
        return redirect('admin/login');
    }
    } 