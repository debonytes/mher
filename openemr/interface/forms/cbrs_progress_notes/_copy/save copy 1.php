<?php
/**
 * Clinical instructions form save.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Jacob T Paul <jacob@zhservices.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2015 Z&H Consultancy Services Private Limited <sam@zhservices.com>
 * @copyright Copyright (c) 2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../../globals.php");
require_once("$srcdir/api.inc");
require_once("$srcdir/forms.inc");

use OpenEMR\Common\Csrf\CsrfUtils;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}

if (!$encounter) { // comes from globals.php
    die(xlt("Internal error: we do not seem to be in an encounter!"));
}

$folderName = 'cbrs_progress_notes';
$tableName = 'form_' . $folderName;

function cleaning_input($data) { 
  $data = trim($data); 
  $data = stripslashes($data); 
  $data = htmlspecialchars($data); 
  return $data; 
} 

$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');

/* form data */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_data = array('name', 'cbrs', 'billing_code', 'services_place', 'services_with', 'goals_object_1', 'goals_object_1_status', 'goals_object_2', 'goals_object_2_status', 'goals_object_3', 'goals_object_3_status', 'narrative_services', 'meet_again_date', 'meet_again_time', 'work_on', 'starttime', 'endtime', 'date', 'duration');

    $data_arr = array();

    foreach($form_data as $field){
        $data_arr[$field] = cleaning_input($_POST[$field]);
    }

    //echo print_r($data_arr);

    if ($id && $id != 0) {
        sqlStatement("UPDATE form_cbrs_progress_notes SET cbrs =?, services_place= ?, services_with=?, goals_object_1=?, goals_object_1_status=?, goals_object_2=?, goals_object_2_status=?, goals_object_3=?, goals_object_3_status=?, narrative_services=?, meet_again_date=?, meet_again_time=?, work_on=?, starttime=?, endtime=?, duration=?  WHERE id = ?", array($data_arr['cbrs'], $data_arr['services_place'], $data_arr['services_with'], $data_arr['goals_object_1'], $data_arr['goals_object_1_status'], $data_arr['goals_object_2'], $data_arr['goals_object_2_status'], $data_arr['goals_object_3'], $data_arr['goals_object_3_status'], $data_arr['narrative_services'],$data_arr['meet_again_date'], $data_arr['meet_again_time'], $data_arr['work_on'], $data_arr['starttime'], $data_arr['endtime'], $data_arr['duration'], $id));           
            echo json_encode(['success' => 1, 'message' => 'Updated']);
    } else {
        $newid = sqlInsert("INSERT INTO form_cbrs_progress_notes (pid, encounter, user, name, cbrs, billing_code, services_place, services_with, goals_object_1, goals_object_1_status, goals_object_2, goals_object_2_status, goals_object_3, goals_object_3_status, narrative_services, meet_again_date, meet_again_time, work_on, starttime,  endtime, date, duration) VALUES (?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($pid, $encounter, $_SESSION['authUser'], $data_arr['name'], $data_arr['cbrs'], $data_arr['billing_code'], $data_arr['services_place'], $data_arr['services_with'], $data_arr['goals_object_1'], $data_arr['goals_object_1_status'], $data_arr['goals_object_2'], $data_arr['goals_object_2_status'], $data_arr['goals_object_3'], $data_arr['goals_object_3_status'], $data_arr['narrative_services'], $data_arr['meet_again_date'], $data_arr['meet_again_time'], $data_arr['work_on'], $data_arr['starttime'], $data_arr['endtime'], $data_arr['date'], $data_arr['duration'] ));
        addForm($encounter, "CBRS Progress Notes", $newid, "cbrs_progress_notes", $pid, $userauthorized);
        echo json_encode(['success' => 1, 'message' => 'Inserted']);
    }

}

/* form data */

/*
$instruction = $_POST["instruction"];

if ($id && $id != 0) {
    sqlStatement("UPDATE form_clinical_instructions SET instruction =? WHERE id = ?", array($instruction, $id));
} else {
    $newid = sqlInsert("INSERT INTO form_clinical_instructions (pid,encounter,user,instruction) VALUES (?,?,?,?)", array($pid, $encounter, $_SESSION['authUser'], $instruction));
    addForm($encounter, "Clinical Instructions", $newid, "clinical_instructions", $pid, $userauthorized);
}
*/
/*
formHeader("Redirecting....");
formJump();
formFooter();
*/

