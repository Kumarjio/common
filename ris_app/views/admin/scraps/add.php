<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery('.radio-error').hide();
        jQuery("#add").validate({
            errorPlacement: function(error, element) {
                if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                    if(element.attr('type') === 'radio') {
                        jQuery('.radio-error').html(error);
                        jQuery('.radio-error').show();    
                    }

                    if(element.attr('type') === 'checkbox') {
                        jQuery('.checkbox-error').html(error);
                        jQuery('.checkbox-error').show();    
                    }
                    
                }
                else {
                    error.insertAfter(element);
                }
            }
        });

        jQuery('#businesscategory_id').change(function(){
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo ADMIN_URL ."get_sub_cat_bussiness/"; ?>' + $('#businesscategory_id').val(),
                success: function(data){
                    jQuery('#businesssubcategory_id').empty();
                    jQuery('#businesssubcategory_id').append(data);
                }
            });
        });
    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'scrap/add'; ?>" >
            <div class="form-group">
                <label class="col-lg-2 control-label" for="radios">Type <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <?php foreach ($scrap_sites as $key => $value) { ?>
                        <div class="radio">
                            <label for="radios-<?php echo $key; ?>">
                                <input name="type" id="radios-<?php echo $key; ?>" value="<?php echo $key; ?>" type="radio" class="required">&nbsp;<?php echo $value; ?>
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
                        <option value=""></option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Sub Category Name<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="businesssubcategory_id" class="form-control required" id="businesssubcategory_id">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">URL <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="url" palceholder="Site URL"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Check Pagination <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="checkbox" class="form-control" name="link_status" value="1" checked/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Save</button>
                    <a href="<?php echo ADMIN_URL . 'scrap' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
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