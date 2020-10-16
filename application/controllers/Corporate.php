<?php


class Corporate extends CI_Controller
{


	public function __construct()
	{


		parent::__construct();
		$session_data = $this->session->userdata('users');
		$this->session_data = $session_data;
	}

	public function index()
	{
		$this->load->view('corporate');
	}

	public function add()
	{

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('message', 'Enquiry', 'required');

		if ($this->form_validation->run() == FALSE) {
			$error = validation_errors();
			$this->session->set_flashdata('error', $error);
			redirect('contact');
		}

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$msg = $this->input->post('message');
		$createdAt = date('Y-m-d H:i:s');


		// send email
		$to = 'davidmark0772@gmail.com';
		$subject = 'Corporate Message';
		$email_data['message'] = $msg . '<br><br>' . '<p style="text-align: left;">Name: ' . $name . '<br>Email: ' . $email . '<br>Phone: ' . $phone . '</p>';
		$message = $this->load->view('emails/corporate', $email_data, true);
		$this->smtp_email->send('', '', $to, $subject, $message);


		$data['name'] = $name;
		$data['email'] = $email;
		$data['phone'] = $phone;
		$data['message'] = $msg;
		$data['type'] = 'corporate';
		$data['createdAt'] = date('Y-m-d H:i:s');

		$this->db->insert("contact_us", $data);
		$this->session->set_flashdata('success', 'Your message has been sent successfully');
		redirect('corporate');
	}

	public function load_temp()
	{
		$email_data['message'] = 'hi admin! here is test message <br><br>' . '<p style="text-align: left;">Name: david <br>Email: dfgdf@gdfmg.vom <br>Phone: gdfdg</p>';
		$this->load->view('emails/corporate', $email_data);
	}
}
