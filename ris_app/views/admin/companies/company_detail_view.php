<div class="panel panel-primary">
    <div class="panel-heading">
        <?php echo $company_detail->businesscategory_name .' / ' . $company_detail->businesssubcategory_name . ' / ' . $company_detail->country_name . ' / ' . $company_detail->state_name . ' / ' . $company_detail->city_name; ?>
    </div>
    <div class="panel-body">
	    <div class="col-lg-12">
	        <div class="col-lg-3">Type</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->type; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Website URL</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->url; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Company Name</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->company_name; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Contact Person</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->contact_person; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Email Address</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->email_address; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Landline</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->landline; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Mobile</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->mobile; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Address</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->address; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Establishment</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->estd; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>

	    <div class="col-lg-12">
	        <div class="col-lg-3">Also Listed IN</div>
	        <div class="col-lg-9">
	            <input type="text" class="form-control" value="<?php echo $company_detail->listedin; ?>"  onclick="this.select()" onfocus="this.select()"/>
	        </div>
	        <p style="clear:both"></p>
	    </div>
    </div>
</div>