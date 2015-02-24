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

        jQuery('.summernote-sm').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
    //]]>
</script>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'email/edit/' . @$email->id; ?>" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-lg-2 control-label">Subject <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="subject" value="<?php echo $email->subject ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Message <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <textarea  class="required summernote-sm" name="message"><?php echo $email->message; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Short codes <span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <pre class="prettyprint linenums"><?php echo $email->format_info; ?></pre>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo ADMIN_URL . 'email' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
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