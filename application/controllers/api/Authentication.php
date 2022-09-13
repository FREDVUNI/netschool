<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Authentication extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/User_model','User_model');
    }
    public function login_post(){
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');
        $email = strip_tags($this->input->post("email"));
        $password = strip_tags($this->input->post("password"));
     
        if($this->form_validation->run() == TRUE):
            $verify = $this->db->get_where('students',['email' =>$email])->row_array();
            $student_password = password_verify($password,$verify['password']);
            $con["returnType"] = "single";
            $con["conditions"] = array(
                "email" => $email,
                "password" => $student_password,
                "status" => 1,
                "is_active" => 0,
            );
            $student = $this->User_model->get_students($con);
            if($student):
                $this->response([
                    "status" => TRUE,
                    "is_active" => TRUE,
                    "message" => "student login is successful.",
                    "data"    => $student
                ],REST_Controller::HTTP_OK);
            else:
                $this->response("The email address or password seems to be invalid.".$student_password,REST_Controller::HTTP_BAD_REQUEST);
            endif;
        else:
            $message = array(
				'status' => false,
				'error'  => $this->form_validation->error_array(),
				'message'=> validation_errors()
			);
			$this->response($message,REST_Controller::HTTP_NOT_FOUND);
        endif;
    }
    public function registration_post(){
        $this->form_validation->set_rules('firstname','First Name','trim|required');
		$this->form_validation->set_rules('lastname','Last Name','trim|required');
		$this->form_validation->set_rules('email','Email Address','trim|required|is_unique[students.phone]'
        ,array('is_unique' => 'This email address already exists. Please use another one.'));
		$this->form_validation->set_rules('password','Password','trim|required');
		$this->form_validation->set_rules('school','School','trim|required');
		$this->form_validation->set_rules('class','Class','trim|required');
		$this->form_validation->set_rules('phone','Phone number','trim|required|callback_phone_check|max_length[15]|is_unique[students.phone]'
        ,array('is_unique' => 'This phone number already exists. Please enter another one.'));
        
        $firstname = strip_tags($this->post("firstname"));
        $lastname = strip_tags($this->post("lastname"));
        $email = strip_tags($this->post("email"));
        $password = strip_tags($this->post("password"));
        $school = strip_tags($this->post("school"));
        $class = strip_tags($this->post("class"));
        $image = "default.png";
        $phone = strip_tags($this->post("phone"));

        if($this->form_validation->run() == TRUE):
            $con["returnType"] = "count";
            $con["conditions"] = array(
                "email" => $email,
            );
            $student_count = $this->User_model->get_students($con);
            if($student_count  > 0):
                $this->response("This email address is already exists.",REST_Controller::HTTP_BAD_REQUEST);
            else:
                $student_data = array(
                    "firstname" => $firstname,
                    "lastname" => $lastname,
                    "email" => $email,
                    "password" => password_hash($password,PASSWORD_DEFAULT),
                    "school" => $school,
                    "class" => $class,
                    "phone" => $phone,
                    "image" => $image,
                    "is_active" => 0,
                    "status" => 1,
                );
                $this->db->set($student_data);
                $insert = $this->User_model->insert($student_data);

                $token =base64_encode(mt_rand());
                $token_data = array(
                'email' => $email,
                'token' => $token,
                'date_created' =>time()
                );
                $this->db->set($token_data);
                $this->db->insert('user_token', $token_data);
                $this->_sendEmail($token,'verify');
                
                if($insert):
                    $con["returnType"] = "single";
                    $con["conditions"] = array(
                        "email" => $email,
                        "status" => 1
                    );
                    $student = $this->User_model->get_students($con);
                    $this->response([
                        "status" => TRUE,
                        "message" => "student registration has been successful.",
                        "data"    => $student
                    ],REST_Controller::HTTP_OK);
                else:
                    $this->response(
                        "student registration has failed."
                    ,REST_Controller::HTTP_BAD_REQUEST);
                endif;
            endif;
        else:
            $message = array(
				'status' => false,
				'error'  => $this->form_validation->error_array(),
				'message'=> validation_errors()
			);
			$this->response($message,REST_Controller::HTTP_NOT_FOUND);
        endif;
    }
    public function student_get($student_id = 0){
        $con = $student_id?array("student_id" => $student_id):"";
        $student = $this->User_model->get_students($con);
        if(!empty($student)):
            $this->response($student,REST_Controller::HTTP_OK);
        else:
            $this->response([
                "status"  => FALSE,
                "message" =>"No student was found.",
                ],REST_Controller::HTTP_NOT_FOUND);
        endif;
    }
    public function student_put(){
        $student_id = $this->input("student_id");

        $firstname = strip_tags($this->post("firstname"));
        $lastname = strip_tags($this->post("lastname"));
        $email = strip_tags($this->post("email"));
        $school = strip_tags($this->post("school"));
        $class = strip_tags($this->post("class"));
        $image = "default.png";
        $phone = strip_tags($this->post("phone"));

        if(!empty($student_id) && !empty($firstname) && !empty($lastname) && !empty($email) && !empty($school) && !empty($class) && !empty($phone)):
            $student_data = array();
            if(!empty($firstname)):
                $student_data["firstname"] = $firstname;
            endif;
            if(!empty($lastname)):
                $student_data["lastname"] = $lastname;
            endif;
            if(!empty($email)):
                $student_data["email"] = $email;
            endif;
            if(!empty($school)):
                $student_data["school"] = $school;
            endif;
            if(!empty($class)):
                $student_data["class"] = $class;
            endif;
            if(!empty($phone)):
                $student_data["phone"] = $class;
            endif;
            $update = $this->User_model->update($student_data,$student_id);
            if($update):
                $this->response([
                    "status" => TRUE,
                    "message" => "student has been updated.",
                    "data"    => $update
                ],REST_Controller::HTTP_OK);
            else:
                $this->response(
                    "student update has failed."
                ,REST_Controller::HTTP_BAD_REQUEST);
            endif;
        else:
            $this->response(
                "student update has failed."
            ,REST_Controller::HTTP_BAD_REQUEST);
        endif;
    }
    public function verify(){
        $email= $this ->input->get('email');
        $token =$this ->input->get('token');
        $user=$this ->db->get_where('students',['email' =>$email])->row_array();
        
        if($user):
        $user_token=$this ->db->get_where('user_token',['token' =>$token])->row_array();
            if( $user_token):
                if(time() - $user_token['date_created'] < (60*60*24)):
                   $this->db->set('is_active',1);
                   $this->db->where('email',$email);
                   $this->db->update('students');
                   
                   $this->db->delete('user_token',['email'=>$email]);
                   $this->session->set_flashdata('message','
                <div class="alert alert-success" role="alert">
                    '.$email.' has been verified.Welcome to netschool.
                </div>
                ');
                 redirect('student/login');
                else:
                   $this->db->delete('students',['email'=>$email]);
                   $this->db->delete('user_token',['email'=>$email]);
                   
                   $this->session->set_flashdata('message','
                <div class="alert alert-danger" role="alert">
                    Token has expired.
                </div>
                ');
                redirect('student/login');
                
                endif;
            else:
            $this->session->set_flashdata('message','
            <div class="alert alert-danger" role="alert">
                Your account activation has failed.
            </div>
            ');
            redirect('student/login');
            endif;
        else:
            $this->session->set_flashdata('message','
            <div class="alert alert-danger" role="alert">
                Your account activation has failed.
            </div>
            ');
            redirect('student/login');
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

        $mail->setFrom('info@netschool.com', 'NET SCHOOL');
        $mail->addReplyTo('netschool@gmail.com', 'NET SCHOOL');
    
            if($type == 'verify'):
                $mail->addAddress($this->input->post('email'));
                $mail->Subject = 'NET SCHOOL-ACCOUNT ACTIVATION';
                $mail->isHTML(true);

                $mailContent ='
                    <!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><meta name="viewport" content="width=device-width, initial-scale=1"><meta http-equiv="X-UA-Compatible" content="IE=edge" /><style type="text/css">body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}img{-ms-interpolation-mode:bicubic}img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important}@media screen and (max-width:600px){h1{font-size:32px !important;line-height:32px !important}}div[style*="margin: 16px 0;"]{margin:0 !important}</style><style type="text/css"></style></head><body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;"><div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> Account verification</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td bgcolor="#f4f4f4" align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> <a href="http://m.earlcommunications.com" > <img alt="Logo" src="http://m.earlcommunications.com/assets/frontend/img/earl.png" width="169" height="40" style="display: block; width: 169px; max-width: 169px; min-width: 169px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0"> </a></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;"><h1 style="font-size: 28px; font-weight: 400; margin: 0; letter-spacing: 0px;">Verify your account</h1></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">We\'re excited to have you get started. First, you need to confirm your account. Just click the button below.</p></td></tr><tr><td bgcolor="#ffffff" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;"><table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="border-radius: 3px;" > <a data-click-track-id="37" href=" '.base_url().'verify?email=' . $this->input->post('email') .'&token='.urlencode($token).'" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px;background-color:#ED502E; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank"> Activate account </a></tr></table></td></tr></table></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;"></p><p style="margin: 0;">You can also reach us via our <a data-click-track-id="1053" href="https://m.earlcommunications.com/contact-us" style="font-weight: 500; color: #EEB31E" target="_blank">Help Center</a>.</p></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">Cheers, <br>The NET SCHOOL Team</p></td></tr></table></td></tr><tr><td background-color="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;"></td></tr></table></td></tr></table></body></html>
                ';
                $mail->Body = $mailContent;

                if(!$mail->send()):
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                        Your account activation has failed.</div>');
                    redirect('student/register');
                else:
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                        We\'ve sent an email to ' .$this->input->post('email').'.Open it up to activate your account.</div>');
                    redirect('student/register');
                endif;
            endif;
        }
    public function phone_check($str){
		if (!preg_match('/^(?:256|\+256|0)?(7(?:(?:[0127589][0-9])|(?:0[0-8])|(4[0-1]))[0-9]{6})$/',$str)):
			$this->form_validation->set_message('phone_check', 'The phone number is invalid.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
}