    <?php
/**
 * Created by PhpStorm.
 * User: taohansamu
 * Date: 09/12/2016
 * Time: 00:06
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MY_Controller {
    public function __construct() {

        parent::__construct();

// Load form and url and security helper library
        $this->load->helper(array('form','url','security'));

// Load form validation library
        $this->load->library('form_validation');

// Load session library
        $this->load->library('session');

// Load database
        $this->load->model('Post');
        $this->load->model('User');

    }
    public function index() {
        $this->middle = 'main_page/home'; // its your view name, change for as per requirement.
        $this->layout();
    }
    public function write_blog(){
        $this->middle= 'main_page/write_blog';
        $this->layout();
    }
    public function home(){
        $this->data['post']=$this->Post->get_by_user($this->session->userdata('userid'));
        $this->middle= 'main_page/home';
        $this->layout();
    }
 /**
     *POST function
     */
    public function post(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'user_id'  => $this->input->post('userid'),
                'private'  => $this->input->post('private')
            );
            $result = $this->Post->post_insert($data);
            if($result==TRUE)$this->data['messenger']='Posted';
            else $this->data['messenger']='Post Failed';
            $this->middle= 'main_page/write_blog';
            $this->layout();
        }
    }

    public function delete_post(){
        return $this->Post->delete_post($this->input->post('post_id'));
    }

    public function update_post(){
        return $this->Post->update_post($this->input->post('post_id'),array(
            'title'=>$this->input->post('title'),
            'content'=>$this->input->post('content')
        ));
    }
    /**
     *
     */
    public function search_user(){

       if($this->input->get('username')){
           $this->data['users']=$this->User->get_user_list_by_username($this->input->get('username'));
        }
        else{
            $this->data['users']=$this->User->select(1);
        }
        $this->middle='main_page/list_user';
        $this->layout();
    }
    public function follow(){
       $this->User->add_follow_with($this->session->userdata['userid'],$this->input->post('user_id'));
        return TRUE;
    }

    public function getMessages() {
        $this->data['messages']=$this->Message->getMessages($this->session->userdata['userid']);
        $this->middle='main_page/message';
        $this->layout();
        return ;
    }
    public function addMessage($message,$group_id){
        return $this->Message->addMessage(array(
            'from_user_id' => $this->session->userdata['userid'],
            'group_id' => $group_id,
            'content' => $message
        ));
    }
    public function suggest_user(){
        $query=$this->input->get('query');
        if(isset($query)){
            if($result=$this->User->suggest_user($query)){
                foreach ($result as $r){
                    echo "<p><a href='##'> " . $r->user_name . "</a></p>";
                }
                } else{
                    echo "<p>No matches found for <b>$query</b></p>";
                }
            } else{
                echo "ERROR in Mysql " ;
            }
        }
}
?>