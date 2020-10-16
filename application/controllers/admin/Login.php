<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Login extends CI_Controller
{



    public function __construct()
    {

        parent::__construct();
        $sess_data = $this->session->userdata('admin');

        if (isset($sess_data->adminID)) {
            redirect('admin/home');
        }
    }



    public function index()
    {

        $this->data['page_title'] = "login - Admin";
        $this->load->view('admin/login', $this->data);
    }



    public function login_access()
    {

        $this->data['page_title'] = "login - Admin ";
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = array();
            $response['code'] = 0;
            $response['message'] = validation_errors();
            echo json_encode($response);
            exit();
        } else {

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where('emailID', $email);
            $this->db->where('password', MD5($password));
            $this->db->limit(1);
            $query = $this->db->get();

            if ($query->num_rows() >= 1) {

                $sess_data = $query->row();

                if ($sess_data->adminStatus  != 'Active') {

                    $response = array();
                    $response['code'] = 0;
                    $response['message'] = 'Admin Inactive, Please Contact Administrator';
                    echo json_encode($response);
                    exit();
                }

                $this->session->set_userdata(array('admin' => $sess_data));
                $data_array = array('lastLogin' => date('Y-m-d H:i:s'));
                $this->db->where('emailID', $email);
                $this->db->update('admin', $data_array, array('emailID' => $email));

                // county session //            

                $response = array();
                $response['code'] = 1;
                $response['message'] = 'Successful Login';
                echo json_encode($response);
                exit();
            } else {

                $response = array();
                $response['code'] = 0;
                $response['message'] = 'Incorrect Email Or Password';
                echo json_encode($response);
                exit();
            }
        }
    }



    public function forgot()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {

            $response = array();
            $response['code'] = 0;
            $response['message'] = validation_errors();
            echo json_encode($response);
            exit();
        } else {

            $email = $this->input->post('email');
            $query = $this->db->query("SELECT * FROM admin WHERE emailID='" . $email . "'");

            if ($query->num_rows() < 1) {

                $response = array();
                $response['code'] = 0;
                $response['message'] = 'Email does not exist';
                echo json_encode($response);
                exit();
            } else {

                $pass_code = (uniqid());
                $this->db->set('passwordResetToken', $pass_code);
                $this->db->where('emailID', $email);
                $this->db->update('admin');

                // email //                 
                $to = $email;
                $subject = 'Reset Password';
                $message = 'Your New Password Renewal Link is ' . base_url() . 'admin/login/update_password/' . $pass_code;

                $this->smtp_email->send('', '', $to, $subject, $message);

                $response = array();
                $response['code'] = 1;
                $response['message'] = 'Password Change Link has been sent to your email';
                echo json_encode($response);
                exit();
            }
        }
    }



    public function update_password()
    {

        $this->data['page_title'] = 'Update password';

        if ($this->uri->segment(4)) {

            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where('passwordResetToken', $this->uri->segment(4));
            $this->db->limit(1);
            $query = $this->db->get();

            if ($query->num_rows() == 0) {

                redirect('admin/login');
                exit();
            }

            $this->data['pass_code'] = $this->uri->segment(4);
            $this->load->view('admin/update_password_view', $this->data);
        } else {

            redirect('admin/login');
            exit();
        }
    }



    public function update_password_code()
    {

        $this->form_validation->set_rules('password', 'Password', 'required|matches[c-password]|min_length[8]');
        $this->form_validation->set_rules('c-password', 'Password Confirmation', 'required');
        $pass_code = $this->input->post('pass_code');

        if ($this->form_validation->run() == FALSE) {

            $error = validation_errors();
            $response = array();
            $response['code'] = 0;
            $response['message'] = $error;
            echo json_encode($response);
            exit();
        } else {

            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where('passwordResetToken', $pass_code);
            $this->db->limit(1);
            $query = $this->db->get();

            if ($query->num_rows() == 0) {

                $response = array();
                $response['code'] = 0;
                $response['message'] = 'Something went wrong';
                echo json_encode($response);
                exit();
            }

            $password = md5($this->input->post('password'));
            $this->db->set('password', $password);
            $this->db->where('passwordResetToken', $pass_code);
            $this->db->update('admin');
            $this->db->set('passwordResetToken', '');
            $this->db->where('passwordResetToken', $pass_code);
            $this->db->update('admin');

            $response = array();
            $response['code'] = 1;
            $response['message'] = 'password changed successfully';
            echo json_encode($response);
            exit();
        }
    }
}
