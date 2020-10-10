<?php
/**
 * Clinical instructions form.
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

$folderName = 'cbrs_progress_notes';
$tableName = 'form_' . $folderName;


$returnurl = 'encounter_top.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : 0);
$check_res = $formid ? formFetch($tableName, $formid) : array();
?>
<html>
    <head>
        <title><?php echo xlt("CBRS Progress Notes"); ?></title>

        <?php Header::setupHeader(['datetime-picker', 'opener']); ?>
        <link rel="stylesheet" href="<?php echo $web_root; ?>/library/css/bootstrap-timepicker.min.css">
    </head>
    <body class="body_top">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h2><?php echo xlt('CBRS Progress Notes'); ?></h2>
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

            $duration = [
                0 => 'Select',
                1 => '0.25 hr / 1 unit',
                2 => '0.50 hr / 2 units',
                3 => '0.75 hr / 3 units',
                4 => '1 hr / 4 units',
                5 => '1.25 hrs / 5 units',
                6 => '1.50 hrs / 6 units',
                7 => '1.75 hrs / 7 units',
                8 => '2 hrs / 8 units',
                9 => '2.25 hrs / 9 units',
                10 => '2.50 hrs / 10 units',
                11 => '2.75 hrs / 11 units',
                12 => '3 hrs / 12 units',
                13 => '3.25 hrs / 13 units',
                14 => '3.50 hrs / 14 units',
                15 => '3.75 hrs / 15 units',
                16 => '4 hrs / 16 units',
            ];

            ?>
            <div class="row">
                
                <form method="post" id="my_progress_notes_form" name="my_progress_notes_form" action="<?php echo $rootdir; ?>/forms/cbrs_progress_notes/save.php?id=<?php echo attr_url($formid); ?>">
            

                
                    <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                    <input type="hidden" name="encounter" value="<?php echo $encounter; ?>">
                    <input type="hidden" name="user" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="authorized" value="<?php echo $userauthorized; ?>">
                    <input type="hidden" name="activity" value="1">

                    <fieldset>
                        <legend class=""><?php echo xlt('CBRS Progress Notes'); ?></legend>
                            <!--
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <textarea name="services_place" id ="services_place"  class="form-control" cols="80" rows="5" ><?php //echo text($check_res['services_place']); ?></textarea>
                                </div>
                            </div>
                            -->
                           
                            

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 "><?php echo xlt('Client Name'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text"  id="name" class="form-control" value="<?php echo text($patient_full_name); ?>" readonly>
                                        <input type="hidden" name="name" value="<?php echo text($patient_full_name); ?>" >
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="cbrs" class="col-sm-3 "><?php echo xlt('CBRS'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="cbrs" id="cbrs" class="form-control" value="<?php echo text($check_res['cbrs']); ?>">
                                        <small class="text-danger cbrs_error"></small>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 "><?php echo xlt('Billing Code'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text"  class="form-control" value="H2017-CBRS" readonly>
                                        <input type="hidden" name="billing_code" value="H2017-CBRS">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 "><?php echo xlt('Date of Service'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="dateofservice" id="dateofservice" class="form-control datepicker" value="<?php echo text($check_res['dateofservice']); ?>" autocomplete="off">
                                        <small class="text-danger date_error"></small>
                                    </div>                                    
                                </div>

                                <div class="form-group">
                                    <label for="starttime" class="col-sm-3 "><?php echo xlt('Start Time'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="starttime" id="starttime" class="form-control timepicker" value="<?php echo text($check_res['starttime']); ?>" autocomplete="off">
                                        <small class="text-danger starttime_error"></small>
                                    </div>                                    
                                </div>

                                <div class="form-group">
                                    <label for="endtime" class="col-sm-3 "><?php echo xlt('End Time'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="endtime" id="endtime" class="form-control timepicker" value="<?php echo text($check_res['endtime']); ?>" autocomplete="off">
                                        <small class="text-danger endtime_error"></small>
                                    </div>                                    
                                </div>

                                <div class="form-group">
                                    <label for="duration" class="col-sm-3 "><?php echo xlt('Duration'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="duration" class="form-control" name="duration" value="<?php echo text($check_res['duration']); ?>">
                                        <small class="text-danger duration_error"></small>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-20" >
                                <div class="form-group">
                                    <label for="" class="col-sm-4 ">
                                        <?php echo xlt('(N) State where the services took place:'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                          <input type="radio" name="services_place" id="services_place1" value="home" <?php echo ($check_res['services_place'] == 'home') ? "checked": "";  ?> > <?php echo xlt('Home'); ?>
                                        </label>
                                        <label class="radio-inline">
                                          <input type="radio" name="services_place" id="services_place2" value="community"  <?php echo ($check_res['services_place'] == 'community') ? "checked": "";  ?> > <?php echo xlt('Community'); ?>
                                        </label>
                                        <small class="text-danger services_place_error clearfix"></small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 ">
                                        <?php echo xlt('And who you were with:'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                          <input type="radio" name="services_with" id="services_with1" value="client"  <?php echo ($check_res['services_with'] == 'client') ? "checked": "";  ?> > <?php echo xlt('Client'); ?>
                                        </label>
                                        <label class="radio-inline">
                                          <input type="radio" name="services_with" id="services_with2" value="family" <?php echo ($check_res['services_with'] == 'family') ? "checked": "";  ?> > <?php echo xlt('Family'); ?>
                                        </label>
                                        <small class="text-danger services_with_error clearfix"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-20" >
                                <p>
                                    <?php echo xlt('(A) State the goals and tasks set at the beginning of services for the client. You will not always work on all of them at each date of service.'); ?>
                                </p>

                                <div class="form-group margin-top-20">
                                    <label for="" class="col-sm-2 control-label"><strong><?php echo xlt('Objective 1.1 (H2017):'); ?></strong></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control " name="goals_object_1" id="goals_object_1" style="width: 250px; float: left; margin-right: 20px" value="<?php echo text($check_res['goals_object_1']); ?>">
                                        <small class="text-danger goals_object_1_error" style="height: 24px; line-height: 24px;"></small>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-10 col-sm-offset-2" >
                                    <div class="form-group padding-left-18">
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_1_status" id="goals_object_1a" value="completed" <?php echo ($check_res['goals_object_1_status'] == 'completed') ? "checked": "";  ?> > <?php echo xlt('Completed/Maintenance'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_1_status" id="goals_object_1b" value="substantial" <?php echo ($check_res['goals_object_1_status'] == 'substantial') ? "checked": "";  ?> > <?php echo xlt('Substantial'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_1_status" id="goals_object_1c" value="moderate" <?php echo ($check_res['goals_object_1_status'] == 'moderate') ? "checked": "";  ?> > <?php echo xlt('Moderate'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_1_status" id="goals_object_1d" value="minimal" <?php echo ($check_res['goals_object_1_status'] == 'minimal') ? "checked": "";  ?> > <?php echo xlt('Minimal'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_1_status" id="goals_object_1e" value="regression" <?php echo ($check_res['goals_object_1_status'] == 'regression') ? "checked": "";  ?> > <?php echo xlt('Regression'); ?>
                                        </label>
                                        <small class="text-danger clearfix goals_object_1_status_error"></small>
                                    </div>  
                                </div>

                                <div class="clearfix "></div>

                                <div class="form-group margin-top-20">
                                    <label for="" class="col-sm-2 control-label"><strong><?php echo xlt('Objective 2.1 (H2017):'); ?></strong></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="goals_object_2" id="goals_object_2" style="width: 250px; float: left; margin-right: 20px" value="<?php echo text($check_res['goals_object_2']); ?>">
                                        <small class="text-danger goals_object_2_error" style="height: 24px; line-height: 24px;"></small>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-10 col-sm-offset-2" >
                                    <div class="form-group padding-left-18">
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_2_status" id="goals_object_2a" value="completed" <?php echo ($check_res['goals_object_2_status'] == 'completed') ? "checked": "";  ?> > <?php echo xlt('Completed/Maintenance'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_2_status" id="goals_object_2b" value="substantial" <?php echo ($check_res['goals_object_2_status'] == 'substantial') ? "checked": "";  ?> > <?php echo xlt('Substantial'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_2_status" id="goals_object_2c" value="moderate" <?php echo ($check_res['goals_object_2_status'] == 'moderate') ? "checked": "";  ?> > <?php echo xlt('Moderate'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_2_status" id="goals_object_2d" value="minimal" <?php echo ($check_res['goals_object_2_status'] == 'minimal') ? "checked": "";  ?> > <?php echo xlt('Minimal'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_2_status" id="goals_object_2e" value="regression" <?php echo ($check_res['goals_object_2_status'] == 'regression') ? "checked": "";  ?> > <?php echo xlt('Regression'); ?>
                                        </label>
                                        <small class="text-danger clearfix goals_object_2_status_error"></small>
                                    </div>  
                                </div>

                                <div class="clearfix "></div>

                                <div class="form-group margin-top-20">
                                    <label for="" class="col-sm-2 control-label"><strong><?php echo xlt('Objective 3.1 (H2017):'); ?></strong></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="goals_object_3" id="goals_object_3" style="width: 250px; float: left; margin-right: 20px" value="<?php echo text($check_res['goals_object_3']); ?>">
                                        <small class="text-danger goals_object_3_error" style="height: 24px; line-height: 24px;"></small>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-10 col-sm-offset-2" >
                                    <div class="form-group padding-left-18">
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_3_status" id="goals_object_3a" value="completed" <?php echo ($check_res['goals_object_3_status'] == 'completed') ? "checked": "";  ?>  > <?php echo xlt('Completed/Maintenance'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_3_status" id="goals_object_3b" value="substantial" <?php echo ($check_res['goals_object_3_status'] == 'substantial') ? "checked": "";  ?> > <?php echo xlt('Substantial'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_3_status" id="goals_object_3c" value="moderate" <?php echo ($check_res['goals_object_3_status'] == 'moderate') ? "checked": "";  ?> > <?php echo xlt('Moderate'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_3_status" id="goals_object_3d" value="minimal" <?php echo ($check_res['goals_object_3_status'] == 'minimal') ? "checked": "";  ?>  > <?php echo xlt('Minimal'); ?>
                                        </label>
                                        <label class="radio-inline margin-right-40">
                                          <input type="radio" name="goals_object_3_status" id="goals_object_3e" value="regression" <?php echo ($check_res['goals_object_3_status'] == 'regression') ? "checked": "";  ?> > <?php echo xlt('Regression'); ?>
                                        </label>
                                        <small class="text-danger clearfix goals_object_3_status_error"></small>
                                    </div>  
                                </div>

                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-20">
                                <label for="narrative_services"><?php echo xlt('Narrative of Service:'); ?></label>
                                <textarea name="narrative_services" id="narrative_services" rows="4" class="form-control"><?php echo text($check_res['narrative_services']); ?></textarea>
                                <small class="text-danger narrative_services_error"></small>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-20">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 "><?php echo xlt('(P) State the plan. I will meet with them: '); ?></label>
                                    <div class="col-sm-3">
                                        <span class="col-sm-3"><?php echo xlt('Date:'); ?> </span>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control datepicker" name="meet_again_date" id="meet_again_date" value="<?php echo text($check_res['meet_again_date']); ?>" autocomplete="off">
                                            <small class="text-danger meet_again_date_error"></small>
                                        </div>                                        
                                    </div>

                                    <div class="col-sm-3">
                                        <span class="col-sm-3"><?php echo xlt('Time:'); ?> </span>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control timepicker" name="meet_again_time" id="meet_again_time" value="<?php echo text($check_res['meet_again_time']); ?>" autocomplete="off">
                                            <small class="text-danger meet_again_time_error"></small>
                                        </div>
                                    </div>                                     
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>

                            <div class="col-md-12 margin-top-20">
                                <label for="work_on" class="col-sm-2"><?php echo xlt('To work on:'); ?> </label>
                                <div >                                    
                                    <textarea name="work_on" id="work_on"  rows="4" class="form-control"><?php echo text($check_res['work_on']); ?></textarea>
                                    <small class="text-danger work_on_error"></small>
                                </div>
                            </div>

                            <div class="clearfix">&nbsp;</div>
                            
                    </fieldset>

                    

                    <div class="form-group clearfix">
                        <div class="col-sm-12 col-sm-offset-1 position-override">
                            <div class="btn-group oe-opt-btn-group-pinch" role="group">
                                <button type='submit'  class="btn btn-default btn-save" name="save_progress_notes"><?php echo xlt('Save'); ?></button>
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

                var today = new Date();

                $("input#endtime, input#starttime").on("keypress change blur focusout",function(){
                  var s = $("input#starttime").val();
                  var e = $("input#endtime").val();
                  var startTime = s.replace(/\s+/g, '').trim();
                  var endTime = e.replace(/\s+/g, '').trim();
                  if(startTime && endTime) {
                    
                    var date_today = today.getFullYear() + "-" + ('0' + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + (today.getDate() + 1)).slice(-2);
                    var date1 = new Date( date_today + " " + s ).getTime();
                    var date2 = new Date( date_today + " " + e ).getTime();
                    var msec = date2 - date1;
                    var total_in_minutes = Math.floor(msec / 60000);
                    var mins = Math.floor(msec / 60000);
                    var hrs = Math.floor(mins / 60);
                    var days = Math.floor(hrs / 24);
                    var yrs = Math.floor(days / 365);
                    var hours_text = '';
                    var hour_and_mins = '';

                    mins = mins % 60;
                    if(mins>1) {
                      hour_and_mins = hrs + "." + mins + ' hours';
                    } else {
                      if(hrs>1) {
                        hour_and_mins = hrs + ' hours';
                      } else {
                        hour_and_mins = hrs + ' hour';
                      }
                    }

                    /* 
                      1 hour = 4 units 
                      60 mins = 4 units
                      4 / 60 = 0.066 unit
                      1 min = 0.066 unit
                    */

                    var per_unit = 4/60;
                    var total_units = total_in_minutes * per_unit;
                    var unit_text = (total_units>0) ? total_units + ' units': total_units + ' unit';
                    var duration_text = hour_and_mins + " / " + unit_text;
                    $("input#duration").val(duration_text);
                    
                  }
                });

            });
        </script>
    </body>
</html>
