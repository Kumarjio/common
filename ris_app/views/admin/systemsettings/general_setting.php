<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#edit").validate();
    });
    //]]>
</script>
<?php $session = $this->session->userdata('admin_session'); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'system_setting/update_general'; ?>" enctype="multipart/form-data">
            <?php foreach ($setting as $value) { ?>
                <?php if ($value->sys_key == 'login_logo' || $value->sys_key == 'main_logo') { ?>

                    <?php if (!is_null($value->sys_value) && file_exists('assets/img/' . $value->sys_value)) { ?>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?php echo 'Current ', ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">&nbsp;</span></label>
                            <div class="col-lg-7">
                                <img src="<?php echo IMG_URL . $value->sys_value; ?>" />
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">&nbsp;</span></label>
                        <div class="col-lg-7">
                            <input type="file" name="<?php echo $value->sys_key; ?>" class="form-control">
                            <?php
                            if ($this->session->flashdata($value->sys_key)) {
                                echo '<label class="error">' . $this->session->flashdata($value->sys_key) . '</label>';
                            }
                            ?>
                        </div>
                    </div>
                <?php } else if ($value->sys_key == 'post_last_wish') { ?>
                <?php $post_last_wish = explode('_', $value->sys_value);?>                   
                    <div class="form-group">
                        <label for="question" class="col-lg-3 control-label"><?php echo ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="int" min="0" name="post_last_wish_input"  class="form-control required input-sm" value="<?php echo $post_last_wish[0]; ?>"/>
                                </div>
                                <div class="col-lg-6">
                                    <select name="post_last_wish_select" class="form-control input-sm">
                                        <option value="H" <?php echo (@$post_last_wish[1] == 'H') ? 'selected="selected"' : ''; ?>>Hour(s)</option>
                                        <option value="D" <?php echo (@$post_last_wish[1] == 'D') ? 'selected="selected"' : ''; ?>>Day(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="form-group">
                        <label for="question" class="col-lg-3 control-label"><?php echo ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="<?php echo $value->sys_key; ?>"  class="form-control required" value="<?php echo $value->sys_value; ?>"/>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

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