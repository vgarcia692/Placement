<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exams_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function upload_exams($data) {
        $insertData = array();

        // Loop through each exam
        foreach ($data as $key => $exam) {

            // Calculate English Score
            $englishTotalScore = $exam[14] + $exam[17] + $exam[20];

            // Calcualte Accuplacer English Level
            $accuplacer_level = 0;
            switch(true) {
               case ($englishTotalScore < 42):
                  $accuplacer_level = 0;
               break;
               case in_array($englishTotalScore, range(42,57)): 
                  $accuplacer_level = 1;
               break;
               case in_array($englishTotalScore, range(58,72)):
                  $accuplacer_level = 2;
               break;
               case in_array($englishTotalScore, range(73,84)):
                  $accuplacer_level = 3;
               break;
               case ($englishTotalScore >= 85):
                  $accuplacer_level = 4;
               break;
            };

            // Calculate Math Score
            $mathTotalScore = $exam[26] + $exam[23];

            // Calcualte Math Level
            $math_level = 0;
            switch(true) {
               case in_array($mathTotalScore, range(0,29)): 
                  $math_level = 1;
               break;
               case in_array($mathTotalScore, range(30,37)):
                  $math_level = 2;
               break;
               case in_array($mathTotalScore, range(38,46)):
                  $math_level = 3;
               break;
               case ($mathTotalScore > 46):
                  $math_level = 4;
               break;
            };

            // ADD DATA TO DB FIELDS FOR INSERT
            $insertData[$key] = array(
                'is_community_exam' => (isset($exam[28]) ? true : false),
                'test_date' => $exam[27],
                'l_name' => $exam[0],
                'm_initial' => $exam[1],
                'f_name' => $exam[2],
                'ssn' => $exam[3],
                'dob' => $exam[4],
                'gender' => $exam[5],
                'high_school' => $exam[7],
                'taken_before' => $exam[8],
                'if_taken_when' => $exam[6],
                'overall_grade' => $exam[9],
                'overall_percent_score' => $exam[10],
                'overall_total_score' => $exam[11],
                'lu_grade' => $exam[12],
                'lu_percent_score' => $exam[13],
                'lu_total_score' => $exam[14],
                'ss_grade' => $exam[15],
                'ss_percent_score' => $exam[16],
                'ss_total_score' => $exam[17],
                'rs_grade' => $exam[18],
                'rs_percent_score' => $exam[19],
                'rs_total_score' => $exam[20],
                'ea_grade' => $exam[21],
                'ea_percent_score' => $exam[22],
                'ea_total_score' => $exam[23],
                'a_grade' => $exam[24],
                'a_percent_score' => $exam[25],
                'a_total_score' => $exam[26],
                'accuplacer_english_score' => $englishTotalScore,
                'accuplacer_level' => $accuplacer_level,
                'math_score' => $mathTotalScore,
                'math_level' => $math_level
            );


        }

        // Check if first exam element has data then run insert
        if ($insertData[0]['l_name']=='') {
            return FALSE;
        } else {
            $examIds = array();
            foreach ($insertData as $value) {
                $this->db->insert('exams', $value);
                // Get each exam info to write exam id on writing essays
                $this->db->select("id, CONCAT(f_name,' ',m_initial,' ',l_name) as name");
                $this->db->where('id',$this->db->insert_id());
                $query = $this->db->get('exams');
                $result = $query->row_array();
                $examIds[] = $result;
            }
            return $examIds;
        }  
        
    }

    public function count_exams_to_score_writing() {
        $this->db->from('exams');
        $this->db->where('writing_sample_score', NULL);
        
        return $this->db->count_all_results();
    }  

    public function get_exams_to_score_writing($limit, $start) {
        $this->db->select("id, CONCAT(f_name,' ',m_initial,' ',l_name) as name");
        $this->db->where('writing_sample_score', NULL);
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('exams');

        return $query->result_array();
    }   

    public function get_exam($examId) {
        $this->db->where('id',$examId);
        $query = $this->db->get('exams');

        return $query->row_array();
    }

    public function get_exam_accuplacer_level($examId) {
        $this->db->select('accuplacer_level');
        $this->db->where('id',$examId);
        $query = $this->db->get('exams');

        return $query->row_array();
    }

    public function update_exam($exam) {

        if (!isset($exam['final_score'])) {
            // UPDATE THE WRITING SAMPLE SCORE AND ADD TO FACULTY INPUT TABLE
            $this->db->where('id', $exam['id']);
            $this->db->set('writing_sample_score', $exam['writing_sample_score']);
            $this->db->update('exams');
            
            // GET THE EXAM INFO NEEDED FOR FACULTY INPUT TABLE
            $this->db->select('id, lu_total_score as lu_score, ss_total_score as ss_score, rs_total_score as rs_score');
            $this->db->where('id', $exam['id']);
            $query = $this->db->get('exams');
            $examResult = $query->row_array();
            $examResult['writing_sample_score'] = $exam['writing_sample_score'];

            $this->db->insert('faculty_input', $examResult);

            return 'facultyInput';
            
            
        } else {
            // JUST UPDATE THE WRITING SAMPLE SCORE
            $this->db->where('id', $exam['id']);
            $this->db->set('writing_sample_score', $exam['writing_sample_score']);
            $this->db->set('final_score', $exam['final_score']);
            $this->db->update('exams');

            return 'noFacultyInput';
        }
    }

    public function count_exams_for_faculty_input() {
        $this->db->from('faculty_input');

        return $this->db->count_all_results();
    }  

    public function get_exams_for_faculty_input($limit, $start) {
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('faculty_input');

        return $query->result_array();
    } 

    public function score_exam_final_placement($exam) {
        $this->db->set('final_score', $exam['final_score']);
        $this->db->set('faculty_score', $exam['final_score']);
        $this->db->where('id', $exam['id']);
        $this->db->update('exams');

        $this->db->where('id', $exam['id']);
        $this->db->delete('faculty_input');

        return true;
    }

    public function get_min_max_dates() {
        $this->db->order_by('id', 'ASC');
        $this->db->select("MIN(test_date) as min_date, MAX(test_date) as max_date");
        $query = $this->db->get('exams');
        return $query->row_array();
    }

    public function get_annual_report_data($sy) {
        $this->db->select("CONCAT(f_name,' ',m_initial,' ',l_name) as FullName,id as Exam ID,gender as Gender,dob as Date of Birth,high_school as High School,test_date as Date of test,accuplacer_english_score as Total English Score,accuplacer_level, writing_sample_score as Writing Sample Score, math_score as Total Math Score, admission_is_complete as Admission Completed, admission_date as Admission Date, is_registered Registred, registration_semester as Registration Semester, registration_year as Registration Year, dropped_semester as Dropped Semester");
        $this->db->where('test_date >=', $sy['startDate']);
        $this->db->where('test_date <=', $sy['endDate']);
        $query = $this->db->get('exams');
        return $query->result_array();
    }

    public function count_all_school_exams($hs) {
        $this->db->where('high_school', $hs);
        return $this->db->count_all_results("exams");
    }

    public function get_all_school_exams($limit,$offset,$hs) {
        $this->db->select("id, test_date, CONCAT(f_name,' ',m_initial,' ',l_name) as name, math_level, accuplacer_level, taken_before");
        $this->db->order_by('test_date', 'ASC');
        $this->db->where('high_school', $hs);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('exams');
        return $query->result_array();
    }

    public function count_all_like_name_exams($hs,$name) {
        $sql = "SELECT COUNT(id) as number
                FROM exams
                WHERE high_school = '".$hs."'
                    AND concat(f_name,' ',m_initial,' ',l_name) LIKE '%".$name."%'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_all_like_name_exams($limit,$offset,$hs,$name) {
        $sql = "SELECT id, test_date, CONCAT(f_name,' ',m_initial,' ',l_name) as name, math_level,accuplacer_level, taken_before
                
                FROM exams
                WHERE high_school = '".$hs."'
                AND concat(f_name,' ',m_initial,' ',l_name) LIKE '%".$name."%'
                ORDER BY test_date ASC
                LIMIT ".$limit." OFFSET ".$offset;

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_exam_info($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('exams');
        return $query->row_array();
    }

    public function update_sis_name_number($data) {
        $this->db->set('sis_stud_no', $data['sisNumber']);
        $this->db->set('sis_full_name', $data['sisName']);
        $this->db->where('id',$data['id']);
        return $this->db->update('exams');
    } 

    public function update_is_admission_complete($data) {
        $this->db->set('admission_is_complete', $data['value']);
        $this->db->where('id',$data['id']);
        return $this->db->update('exams');
    }

    public function remove_admission_date($data) {
        $this->db->set('admission_is_complete', $data['value']);
        $this->db->set('admission_date', NULL);
        $this->db->where('id',$data['id']);
        $this->db->update('exams');
    }

    public function update_is_register_complete($data) {
        $this->db->set('is_registered', $data['value']);
        $this->db->set('is_registered', $data['value']);
        $this->db->where('id',$data['id']);
        return $this->db->update('exams');
    }

    public function remove_register_year_sem($data) {
        $this->db->set('is_registered', $data['value']);
        $this->db->set('registration_year', NULL);
        $this->db->set('registration_semester', NULL);
        $this->db->where('id',$data['id']);
        $this->db->update('exams');
    }

    public function update_dropped_semester($data) {
        $this->db->set('dropped_semester', $data['value']);
        $this->db->where('id',$data['id']);
        return $this->db->update('exams');
    }

    public function update_register_sem_year($data) {

        $this->db->set('registration_year', $data['year']);
        $this->db->set('registration_semester', $data['sem']);
        $this->db->where('id',$data['id']);
        return $this->db->update('exams');
    }

    public function update_admission_date($data) {
        $date = date_format(date_create($data['date']),'Y-m-d');
        $this->db->set('admission_date', $date);
        $this->db->where('id',$data['id']);
        return $this->db->update('exams');
    }
}