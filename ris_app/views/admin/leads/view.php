<script type="text/javascript" >
    jQuery(document).ready(function() {
        loaDatatable();

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
                {"sClass": ""},{"sClass": ""},{"sClass": ""},
                {"sClass": ""},{"sClass": ""},{"sClass": ""}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . 'lead/getjson?cat_id='; ?>" + jQuery('#businesscategory_id').val() + '&sub_cat_id=' + jQuery('#businesssubcategory_id').val() + '&country_id=' + jQuery('#country_id').val() + '&state_id=' + jQuery('#state_id').val() + '&city_id=' + jQuery('#city_id').val(),
        });
    }

</script>

<div class="row">
    <div class="col-md-12">
        <h4>Filters</h4>
        <hr />
        <div class="row">
            <div class="col-md-6">
                <select id="businesscategory_id" class="form-control chosen-select">
                    <option value="0">All Bussiness Category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6">
                <select id="businesssubcategory_id" class="form-control chosen-select">
                    <option value="0">All Bussiness Sub Category</option>
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
<div class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead>
            <tr align="left">
                <th>Name</th>
                <th width="100">Category</th>
                <th width="150">Sub Category</th>
                <th width="100">Country</th>
                <th width="100">State</th>
                <th width="100">City</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td colspan="5"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>