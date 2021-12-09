<?php
    $this->load->view('user/inc/header');
    $this->load->view('user/inc/sidebar');
?>


                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-dark font-weight-bold">Dashboard</h1>
                    </div>

                    

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark">Valuation details</h6>
                        </div>
                        <div class="card-body">
                        <?php 
                            if($this->session->flashdata("errors")){
                                echo '<div class="alert alert-danger text-center">'.$this->session->flashdata("errors").'</div>';
                            }elseif($this->session->flashdata('success')){
                                echo '<div class="alert alert-success text-center">'.$this->session->flashdata("success").'</div>';
                            }
                            
                        ?>
                        </div>
                    </div>

<?php
    $this->load->view('user/inc/footer');
?>