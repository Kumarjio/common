<script type="text/javascript" >
    jQuery(document).ready(function() {
        jQuery('#list_data').dataTable({
            "bProcessing": true,
            "aLengthMenu": [ [<?php echo $this->config->item('data_table_length'); ?>], [<?php echo $this->config->item('data_table_length'); ?>] ],
            'iDisplayLength': <?php $lengths = explode(',', $this->config->item('data_table_length'));
            echo $lengths[0]; ?>,
            "bServerSide" : true,
            "aoColumns": [
                {"sClass": ""},{"sClass": ""},
                {"bSortable": false, "sClass": "text-center"},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . 'businesssubcategory/getjson'; ?>",
        });
    });

</script>

<div class="row">
    <div class="col-md-12 text-right">
        <a href="<?php echo ADMIN_URL . 'businesssubcategory/add'; ?>" class="btn btn-success"> Add New Sub Category</a>
    </div>
</div>
<br />
<div class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead>
            <tr align="left">
                <th>Name</th>
                <th width="200">Category</th>
                <th width="50">Status</th>
                <th width="50">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td colspan="4"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>