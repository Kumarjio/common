<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ajax extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->session_data = $this->session->userdata('user_session');
    }
    
    
    function getAllBussinessSubCategoryFromBussinessCategory($bussiness_category_id) {
        $businesssubcategory = New Businesssubcategory();
        $businesssubcategory->Where('businesscategory_id', $bussiness_category_id);
        echo '<option value="">Select Bussiness Sub Category</option>';
        foreach ($businesssubcategory->get() as $subcategory) {
            echo '<option value="' . $subcategory->id . '">' . $subcategory->name . '</option>';
        }
    }

    function getBatchFee($id){
        $batch = New Batch();
        $batch->where('id', $id)->get();
        echo $batch->fee;
    }

    function getDashboardTotalCountData(){
            $obj_cat = new Businesscategory();
            $data['total_bussiness_categories'] = $obj_cat->count();

            $obj_sub_cat = new Businesssubcategory();
            $data['total_bussiness_sub_categories'] = $obj_sub_cat->count();

            $obj_company = new Company();
            $data['total_compaines'] = $obj_company->count();

            $obj_scrap = new Scrap();
            $total = $obj_scrap->count();
            $obj_scrap->where('status', '1')->get();
            $data['total_urls'] = $obj_scrap->result_count() .' / ' . $total;

            $obj_leads = new Lead();
            $data['total_leads'] = $obj_leads->count();

            echo json_encode(array('total_counts' => $data));
    }

    function getAllStatesOptionsFromCountry($country_id) {
        $states = New State();
        $states->Where('country_id', $country_id);
        $states->order_by('name', 'ASC');
        $states->get();
        echo '<option value="">Select Sate</option>';
        foreach ($states as $state) {
            echo '<option value="' . $state->id . '">' . $state->name . '</option>';
        }
    }
    
    function getAllCitiesOptionsFromState($state_id) {
        $cities = New City();
        $cities->Where('state_id', $state_id);
        $cities->order_by('name', 'ASC');
        $cities->get();
        echo '<option value="">Select City</option>';
        foreach ($cities as $city) {
            echo '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
    }

}
