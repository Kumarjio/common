<script type="text/javascript" >
    jQuery(document).ready(function() {
        loaDatatable();

        jQuery('#site_type').change(function(){
            loaDatatable();
        });

        jQuery('#businesscategory_id').change(function(){
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo ADMIN_URL ."get_sub_cat_bussiness/"; ?>' + $('#businesscategory_id').val(),
                success: function(data){
                    jQuery('#businesssubcategory_id').empty();
                    jQuery('#businesssubcategory_id').append(data);
                    jQuery("#businesssubcategory_id").trigger("chosen:updated");
                    loaDatatable();
                }
            });
        });

        jQuery('#businesssubcategory_id').change(function(){
            loaDatatable();
        });

        jQuery('#country_id').change(function(){
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo ADMIN_URL ."get_state/"; ?>' + $('#country_id').val(),
                success: function(data){
                    jQuery('#state_id').empty();
                    jQuery('#state_id').append(data);
                    jQuery("#state_id").trigger("chosen:updated");
                    loaDatatable();
                }
            });
        });

        jQuery('#state_id').change(function(){
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo ADMIN_URL ."get_city/"; ?>' + $('#state_id').val(),
                success: function(data){
                    jQuery('#city_id').empty();
                    jQuery('#city_id').append(data);
                    jQuery("#city_id").trigger("chosen:updated");
                    loaDatatable();
                }
            });
        });

        jQuery('#city_id').change(function(){
            loaDatatable();
        });

        $('#mainpanel').delegate('.detailReport', 'click', function(e){
            e.preventDefault();
            $this = $(this);
            table = jQuery('#list_data').DataTable();
            jQuery.ajax({
                url: $this.attr('data-url'),
                success: function(data) {
                    var tr = $this.closest('tr');
                    var row = table.row(tr);
                    if (row.child.isShown()) {
                        $this.find('i.detail-icon').removeClass('fa-minus-circle');
                        $this.find('i.detail-icon').addClass('fa-plus-circle');
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        $this.find('i.detail-icon').addClass('fa-minus-circle');
                        $this.find('i.detail-icon').removeClass('fa-plus-circle');
                        row.child(data).show();
                        tr.addClass('shown');
                    }
                } 
            });
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
                {"sClass": ""},{"sClass": ""},
                {"sClass": ""},{"sClass": ""},
                {"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . 'company/getjson?type='; ?>" + jQuery('#site_type').val() + '&cat_id=' + jQuery('#businesscategory_id').val() + '&sub_cat_id=' + jQuery('#businesssubcategory_id').val() + '&country_id=' + jQuery('#country_id').val() + '&state_id=' + jQuery('#state_id').val() + '&city_id=' + jQuery('#city_id').val(),
        });
    }

    function deletedata(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        var $this = $(ele);

        swal(
            {
                title: "Manage Comapny",
                text: "Do you Want to Delete the Comapny ?",
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
                        url: http_host_js + 'company/delete/' + current_id,
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
        <a href="<?php echo ADMIN_URL . 'company/add'; ?>" class="btn btn-success"> Add New Comapny</a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <h4>Filters</h4>
        <hr />
        <div class="row">
            <div class="col-md-4">
                <select id="site_type" class="form-control filter_change">
                    <option value="0">All Site Type</option>
                    <?php foreach ($company_types as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <select id="businesscategory_id" class="form-control">
                    <option value="0">All Bussiness Category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <select id="businesssubcategory_id" class="form-control filter_change">
                    <option value="0">All Bussiness Sub Category</option>
                    <?php foreach ($sub_categories as $sub_category) { ?>
                        <option value="<?php echo $sub_category->id; ?>"><?php echo $sub_category->name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-4">
                <select id="country_id" class="form-control chosen-select">
                    <option value="0">All Country</option>
                    <?php foreach ($countries as $country) { ?>
                        <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-4">
                <select id="state_id" class="form-control chosen-select">
                    <option value="0">All Sates</option>
                </select>
            </div>

            <div class="col-md-4">
                <select id="city_id" class="form-control chosen-select">
                    <option value="0">All City</option>
                </select>
            </div>
        </div>
        <hr />
    </div>
</div>
<br />
<div id="mainpanel" class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead>
            <tr align="left">
                <th>Company Name</th>
                <th width="200">Type</th>
                <th width="100">Category</th>
                <th width="150">Sub Category</th>
                <th width="100">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td colspan="5"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>