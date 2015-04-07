<div class="panel panel-primary">
    <div class="panel-heading">
        <?php echo $lead_detail->businesscategory_name .' / ' . $lead_detail->businesssubcategory_name . ' / ' . $lead_detail->country_name . ' / ' . $lead_detail->state_name . ' / ' . $lead_detail->city_name; ?>
    </div>
    <div class="panel-body">
	    <div class="col-lg-12">
	        <div class="col-lg-3">Name</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $lead_detail->name; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Address</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $lead_detail->address; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Phone</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $lead_detail->phone_number; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Email</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $lead_detail->email; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Website</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $lead_detail->website; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>
    </div>
</div>