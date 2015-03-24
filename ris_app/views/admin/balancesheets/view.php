<script type="text/javascript" >
    jQuery(document).ready(function() {
        loadDatatable();

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
                        $this.find('i').removeClass('fa-minus-circle');
                        $this.find('i').addClass('fa-plus-circle');
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        $this.find('i').addClass('fa-minus-circle');
                        $this.find('i').removeClass('fa-plus-circle');
                        row.child(data).show();
                        tr.addClass('shown');
                    }
                } 
            });
        });

    });

    function loadDatatable(){
        if(typeof dTable!='undefined'){dTable.fnDestroy();}
        
        dTable=jQuery('#list_data').dataTable({
            "bProcessing": true,
            "aLengthMenu": [ [<?php echo $this->config->item('data_table_length'); ?>], [<?php echo $this->config->item('data_table_length'); ?>] ],
            'iDisplayLength': <?php $lengths = explode(',', $this->config->item('data_table_length'));
            echo $lengths[0]; ?>,
            "bServerSide" : true,
            "aaSorting" : [[0, 'desc']],
            "aoColumns": [
                {"sClass": ""},{"sClass": "text-center"},{"sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . 'balancesheet/getjson'; ?>",
        });
    }

        function deletedata(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        var $this = $(ele);

        swal(
            {
                title: "Manage Batch",
                text: "Do you Want to Delete the Batch?",
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
                        url: http_host_js + 'balancesheet/delete/' + current_id,
                        data: id = current_id,
                        dataType : 'JSON',
                        success: function(data) {
                            if(data.status == 'success'){
                                loadDatatable();
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
        <a href="<?php echo ADMIN_URL . 'balancesheet/add'; ?>" class="btn btn-success"> Add Expense</a>
    </div>
</div>
<br />
<div id="mainpanel" class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead>
            <tr align="left">
                <th>Date</th>
                <th width="15%">Outgoing</th>
                <th width="15%">Incoming</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td colspan="3"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>