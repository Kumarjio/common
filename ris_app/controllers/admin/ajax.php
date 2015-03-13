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
}
