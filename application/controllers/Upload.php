<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exams_model');
        $this->load->library('form_validation');
    }

    public function uploadForm() {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }

        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('exams/upload');
        $this->load->view('templates/footer');
    }

    public function processUpload() {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }
        
        $this->form_validation->set_rules('upload', 'CSV FILE', 'required');
        $this->form_validation->set_rules('testDate', 'Test Date', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->uploadForm();
        }

        $fileName = base_url('uploads/'.$this->uploadFile());

        $csv = array_map('str_getcsv', file($fileName));

        if (!isset($_POST['doNotIncludesFields'])) {
            array_shift($csv);    
        }

        for ($i=0; $i < count($csv); $i++) { 
            if (isset($csv[$i][4])) {
                $str1 = substr($csv[$i][4], 0,2).'/';
                $str2 = substr($csv[$i][4], 2,2).'/';
                $str3 = substr($csv[$i][4], -2);
                $csv[$i][4] = date_format(date_create($str1.$str2.$str3),'Y-m-d');
            }
            $csv[$i][27] = $this->input->post('testDate');
        }

        // IF CHECKED COMMUNITY THEN ADD THE VALUE
        if ($this->input->post('isCommunity')) {
            for ($i=0; $i < count($csv); $i++) { 
                $csv[$i][28] = true;
            }
        }
        // echo $this->input->post('doNotIncludesFields');

        // echo "<pre>";
        // print_r($csv);
        // echo "</pre>";
        
        // CHECK THE FIRST ELEMENT OF FIRST ARRAY TO SEE IF IT IS THE HEADER OR A DATE
        // SEEING IF THE FIELDS WERE INCLUDED OR NOT
        $validDate = $this->validateDate($csv[0][0]);
        if ($validDate) {
            $result = $this->exams_model->upload_exams($csv);
            if($result) {
                $this->session->set_flashdata('uploadMessage', 'Upload Successfull.');
                $this->session->set_flashdata('uploadResult', $result);
                redirect(base_url('upload/uploadSuccess'));
                // echo "<pre>";
                // print_r($result);
                // echo "</pre>";
                // $this->uploadSuccess($result);
            } else {
                $this->session->set_flashdata('uploadMessage', 'Could not upload CSV file, please check that the file is valid.');
                redirect(base_url('upload/uploadForm'));
            }
            
        } else {
            $this->session->set_flashdata('uploadMessage', 'Could not upload CSV file, please check that the file is valid. Check to see if field headers are included');
            redirect(base_url('upload/uploadForm'));
        }
        
    }

    public function uploadFile() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '5000';
        
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            echo $this->upload->display_errors();
        } else {
            return $this->upload->data('file_name');
        }

    }

    private function validateDate($firstElementInCSV) {
        if ($firstElementInCSV == "Last Name") {
            return FALSE;
        } else { 
            return TRUE;
        }
    }

    public function uploadSuccess() {

        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('exams/upload_success_exams');
        $this->load->view('templates/footer');
    }

}