<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exams_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function listReports() {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }

        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('reports/report_list');
        $this->load->view('templates/footer');
    }

    public function annualReportForm() {
        if (!$this->session->userType=='admin') {
            redirect('/');
        }
        
        $testYears = array();

        // Get all the years available in test date from database
        $testDates = $this->exams_model->get_min_max_dates();
        
        // Subtract a year from the min so that we can have a school before the min
        // incase there are exams before the min date sy but same calendar year
        $subtractedMinDate = intval(date_format(date_create($testDates['min_date']), 'Y') -1);

        // Get the number of years between the min and max dates for number of options
        $numberOfYears = intval(date_format(date_create($testDates['max_date']), 'Y')) - $subtractedMinDate;

        // Create school year options from the min_date and the number of years after
        for ($i=0; $i < $numberOfYears+1; $i++) { 
            $year = $subtractedMinDate + $i;
            $testYears[] = strval($year).'-'.strval($year+1);
        }

        $data['testYearOptions'] = $testYears;

        $this->load->view('templates/header');
        $this->load->view('templates/navigation');
        $this->load->view('reports/annual_report_form', $data);
        $this->load->view('templates/footer');
    }

    public function processAnnualReport() {

        /** Include PHPExcel */
        require_once FCPATH . '/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("CMI Placement System")
                                     ->setLastModifiedBy("CMI Placement System")
                                     ->setTitle("CMI Placement Annual Report")
                                     ->setSubject("Annual Report")
                                     ->setDescription("CMI Placement Exam Report.")
                                     ->setKeywords("CMI Placement xml annual report")
                                     ->setCategory("CMI Placement");

        // Pull Data from Database
        $selectedSY = $this->input->post('sy');

        $records = $this->getAnnualReportRecords($selectedSY);

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->fromArray($records, null, 'A1');

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Placement Annual Report');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="CMIPlacementAnnualReport.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    private function getAnnualReportRecords($sy) {
        // Split the selected years into two years
        $schoolYear = explode('-', $sy);

        // Prep the search criteria
        $searchCriteria = array(
            'startDate' => date_format(date_create($schoolYear[0].'-08-01'), 'Y-m-d'),
            'endDate' => date_format(date_create($schoolYear[1].'-07-31'), 'Y-m-d')
        );

        //Get records with search criteria
        $records = $this->exams_model->get_annual_report_data($searchCriteria);

        // If got records send to phpExcel processing or else redirect
        if (!empty($records)) {
            $updatedRecords = array();
            
            foreach ($records as $key => $record) {
                $updatedRecords[$key]['Full Name'] = $record['FullName'];
                $updatedRecords[$key]['Exam ID'] = $record['Exam ID'];
                $updatedRecords[$key]['Gender'] = $record['Gender'];
                $updatedRecords[$key]['Date of Birth'] = $record['Date of Birth'];
                $updatedRecords[$key]['High School'] = $record['High School'];
                $updatedRecords[$key]['Date of Test'] = $record['Date of test'];
                $updatedRecords[$key]['Total English Score'] = $record['Total English Score'];
                $updatedRecords[$key]['Writing Sample Score'] = $record['Writing Sample Score'];
                $updatedRecords[$key]['Total Math Score'] = $record['Total Math Score'];

                // Calcualte English Level
                $englishLevel = '';
                switch($record['accuplacer_level']) {
                   case 0: 
                      $englishLevel = 'Did Not Pass';
                   break;
                   case 1: 
                      $englishLevel = 'Level 1';
                   break;
                   case 2: 
                      $englishLevel = 'Level 2';
                   break;
                   case 3: 
                      $englishLevel = 'Level 3';
                   break;
                   case 4: 
                      $englishLevel = 'Credit Level';
                   break;
                };
                $updatedRecords[$key]['English Level'] = $englishLevel;

                // Calcualte Math Level
                $mathLevel = '';
                switch($record['accuplacer_level']) {
                   case 1: 
                      $mathLevel = 'Level 1';
                   break;
                   case 2: 
                      $mathLevel = 'Level 2';
                   break;
                   case 3: 
                      $mathLevel = 'Level 3';
                   break;
                   case 4: 
                      $mathLevel = 'Credit Level';
                   break;
                };
                $updatedRecords[$key]['Math Level'] = $mathLevel;

                // Change admission is complete to yes/no
                if ($record['Admission Completed']!=true) {
                    $updatedRecords[$key]['Admission Completed'] = 'No';
                } else {
                    $updatedRecords[$key]['Admission Completed'] = 'Yes';
                };

                $updatedRecords[$key]['Admission Date'] = $record['Admission Date'];

                // Change registered to yes/no
                if ($record['Registred']!=true) {
                    $updatedRecords[$key]['Registred'] = 'No';
                } else {
                    $updatedRecords[$key]['Registred'] = 'Yes';
                };

                $updatedRecords[$key]['Registration Semester'] = $record['Registration Semester'];
                $updatedRecords[$key]['Registration Year'] = $record['Registration Year'];

                // Change completed semester to yes/no
                if ($record['Dropped Semester']!=true) {
                    $updatedRecords[$key]['Dropped Semester'] = 'No';
                } else {
                    $updatedRecords[$key]['Dropped Semester'] = 'Yes';
                };
            }

            // Add Field Names to the array
            $fieldNames = array();
            foreach ($updatedRecords[0] as $key => $value) {
                $fieldNames[] = $key;
            }
            array_unshift($updatedRecords, $fieldNames);

            return $updatedRecords;
        } elseif (empty($records)) {
            $this->session->set_flashdata('flashError', 'Could not retrieve any records with School Year selected');
            redirect(base_url('reports/annualReportForm'));
            die();
        }
    }
 

}