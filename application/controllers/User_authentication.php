<?php
/**
 * Created by PhpStorm.
 * User: taohansamu
 * Date: 22/11/2016
 * Time: 16:59
 */



Class User_Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();

// Load form and url and security helper library
        $this->load->helper(array('form','url','security'));

// Load form validation library
        $this->load->library('form_validation');

// Load session library
        $this->load->library('session');

// Load database
        $this->load->model('User');


    }

// Show login page
    public function index() {
        $this->load->view('login/login_form');
    }

// Show registration page
    public function user_registration_show() {
        $this->load->view('login/registration_form');
    }

// Validate and store registration data in database
    public function new_user_registration() {

// Check validation for user input in SignUp form
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email_value', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('passconf','Password_Confirmation','trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/registration_form');
        } else {
            $data = array(
                'user_name' => $this->input->post('username'),
                'email' => $this->input->post('email_value'),
                'password' => $this->input->post('password')
            );
            $result = $this->User->registration_insert($data);
            if ($result == TRUE) {
                $data['message_display'] = 'Registration Successfully !';
                $this->load->view('login/login_form', $data);
            } else {
                $data['message_display'] = 'Username already exist!';
                $this->load->view('login/registration_form', $data);
            }
        }
    }

// Check for user login process
    public function user_login_process() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if(isset($this->session->userdata['logged_in'])){
                redirect('/page/home','location');
            }else{
                $this->load->view('login/login_form');
            }
        } else {
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );
            $result = $this->User->login($data);
            if ($result == TRUE) {

                $email = $this->input->post('email');
                $result = $this->User->read_user_information($email);
                if ($result != false) {
                    $session_data = array(
                        'userid'  =>$result[0]->user_id,
                        'username' => $result[0]->user_name,
                        'email' => $result[0]->email,
                        'logged_in' => TRUE
                    );
                    // Add user data in session
                    $this->session->set_userdata( $session_data);
                    redirect('/page/home','location');
                }
            //login fail
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('login/login_form', $data);
            }
        }
    }

// Logout from admin page
    public function logout() {


        $this->session->sess_destroy();
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('login/login_form', $data);
    }

}

?>
