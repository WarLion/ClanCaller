<?php

    /* ====================================================================
    *
    *                             PHP Setup Wizard
    *                              by Thorsteinn
    *                               April 2010
    *
    *                          -= LAUNCH INSTALLER =-
    *
    *  ---------------------------------------------------------------
    *  WHAT DOES THIS CODE DO?
    *  ---------------------------------------------------------------
    *  Put this code in the "index.php" of your personal script to
    *  launch the installer. Make sure you have edited configuration
	*  and mask files before running the installation
    *
    *  Get more information about these files and configuration in the
    *  documentation that came with the installer. 
	*
	*  The constants below start with INST_ to prevent collision with
	*  your own constants or the framework you are using.
    *
    *
    *  ---------------------------------------------------------------
    *  DEFINE INSTALLATION CONSTANTS
    *  ---------------------------------------------------------------
    *  INST_RUNSCRIPT  - Get the name of the executing script
    *  INST_BASEDIR    - The path to the directory of THIS file
    *  INST_RUNFOLDER  - The folder that will contain the actual installer
	*  INST_RUNINSTALL - The installer script to launch
    */
    
    define('INST_RUNSCRIPT', pathinfo(__FILE__, PATHINFO_BASENAME));
    define('INST_BASEDIR',	 str_replace(INST_RUNSCRIPT, '', __FILE__));
    define('INST_RUNFOLDER', 'installer/');
	define('INST_RUNINSTALL', 'installer.php');
    if (is_dir(INST_BASEDIR.INST_RUNFOLDER) && 
		is_readable(INST_BASEDIR.INST_RUNFOLDER.INST_RUNINSTALL))
        require(INST_BASEDIR.INST_RUNFOLDER.INST_RUNINSTALL);
                 
    /* ================================================================= */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Your system</title>
</head>
<body>
<h1>Your PHP script starts here!</h1>
<p>Final config:</p>

<?
	include('includes/inc.config.php');	

	if(LICENCE_TRIAL_MODE)
	{
		echo '<h3>You are using a trial that will be active for the next '.LICENCE_TRIAL_TIMEOUT.' days</h3>';
	}
	else
	{
		echo '<h3>You are using FULL-VERSION</h3>';
		echo '<ul><li>Write down your serial key: <tt>'.LICENCE_SERIAL_KEY.'</tt></li></ul>';
	}

	echo '<h3>System info:</h3><ul>';
	foreach($system as $key=>$sys)
	{
		echo '<li>'.$key.' = '.$sys.'</li>';
	}
	echo '</ul>';

	echo '<h3>Database settings:</h3><ul>';
	foreach($dbConn as $key=>$con)
	{
		echo '<li>'.$key.' = '.$con.'</li>';
	}
	echo '</ul>';

	echo '<h3>Time settings:</h3><ul>';
	foreach($time as $key=>$tim)
	{
		echo '<li>'.$key.' = '.$tim.'</li>';
	}
	echo '</ul>';

	echo '<h3>Admin info:</h3><ul>';
	foreach($admin as $key=>$adm)
	{
		echo '<li>'.$key.' = '.$adm.'</li>';
	}
	echo '</ul>';

?>
</body>
</html>
