<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#forgot_password").validate({
            errorPlacement: function(){
                return false;
            }
        });
    });
    //]]>
</script>
<div class="form-box mar-tp-10" id="login-box">
    <div class="header">Forgot Password</div>
    <form id="forgot_password" action="<?php echo ADMIN_URL .'send_reset_password_link'; ?>" method="post">
        <div class="body bg-gray">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input type="email" name="email" class="form-control required" placeholder="Email address"/>
                </div>
            </div>
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Send Mail</button>
            <p class="text-center"><a href="<?php echo ADMIN_URL; ?>">Back to Login</a></p>    
        </div>
    </form>
    <div class="margin text-center">
        <br/>
    </div>
</div>