<div class="login-register" style="background-image:url(<?php echo base_url(); ?>assets/themes/adminpress/images/background/login-register.jpg);">>
    <div class="login-box card">
        <div class="card-body">
            <?php
            $attributes = array('class' => 'form-horizontal form-material', 'id' => 'loginform');
            echo form_open('auth/reset_password/' . $code, $attributes);
            ?>  
            <h3 class="box-title m-b-20"><?php echo lang('reset_password_heading'); ?></h3>

            <?php if (isset($message)){ ?>
                <div class="alert alert-info"><?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
            <?php } ?>  
            
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" id="new" name="new" type="password" required placeholder="Nuova password" pattern="^.{8}.*$"> 
                </div>
            </div>            
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" id="new_confirm" name="new_confirm" type="password" required placeholder="Conferma nuova password"> 
                </div>
            </div>              
            
            <?php echo form_input($user_id); ?>
            <?php echo form_hidden($csrf); ?>
            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"><?php echo lang('reset_password_submit_btn'); ?></button>
                </div>
            </div>  

            <?php echo form_close(); ?>
        </div>
    </div>
</div>