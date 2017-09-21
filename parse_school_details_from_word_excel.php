<?php

require("class.filetotext.php");

$file = fopen("test.csv", 'w');
$file_count = 0;
$columns = [
  'College Name' => 'Name of College or University:',
  'Application Deadline' => '',
  'Priority application deadline' => 'Priority date:',
  'Notification date' => 'If yes, starting date:',
//  'Deadline for accepting admission offers' => '',
//  'Students accepted for terms other than the fall' => '',
//  'Early decision plan offered' => 'Does your institution offer an early decision plan (an admission plan that permits students to apply and be notified of an admission decision well in advance of the regular notification date and that asks students to commit to attending if accepted) for first-time, first-year (freshman) applicants for fall enrollment?',
//  'Early decision deadline' => 'First or only early decision plan notification date',
//  'Early decision decision sent by' => 'First or only early decision plan closing date',
 // 'Early action plan offered' => 'Do you have a nonbinding early action plan whereby students are notified of an admission decision well in advance of the regular notification date but do not have to commit to attending your college?',
//  'Students restricted from applying to other early action plans' => 'Is your early action plan a “restrictive” plan under which you limit students from applying to other early plans?',
 // 'Early action deadline' => 'Early action notification date',
//  'Early action decision sent by' => 'Early action closing date',
  'Application fee' => 'Amount of application fee:',
//  'Application fee refundable' => '',
//  'Application fee waived for students with financial need' => 'Can it be waived for applicants with financial need?',
  'Application fee for students who apply online' => 'Same fee:',
  'Reduced application fee for students who apply online' => 'Reduced:',
//  'Deferred admissions allowed' => 'Does your institution allow students to postpone enrollment after admission?',
  'Maximum length of deferment' => 'If yes, maximum period of postponement:',
  'Application URL' => 'If there is a separate URL for your school s online application, please specify:',
//  'Common Application accepted' => '',
//  'Tuition deposit' => '',
//  'Tuition deposit refundable' => '',
//  'Room deposit' => '',
//  'Room deposit refundable' => '',
  'Admissions phone' => 'Admissions Phone Number:',
  'Admissions email' => 'Admissions E-mail Address:',
  'Admissions address' => 'Mailing Address, City/State/Zip/Country:',
//  'Admission interview' => '',
//  'Campus visit' => '',
//  'Off-campus interviews' => '',
  'Open admission policy' => 'Open admission policy as described above for all students',
//  'College uses SAT or ACT scores in admissions decisions for first-time, first-year applicants' => 'Does your institution make use of SAT, ACT, or SAT Subject Test scores in admission decisions for first-time, first-year, degree-seeking applicants?',
//  'Required standardized tests' => '',
//  'SAT with Writing Test' => '',
//  'ACT with Writing Test' => 'ACT with writing recommended',
  'SAT/ACT scores must be received by' => 'Latest date by which SAT or ACT scores must be received for fall-term admission',
  'SAT Subject Test scores must be received by' => 'Latest date by which SAT Subject Test scores must be received for fall-term admission',
//  'SAT essay used in admissions' => 'SAT with Essay component required',
//  'ACT essay used in admissions' => '',
//  'Applicants test scores used for academic advising' => 'In addition, does your institution use applicants test scores for academic advising?',
//  'High school completion requirements' => 'High school completion requirement',
//  'General college-preparatory program' => 'Does your institution require or recommend a general college-preparatory program',
//  'Special requirements for admission to specific programs' => '',
//  'Special programs/policies for students with academic deficiencies or economic disadvantages' => '',
//  'Early admission of high school students' => 'Early admission of high school students',
//  'SAT subject tests' => 'SAT Subject Tests',
//  'Relative importance of each of the following academic and nonacademic' => 'Relative importance of each of the following academic and nonacademic factors in first-time, first- year, degree-seeking (freshman) admission decisions.',
  'English units' => 'English',
  'Foreign Language units' => 'Foreign language',
  'History units' => 'History',
  'Math units' => 'Mathematics',
  'Science units' => 'Science',
  'Science lab units' => 'Of these, units that must be lab',
  'Social studies units' => 'Social studies',
  'Academic electives' => 'Academic electives',
  'Total units required' => 'Total academic units',
//  'English units' => '',
//  'Foreign language units' => '',
//  'History units' => '',
//  'Math units' => '',
//  'Science units' => '',
//  'Science lab units' => '',
//  'Social Studies units' => '',
//  'Academic electives' => '',
//  'Total units recommended' => '',
//  'AP tests may be used for' => '',
//  'AP scores accepted' => '',
//  'IB exams may be used for' => '',
//  'In-State Tuition' => '',
//  'Tuition Fees' => '',
//  'Room & Board' => '',
//  'Fall 2015 acceptance rate' => '',
//  'Early decision acceptance rate' => '',
//  'Early action acceptance rate' => '',
//  'Acceptance rate (excluding early action and early decision students)' => '',
//  'Provide the number of students who applied, were admitted, and enrolled as degree-seeking transfer' => 'Provide the number of students who applied, were admitted, and enrolled as degree-seeking transfer',
//  'Freshman enrollment' => '',
  'Female freshman enrollment' => 'Total full-time, first-time, first-year (freshman) women who enrolled',
  'Male freshman enrollment' => 'Total full-time, first-time, first-year (freshman) men who enrolled',
//  'Early decision applicants' => '',
//  'Early decision applicants accepted' => '',
//  'Early decision applicants enrolled' => '',
//  'Early action applicants' => '',
//  'Early action applicants accepted' => '',
//  'Early action applicants enrolled' => '',
//  'Total enrolled incoming freshmen who were accepted under early acceptance or early action' => '',
//  'School has a wait list' => 'Do you have a policy of placing students on a waiting list?',
//  'Applicants placed on wait list' => '',
//  'Students accepting place on wait list' => '',
//  'Students accepted from wait list' => '',
//  'Freshman students submitting high school class standing' => '',
//  'Freshmen in top 10 percent of high school class' => '',
//  'Freshmen in top 25 percent of high school class' => '',
//  'Freshmen in top 50 percent of high school class' => '',
//  'Freshmen in bottom 25 percent of high school class' => '',
  'Freshman students submitting high school GPA' => 'Percent of total first-time, first-year (freshman) students who submitted high school GPA:',
  'Average high school GPA' => 'Average high school GPA of all degree-seeking, first-time, first-year (freshman) students who submitted GPA:',
//  'High school GPA 25th-75th percentile range' => '',
//  'GPA Breakdown' => '',
  'Freshman students submitting SAT scores' => 'Percent submitting SAT scores',
//  'SAT Critical Reading average score' => '',
///  'SAT Critical Reading 25th-75th percentile range' => 'SAT Critical Reading',
//  'SAT Math average score' => '',
///  'SAT Math 25th-75th percentile range' => 'SAT Math',
//  'SAT Writing average score' => '',
///  'SAT Writing 25th-75th percentile range' => 'SAT Writing',
///  'SAT Essay 25th-75th percentile range' => 'SAT Essay',
  'Freshman students submitting ACT scores' => 'Percent submitting ACT scores',
//  'Average ACT Composite score' => '',
///  'ACT Composite 25th-75th percentile range' => 'ACT Composite',
  'ACT Composite 0-6 score' => 'Below 6',
  'ACT Composite 6-11 score' => '6-11',
  'ACT Composite 12-17 score' => '12-17',
  'ACT Composite 18-23 score' => '18-23',
  'ACT Composite 24-29 score' => '24-29',
  'ACT Composite 30-36 score' => '30-36',
///  'ACT English 25th-75th percentile range' => 'ACT English',
///  'ACT Math 25th-75th percentile range' => 'ACT Math',
//  'ACT Reading 25th-75th percentile range' => '',
//  'ACT Science 25th-75th percentile range' => '',
//  'Accepting applications' => '',
  'Application due date' => 'Application closing date (fall)',
//  'Admission decision sent' => '',
//  'Deadline for accepting admission offers' => '',
  'Minimum credits to apply' => 'If yes, what is the minimum number of credits and the unit of measure?',
  'Minimum required high school GPA' => 'If a minimum high school grade point average is required of transfer applicants, specify (on a 4.0 scale):',
  'Minimum required college GPA' => 'If a minimum college grade point average is required of transfer applicants, specify (on a 4.0 scale):',
//  'Indicate all items required of transfer students to apply for admission' => 'Indicate all items required of transfer students to apply for admission',
//  'Transfer students may earn advanced standing credit' => '',
  'Lowest course grade that may be transferred for credit' => 'Report the lowest grade earned for any course that may be transferred for credit:',
//  'Maximum credit/courses that may be transferred' => '',
  'Minimum credits needed to complete associate degree' => 'Minimum number of credits that transfers must complete at your institution to earn an associate degree:',
  'Minimum credits needed to complete bachelor\'s degree' => 'Minimum number of credits that transfers must complete at your institution to earn a bachelor’s degree:',
//  'Open admission policy applies to transfer students' => 'Does an open admission policy, if reported, apply to transfer students?',
//  'Transfer students applying for Fall 2015' => '',
//  'Transfer students accepted for Fall 2015' => '',
//  'New transfer students enrolled for Fall 2015' => '',
//  'New transfer students who had an associate degree granted by another institution' => '',
//  'New transfer students who entered with credits granted by a community college' => '',
//  'Has guaranteed admission agreement with at least one other institution' => '',
//  'Guaranteed admission agreement URL' => '',
//  'Application deadline' => '',
//  'Preapplication form required' => '',
//  'Separate application form required' => '',
//  'Conditional admission offered' => '',
//  'Early decision or early action options available' => '',
//  'TOEFL accepted instead of SAT or ACT' => '',
//  'Minimum score required (paper test)' => '',
//  'Minimum score required (internet-based test)' => '',
//  'Average score (paper test)' => '',
//  'Average score (internet-based test)' => '',
//  'Minimum score required' => '',
//  'Average score' => '',
//  'International students applying for Fall 2015' => '',
//  'International students accepted for Fall 2015' => '',
//  'International freshmen enrolled for Fall 2015' => '',
//  'Institution actively recruits international students via' => '',
//  'Institution conducts off-campus admissions interviews with international students via' => '',
//  'Admissions website translated into languages other than English' => '',
//  'International student contact (Name)' => '',
//  'International student contact (Title)' => '',
//  'International student contact (Phone)' => '',
//  'International student contact (Email)' => '',
//  'Tuition and fees' => '',
//  'Minimum credits per term a student can take for full-time tuition price' => '',
//  'Maximum credits per term a student can take for full-time tuition price' => '',
//  'Per-credit-hour charge' => '',
//  'In-state per-credit-hour charge' => '',
//  'Out-of-state per-credit-hour charge' => '',
//  'In-state tuition for all military veterans' => '',
//  'Room and board' => '',
  'Estimated cost of books and supplies' => 'Books and supplies:',
  'Estimated transportation cost' => 'Transportation:',
  'Estimated personal expenses' => 'Other expenses:',
//  'Payment plans available' => '',
  'Priority filing date for institution\'s financial aid form' => 'Priority date for filing required financial aid forms:',
//  'Application deadline for financial aid' => 'Deadline for filing required financial aid forms:',
//  'Financial aid forms required of domestic freshman students' => 'Check off all financial aid forms domestic first-year (freshman) financial aid applicants must submit:',
//  'Criteria used in awarding institutional' => 'Check off criteria used in awarding institutional aid. Check all that apply.',
//  'Types of loans available' => 'FEDERAL DIRECT STUDENT LOAN PROGRAM (DIRECT LOAN)',
//  'Students who applied for need-based financial aid' => '',
//  'Students determined to have financial need' => '',
//  'Students whose need was fully met' => '',
//  'Average financial aid package (freshmen)' => '',
//  'Students who received need-based financial aid' => '',
//  'Average need-based scholarship or grant award (freshmen)' => '',
//  'Students who received need-based scholarship or grant aid (freshmen)' => '',
//  'Average need-based self-help aid award (freshmen)' => '',
//  'Students who received need-based self-help aid (freshmen)' => '',
//  'Average need-based loan (excluding PLUS, unsubsidized, or other private loans)' => '',
//  'Average percent of need met' => '',
//  'Average non-need-based scholarship or grant award (freshmen)' => '',
//  'Average non-need-based athletic scholarship or grant award (freshmen)' => '',
//  'Average need-based self-help aid award (in-state, undergraduate students)' => '',
//  'In-state, undergraduate students receiving need-based self-help aid' => '',
//  'Average need-based self-help aid award (out-of-state, undergraduate students)' => '',
//  'Out-of-state, undergraduate students receiving need-based self-help aid' => '',
//  'Average need-based loan (in-state, freshman students)' => '',
//  'In-state, freshman students receiving need-based loans' => '',
//  'Average need-based loan award (out-of-state, freshman students)' => '',
//  'Out-of-state, freshman students receiving need-based loans' => '',
//  'Average need-based loan award (in-state, undergraduate students)' => '',
//  'In-state, undergraduate students receiving need-based loans' => '',
//  'Average need-based loan (out-of-state, undergraduate students)' => '',
//  'Out-of-state, undergraduate students receiving need-based loans' => '',
//  'Average non-need-based scholarship or grant award (in-state, freshman students)' => '',
//  'In-state, freshman students receiving non-need-based scholarship or grant aid' => '',
//  'Average non-need-based scholarship or grant award (out-of-state, freshman students)' => '',
//  'Out-of-state, freshman students receiving non-need-based scholarship or grant aid' => '',
//  'Average non-need-based scholarship or grant award (in-state, undergraduate students)' => '',
//  'In-state, undergraduate students receiving non-need-based scholarship or grant aid' => '',
//  'Average non-need-based scholarship or grant award (out-of-state, undergraduate students)' => '',
//  'Out-of-state, undergraduate students receiving non-need-based scholarship or grant aid' => '',
//  'Students determined to have financial need' => '',
//  'Average financial aid package ' => '',
//  'Average need-based scholarship or grant award (undergraduates) ' => '',
//  'Average need-based self-help aid award (undergraduates) ' => '',
//  'Average need-based loan (excluding PLUS, unsubsidized, or other private loans) ' => '',
//  'Average non-need-based scholarship or grant award (undergraduates)' => '',
//  'Average non-need-based athletic scholarship or grant award (undergraduates)' => '',
//  'Used GI Bill benefits to partially or fully finance tuition and fees' => '',
//  'Average total indebtedness of 2015 graduating class' => '',
//  'Graduating students who have borrowed (any loan type, 2015)' => '',
//  'Average federal indebtedness of 2015 graduating class' => '',
//  'Graduating students who borrowed (federal loans, 2015)' => '',
//  'Average institutional indebtedness of 2015 graduating class' => '',
//  'Graduating students who have borrowed (institutional loans, 2015)' => '',
//  'Average state indebtedness of 2015 graduating class' => '',
//  'Graduating students who have borrowed (state loans, 2015)' => '',
//  'Average private indebtedness of 2015 graduating class' => '',
//  'Graduating students who have borrowed (private loans, 2015)' => '',
//  'School offers non-federal need-based or non-need-based aid to international students' => '',
//  'Priority filing date for financial aid' => '',
//  'Application deadline for financial aid' => '',
//  'School financial form required' => '',
//  'CSS/financial aid PROFILE required' => '',
//  'International student financial aid application required' => '',
//  'International student certification of finances required' => '',
//  'International undergraduates receiving institutional aid' => '',
//  'Average amount of institutional financial aid awarded to international undergraduates' => '',
//  'Full-time undergraduate international students who were awarded need-based aid' => '',
//  'Full-time undergraduate international students who were awarded non-need-based aid' => '',
//  'Financial aid director' => '',
//  'Financial aid office phone number' => '',
//  'Average freshman retention rate' => '',
//  'International student retention rate' => '',
//  '6-year graduation rate of students who received a Pell grant' => '',
//  '6-year graduation rate of students who received a subsidized Stafford loan' => '',
//  '6-year graduation rate of students who did not receive a Pell grant or subsidized Stafford loan' => '',
//  '6-year graduation rate of international students' => '',
//  'Total enrollment' => '',
//  'Full-time degree-seeking students' => '',
//  'Part-time degree-seeking students' => '',
//  'Non-degree-seeking students' => '',
//  'Students 25 and older' => '',
//  'Average age of full-time students' => '',
//  'Average age of all undergraduates' => '',
//  'Out-of-state students' => '',
//  'Region from which most U.S. students come' => '',
//  'International students' => '',
//  'Number of countries represented by international students' => '',
//  'Countries most represented by international students' => '',
//  'Student Diversity Black' => '',
//  'Student Diversity American Indian' => '',
//  'Student Diversity Asian' => '',
//  'Student Diversity Hispanic' => '',
//  'Student Diversity White' => '',
//  'Student Diversity Pacific Islander' => '',
//  'Student Diversity Two or more races' => '',
//  'Student Diversity International' => '',
//  'Student Diversity Unknown' => '',
//  'Total undergraduate enrollment' => '',
//  'Total graduate enrollment' => '',
  ];

