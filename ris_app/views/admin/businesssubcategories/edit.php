<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#edit").validate({
            errorPlacement: function(error, element) {
                if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                    error.appendTo(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            }
        });
    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'businesssubcategory/edit/' . @$businesssubcategory->id; ?>" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-lg-2 control-label">Business Category <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="businesscategory_id" class="form-control">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $businesssubcategory->businesscategory_id) ? 'selected' : ''; ?>><?php echo $category->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Sub Category Name<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="name" value="<?php echo $businesssubcategory->name ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="radios">Status <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="radio">
                        <label for="radios-0">
                            <input name="status" id="radios-0" value="Active" type="radio" <?php echo ($businesssubcategory->status == 'Active') ? 'checked' : ''; ?>> Active
                        </label>
                    </div>
                    <div class="radio">
                        <label for="radios-1">
                            <input name="status" id="radios-1" value="InActive" type="radio" <?php echo ($businesssubcategory->status == 'InActive') ? 'checked' : ''; ?>> Inactive
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo ADMIN_URL . 'businesssubcategory' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
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