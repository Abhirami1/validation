<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('ForgotModel');
    }


    public function check_email_exist(){

        $email=$this->input->post('email');

		$checkemail=$this->ForgotModel->check_email($email);
		echo $checkemail;

    }


    public function forgot_password()
    {

        
        $token=md5(rand());

        $email=$this->input->post('email');

        $update=$this->ForgotModel->update_token($email,$token);

        echo $update;
    }


    public function reset_pass()
    {
        $this->load->view('reset_pass');
    }


    public function reset_user()
    {
        $pass=$this->input->post('pass');
        $password=md5($pass);

        
        $token=$this->input->post('token');

        $data = array(
            'password' => $password,
        );
    
        $this->db->where('token', $token);
        $this->db->update('registration', $data);

        if ($this->db->affected_rows() > 0) {
            // Password reset successful, send success response
            $response = array('status' => 'success');
        } else {
            // Password reset failed, send failure response
            $response = array('status' => 'error');
        }
    
        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }





    public function password_change()
    {
        $this->load->view('password_change');
    }
}