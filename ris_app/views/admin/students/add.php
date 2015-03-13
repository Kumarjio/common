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

        jQuery('select[name="batch_id"').on("change",function(){
            jQuery.ajax({
                url: '<?php echo ADMIN_URL ."get_batch_fee/" ?>' + jQuery(this).val(),
                success: function(data) {
                    $('input[name="fee"]').val(data);
                }
            }); 
        });

    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'student/add'; ?>">
            <div class="form-group">
                <label class="col-lg-2 control-label">Batch <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="batch_id" class="form-control">
                        <option value="">Select Batch</option>
                        option
                        <?php foreach ($batches as $batch) { ?>
                            <option value="<?php echo $batch->id; ?>"><?php echo $batch->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Name <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="name" placeholder="Name"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">college <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="college" placeholder="College"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">project <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="project" placeholder="Project Title"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">fee <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="fee" placeholder="Fee"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Save">Save</button>
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