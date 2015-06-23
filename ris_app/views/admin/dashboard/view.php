<script type="text/javascript">
    $(document).ready(function(){
        get_total_count();
    });

    function get_total_count(){
        $.ajax({
            type : 'POST',
            url : http_host_js + 'get_dashboard_count',
            dataType : 'JSON',
            success: function(data) {
                if(data != ''){
                    jQuery('#total_bussiness_categories').html(data.total_counts.total_bussiness_categories);
                    jQuery('#total_bussiness_sub_categories').html(data.total_counts.total_bussiness_sub_categories);
                    jQuery('#total_compaines').html(data.total_counts.total_compaines);
                    jQuery('#total_urls').html(data.total_counts.total_urls);
                    jQuery('#total_leads').html(data.total_counts.total_leads);
                } else {
                    jQuery('#total_bussiness_categories').html('0');
                    jQuery('#total_bussiness_sub_categories').html('0');
                    jQuery('#total_compaines').html('0');
                    jQuery('#total_urls').html('0');
                    jQuery('#total_leads').html('0');
                }

                setTimeout(function() {
                    get_total_count();
                }, <?php echo $this->config->item('notification_timer'); ?>);

            }
        });
    }    
</script>

<div class="row">
    <?php if (hasPermission('scraps', 'viewScrap')) { ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 id="total_urls"></h3>
                    <p>Scrap Urls</p>
                </div>
                <div class="icon"><i class="ion ion-clipboard"></i></div>
                <span class="small-box-footer">&nbsp;</span>
            </div>
        </div>
    <?php } ?>
    
    <?php if (hasPermission('leads', 'viewLead')) { ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3 id="total_leads"></h3>
                    <p>Leads</p>
                </div>
                <div class="icon"><i class="ion ion-android-friends"></i></div>
                <span class="text-right small-box-footer"><a href="#" class=""> View All</a></span>
            </div>
        </div>
    <?php } ?>

    <?php if (hasPermission('companies', 'viewCompany')) { ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 id="total_compaines"></h3>
                    <p>Companies</p>
                </div>
                <div class="icon"><i class="ion ion-stats-bars"></i></div>
                <span class="small-box-footer">&nbsp;</span>
            </div>
        </div>
    <?php } ?>
</div>

<div class="row">
    <?php if (hasPermission('businesscategories', 'viewBusinesscategory')) { ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-light-blue">
                <div class="inner">
                    <h3 id="total_bussiness_categories"></h3>
                    <p>Bussiness Caegories</p>
                </div>
                <div class="icon"><i class="ion ion-android-friends"></i></div>
                <span class="text-right small-box-footer"><a href="#" class=""> View All</a></span>
            </div>
        </div>
    <?php } ?>

    <?php if (hasPermission('businesssubcategories', 'viewBusinesssubcategory')) { ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="total_bussiness_sub_categories"></h3>
                    <p>Bussiness Sub Caegories</p>
                </div>
                <div class="icon"><i class="ion ion-android-contacts"></i></div>
                <span class="small-box-footer">&nbsp;</span>
            </div>
        </div>
    <?php } ?>
</div>