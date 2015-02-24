<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#login").validate({
            errorPlacement: function(){
                return false;
            }
        });
    });
    //]]>
</script>
<div class="form-box mar-tp-10" id="login-box">
    <div class="header">Sign In</div>
    <form id="login" action="<?php echo ADMIN_URL .'validate'; ?>" method="post">
        <div class="body bg-gray">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input type="email" name="email" class="form-control required" placeholder="Email address"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <input type="password" name="password" class="form-control required" placeholder="Password"/>
                </div>
            </div>

        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Sign in</button>  
            <p><a href="<?php echo ADMIN_URL .'forgot_password'; ?>">I forgot my password</a></p>
        </div>
    </form>
    <div class="margin text-center">
        <br/>
    </div>
</div>