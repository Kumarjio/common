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
        <form id="edit" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'balancesheet/edit/' . $expense->id; ?>">
            <div class="form-group">
                <label class="col-lg-2 control-label">Type <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="radio-inline">
                        <label for="radios-I">
                            <input name="type" id="radios-I" value="I" type="radio" class="required" <?php echo $expense->type == 'I' ? 'checked' : ''; ?>>&nbsp;Income
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label for="radios-O">
                            <input name="type" id="radios-O" value="O" type="radio" class="required"  <?php echo $expense->type == 'O' ? 'checked' : ''; ?>>&nbsp;Outgoing
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Date <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control date-picker required" name="expense_date" placeholder="Date" value="<?php echo date('d-m-Y', strtotime($expense->expense_date)); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Amount <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" name="amount" placeholder="Amount" value="<?php echo $expense->amount; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Note <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <textarea class="form-control required" name="description" rows="5"><?php echo $expense->description; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Save">Save</button>
                    <a href="<?php echo ADMIN_URL . 'balancesheet' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
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