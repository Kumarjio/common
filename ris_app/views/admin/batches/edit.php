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

        $('.date-picker').datepicker({
            autoclose: true,
            endDate: '+0d'
        });

    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'batch/edit/' . @$batch->id; ?>">

            <div class="form-group">
                <label class="col-lg-2 control-label">Name <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="name" value="<?php echo $batch->name ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Fee <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="fee" value="<?php echo $batch->fee; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Start Date <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control date-picker required" name="st_date" value="<?php echo date('d-m-Y', strtotime($batch->st_date)); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">End Date <span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control date-picker " name="ed_date" value="<?php echo ($batch->ed_date != '' && $batch->ed_date != '0000-00-00') ? date('d-m-Y', strtotime($batch->ed_date)) : '' ; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="radios">Status <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="radio">
                        <label for="radios-0">
                            <input name="status" id="radios-0" value="active" type="radio" <?php echo ($batch->status == 'active') ? 'checked' : ''; ?>> Active
                        </label>
                    </div>
                    <div class="radio">
                        <label for="radios-1">
                            <input name="status" id="radios-1" value="inactive" type="radio" <?php echo ($batch->status == 'inactive') ? 'checked' : ''; ?>> Inactive
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo ADMIN_URL . 'batch' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
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