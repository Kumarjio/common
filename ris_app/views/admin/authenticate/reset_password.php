<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#reset_paqssword").validate({
            rules: {
                new_cpassword: {equalTo: '#new_password'}
            },
            messages: {
                new_cpassword: {equalTo: '* Password does Not Match'}

            },
            errorPlacement: function(){
                return false;
            }
        });
    });
    //]]>
</script>
<div class="form-box mar-tp-10" id="login-box">
    <div class="header">ResetPassword</div>
    <form id="reset_password" action="<?php echo ADMIN_URL . 'reset_password/' . $random_string; ?>" method="post">
        <div class="body bg-gray">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <input type="password" name="new_password" id="new_password" class="form-control required" placeholder="New Password"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <input type="password" name="new_cpassword" class="form-control required" placeholder="Re-enter Password"/>
                </div>
            </div>

        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Reset Password</button>
            <p class="text-center"><a href="<?php echo ADMIN_URL; ?>">Back to Login</a></p>  
        </div>
    </form>
    <div class="margin text-center">
        <br/>
    </div>
</div>