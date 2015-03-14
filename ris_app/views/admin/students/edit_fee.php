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
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: '+0d'
        });

    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'student/fee/edit/' . @$studentfee->id; ?>">

            <div class="form-group">
                <label class="col-lg-2 control-label">Student <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="student_id" class="form-control">
                        <option value="">Select Student</option>
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student->id; ?>" <?php echo ($student->id == $studentfee->student_id) ? 'selected' : ''; ?>><?php echo $student->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Fee <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="fee" placeholder="Fee" value="<?php echo $studentfee->fee; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Date <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control date-picker required" name="given_date" placeholder="Date"  value="<?php echo date('d-m-Y', strtotime($studentfee->given_date)); ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo ADMIN_URL . 'student/fee' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
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