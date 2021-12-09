<?php
    $this->load->view('user/inc/header');
    $this->load->view('user/inc/sidebar');
    $data['years'] = 0;
    $data['terminal_growth'] = 0;
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Site Settings</h1>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Site Settings</div>
            <div class="card-body">
                
                <?php 
                    if($this->session->flashdata("errors")){
                        echo '<div class="alert alert-danger text-center">'.$this->session->flashdata("errors").'</div>';
                    }elseif($this->session->flashdata('success')){
                        echo '<div class="alert alert-success text-center">'.$this->session->flashdata("success").'</div>';
                    }
                    
                ?>      
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputchat_api_instance_id">Chat API Instance ID</label>
                            <input class="form-control" value="<?= ($chat_api_instance_id ? $chat_api_instance_id : '') ?>" name="chat_api_instance_id" id="inputchat_api_instance_id" type="text" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputchat_api_token">Chat API Token</label>
                            <input class="form-control" value="<?= ($chat_api_token ? $chat_api_token : '') ?>" name="chat_api_token" id="inputchat_api_token" type="text" required>
                        </div>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </form>
            </div>
            </div>
        </div>
    </div>


<?php
    $this->load->view('user/inc/footer', $data);