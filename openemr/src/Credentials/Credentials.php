<?php
/**
 * Functions used to check is certain credentials are required for a gven user
 *
 * @author    J. Alvin Harris <jalvin.cde@gmail.com>
 *
 * These functions are copied into the files needed. Referencing these functions from another file doesn't seem to 
 * work
 * These functions are currently used in 
 *		C:\xampp\htdocs\openemr\interface\main\expiration_date_alert.php
 *		C:\xampp\htdocs\openemr\interface\main\main_screen.php
 *			which trickles through to C:\xampp\htdocs\openemr\library\auth.inc
 *		C:\xampp\htdocs\openemr\src\Notifications\EmployeeCredentialNotification.php
 */

/****************************************
* IS ICANS REQUIRED
* check if ICANS is required for the given
* provider
****************************************/
function isICANSRequired($providerType) {
	// obtain lists that require the expirations
	$num = 20;
	$sql_limits = 'ASC LIMIT 0, '.escape_limit($num);
	$list_id = "Provider_Type_ICANs_required";
	$icansRequired = sqlStatement("SELECT lo.*
							 FROM list_options AS lo
							 RIGHT JOIN list_options as lo2 on lo2.option_id = lo.list_id AND lo2.list_id = 'lists' AND lo2.edit_options = 1
							 WHERE lo.list_id = ? AND lo.edit_options = 1
							 ORDER BY seq,title ".$sql_limits, array($list_id));
	
	// check if provider type in list
	while($row = sqlFetchArray($icansRequired)) 
	{
		if(xl($providerType) == xl($row['option_id']))
			return true;
	}

	// not in list, return false
	return false;
}

/****************************************
* IS CAR INS REQUIRED
* check if CAR INS is required for the given
* provider
****************************************/
function isCarInsRequired($providerType) {
	// obtain lists that require the expirations
	$num = 20;
	$sql_limits = 'ASC LIMIT 0, '.escape_limit($num);
	$list_id = "Provider_Type_Car_Ins_required";
	$carInsRequired = sqlStatement("SELECT lo.*
							 FROM list_options AS lo
							 RIGHT JOIN list_options as lo2 on lo2.option_id = lo.list_id AND lo2.list_id = 'lists' AND lo2.edit_options = 1
							 WHERE lo.list_id = ? AND lo.edit_options = 1
							 ORDER BY seq,title ".$sql_limits, array($list_id));
	
	// check if provider type in list
	while($row = sqlFetchArray($carInsRequired)) 
	{
		if(xl($providerType) == xl($row['option_id']))
			return true;
	}

	// not in list, return false
	return false;
}

/****************************************
* IS LICENSE REQUIRED
* check if LICENSE is required for the given
* provider
****************************************/
function isLicenseRequired($providerType) {
	// obtain lists that require the expirations
	$num = 20;
	$sql_limits = 'ASC LIMIT 0, '.escape_limit($num);
	$list_id = "Provider_Type_License_required";
	$licenseRequired = sqlStatement("SELECT lo.*
							 FROM list_options AS lo
							 RIGHT JOIN list_options as lo2 on lo2.option_id = lo.list_id AND lo2.list_id = 'lists' AND lo2.edit_options = 1
							 WHERE lo.list_id = ? AND lo.edit_options = 1
							 ORDER BY seq,title ".$sql_limits, array($list_id));
	
	// check if provider type in list
	while($row = sqlFetchArray($licenseRequired)) 
	{
		if(xl($providerType) == xl($row['option_id']))
			return true;
	}

	// not in list, return false
	return false;
}
?>
