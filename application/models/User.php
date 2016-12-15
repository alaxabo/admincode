<?php

Class User extends CI_Model {

// Insert registration data in database
    public function registration_insert($data) {

// Query to check whether username already exist or not
        $condition = "email =" . "'" . $data['email'] . "'";
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {

// Query to insert data in database
            $this->db->insert('User', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

// Read data using username and password
    public function login($data) {

        $condition = "email =" . "'" . $data['email'] . "' AND " . "password =" . "'" . $data['password'] . "'";
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

// Read data from database to show data in admin page
    public function read_user_information($email) {

        $condition = "email =" . "'" . $email . "'";
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        print_r($condition);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_user_list_by_username($username){
        $condition="user_name LIKE "."'%".$username."%'";
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where($condition);
        $query = $this->db->get();
        //print_r($condition);
        return $query->result();
    }

    public function get_user_list_by_userid($userid){
        $condition = "user_id='".$userid."'";
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where($condition);
        return $this->db->get()->result();
    }

    public function add_follow_with($from_user_id,$to_user_id){
        $this->db->insert('Follow', array(
            from_user_id =>$from_user_id,
            to_user_id  =>  $to_user_id
        ));
    }
    public function relationship($userid1,$userid2){
        $condition="from_user_id=".$userid1." and to_user_id=".$userid2;
        $this->db->select('*');
        $this->db->from('Follow');
        $this->db->where($condition);
        $count1=$this->db->get()->num_rows();
        $condition="from_user_id=".$userid2." and to_user_id=".$userid1;
        $this->db->select('*');
        $this->db->from('Follow');
        $this->db->where($condition);
        $count2=$this->db->get()->num_rows();
        return $count1*10+$count2;
    }
    public function select($condition){
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where($condition);
        return $this->db->get()->result();
    }

    public function delete_user($user_id){
        return $this->db->delete('User', array('user_id' => $user_id));
    }
    public function update_user($user_id,$data){
        $this->db->where('user_id',$user_id);
        return $this->db->update('User',$data);
    }
}

?>