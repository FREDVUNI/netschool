<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notice extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->library(['pagination', 'form_validation']);
		$this->load->model(['Notice_model']);
		$this->load->model('backend/Payment_model');
    }

	public function index()
	{
        $user = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

        if(empty($user)):
            return redirect('admin/404');
        endif;
		
		$this->data['title'] ='Netschoolug | Notices';
		$this->data['user'] = $user;
        $this->data['notices'] = $this->Notice_model->getNotices();
        
        $this->load->view('templates/backend/header', $this->data);
        $this->load->view('backend/notice/index', $this->data);
        $this->load->view('templates/backend/sidebar');
        $this->load->view('templates/backend/footer');
	}

	public function store(){
		$this->data['user'] = $this->db->get_where('admins',['email'=>
		$this->session->userdata('email')])->row_array();

		$this->data['title'] ='Netschoolug | Create notice';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		$this->form_validation->set_rules('expires_on', 'Expiry Date', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('templates/backend/header', $this->data);
			$this->load->view('backend/notice/store', $this->data);
			$this->load->view('templates/backend/sidebar');
			$this->load->view('templates/backend/footer');
		} else {
			$query = $this->input->post();

			$this->Notice_model->addNotice([
				'title' 		=> $query['title'],
				'body' 			=> $query['body'],
				'expires_on' 	=> $query['expires_on']
			]);

			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Notice has been created.</div>');
			redirect('admin/notices');
		}
	}

	public function edit($noticeId){
		$user = $this->db->get_where('admins',['email'=>
		$this->session->userdata('email')])->row_array();

		$notice = $this->Notice_model->getNotice(['id' => $noticeId]);

		if(empty($notice)):
			return redirect('admin/404');
		endif;

		$this->data['title'] ='Netschoolug | Edit notice';
		$this->data['user'] = $user;
		$this->data['notice'] = $notice;
		
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		$this->form_validation->set_rules('expires_on', 'Expiry Date', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('templates/backend/header',$this->data);
			$this->load->view('backend/notice/edit',$this->data);
			$this->load->view('templates/backend/sidebar');
			
			$this->load->view('templates/backend/footer');
		} else {
			$query = $this->input->post();

			$this->Notice_model->editNotice($noticeId, [
				'title' => $query['title'],
				'body' => $query['body'],
				'expires_on' => $query['expires_on']
			]);
			$this->session->set_flashdata('message','<div class="alert alert-success role="alert">
				The notice has been updated.</div>');
			return redirect('admin/notices');
		}
	}

	public function delete($noticeId){
		if($this->Notice_model->deleteNotice(['id' => $noticeId])):
			$this->session->set_flashdata('message','<div class="alert alert-success role="alert">
				The Notice has been deleted.</div>');
			return redirect('admin/notices');
		endif;
	}
}
