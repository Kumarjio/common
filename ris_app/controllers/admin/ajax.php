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
            $data['total_urls'] = $obj_scrap->count();

            echo json_encode(array('total_counts' => $data));
    }
}
