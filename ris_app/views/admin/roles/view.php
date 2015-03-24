<script type="text/javascript" >
    $(document).ready(function() {
        $('#list_data').dataTable({
            "bProcessing": true,
            "aLengthMenu": [ [<?php echo $this->config->item('data_table_length'); ?>], [<?php echo $this->config->item('data_table_length'); ?>] ],
            'iDisplayLength': <?php $lengths = explode(',', $this->config->item('data_table_length'));
            echo $lengths[0]; ?>,
            "bServerSide" : true,
            "aoColumns": [
                {"sClass": ""},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . "role/getjson"; ?>",
        });
    });

</script>

<div class="row">
    <div class="col-md-12 text-right">
        <a href="<?php echo ADMIN_URL . 'role/add'; ?>" class="btn btn-success"> Add Role</a>
    </div>
</div>
<br />
<div id="mainpanel" class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead class="the-box dark full">
            <tr align="left">
                <th>Role Name</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>