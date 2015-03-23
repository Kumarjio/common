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
        
        $('#permission_tree-checkAll').click(function(){
            $('#permission_tree div').tree('checkAll');
        });

        $('#permission_tree-uncheckAll').click(function(){
            $('#permission_tree div').tree('uncheckAll');
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
            <label class="col-lg-3 control-label">&nbsp;</label>
            <div class="col-lg-5">
                 <button id="permission_tree-checkAll" type="button" class="btn btn-default">Check All</button>
                <button id="permission_tree-uncheckAll" type="button" class="btn btn-default">Uncheck All</button>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-lg-3 control-label">
                <?php echo $this->lang->line('permission'); ?>
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-lg-5">
                <div id="permission_tree">
                    <div>
                        <ul>
                            <?php echo loopPermissionArray(createPermissionArray(), unserialize($role->permission)); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-3 control-label">&nbsp;</label>
            <div class="col-lg-5">
                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                <a href="<?php echo base_url() . 'role' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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