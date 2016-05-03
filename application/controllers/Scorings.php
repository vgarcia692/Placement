<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scorings extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exams_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function allScoringExams() {
        if (!$this->session->userType=='userId') {
            redirect('/');
        }

        // PAGINATION CONFIG
        $pagConfig['base_url'] = base_url('scorings/allScoringExams');
        $pagConfig['total_rows'] = $this->exams_model->count_exams_to_score_writing();   
        $pagConfig['per_page'] = 20;   
        $this->pagination->initialize($pagConfig);
        $data['pagnation_links'] = $this->pagination->create_links();
            
        // GET ALL EXAMS
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['exams'] = $this->exams_model->get_exams_to_score_writing($pagConfig['per_page'],$data['page']);
        
        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('exams/exam_scoring', $data);
        $this->load->view('templates/footer');
    }

    // GO TO CERTAIN EXAM FOR SCORING
    public function scoreExam($examId,$page) {

        $data['page'] = $page;

        if (!$this->session->userId) {
            redirect('/');
        }
        
        $data['exam'] = $this->exams_model->get_exam($examId);
        
        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('exams/score_exam', $data);
        $this->load->view('templates/footer');
    }

    // PROCESS SCORING ON EXAM
    public function processScore() {

        if (!$this->session->userId) {
            redirect('/');
        }

        $this->form_validation->set_rules('score', 'Score', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->scoreExam($this->input->post('id'), $this->input->post('page'));
        } else {
            $scoredExamId = $this->input->post('id');
            $writingSampleScore = $this->input->post('score');
            $exam = $this->exams_model->get_exam_accuplacer_level($this->input->post('id'));
            $accuplacerLevel = $exam['accuplacer_level'];
            $updateData = array();
            if (abs($accuplacerLevel - $writingSampleScore) >= 2) {
                // IF THERE WAS A CONFLICT OF TWO POINTS     
                $updateData = array(
                    'id' => $scoredExamId,
                    'writing_sample_score' => $writingSampleScore
                );
            } else {
                // IF THE SCORING DID NOT HAVE A CONFLICT OF 2 POINTS
                
                // GET THE MINIMUM SCORE
                $finalScore = ($writingSampleScore < $accuplacerLevel) ? $writingSampleScore : $accuplacerLevel;
                
                $updateData = array(
                    'id' => $scoredExamId,
                    'writing_sample_score' => $writingSampleScore,
                    'final_score' => $finalScore
                );
            }

            $pageNum = $this->input->post('page');

            $result = $this->exams_model->update_exam($updateData);
            if($result) {
                if ($result=='facultyInput') {
                    $this->session->set_flashdata('examScoreMessage','Writing Sample Scored Without Final Placement');
                    redirect(base_url('scorings/allScoringExams/'.$pageNum));
                } else {
                    $this->session->set_flashdata('examScoreMessage','Successfully Scored Exam and Final Placement');
                    redirect(base_url('scorings/allScoringExams/'.$pageNum));
                }
            } else {
                $this->session->set_flashdata('examScoreMessage','Unable to Score Exam');
                redirect(base_url('scorings/allScoringExams/'.$pageNum));
            }
        }
        
    }
    

}