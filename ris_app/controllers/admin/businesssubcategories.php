<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class businesssubcategories extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Business Sub Categories');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    public function viewBusinesssubcategory() {
        if (empty($this->session_data)) {
            redirect(ADMIN_URL . 'login', 'refresh');
        } else {
            $data['page_h1_title'] = 'List Business Sub Categories';           
            $this->layout->view('admin/businesssubcategories/view', $data);
        }
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('sub.name', 'sub.status', 'cat.name AS cat_name');
        $this->datatable->eColumns = array('sub.id');
        $this->datatable->sIndexColumn = "sub.id";
        $this->datatable->sTable = " businesssubcategories sub, businesscategories cat";
        $this->datatable->myWhere = " WHERE sub.businesscategory_id=cat.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['name'];
            $temp_arr[] = $aRow['cat_name'];

            if($aRow['status'] == 'Active') {
                $temp_arr[] = '<label class="label label-success">Active</label>';
            } else {
                $temp_arr[] = '<label class="label label-danger">InActive</label>';
            }

            $temp_arr[] = '<a href="' . ADMIN_URL . 'businesssubcategory/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function addBusinesssubcategory() {
        if ($this->input->post() !== false) {
            $businesssubcategory = new Businesssubcategory();
            $businesssubcategory->businesscategory_id = $this->input->post('businesscategory_id');
            $businesssubcategory->name = $this->input->post('name');
            $businesssubcategory->status = $this->input->post('status');
            $businesssubcategory->user_id = $this->session_data->id;
            $businesssubcategory->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'businesssubcategory', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add Business category');
            $data['page_h1_title'] = 'Add Business Sub Category';

            $obj_cat = new Businesscategory();
            $data['categories'] = $obj_cat->get();

            $this->layout->view('admin/businesssubcategories/add', $data);
        }
    }

    function editBusinesssubcategory($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $businesssubcategory = new Businesssubcategory();
                $businesssubcategory->where('id', $id)->get();
                $businesssubcategory->businesscategory_id = $this->input->post('businesscategory_id');
                $businesssubcategory->name = $this->input->post('name');
                $businesssubcategory->status = $this->input->post('status');
                $businesssubcategory->user_id = $this->session_data->id;
                $businesssubcategory->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'businesssubcategory', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Business category');
                $businesssubcategory = new Businesssubcategory();
                $data['businesssubcategory'] = $businesssubcategory->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Business Sub Categories'; 

                $obj_cat = new Businesscategory();
                $data['categories'] = $obj_cat->get();
                $this->layout->view('admin/businesssubcategories/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'businesssubcategory', 'refresh');
        }
    }
}
