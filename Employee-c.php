<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/employee_model');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data = array();
    }

    function index(){
        $data = array();
		$data['title'] = 'Add New Employee';
		$data['header'] = $this->load->view('inc/header', $data, true);
		$data['footer'] = $this->load->view('inc/footer', '', true);
		$data['sidebar'] = $this->load->view('inc/sidebar', '', true);
		$data['content'] = $this->load->view('inc/staff/employee', $data, true);
		$this->load->view('home', $data);
    }
    public function showAllEmployee(){
        $result = $this->employee_model->showAllEmployee();
        echo json_encode($result);
         
	}
	public function addEmployee()
	{
		$result = $this->employee_model->addEmployee();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if ($result) {
			$msg['success'] = true;
		}
        echo json_encode($msg); 
	}
	public function editEmployee(){
        $result = $this->employee_model->editEmployee();
        echo json_encode($result);
         
	}
	public function updateEmployee(){
        $result = $this->employee_model->updateEmployee();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if ($result) {
			$msg['success'] = true;
		}
        echo json_encode($msg); 
         
	}

	public function deleteEmployee(){
        $result = $this->employee_model->deleteEmployee();
		$msg['success'] = false;
		 
		if ($result) {
			$msg['success'] = true;
		}
        echo json_encode($msg); 
         
	}

}