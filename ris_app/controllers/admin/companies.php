<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class companies extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Company Details');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewCompany() {
        $data['page_h1_title'] = 'List companies';
        $this->layout->view('admin/companies/view', $data);
    }

    function addCompany() {
        if ($this->input->post() !== false) {
            $obj_company = new Company();
            $obj_company->type = $this->input->post('type');
            $obj_company->businesscategory_id = $this->input->post('businesscategory_id');
            $obj_company->businesssubcategory_id = $this->input->post('businesssubcategory_id');
            $obj_company->url = $this->input->post('url');
            $obj_company->company_name = $this->input->post('company_name');
            $obj_company->contact_person = $this->input->post('contact_person');
            $obj_company->email_address = $this->input->post('email_address');
            $obj_company->landline = $this->input->post('landline');
            $obj_company->mobile = $this->input->post('mobile');
            $obj_company->address = $this->input->post('address');
            $obj_company->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'company', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add New Company');
            $data['page_h1_title'] = 'Add New Company';

            $obj_cat = new Businesscategory();
            $data['categories'] = $obj_cat->get();

            $data['company_types'] = $this->config->item('company_type_array');

            $this->layout->view('admin/companies/add', $data);
        }
    }
    
    function editCompany($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $obj_company = new Company();
                $obj_company->where('id', $id)->get();
                $obj_company->type = $this->input->post('type');
                $obj_company->businesscategory_id = $this->input->post('businesscategory_id');
                $obj_company->businesssubcategory_id = $this->input->post('businesssubcategory_id');
                $obj_company->url = $this->input->post('url');
                $obj_company->company_name = $this->input->post('company_name');
                $obj_company->contact_person = $this->input->post('contact_person');
                $obj_company->email_address = $this->input->post('email_address');
                $obj_company->landline = $this->input->post('landline');
                $obj_company->mobile = $this->input->post('mobile');
                $obj_company->address = $this->input->post('address');
                $obj_company->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'company', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Company');
                $obj_company = new Company();
                $data['company'] = $obj_company->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Company Details';

                $obj_cat = new Businesscategory();
                $data['categories'] = $obj_cat->get();
                $data['company_types'] = $this->config->item('company_type_array');

                $businesssubcategory = New Businesssubcategory();
                $data['sub_categories'] = $businesssubcategory->where('businesscategory_id', $obj_company->businesscategory_id)->get();

                $this->layout->view('admin/companies/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'company', 'refresh');
        }
    }
    
    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('type', 'company_name', 'businesscategories.name AS cat_name', 'businesssubcategories.name AS sub_cat');
        $this->datatable->eColumns = array('companies.id');
        $this->datatable->sIndexColumn = "companies.id";
        $this->datatable->sTable = " companies, businesscategories, businesssubcategories";
        $this->datatable->myWhere = " WHERE companies.businesscategory_id=businesscategories.id AND companies.businesssubcategory_id=businesssubcategories.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['company_name'];
            
            $company_types = $this->config->item('company_type_array');

            $temp_arr[] = $company_types[$aRow['type']];
            $temp_arr[] = $aRow['cat_name'];
            $temp_arr[] = $aRow['sub_cat'];
            $temp_arr[] = '<a href="' . ADMIN_URL . 'company/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
