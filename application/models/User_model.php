<?php

class User_model extends CI_Model{


    function login($data){
        $user = $this->db->get_where('users', $data);
        if($user->num_rows() > 0){
            return $user->row();
        }else{
            return false;
        }
    }

    function check_existance($table, $data){
        $res = $this->db->get_where($table, $data);
        if($res->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function signup($data){
        $signup = $this->db->insert('users',$data);
        if($signup){
            $user = $this->db->get_where('users',['id' => $this->db->insert_id()])->row();
            return $user;
        }else{
            return false;
        }
    }


    function get_settings(){
        $res = $this->db->get('settings');
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }

    function save_settings($key,$value){
        $check = $this->check_existance("settings",array("setting_name"=>$key));
        if($check){
            $this->db->update("settings",array("setting_value"=>$value),array("setting_name"=>$key));
        }else{
            $this->db->insert("settings",array("setting_value"=>$value,"setting_name"=>$key));
        }
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function get_user($where){
        $user = $this->db->get_where('users', $where);
        if($user->num_rows() > 0){
            return $user->row();
        }else{
            return false;
        }
    }

    function update_user($data, $where){
        $update = $this->db->update('users', $data, $where);
        if($update){
            $user = $this->db->get_where('users', $where)->row();
            return $user;
        }else{
            return false;
        }
    }


}