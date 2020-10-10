<?php
/**
 * The data will be stored in cbrs_treatment_plan form.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Jacob T Paul <jacob@zhservices.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2015 Z&H Consultancy Services Private Limited <sam@zhservices.com>
 * @copyright Copyright (c) 2017-2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../../globals.php");
require_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
//require_once("date_qualifier_options.php");
require_once("$srcdir/options.inc.php");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;

$folderName = 'cbrs_treatment_plan';
$tableName = 'form_' . $folderName;


$returnurl = 'encounter_top.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : 0);
$check_res = $formid ? formFetch($tableName, $formid) : array();
?>
<html>
    <head>
        <title><?php echo xlt("CBRS Treatment Plan"); ?></title>

        <?php Header::setupHeader(['datetime-picker', 'opener']); ?>
        <link rel="stylesheet" href="<?php echo $web_root; ?>/library/css/bootstrap-timepicker.min.css">
        <link rel="stylesheet" href="/public/themes/custom.css">
    </head>
    <body class="body_top">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h2><?php echo xlt('CBRS Treatment Plan'); ?></h2>
                </div>
            </div>
            <?php
            $current_date = date('Y-m-d');

            $patient_id = ( isset($_SESSION['alert_notify_pid']) && $_SESSION['alert_notify_pid'] ) ? $_SESSION['alert_notify_pid'] : '';
            $pid = ( isset($_SESSION['pid']) && $_SESSION['pid'] ) ? $_SESSION['pid'] : 0;
            if($patient_id) {
              $patient = getPatientData($patient_id);
              $patient_fname = ( isset($patient['fname']) && $patient['fname'] ) ? $patient['fname'] : '';
              $patient_mname = ( isset($patient['mname']) && $patient['mname'] ) ? $patient['mname'] : '';
              $patient_lname = ( isset($patient['lname']) && $patient['lname'] ) ? $patient['lname'] : '';
              $patientInfo = array($patient_fname,$patient_mname,$patient_lname);
              if($patientInfo && array_filter($patientInfo)) {
                $patient_full_name = implode( ' ', array_filter($patientInfo) );
              }
            }

            $progress_codes = [
                0 => 'Select',
                1 => 'Objective Reached',
                2 => 'Major Progress',
                3 => 'Some Progress',
                4 => 'Unchanged',
                5 => 'Some Deterioration',
                6 => 'Major Deterioration',
                7 => 'Re-Evaluation Target',
            ];

            ?>
            <div class="row">
                
                <form method="post" id="my_treatment_plan_form" name="my_treatment_plan_form" >
                
                    <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                    <input type="hidden" name="encounter" value="<?php echo $encounter; ?>">
                    <input type="hidden" name="user" value="<?php echo $_SESSION['authUser']; ?>">

                    <fieldset>
                        <legend class=""><?php echo xlt('CBRS Treatment Plan'); ?></legend>

                            <div class="col-md-12">
                                <div class="col-md-3 center_align review_box" style="text-align: center; border: 1px solid #333;  padding: 3px 5px 5px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="review" value="90 Day Review" id="review1" <?php echo ($check_res['review'] == '90 Day Review') ? "checked": ""; ?> > <?php echo xlt('90 Day Review'); ?>
                                    </label>                    
                                </div>
                                <div class="col-md-3 center_align review_box" style="text-align: center; border-right: 1px solid #333; border-top: 1px solid #333; border-bottom: 1px solid #333; padding: 3px 5px 5px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="review"  value="180 Day Review" id="review2" <?php echo ($check_res['review'] == '180 Day Review') ? "checked": ""; ?>> <?php echo xlt('180 Day Review'); ?>
                                    </label>
                                </div>
                                <div class="col-md-3 center_align review_box" style="text-align: center;  border-top: 1px solid #333; border-bottom: 1px solid #333; padding: 3px 5px 5px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="review" value="270 Day Review" id="review3" <?php echo ($check_res['review'] == '270 Day Review') ? "checked": ""; ?>> <?php echo xlt('270 Day Review'); ?>
                                    </label>
                                </div>
                                <div class="col-md-3 center_align review_box" style="text-align: center; border: 1px solid #333;  padding: 3px 5px 5px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="review" value="Other Review" id="review4" <?php echo ($check_res['review'] == 'Other Review') ? "checked": ""; ?>> <?php echo xlt('Other Review'); ?>
                                    </label>
                                </div>
                                <div class="center_align text-danger review_error" style="width: 100%"></div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-30">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="participant_name" class="col-sm-4 "><?php echo xlt('Participant Name'); ?></label>
                                        <div class="col-sm-8">
                                          <input type="text" class="form-control" id="participant_name" name="participant_name" value="<?php echo text($check_res['participant_name']); ?>">
                                          <small class="text-danger participant_name_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="medical_id" class="col-sm-5"><?php echo xlt('Medical ID#'); ?></label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control" id="medical_id" name="medical_id" value="<?php echo text($check_res['medical_id']); ?>">
                                          <small class="text-danger medical_id_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date_birth" class="col-sm-2"><?php echo xlt('DOB'); ?></label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control datepicker" id="date_birth" name="date_birth" autocomplete="off" value="<?php echo text($check_res['date_birth']); ?>">
                                          <small class="text-danger date_birth_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="age" class="col-sm-2"><?php echo xlt('Age'); ?></label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="age" name="age" value="<?php echo text($check_res['age']); ?>">
                                          <small class="text-danger age_error"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-10">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="examiner" class="col-sm-3"><?php echo xlt('Examiner'); ?></label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" id="examiner" name="examiner" value="<?php echo text($check_res['examiner']); ?>">
                                          <small class="text-danger examiner_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="practitioner_id" class="col-sm-3"><?php echo xlt('Practitioner ID'); ?></label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" id="practitioner_id" name="practitioner_id" value="<?php echo text($check_res['practitioner_id']); ?>">
                                          <small class="text-danger practitioner_id_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date" class="col-sm-2"><?php echo xlt('Date'); ?></label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo text($check_res['date']); ?>">
                                          <small class="text-danger date_error"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="col-md-12 margin-top-20">
                                <?php 
                                    $diagnoses = ($check_res['dsm_diagnoses']) ? explode('|', $check_res['dsm_diagnoses']) : array();
                                 ?>
                                <h4 class="field-heading"><?php echo xlt('DSM-V DIAGNOSES'); ?></h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control dsm_diagnoses" name="dsm_diagnoses[]" value="<?php echo text($diagnoses[0]); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control dsm_diagnoses" name="dsm_diagnoses[]" value="<?php echo text($diagnoses[1]); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control dsm_diagnoses" name="dsm_diagnoses[]" value="<?php echo text($diagnoses[2]); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control dsm_diagnoses" name="dsm_diagnoses[]" value="<?php echo text($diagnoses[3]); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control dsm_diagnoses" name="dsm_diagnoses[]" value="<?php echo text($diagnoses[4]); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control dsm_diagnoses" name="dsm_diagnoses[]" value="<?php echo text($diagnoses[5]); ?>">
                                    </div>
                                </div>
                                <small class="text-danger center_align dms_diagnnoses_error"></small>
                                <div class="clearfix"></div>
                                <div class="form-group margin-top-10">
                                    <label for="last_scan_date" class="col-sm-3"><?php echo xlt('Last ICANS Date:'); ?></label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control datepicker" id="last_scan_date" name="last_scan_date" autocomplete="off" value="<?php echo text($check_res['last_scan_date']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <hr>
                            <div class="col-md-12 padding-20 ">
                                <p class="bold"><?php echo xlt('When was the cosumer\'s last history & physical examination?'); ?></p>
                                <div class="form-group " style="padding-left: 20px">
                                    <label class="radio-inline margin-right-30">
                                        <input type="radio" name="last_examination" id="last_examination1" value="current_year" <?php echo ($check_res['last_examination'] == 'current_year') ? "checked": ""; ?> > <?php echo xlt('Current Year'); ?>
                                    </label>
                                    <label class="radio-inline margin-right-30">
                                      <input type="radio" name="last_examination" id="last_examination2" value="prior_year" <?php echo ($check_res['last_examination'] == 'prior_year') ? "checked": ""; ?>> <?php echo xlt('Prior Year'); ?>
                                    </label>
                                    <label class="radio-inline margin-right-30">
                                      <input type="radio" name="last_examination" id="last_examination3" value="longer_prior_year" <?php echo ($check_res['last_examination'] == 'longer_prior_year') ? "checked": ""; ?> > <?php echo xlt('Longer Than Prior Year'); ?>
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="last_examination" id="last_examination4" value="unknown" <?php echo ($check_res['last_examination'] == 'unknown') ? "checked": ""; ?> > <?php echo xlt('Unknown'); ?>
                                    </label>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <hr>
                            <div class="col-md-12">
                                <p class="bold"><?php echo xlt('Please list the providers who are delivering psychotherapy and/or medication management.'); ?></p>
                                <div class="form-group">
                                    <label for="providers_medication_mgt"><?php echo xlt('Medication Management:'); ?></label>
                                    <textarea name="providers_medication_mgt" id="providers_medication_mgt" rows="3" class="form-control"><?php echo text($check_res['providers_medication_mgt']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="providers_psychotherapy"><?php echo xlt('Psychotherapy:'); ?></label>
                                    <textarea name="providers_psychotherapy" id="providers_psychotherapy" rows="3" class="form-control"><?php echo text($check_res['providers_psychotherapy']); ?></textarea>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="critical_strengths"><?php echo xlt('What are the consumer\'s critical strengths?'); ?></label>
                                    <textarea name="critical_strengths" id="critical_strengths" rows="3" class="form-control" ><?php echo text($check_res['critical_strengths']); ?></textarea>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <hr>

                            <div class="col-md-12">
                                <p class="bold"><?php echo xlt('Assessment of the member\'s difficulty functioning in any of the following areas?'); ?></p>
                                <div class="form-group">
                                    <label for="educational " class="col-sm-3"><?php echo xlt('Vocational/Educational:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="educational" id="educational" class="form-control" value="<?php echo text($check_res['educational']); ?>">
                                        <small class="text-danger educational_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="financial" class="col-sm-3"><?php echo xlt('Financial:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="financial" id="financial" class="form-control" value="<?php echo text($check_res['financial']); ?>">
                                        <small class="text-danger financial_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="family" class="col-sm-3"><?php echo xlt('Family:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="family" id="family" class="form-control" value="<?php echo text($check_res['family']); ?>">
                                        <small class="text-danger family_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="social_support" class="col-sm-3"><?php echo xlt('Social Supports:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="social_support" id="social_support" class="form-control" value="<?php echo text($check_res['social_support']); ?>">
                                        <small class="text-danger social_support_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="housing" class="col-sm-3"><?php echo xlt('Housing:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="housing" id="housing" class="form-control" value="<?php echo text($check_res['housing']); ?>">
                                        <small class="text-danger housing_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="living_skills" class="col-sm-3"><?php echo xlt('Basic Living Skills:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="living_skills" id="living_skills" class="form-control" value="<?php echo text($check_res['living_skills']); ?>">
                                        <small class="text-danger living_skills_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="community" class="col-sm-3"><?php echo xlt('Community/Legal:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="community" id="community" class="form-control" value="<?php echo text($check_res['community']); ?>">
                                        <small class="text-danger community_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="relationships" class="col-sm-3"><?php echo xlt('Relationships:'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="relationships" id="relationships" class="form-control" value="<?php echo text($check_res['relationships']); ?>" >
                                        <small class="text-danger relationships_error"></small>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr>
                            <div class="col-md-12">
                                <p class="bold"><?php echo xlt('Function areas to be addressed in this plan year:'); ?></p>
                                <div class="form-group margin-top-20" style="padding-left: 20px;">
                                    <?php $areas_addressed = ($check_res['areas_to_be_addressed']) ? explode('|', $check_res['areas_to_be_addressed']) : array(); ?>
                                    <label class="checkbox-inline margin-right-10">                                       
                                        <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed1" value="Educational" <?php echo (in_array('Educational', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Vocational/Educational'); ?>
                                    </label>
                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed2" value="Financial" <?php echo (in_array('Financial', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Financial'); ?>
                                    </label>
                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed3" value="Family" <?php echo (in_array('Family', $areas_addressed) ) ? "checked": ""; ?>  > <?php echo xlt('Family'); ?>
                                    </label>

                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed4" value="Social Supports" <?php echo (in_array('Social Supports', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Social Supports'); ?>
                                    </label>
                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed5" value="Housing" <?php echo (in_array('Financial', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Housing'); ?>
                                    </label>
                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed6" value="Basic Living Skills" <?php echo (in_array('Basic Living Skills', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Basic Living Skills'); ?>
                                    </label>

                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed7" value="Community" <?php echo (in_array('Community', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Community/Legal'); ?>
                                    </label>
                                    <label class="checkbox-inline margin-right-10">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed8" value="Health" <?php echo (in_array('Health', $areas_addressed) ) ? "checked": ""; ?>  > <?php echo xlt('Health/Medical'); ?>
                                    </label>
                                    <label class="checkbox-inline">
                                      <input type="checkbox" name="areas_to_be_addressed[]" id="areas_to_be_addressed9" value="Relationships" <?php echo (in_array('Relationships', $areas_addressed) ) ? "checked": ""; ?> > <?php echo xlt('Relationships'); ?>
                                    </label>
                                </div>
                                <p class="margin-top-20"><?php echo xlt('All areas checked above will be addressed as needed thoughout the plan year although they may not be outlined in the major problem areas focused on below.'); ?></p>
                                <p><?php echo xlt('This plan will be addressed both CBRS including skills training and symptom management as well as Case Management activities such as linking, coordinating and advocating for the person served.'); ?></p>
                            </div>

                            <div class="clearfix"></div>
                            
                            <div class="padding-20">
                                <h4 class="field-heading"><?php echo xlt('GOALS/OBJECTIVES SECTION'); ?></h4>
                                <p><?php echo xlt('Objectives must address the emotional, behavioral, and skill training needs identified by the member'); ?></p>
                            </div>
                            

                            <div class="col-md-12"> <!-- beginning of Problem #1 -->
                                <h4><?php echo xlt('Problem Area 1#'); ?></h4>
                                <div class="form-group">
                                    <label for="problem_1_description"><?php echo xlt('Choose (see above) (BRIEF description of issues will be addressed in the following goal)'); ?></label>
                                    <textarea name="problem_1_description" id="problem_1_description" rows="3" class="form-control"><?php echo text($check_res['problem_1_description']); ?></textarea>
                                    <small class="text-danger problem_1_description_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_1_client_goal"><?php echo xlt('Client\'s statement of overall goal or need:'); ?></label>
                                    <textarea name="problem_1_client_goal" id="problem_1_client_goal" rows="3" class="form-control"><?php echo text($check_res['problem_1_client_goal']); ?></textarea>
                                    <small class="text-danger problem_1_client_goal_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_1_objectives"><?php echo xlt('TX Objectives (must be concrete and measurable)'); ?></label>
                                    <textarea name="problem_1_objectives" id="problem_1_objectives" rows="3" class="form-control"><?php echo text($check_res['problem_1_objectives']); ?></textarea>
                                    <small class="text-danger problem_1_objectives_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_1_objectives_tasks"><?php echo xlt('Tasks to complete objectives: (including type and frequency of treatment)'); ?></label>
                                    <textarea name="problem_1_objectives_tasks" id="problem_1_objectives_tasks" rows="3" class="form-control"><?php echo text($check_res['problem_1_objectives_tasks']); ?></textarea>
                                    <small class="text-danger problem_1_objectives_tasks_error"></small>
                                </div>
                                <div class="margin-top-20">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="col-sm-6"><?php echo xlt('Date of Review'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="problem_1_date_review" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_1_date_review']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_1_progress_code" class="col-sm-5"><?php echo xlt('Progress Code'); ?></label>
                                            <div class="col-sm-7">
                                                <select name="problem_1_progress_code" id="problem_1_progress_code" class="form-control">
                                                    <?php foreach($progress_codes as $key => $code): ?>
                                                        <option value="<?php echo $key; ?>" <?php echo ($check_res['problem_1_progress_code'] == $key) ? "selected": ""; ?>  ><?php echo $code; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_1_comments" class="col-sm-4"><?php echo xlt('Comments'); ?></label>
                                            <div class="col-sm-8">
                                                <textarea name="problem_1_comments" class="form-control" id="problem_1_comments" rows="3"><?php echo text($check_res['problem_1_comments']); ?></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="margin-top-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="col-sm-6"><?php echo xlt('Target Date for Attainment:'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="problem_1_date_target" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_1_date_target']); ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="col-sm-4"><?php echo xlt('Completion Date:'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="problem_1_date_completion" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_1_date_completion']); ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>  
                            <div class="clearfix"></div> <!-- end of Problem 1 -->

                            <hr>

                            <div class="col-md-12"> <!-- beginning of Problem 2 -->
                                <h4><?php echo xlt('Problem Area 2#'); ?></h4>
                                <div class="form-group">
                                    <label for="problem_2_description"><?php echo xlt('Choose (see above) (BRIEF description of issues will be addressed in the following goal)'); ?></label>
                                    <textarea name="problem_2_description" id="problem_2_description" rows="3" class="form-control"><?php echo text($check_res['problem_2_description']); ?></textarea>
                                    <small class="text-danger problem_2_description_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_2_client_goal"><?php echo xlt('Client\'s statement of overall goal or need:'); ?></label>
                                    <textarea name="problem_2_client_goal" id="problem_2_client_goal" rows="3" class="form-control"><?php echo text($check_res['problem_2_client_goal']); ?></textarea>
                                    <small class="text-danger problem_2_client_goal_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_2_objectives"><?php echo xlt('TX Objectives (must be concrete and measurable)'); ?></label>
                                    <textarea name="problem_2_objectives" id="problem_2_objectives" rows="3" class="form-control"><?php echo text($check_res['problem_2_objectives']); ?></textarea>
                                    <small class="text-danger problem_2_objectives_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_2_objectives_tasks"><?php echo xlt('Tasks to complete objectives: (including type and frequency of treatment)'); ?></label>
                                    <textarea name="problem_2_objectives_tasks" id="problem_2_objectives_tasks" rows="3" class="form-control"><?php echo text($check_res['problem_2_objectives_tasks']); ?></textarea>
                                    <small class="text-danger problem_2_objectives_tasks_error"></small>
                                </div>
                                <div class="margin-top-20">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_2_date_review" class="col-sm-6"><?php echo xlt('Date of Review'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="problem_2_date_review" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_2_date_review']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_2_progress_code" class="col-sm-5"><?php echo xlt('Progress Code'); ?></label>
                                            <div class="col-sm-7">
                                                <select name="problem_2_progress_code" id="problem_2_progress_code" class="form-control">
                                                    <?php foreach($progress_codes as $key => $code): ?>
                                                        <option value="<?php echo $key; ?>" <?php echo ($check_res['problem_2_progress_code'] == $key) ? "selected ": "";  ?>  ><?php echo $code; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_2_comments" class="col-sm-4"><?php echo xlt('Comments'); ?></label>
                                            <div class="col-sm-8">
                                                <textarea name="problem_2_comments" class="form-control" id="problem_2_comments" rows="3"><?php echo text($check_res['problem_2_comments']); ?></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="margin-top-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_2_date_target" class="col-sm-6"><?php echo xlt('Target Date for Attainment:'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="problem_2_date_target" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_2_date_target']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_2_date_completion" class="col-sm-4"><?php echo xlt('Completion Date:'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="problem_2_date_completion" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_2_date_completion']); ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>  
                            <div class="clearfix"></div> <!-- end of Problem 2 -->

                            <hr>

                            <div class="col-md-12"> <!-- beginning of Problem 3 -->
                                <h4><?php echo xlt('Problem Area 3#'); ?></h4>
                                <div class="form-group">
                                    <label for="problem_3_description"><?php echo xlt('Choose (see above) (BRIEF description of issues will be addressed in the following goal)'); ?></label>
                                    <textarea name="problem_3_description" id="problem_3_description" rows="3" class="form-control"><?php echo text($check_res['problem_3_description']); ?></textarea>
                                    <small class="text-danger problem_3_description_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_3_client_goal"><?php echo xlt('Client\'s statement of overall goal or need:'); ?></label>
                                    <textarea name="problem_3_client_goal" id="problem_3_client_goal" rows="3" class="form-control"><?php echo text($check_res['problem_3_client_goal']); ?></textarea>
                                    <small class="text-danger problem_3_client_goal_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_3_objectives"><?php echo xlt('TX Objectives (must be concrete and measurable)'); ?></label>
                                    <textarea name="problem_3_objectives" id="problem_3_objectives" rows="3" class="form-control"><?php echo text($check_res['problem_3_objectives']); ?></textarea>
                                    <small class="text-danger problem_3_objectives_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem_3_objectives_tasks"><?php echo xlt('Tasks to complete objectives: (including type and frequency of treatment)'); ?></label>
                                    <textarea name="problem_3_objectives_tasks" id="problem_3_objectives_tasks" rows="3" class="form-control"><?php echo text($check_res['problem_3_objectives_tasks']); ?></textarea>
                                    <small class="text-danger problem_3_objectives_tasks_error"></small>
                                </div>
                                <div class="margin-top-20">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_3_date_review" class="col-sm-6"><?php echo xlt('Date of Review'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="problem_3_date_review" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_3_date_review']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_3_progress_code" class="col-sm-5"><?php echo xlt('Progress Code'); ?></label>
                                            <div class="col-sm-7">
                                                <select name="problem_3_progress_code" id="problem_3_progress_code" class="form-control">
                                                    <?php foreach($progress_codes as $key => $code): ?>
                                                        <option value="<?php echo $key; ?>" <?php echo ($check_res['problem_3_progress_code'] == $key) ? "selected": ""; ?>  ><?php echo $code; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_3_comments" class="col-sm-4"><?php echo xlt('Comments'); ?></label>
                                            <div class="col-sm-8">
                                                <textarea name="problem_3_comments" class="form-control" id="problem_3_comments" rows="3"><?php echo text($check_res['problem_3_comments']); ?></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="clearfix"></div>
                                <div class="margin-top-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_3_date_target" class="col-sm-6"><?php echo xlt('Target Date for Attainment:'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="problem_3_date_target" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_3_date_target']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_3_date_completion" class="col-sm-4"><?php echo xlt('Completion Date:'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="problem_3_date_completion" class="form-control datepicker" autocomplete="off" value="<?php echo text($check_res['problem_3_date_completion']); ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>  
                            <div class="clearfix"></div> <!-- end of Problem 3 -->

                            <div class="col-md-12 margin-top-20">
                                <div class="form-group">
                                    <label for="individual_included" class="col-sm-5"><?php echo xlt('Individuals included in initial treatment planning or review:'); ?></label>
                                    <div class="col-sm-7">
                                        <input type="text" name="individual_included" id="individual_included" class="form-control" autocomplete="off" value="<?php echo text($check_res['individual_included']); ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="clearfix">&nbsp;</div>
                            
                    </fieldset>

                    

                    <div class="form-group clearfix">
                        <div class="col-sm-12 col-sm-offset-1 position-override">
                            <div class="btn-group oe-opt-btn-group-pinch" role="group">
                                <button type='submit'  class="btn btn-default btn-save" name="save_treatment_plan"><?php echo xlt('Save'); ?></button>
                                <button type="button" class="btn btn-link btn-cancel oe-opt-btn-separate-left" onclick="top.restoreSession(); parent.closeTab(window.name, false);"><?php echo xlt('Cancel');?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <script src="<?php echo $web_root; ?>/library/js/bootstrap-timepicker.min.js"></script>
        <script language="javascript">
            $(document).ready(function(){

                $('.timepicker').timepicker({
                  defaultTime: null
                });

                

                $('.datepicker').datetimepicker({
                  <?php $datetimepicker_timepicker = false; ?>
                  <?php $datetimepicker_showseconds = false; ?>
                  <?php $datetimepicker_formatInput = false; ?>
                  <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
                  <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
                });

                $('.btn-save').on('click', function(e){
                    e.preventDefault();

                    var errors = false;

                    var review1 = $('#review1').prop('checked');
                    var review2 = $('#review2').prop('checked');
                    var review3 = $('#review3').prop('checked');
                    var review4 = $('#review4').prop('checked');
                    if((review1 == '') && (review2 == '') && (review3 == '') && (review4 == '')){
                        $('.review_error').text('Please enter your Review.');
                        errors = true;
                    } else {
                        $('.review_error').text('');
                        errors = false;
                    }

                    var participant_name = $('#participant_name').val();
                    if(participant_name == ''){
                        $('.participant_name_error').text('Please enter Participant Name.');   
                        errors = true;                     
                    } else {
                        $('.participant_name_error').text('');
                        errors = false;
                    }

                    var medical_id = $('#medical_id').val();
                    if(medical_id == ''){
                        $('.medical_id_error').text('Enter Medical ID.');  
                        errors = true;                      
                    } else {
                        $('.medical_id_error').text('');
                        errors = false;
                    }

                    var date_birth = $('#date_birth').val();
                    if(date_birth == ''){
                        $('.date_birth_error').text('Enter date of birth.');      
                        errors = true;                  
                    } else {
                        $('.date_birth_error').text('');
                        errors = false;
                    }

                    var age = $('#age').val();
                    if(age == ''){
                        $('.age_error').text('Enter age.'); 
                        errors = true;                       
                    } else {
                        $('.age_error').text('');
                        errors = false;
                    }

                    
                    var examiner = $('#examiner').val();
                    if(examiner == ''){
                        $('.examiner_error').text('Please enter examiner name.');    
                        errors = true;                    
                    } else {
                        $('.examiner_error').text('');
                        errors = false;
                    }


                    var practitioner_id = $('#practitioner_id').val();
                    if(practitioner_id == ''){
                        $('.practitioner_id_error').text('Please enter Practitioner ID.');    
                        errors = true;                    
                    } else {
                        $('.practitioner_id_error').text('');
                        errors = false;
                    }

                    var date = $('#date').val();
                    if(date == ''){
                        $('.date_error').text('Please enter date.');    
                        errors = true;                    
                    } else {
                        $('.date_error').text('');
                        errors = false;
                    }
                    
                    /*$('.dsm_diagnoses').each(function(){
                        if($(this).val() == ''){
                            $('.dsm_diagnoses_error').text('Please enter some diagnoses.');    
                            errors = true;
                        } else {
                            $('.dsm_diagnoses_error').text('');    
                            errors = false;
                        }
                    });*/


                    

                    

                    if(errors){
                        return;
                    }                    

                    top.restoreSession();

                    $.ajax({
                        url: "<?php echo $rootdir; ?>/forms/<?php echo $folderName; ?>/save.php?id=<?php echo attr_url($formid); ?>",
                        type: 'POST',
                        data: $('form#my_treatment_plan_form').serialize(),
                        success: function(response){
                            console.log(response);
                            //window.location.reload();
                            window.location.href = "<?php echo $rootdir; ?>/forms/<?php echo $folderName; ?>/redirect.php";
                        },
                        errors: function(response){
                            console.log(response);
                        }
                    });

                });
            });
        </script>
    </body>
</html>