$one_number = [
  'English',
  'Foreign language',
  'History',
  'Mathematics',
  'Science',
  'Of these, units that must be lab',
  'Social studies',
  'Academic electives',
];
$two_number = [
  'Total academic units',
];
$four_numbers = [
  'Total full-time, first-time, first-year (freshman) women who enrolled',
  'Total full-time, first-time, first-year (freshman) men who enrolled',
];
$two_words = [
  'Latest date by which SAT or ACT scores must be received for fall-term admission',
];
$next_array_value = [
  'Average high school GPA of all degree-seeking, first-time, first-year (freshman) students who submitted GPA:',
];

$first_dollar = [
  'Other expenses:',
  'Transportation:',
  'Books and supplies:',

];

$first_percentage = [
  'Percent submitting SAT scores',
  'Percent submitting ACT scores',
  'Below 6',
  '6-11',
  '12-17',
  '18-23',
  '24-29',
  '30-36'
];
$table_data = [
  'SAT Critical Reading',
  'SAT Math',
  'SAT Writing',
  'SAT Essay',
  'ACT Composite',
  'ACT English',
  'ACT Math'
];

$two_characters = [
  'Amount of application fee:',
  'If yes, what is the minimum number of credits and the unit of measure?',
];


$result = array();
if ($handle = opendir('doc to convert')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('doc to convert/'.$entry);
      $return = $docObj->convertToText();

      $text = explode("\n\r", $return);

      foreach($text as $key => $val) {
        $str = $val;
        foreach($columns as $x => $y) {
          if(!empty($y)) {
            preg_match("/".$y."(.*)/", $str, $match);
            if(!empty($match) && empty($result[$x])) {
              $matched_string = $match[1];
              if(in_array($y, $one_number)) {
                $matched_string = substr($matched_string, 0, 1);
              }
              else if(in_array($y, $two_number)) {
                $matched_string = substr($matched_string, 0, 2);
              }
              else if(in_array($y, $two_characters)) {
                $matched_string = substr($matched_string, 0, 3);
              }
              else if(in_array($y, $four_numbers)) {
                $matched_string = substr($matched_string, 0, 5);
              }
              else if(in_array($y, $next_array_value)) {
                $temp_array = $text[$key+1];
                $matched_string = $temp_array;
              }
              else if(in_array($y, $first_dollar)) {
                $pos = strpos($matched_string,'$',1);
                $matched_string = substr($matched_string, 0, $pos);
              }
              else if(in_array($y, $first_percentage)) {
                $pos = strpos($matched_string,'%',0);
                $matched_string = substr($matched_string, 0, $pos);
              }
              else if(in_array($y, $two_words)) {
                $pos = strpos($matched_string,'%',0);
                $matched_string = substr($matched_string, ' ', $pos);
              }
              else if(in_array($y, $table_data)) {
                $pos = strpos($matched_string,'%',0);
                $matched_string = substr($matched_string, ' ', $pos);
              }
              $result[$x] = $matched_string;
            }
          }
        }
      }

    }

  }

  closedir($handle);
}


$csv_label = array();
foreach($result as $key => $val) {
  $csv_label[] = $key;
}
fputcsv($file, $csv_label);
$csv_label = array();
foreach($result as $key => $val) {
  $csv_label[] = $val;
}
fputcsv($file, $csv_label);
fclose($file);