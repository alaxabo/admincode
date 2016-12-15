<?php
class Post extends CI_Model{


    public function post_insert($data){
// Query to insert data in database
            $this->db->insert('Post', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        return false;
    }
    public function get_by_user($userid){
        $condition = "user_id='".$userid."'";
        $this->db->select('*');
        $this->db->from('Post');
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function delete_post($post_id){
        return $this->db->delete('Post', array('post_id' => $post_id));
    }
    public function update_post($post_id,$data){
        $this->db->where('post_id',$post_id);
        return $this->db->update('Post',$data);
    }
}