<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
<script type="text/javascript" src="<?php echo PLUGIN_URL; ?>tree/js/jquery.tree.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PLUGIN_URL; ?>tree/css/jquery.tree.css"/>
<style>
    .ui-widget-content {
        border: 0px solid #aaaaaa;
    }
</style>
<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#add").validate({
            rules: {
                en_role_name: {
                    remote: {
                        url: "<?php echo ADMIN_URL . 'role/check/' . $role->id; ?>",
                        type: "post",
                        data: {
                            en_role_name: function() {
                                return $( "#en_role_name" ).val();
                            }
                        }
                    }
                }
            },
            messages: {
                en_role_name: {
                    remote: '* <?php echo $this->lang->line("role_exits"); ?>'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                    error.appendTo(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            }
        });
        
        $('#permission_tree div').tree({
            dnd : false
        });
        
    });
    //]]>
</script>
<h1 class="page-heading"><?php echo $this->lang->line('edit'), ' ', $this->lang->line('role'); ?></h1>
<div class="the-box">

    <form id="add" method="post" class="form-horizontal" action="<?php echo base_url() . 'role/edit/' . $role->id; ?>">

        <div class="form-group">
            <label class="col-lg-2 control-label">Role <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control" name="role_name" palceholder="Role Name"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-lg-2 control-label">
                Permissions
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-lg-9">
                <div id="permission_tree">
                    <ul class="permission-tree-ul">
                        <?php echo loopPermissionArray(createPermissionArray(), unserialize($role->permission)); ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-3 control-label">&nbsp;</label>
            <div class="col-lg-5">
                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                <a href="<?php echo ADMIN_URL. 'role' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-3 control-label">&nbsp;</label>
            <div class="col-lg-5">
                <?php echo $this->lang->line('compulsory_note'); ?>
            </div>
        </div>
    </form>
</div>