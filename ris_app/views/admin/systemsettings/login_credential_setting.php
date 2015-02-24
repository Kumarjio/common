<?php $session_data = $this->session->userdata('admin_session'); ?>
<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#edit").validate({
            rules: {
                cpassword: {equalTo: '#password'}
            },
            messages: {
                cpassword: {equalTo: '* Password does Not Match'}
            }
        });
    });
    //]]>
</script>
<?php $session = $this->session->userdata('admin_session'); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'system_setting/update_login_credential'; ?>">

            <div class="form-group">
                <label class="col-lg-2 control-label">Name <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="fullname" value="<?php echo $session_data->name ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Email <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="email" class="form-control required" name="email" value="<?php echo $session_data->email ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Password <span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <input type="password" class="form-control" name="password"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Confirm Password <span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <input type="password" class="form-control" name="cpassword"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">&nbsp;</label>
                <div class="col-lg-7">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo ADMIN_URL; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">&nbsp;</label>
                <div class="col-lg-7">
                    <?php echo $this->lang->line('compulsory_note'); ?>
                </div>
            </div>
        </form>
    </div>
</div>