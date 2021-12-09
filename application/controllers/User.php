<?php

class User extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('common_helper');
    }

        
    public function index(){;

        if($this->session->userdata('user_id')){
            redirect(base_url(). 'user/dashboard');
        }else{
            redirect(base_url().'user/login');
        }
    }


    public function dashboard(){ 
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->session->userdata('user');
        #preview($data);
        $this->load->view('user/dashboard', $data);
    }

    public function signup(){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }

        if($this->input->post()){
            $email = $this->db->escape_str($this->input->post('email'));
            $password = $this->db->escape_str($this->input->post('password'));

            $errors = '';
            $errors .= ($this->user_model->check_existance('users',['email' => $email]) ? 'Email address already exists' : '');
            
            if(!$errors){
                $data = [
                    'email' => $email,
                    'password' => md5($password),
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'user_img' => 'default.svg',
                    'expiry' => date('Y-m-d',strtotime(date('Y-m-d') . '+ 7 days'))
                ];
    
                $signup = $this->user_model->signup($data);
                if($signup){
                    $this->session->set_flashdata('success', 'Sign up successfull');
                    redirect(base_url().'user/login');
                }else{
                    $this->session->set_flashdata('errors', 'Sign up failed!');
                    //redirect(base_url().'user/login');
                }
            }else{
                $this->session->set_flashdata('errors', 'Email address already exists');
                redirect(base_url().'user/signup');
            }
        }

        $this->load->view('user/signup');
    }


    public function add_user(){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        if($this->input->post()){
            // preview($_POST);
            $first_name = $this->db->escape_str($this->input->post('first_name'));
            $last_name = $this->db->escape_str($this->input->post('last_name'));
            $phone = $this->db->escape_str($this->input->post('phone'));
            $phone = str_replace(' ','',$phone);
            $email = $this->db->escape_str($this->input->post('email'));
            $password = $this->db->escape_str($this->input->post('password'));
            $role = $this->db->escape_str($this->input->post('role'));
            $errors = '';

            $errors .= ($this->user_model->check_existance('users',['email' => $email]) ? 'Email already exist <br>':'');
            $errors .= ($this->user_model->check_existance('users',['phone' => $phone]) ? 'Phone number already exist <br>':'');

            if(!$errors){
                $user_data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $phone,
                    'email' => $email,
                    'password' => md5($password),
                    'role' => $role,
                    'user_image' => 'default.svg'
                ];
    
                $res = $this->user_model->signup($user_data);
                if($res){
                    $this->session->set_flashdata('success', "New user created successfully");
                    redirect(base_url()."user/add_user");
                }else{
                    $this->session->set_flashdata('errors', "Something went wrong!");
                    redirect(base_url()."user/add_user");
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url()."user/add_user");
            }
        }
        $this->load->view('user/user_details/add-user');
    }

    public function edit_user($id){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        $data['user'] = $this->user_model->get_user(['id' => $id]);
        if($_POST){
            // preview($_POST);
            $first_name = $this->db->escape_str($this->input->post('first_name'));
            $last_name = $this->db->escape_str($this->input->post('last_name'));
            $phone = $this->db->escape_str($this->input->post('phone'));
            $email = $this->db->escape_str($this->input->post('email'));
            $role = $this->db->escape_str($this->input->post('role'));

            $user_data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'role' => $role
            ];

            $res = $this->user_model->update_user($user_data, ['id' => $id]);
            if($res){
                $this->session->set_flashdata('success', "User updated successfully");
                $data['user'] = $res;
                redirect(base_url()."user/edit_user/".$id, $data);
            }else{
                $this->session->set_flashdata('errors', "Something went wrong!");
                redirect(base_url()."user/edit_user");
            }
        }
        $this->load->view('user/user_details/add-user', $data);
    }

    public function delete_user($id){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        $res = $this->user_model->delete_user(['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', "User deleted successfully");
            redirect(base_url()."user/user_archive");
        }else{
            $this->session->set_flashdata('errors', "Something went wrong!");
            redirect(base_url()."user/user_archive");
        }
    }

    public function login(){
        if($this->input->post()){
            $email = $this->db->escape_str($this->input->post('email'));
            $password = $this->db->escape_str($this->input->post('password'));
            $remember = $this->db->escape_str($this->input->post('iv_remember'));

            $data = [
                'email' => $email,
                'password' => md5($password)
            ];

            $login = $this->user_model->login($data);
            if($login){
                if($remember){
                    $this->load->helper('cookie');
                    set_cookie('iv_email' , $email, '36000');
                    set_cookie('iv_pass', $password, '36000');
                }
                $this->session->set_userdata('user_id', $login->id);
                $this->session->set_userdata('user', $login);
                redirect(base_url()."user/dashboard");
            }else{
                $this->session->set_flashdata('error', "Invalid credentials");
                redirect(base_url()."user/login");
            }

            
        }
        $this->load->view('user/login');
    }


    public function profile_settings(){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        
        $data = ['first_name' => '', 'last_name' => '', 'email' => '', 'user_image' => ''];
        $user = $this->user_model->get_user(['id' => $this->session->userdata('user_id')]);
        if($user){
            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['email'] = $user->email;
            $data['user_image'] = $user->user_image;
        }
        if(isset($_POST['update_profile'])){
            $first_name = $this->db->escape_str($this->input->post('first_name'));
            $last_name = $this->db->escape_str($this->input->post('last_name'));
            $email = $this->db->escape_str($this->input->post('email'));
            $img = false;
            if(isset($_FILES["user_img"])){
                $file = $_FILES["user_img"];
                $filename = $file["name"];
                $file_name_split = explode(".",$filename);
                $ext = end($file_name_split);
                $allowed_ext = array("jpg","png","jpeg","gif");
                
                if(in_array($ext,$allowed_ext)){
                    $img = upload_img($file,"images/user_img/");
                }
            }
            //preview($_FILES);
            $user_data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email
            ];
            if($img){
                $user_data['user_image'] = $img;
            }

            $update_user = $this->user_model->update_user($user_data, ['id' => $this->session->userdata('user_id')]);
            if($update_user){
                $this->session->set_userdata('user', $update_user);
                $this->session->set_flashdata('success', 'User updated successfully');
                redirect(base_url().'user/profile_settings');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong!');
            }
        }

        if(isset($_POST['change_pass'])){
            $curr_pass = $this->db->escape_str($this->input->post('current_pass'));
            $new_pass = $this->db->escape_str($this->input->post('new_pass'));
            $confirm_pass = $this->db->escape_str($this->input->post('confirm_pass'));

            $user = $this->user_model->get_user(['id' => $this->session->userdata('user_id')]);
            $errors = '';
            $errors .= (!($user->password === md5($curr_pass)) ? "Invalid current password<br>" : '');
            // $errors .= ( count($new_pass) <= 8 ? "Password length should be more than 8 characters" : '');
            $errors .= (!($new_pass === $confirm_pass) ? "Password doesn't match<br>" : '');
            if(!$errors){
                $pass_data = ['password' => md5($new_pass)];
                $update_pass = $this->user_model->update_user($pass_data, ['id' => $user->id ]);
                if($update_pass){
                    $this->session->set_flashdata('success', 'Password updated successfully');
                    redirect(base_url().'user/profile_settings');
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong');
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
            }
        }

        // $settings = $this->user_model->get_settings();
        // foreach($settings as $k => $v){
        //     $data[$v->setting_name] = $v->setting_value;
        // }

        $this->load->view('user/settings/profile-settings', $data);
    }


    public function site_settings(){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        if($this->input->post()){
            $settings = $this->input->post();
            foreach($settings as $k=>$v){
                  $this->user_model->save_settings($k,$v);
            }
            $this->session->set_flashdata("success","Settings have been updated");
            redirect(base_url()."user/site_settings");
        }

        $settings = $this->user_model->get_settings();
        foreach($settings as $k => $v){
            $data[$v->setting_name] = $v->setting_value;
        }

        $this->load->view('user/settings/site-settings', $data);
    }


    function logout(){
        if(!$this->session->userdata("user_id")){
            redirect(base_url()."user/login");
        }
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('company_id');
        redirect(base_url()."user/index");
    }


    function forgot_password(){
        if($this->input->post()){
            $email = $this->db->escape_str($this->input->post('email'));
            $errors = '';
            $errors .= (!$this->user_model->check_existance('users',['email' => $email]) ? "Invalid email address" : "");

            if(!$errors){
                $email = $this->db->escape_str($this->input->post('email'));
                $code = generate_random_key();
                $content = "your Verification code is {$code}";
                $res = za_send_email($email, 'support@vizzwebsolutions.com',"MSG Vizz", 'Reset your password', $content);
                if($res){
                    $this->load->helper('cookie');
                    set_cookie('otp', md5($code), 36000);
                    set_cookie('email', $email, 36000);
                    $this->session->set_flashdata('success','Verification code sent successfully');
                    redirect(base_url('user/verification_code'));
                }else{
                    $this->session->set_flashdata('errors','Something went wrong!');
                }
            }else{
                $this->session->set_flashdata('errors',$errors);
            }
        }
        $this->load->view('user/forgot-password');
    }

    function verification_code(){
        if($this->input->post()){
            $this->load->helper('cookie');
            $code = $this->db->escape_str($this->input->post('code'));
            $otp  = get_cookie('otp');
            if(md5($code) == $otp){
                // $this->session->set_flashdata('success','Verification code sent successfully');
                redirect(base_url('user/reset_password'));
            }else{
                $this->session->set_flashdata('errors','Invalid verification code');
            }
        }
        $this->load->view('user/code-verification');
    }

    function reset_password(){
        if($this->input->post()){
            $pass = $this->db->escape_str($this->input->post('new_pass'));
            $confirm_pass = $this->db->escape_str($this->input->post('confirm_pass'));

            $errors = '';

            $errors .= ($pass != $confirm_pass ? "Password does not match<br>" : '');
            if(!$errors){
                $this->load->helper('cookie');
                $email = get_cookie('email');
                $res = $this->user_model->update_user(['password' => md5($pass)], ['email' => $email]);
                if($res){
                    delete_cookie('otp');
                    delete_cookie('email');
                    $this->session->set_flashdata('success','Password successfuly updated');
                    redirect(base_url('user/login'));
                }else{
                    $this->session->set_flashdata('errors','Invalid verification code');
                }
            }else{
                $this->session->set_flashdata('errors',$errors);
            }

        }
        $this->load->view('user/reset-password');
    }

    
}