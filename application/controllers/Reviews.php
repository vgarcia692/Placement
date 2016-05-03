<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exams_model');
        $this->load->model('schools_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->helper('form');
    }

    public function listSchools() {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }

        $exams = $this->schools_model->get_all_schools();
        $data['schools'] = $exams;
        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('review/school_listing', $data);
        $this->load->view('templates/footer');
    }

    public function allExams($hs) {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }

        if (isset($_POST['search'])) {
            $name = $this->input->post('search');
            $data['searchTerm'] = $name;
            
            // PAGINATION CONFIG
            $pagConfig['base_url'] = base_url('reviews/allExams'.'/'.$hs);
            $result = $this->exams_model->count_all_like_name_exams($hs,$name);   
            $pagConfig['total_rows'] = $result['number']; 
            $pagConfig['per_page'] = 20;   
            $this->pagination->initialize($pagConfig);
            $data['pagnation_links'] = $this->pagination->create_links();
                
            // GET ALL EXAMS
            $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $data['exams'] = $this->exams_model->get_all_like_name_exams($pagConfig['per_page'],$data['page'],$hs,$name);


        } else {
            
            // PAGINATION CONFIG
            $pagConfig['base_url'] = base_url('reviews/allExams'.'/'.$hs);
            $pagConfig['total_rows'] = $this->exams_model->count_all_school_exams($hs);   
            $pagConfig['per_page'] = 20;   
            $this->pagination->initialize($pagConfig);
            $data['pagnation_links'] = $this->pagination->create_links();
                
            // GET ALL EXAMS
            $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $data['exams'] = $this->exams_model->get_all_school_exams($pagConfig['per_page'],$data['page'],$hs);

        }


        $data['hs'] = $hs;

        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('review/school_exams', $data);
        $this->load->view('templates/footer');
    }

    public function exam($id) {
        $data['id'] = $id;

        // Get all exam info
        $data['exam'] = $this->exams_model->get_exam_info($id);

        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('review/exam_detail', $data);
    }

    public function saveSisNameNumber() {
        $response = array(
            'status' => 'fail'
        );
        if($_POST['sisName']==""||$_POST['sisNumber']=="") {
            echo json_encode($response);
        } else {
            $updateData = array(
                'sisName' => $_POST['sisName'],
                'sisNumber' => $_POST['sisNumber'],
                'id' => $_POST['id']
            );

            $result = $this->exams_model->update_sis_name_number($updateData);
            if ($result) {
                $response['status'] = 'success';
                echo json_encode($response);
            } else {
                echo json_encode($response);
            }
            
        }  
    }

    public function saveAdmissionRegistrationDroppedSem() {
        $response = array(
            'status' => 'fail'
        );
        
        switch ($_POST['type']) {
            case 'admission':
                $updateData = array(
                    'value'  => $_POST['value'],
                    'id'  => $_POST['id']
                );
                if ($_POST['value']==true) {
                    $result = $this->exams_model->update_is_admission_complete($updateData);
                    if ($result) {
                        $response['value'] = intval($_POST['value']);
                        $response['status'] = 'success';
                        echo json_encode($response);
                    } else {
                        $response['status'] = 'fail';
                        echo json_encode($response);
                    }
                } else {
                    $this->exams_model->remove_admission_date($updateData);
                    $response['status'] = 'success';
                    echo json_encode($response);
                }
                break;
            case 'register':
                $updateData = array(
                    'value'  => $_POST['value'],
                    'id'  => $_POST['id']
                );
                if ($_POST['value']==true) {
                    $result = $this->exams_model->update_is_register_complete($updateData);
                    if ($result) {
                        $response['status'] = 'success';
                        echo json_encode($response);
                    } else {
                        $response['status'] = 'fail';
                        echo json_encode($response);
                    }
                } else {
                    $this->exams_model->remove_register_year_sem($updateData);
                    $response['status'] = 'success';
                    echo json_encode($response);
                }
                break;
            case 'droppedSem':
                $updateData = array(
                    'value'  => $_POST['value'],
                    'id'  => $_POST['id']
                );
                $result = $this->exams_model->update_dropped_semester($updateData);
                if ($result) {
                    $response['status'] = 'success';
                    echo json_encode($response);
                } else {
                    $response['status'] = 'fail';
                    echo json_encode($response);
                }
                break;
            
            default:
                echo json_encode($response);
                break;
        }
        
    }

    public function saveAdmissionDate() {
        $response = array(
            'status' => 'fail'
        );
        if($_POST['date']=="") {
            echo json_encode($response);
        } else {
            $updateData = array(
                'date' => $_POST['date'],
                'id' => $_POST['id']
            );

            $result = $this->exams_model->update_admission_date($updateData);
            if ($result) {
                $response['status'] = 'success';
                echo json_encode($response);
            } else {
                echo json_encode($response);
            }
            
        } 
    }

    public function saveRegistrationYearSem() {
        $response = array(
            'status' => 'fail'
        );
        if($_POST['year']==""||$_POST['sem']=="") {
            echo json_encode($response);
        } else {
            $updateData = array(
                'year' => $_POST['year'],
                'sem' => $_POST['sem'],
                'id' => $_POST['id']
            );

            $result = $this->exams_model->update_register_sem_year($updateData);
            if ($result) {
                $response['status'] = 'success';
                echo json_encode($response);
            } else {
                echo json_encode($response);
            }
            
        } 
    }


}