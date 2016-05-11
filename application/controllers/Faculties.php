<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faculties extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exams_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function allFacultyInput() {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }

        // PAGINATION CONFIG
        $pagConfig['base_url'] = base_url('faculties/allFacultyInput');
        $pagConfig['total_rows'] = $this->exams_model->count_exams_for_faculty_input();   
        $pagConfig['per_page'] = 5;   
        $this->pagination->initialize($pagConfig);
        $data['pagnation_links'] = $this->pagination->create_links();
            
        // GET ALL EXAMS
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['exams'] = $this->exams_model->get_exams_for_faculty_input($pagConfig['per_page'],$data['page']);
        $data['allExamsForPrint'] = $this->exams_model->get_exams_for_faculty_input(0,0);
        
        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('exams/all_faculty_input', $data);
        $this->load->view('templates/footer');
    }

    // GO TO CERTAIN EXAM FOR SCORING
    public function scoreFinalPlacement($examId,$page) {

        $data['page'] = $page;

        if (!$this->session->userId) {
            redirect('/');
        }
        
        $data['exam'] = $this->exams_model->get_exam($examId);
        
        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('exams/score_final_placement', $data);
        $this->load->view('templates/footer');
    }

    // PROCESS SCORING ON EXAM
    public function processFinalPlacement() {

        if (!$this->session->userType['admin']) {
            redirect('/');
        }

        $this->form_validation->set_rules('finalPlacement', 'Final Placement', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->scoreFinalPlacement($this->input->post('id'), $this->input->post('page'));
        } else {
            $scoredExamId = $this->input->post('id');
            $finalPlacementScore = $this->input->post('finalPlacement');
                
            $updateData = array(
                'id' => $scoredExamId,
                'final_score' => $finalPlacementScore
            );

            $pageNum = $this->input->post('page');

            $result = $this->exams_model->score_exam_final_placement($updateData);
            if($result) {
                $this->session->set_flashdata('examScoreMessage','Successfully Scored Exam Final Placement');
                redirect(base_url('faculties/allFacultyInput/'.$pageNum));
                
            } else {
                $this->session->set_flashdata('examScoreMessage','Unable to Score Exam');
                redirect(base_url('faculties/allFacultyInput/'.$pageNum));
            }
        }
        
    }

}