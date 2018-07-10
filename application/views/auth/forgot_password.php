<div class="login-box card">
    <div class="card-body">
        <?php
        $attributes = array('class' => 'form-horizontal form-material', 'id' => 'loginform');
        echo form_open('auth/forgot_password', $attributes);
        ?>
        <div class="form-group ">
            <div class="col-xs-12">
                <h3><?php echo lang('forgot_password_heading'); ?></h3>
                <p class="text-muted"><?php echo sprintf(lang('forgot_password_subheading'), '<b>Username</b>'); ?> </p>
            </div>
        </div>
        <?php if (isset($message))
        { ?>
            <div class="alert alert-info"><?php echo $message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
        <?php } ?>  
        <div class="form-group ">
            <div class="col-xs-12 controls">               
                <input type="text" class="form-control" id="identity" name="identity"  required  placeholder="Username"> 
            </div>
        </div>
        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <div class="form-actions">
                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"><?php echo lang('forgot_password_submit_btn'); ?></button>
                </div>
            </div>
        </div>            
        <?php echo form_close(); ?>
    </div>
</div>