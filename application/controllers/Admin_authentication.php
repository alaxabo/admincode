<?php
/**
 * Created by PhpStorm.
 * User: taohansamu
 * Date: 22/11/2016
 * Time: 16:59
 */



Class Admin_Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();

// Load form and url and security helper library
        $this->load->helper(array('form','url','security'));

// Load form validation library
        $this->load->library('form_validation');

// Load session library
        $this->load->library('session');

// Load database
        $this->load->model('Adminmodel');


    }

// Show login page
    public function index() {
        $this->load->view('login/login_form_admin');
    }

// Check for user login process
    public function admin_login_process() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if(isset($this->session->userdata['logged_in'])){
                redirect('/adminpage/home','location');
            }else{
                $this->load->view('login/login_form_admin');
            }
        } else {
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );
            $result = $this->Adminmodel->login($data);
            if ($result == TRUE) {

                $email = $this->input->post('email');
                $result = $this->Adminmodel->read_user_information($email);
                if ($result != false) {
                    $session_data = array(
                        // 'userid'  =>$result[0]->user_id,
                        'email' => $result[0]->email,
                        'logged_in' => TRUE
                    );
                    // Add user data in session
                    $this->session->set_userdata( $session_data);
                    redirect('/adminpage/home','location');
                }
            //login fail
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('login/login_form_admin', $data);
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
