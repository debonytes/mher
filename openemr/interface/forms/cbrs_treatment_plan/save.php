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

$folderName = 'cbrs_treatment_plan';
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

    $table_fields = sqlListFields($tableName); /* An array of the table fields */
    $id = formData('id', 'G') + 0;
    $sets = '';

    $exclude_fields = array('id');
    $fieldValues = array();

    /* UPDATE FIELDS */
    if ($id) {

            $i=0; foreach( $_REQUEST as $field=>$val ) {
                if( in_array($field, $table_fields) ) {
                    if($val) {
                        if(($field == 'areas_to_be_addressed') || ($field == 'dsm_diagnoses') ){
                                $val = implode('|', $val);
                        }
                        if( is_numeric($val) ) {
                            if( $val < 1 ) {
                                $val = 0;
                            }
                        }
                    } else {
                        $val = NULL;
                    }
                    $comma = ($i>0) ? ', ':'';
                    $sets .= $comma . $field . ' = ?';
                    $fieldValues[] = cleaning_input($val);
                    $i++;
                }
            }

        sqlStatement("UPDATE $tableName SET $sets WHERE id = $id",$fieldValues);
        echo json_encode(['success' => 1, 'message' => 'Updated']);


    } else {
        /* INSERT FIELDS */

        if( isset($_REQUEST) && $_REQUEST ) {

            if( $encounter ) {

                // areas_to_be_addressed, dsm_diagnoses

                $i=0; foreach( $_REQUEST as $field=>$val ) {
                    if( in_array($field, $table_fields) ) {
                        if($val && !empty($val)) {
                            if(($field == 'areas_to_be_addressed') || ($field == 'dsm_diagnoses') ){
                                $val = implode('|', $val);
                            }
                            if( is_numeric($val) ) {
                                if( $val < 1 ) {
                                    $val = 0;
                                }
                            }
                        } else {
                            $val = NULL;
                        }
                        $comma = ($i>0) ? ', ':'';
                        $sets .= $comma . $field . ' = ?';
                        $fieldValues[] = cleaning_input($val);
                        $i++;
                    }
                }

                $newid = sqlInsert( 
                    "INSERT INTO $tableName SET $sets",$fieldValues
                );

                addForm($encounter, "CBRS Treatment Plan", $newid, "cbrs_treatment_plan", $pid, $userauthorized);
                echo json_encode(['success' => 1, 'message' => 'Inserted']);

            }

        }
    }

    

}



