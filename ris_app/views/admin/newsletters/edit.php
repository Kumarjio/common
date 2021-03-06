<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery('.radio-error').hide();
        jQuery("#edit").validate({
            errorPlacement: function(error, element) {
                if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                    jQuery('.radio-error').html(error);
                    jQuery('.radio-error').show();
                }
                else {
                    error.insertAfter(element);
                }
            }
        });

        jQuery('#businesscategory_id').change(function(){
            if($('#businesscategory_id').val() == 0){
                jQuery('#businesssubcategory_id').empty();
                jQuery('#businesssubcategory_id').append('<option value="0">All</option>');
            } else {
                jQuery.ajax({
                    type: 'GET',
                    url: '<?php echo ADMIN_URL ."get_sub_cat_bussiness/"; ?>' + $('#businesscategory_id').val(),
                    success: function(data){
                        jQuery('#businesssubcategory_id').empty();
                        jQuery('#businesssubcategory_id').append(data);
                    }
                });    
            }
        });
    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'newsletter/edit/' . @$newsletter->id; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-2 control-label">Select Template<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="template_id" class="form-control required">
                        <option value="">Select Template</option>
                        <?php foreach ($newsletter_templates as $template) { ?>
                            <option value="<?php echo $template->id; ?>" <?php echo ($template->id == $newsletter->template_id) ? 'selected' : ''; ?>><?php echo $template->subject; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="radios">Site Type <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="radio">
                        <label for="radios-0">
                            <input name="site_type" id="radios-0" value="0" type="radio" class="required" <?php echo (0 == $newsletter->site_type) ? 'checked' : ''; ?>>&nbsp;All
                        </label>
                    </div>
                    <?php foreach ($site_types as $key => $value) { ?>
                        <div class="radio">
                            <label for="radios-<?php echo $key; ?>">
                                <input name="site_type" id="radios-<?php echo $key; ?>" value="<?php echo $key; ?>" type="radio" class="required" <?php echo ($key == $newsletter->site_type) ? 'checked' : ''; ?>><?php echo $value; ?>
                            </label>
                        </div>
                    <?php } ?>
                    <span class="radio-error"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Business Category <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="businesscategory_id" class="form-control required" id="businesscategory_id">
                        <option value="0">All</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category->id; ?>"  <?php echo ($category->id == $newsletter->businesscategory_id) ? 'selected' : ''; ?>><?php echo $category->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Sub Category Name<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="businesssubcategory_id" class="form-control required" id="businesssubcategory_id">
                        <?php if($newsletter->businesscategory_id == 0) { ?>
                            <option value="0">All</option>
                        <?php } else { ?>
                            <option value="0">All</option>
                            <?php foreach ($sub_categories as $sub_category) { ?>
                                <option value="<?php echo $sub_category->id; ?>"  <?php echo ($sub_category->id == $newsletter->businesssubcategory_id) ? 'selected' : ''; ?>><?php echo $sub_category->name; ?></option>
                            <?php } ?>
                        <?php } ?>
                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Date <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required datepicker" name="date_send" palceholder="Date" value="<?php echo date('d-m-Y', strtotime($newsletter->date_send)); ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">User at time <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="users_at_time" value="<?php echo $newsletter->users_at_time; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo ADMIN_URL . 'newsletter' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <?php echo $this->lang->line('compulsory_note'); ?>
                </div>
            </div>
        </form>
    </div>
</div>