This folder is for bat files to be run. Each bat file references a php file to be run and 
each bat file is scheduled in Windows Task Scheduler.

Also, php needs to be able to be run from the command line
To add the php directory (ie php.exe path), use 
	setx path "%path%;c:\directoryPath" 
For this computer server, the following command has been used
	setx path "%path%;c:\xampp\php"

bat file		referenced file		description
--------		---------------		-----------
dailyRun.bat	->	dailyCodeRun.php	This is a script that is to be run on a daily basis
						Currently the code is set to run at 8:00 AM
