<script type="text/javascript" >
    jQuery(document).ready(function() {
        loaDatatable();

        jQuery('.filter_chage').change(function(){
            loaDatatable();            
        });        
    });

    function loaDatatable(){
        if(typeof dTable!='undefined'){dTable.fnDestroy();}
        
        dTable=jQuery('#list_data').dataTable({
            "bProcessing": true,
            "aLengthMenu": [ [<?php echo $this->config->item('data_table_length'); ?>], [<?php echo $this->config->item('data_table_length'); ?>] ],
            'iDisplayLength': <?php $lengths = explode(',', $this->config->item('data_table_length'));
            echo $lengths[0]; ?>,
            "bServerSide" : true,
            "aoColumns": [
                {"sClass": ""},{"sClass": ""},{"sClass": ""},{"sClass": ""},{"sClass": ""},
                {"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . 'newsletter/getjson/'; ?>" + jQuery('#site_type').val() + '/' + jQuery('#categories').val() + '/' + jQuery('#sub_categories').val(),
        });
    }

    function deletedata(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        var $this = $(ele);

        swal(
            {
                title: "Manage Campaign",
                text: "Do you Want to Delete the Campaign and related ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: http_host_js + 'newsletter/delete/' + current_id,
                        data: id = current_id,
                        dataType : 'JSON',
                        success: function(data) {
                            if(data.status == 'success'){
                                loaDatatable();
                                swal("Deleted!", data.msg, "success");
                            }else{
                                swal("Error!", data.msg, "error");
                            }
                        }
                    });
                }
            }
        );
        return false;
    }

</script>

<div class="row">
    <div class="col-md-12 text-right">
        <a href="<?php echo ADMIN_URL . 'newsletter/add'; ?>" class="btn btn-success"> Add New Campaign</a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-4">
        <select id="site_type" class="form-control filter_chage">
            <option value="0">All Site Type</option>
            <?php foreach ($company_types as $key => $value) { ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <select id="categories" class="form-control filter_chage">
            <option value="0">All Bussiness Category</option>
            <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <select id="sub_categories" class="form-control filter_chage">
            <option value="0">All Bussiness Sub Category</option>
            <?php foreach ($sub_categories as $sub_category) { ?>
                <option value="<?php echo $sub_category->id; ?>"><?php echo $sub_category->name; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<br />
<div class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead>
            <tr align="left">
                <th width="100">Date</th>
                <th>Template Subject</th>
                <th width="75">Type</th>
                <th width="100">Category</th>
                <th width="150">Sub Category</th>
                <th width="100">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td colspan="6"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>