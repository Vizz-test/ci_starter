<?php
    $this->load->view('user/inc/header');
    $this->load->view('user/inc/sidebar');
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile Settings</h1>
</div>


<?php 
    if($this->session->flashdata("errors")){
        echo '<div class="alert alert-danger text-center">'.$this->session->flashdata("errors").'</div>';
    }elseif($this->session->flashdata('success')){
        echo '<div class="alert alert-success text-center">'.$this->session->flashdata("success").'</div>';
    }
    
?>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Profile settings</div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="profile_img_wrapper">
                                    <img width="100" height="100" src="<?=base_url().'images/user_img/'.($user_image? $user_image: 'default.svg')?>" alt="">
                                
                                <label class="profile_img--overlay" for="pf_img">
                                    <i class="fas fa-upload"></i>
                                    <label>Upload</label>
                                </label>
                                <input class="d-none" name='user_img' type="file" value="" id="pf_img" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputfirst_name">First Name</label>
                            <input class="form-control" name="first_name" id="inputfirst_name" type="text" required value="<?= $first_name ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputlast_name">Last name</label>
                            <input class="form-control" name="last_name" id="inputlast_name" type="text" required value="<?= $last_name ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="d-none form-group col-md-6">
                            <label class="small mb-1" for="inputphone">Phone</label>
                            <input class="form-control" name="phone" id="inputphone" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputemail">Email</label>
                            <input class="form-control" name="email" id="inputemail" type="email" value="<?= $email ?>">
                        </div>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" name="update_profile" type="submit">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Change Password</div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputcurrent_pass">Current Password</label>
                            <input class="form-control" name="current_pass" id="inputcurrent_pass" type="password" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputnew_pass">New Password</label>
                            <input class="form-control" name="new_pass" id="inputnew_pass" type="password" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputconfirm_pass">Confirm Password</label>
                            <input class="form-control" name="confirm_pass" id="inputconfirm_pass" type="password" required>
                        </div>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" name="change_pass" type="submit">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $this->load->view('user/inc/footer');

?>