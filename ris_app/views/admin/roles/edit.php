<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
<script type="text/javascript" src="<?php echo PLUGIN_URL; ?>tree/js/jquery.tree.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PLUGIN_URL; ?>tree/css/jquery.tree.css"/>

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
                    remote: '* Role Name already exits.'
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

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1>Manage Roles</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
    <form id="add" method="post" class="form-horizontal" action="<?php echo ADMIN_URL . 'role/edit/' . $role->id; ?>">
        <div class="form-group">
            <label class="col-lg-2 control-label">Role Name<span class="text-danger">&nbsp;</span></label>
            <div class="col-lg-4">
                <input type="text" name="name" class="form-control required" value="<?php echo $role->name; ?>"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-lg-2 control-label">
                Permission
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-lg-10">
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
            <label class="col-lg-2 control-label">&nbsp;</label>
            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                <a href="<?php echo ADMIN_URL . 'role' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
            </div>
        </div>

    </form>
</div>
</div>