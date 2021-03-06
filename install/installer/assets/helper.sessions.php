<?php if(!defined('INST_BASEDIR')) die('Direct access is not allowed!');

    /* ====================================================================
    *
    *                            PHP Setup Wizard
    *
    *                        -= SESSION VALIDATION =-
    *
    *  Do not change anything in this file unless you are certain what
    *  you are doing. Any modifycations here might break the installer!
    *
    *  ================================================================= */
    


	//========================================[ VARIABLES ]========================================//
    
    // Setup the session variables used in this process
	$ID = $config['session_prefix'];
    $connect = 'connection'; 
	$admin   = 'admin';
	$serial  = 'serial';
    $special = 'special';
    $stepkey = 'step';
    $agreemt = 'agreement';	
	
	// The 'doneaction' post is set in the last step of the
	// installer and affects this variable to reset all sessions
	$forceResetAll = false;


	//========================================[ REMOVE OLD CONFIG ]========================================//

	if(isset($_REQUEST['doneaction']))
	{
		// If the user requested that current config should be removed
		if($_REQUEST['doneaction'] == 'removeold')
		{
			/*
			*   This is done here so all the sessions can be reset after
			*   the config has been removed. Othervice the user would have 
			*   to enter a button twice - once for removing the config and
			*   again to reset the sessions and continue
			*/

			$forceResetAll = DeleteFinalOutputConfig();
		}
	}
    

	//========================================[ RESET SESSIONS ]========================================//

    // If reset is requested - sessions are reset and $keywords
    // will be back to defaults
    if($forceResetAll || isset($_REQUEST['reset']))
    {
		if($forceResetAll || $_REQUEST['reset'] == 'all')
		{
			unset($_SESSION[$ID]);
			session_destroy();
		}

		else if($_REQUEST['reset'] == $connect)
			unset($_SESSION[$ID][$connect]);

		else if($_REQUEST['reset'] == $special)
			unset($_SESSION[$ID][$special]);

		else if($_REQUEST['reset'] == $serial)
			unset($_SESSION[$ID][$serial]);

		else if($_REQUEST['reset'] == 'additional')
			unset($_SESSION[$ID][STEP_ADDEDINFO]);

		else if($_REQUEST['reset'] == $admin)
		{
			unset($_SESSION[$ID][$admin]); # Admin data
			SetAdminAccountStatus(); # Admin creation status
		}

		else if($_REQUEST['reset'] == 'install')
			ResetDatabaseInstallStatus();
    }


	//========================================[ SET DEFAULT VALUES ]========================================//
    
	// Set the default keyword values from config to session if not set        
    if(!isset($_SESSION[$ID][$special])) 
        $_SESSION[$ID][$special] = $keywords[$special]; 

	if(!isset($_SESSION[$ID][$serial])) 
        $_SESSION[$ID][$serial] = $keywords[$serial]; 

	if(!isset($_SESSION[$ID][$connect])) 
	{
        $_SESSION[$ID][$connect] = $keywords[$connect];    
		if($steps[STEP_DBCONNECT]['encryptlogin']) 
		{
			$_SESSION[$ID][$connect]['hostname'] = Encrypt($keywords[$connect]['hostname']);
			$_SESSION[$ID][$connect]['username'] = Encrypt($keywords[$connect]['username']);
			$_SESSION[$ID][$connect]['password'] = Encrypt($keywords[$connect]['password']);
			$_SESSION[$ID][$connect]['database'] = Encrypt($keywords[$connect]['database']);
		}
	}

	if(!isset($_SESSION[$ID][$admin])) 
	{
        $_SESSION[$ID][$admin] = $keywords[$admin];    
		if($steps[STEP_ROOTUSER]['encryptdata'])
		{
			foreach($keywords[$admin] as $adminKey=>$defaultValue)
				$_SESSION[$ID][$admin][$adminKey] = $defaultValue;
		}
	}

	if(!isset($_SESSION[$ID][STEP_ADDEDINFO])) 
		$_SESSION[$ID][STEP_ADDEDINFO] = false;
	
	//========================================[ SYNCRONIZE SESSIONS and $KEYWORDS ]========================================//

	/* 
	*   If new keywords where added AFTER the installer was launched (sessions are set) then someone is probably
	*   modifying the installer to fit some system - then it would be very anoying to constantly have to reset
	*   sessions in order to get the new keywords in the session. Same goes if some keyword is removed or renamed
	*   it will not change in the sessions. This piece of code is to syncronize the sessions with the keywords array
	*/

	$parts = array($special, $serial, $connect, $admin);
	foreach($parts as $part)
	{
		// New keywords have been added to $keywords array - add new
		foreach($keywords[$part] as $key=>$value)
		{
			if(!isset($_SESSION[$ID][$part][$key]))
			{
				// Admin part might be encrypted
				if($part == $admin && $steps[STEP_ROOTUSER]['encryptdata'])
					 $_SESSION[$ID][$part][$key] = $value;
				else $_SESSION[$ID][$part][$key] = $value;			
			}
		}

		// Keyword has been removed or renamed - delete unknown keys
		$removeKeys = array();
		foreach($_SESSION[$ID][$part] as $key=>$value)
		{
			if(!isset($keywords[$part][$key]))
				$removeKeys[] = $key;
		}
		// Remove keys are stored until all session array has been 
		// checked - then if some keys where added, remove them
		foreach($removeKeys as $remove)
		{
			unset($_SESSION[$ID][$part][$remove]);
		}
	}


	//========================================[ PROCESS POSTED KEYWORDS ]========================================//
    
    // If there are some posted values, compare them against connection/special 
	// keywords session and override any values that match. The changes will be 
	// updated to $keywords below
    if(isset($_POST) && count($_POST) > 0)
    {
		// If the additional step is enabled, and the "update to sessions" flag 
		// is set - then reset the sessions to remember every posted value
		if($steps[STEP_ADDEDINFO]['enabled'] && isset($_POST[STEP_ADDEDINFO]) && $_POST[STEP_ADDEDINFO] == 'save_to_sessions')
		{
			$_SESSION[$ID][STEP_ADDEDINFO] = array();

			// Set default values first, all keywords will be part of this array
			foreach($steps[STEP_ADDEDINFO]['form'] as $control)
			{
				if(is_array($control) && isset($control['keyword']))
				{
					if(isset($control['value_off']))
						 $_SESSION[$ID][STEP_ADDEDINFO][$control['keyword']] = $control['value_off'];
					else $_SESSION[$ID][STEP_ADDEDINFO][$control['keyword']] = '';
				}
			}

			// Update all values that were posted - but those that were not remain empty
			foreach($_POST as $key=>$value)
			{
				if($key == STEP_ADDEDINFO || $key == 'step' || $key == 'submit')
					continue;

				// to be sure it will be "string" type
				$value = trim(strval($value));
				$_SESSION[$ID][STEP_ADDEDINFO][$key] = $value; 
			}
		}

		// For the reset of the installer
		else
		{
			foreach($_POST as $key=>$value)
			{
				$value = trim($value);

				// Special keywords are just stored
				if(array_key_exists($key, $_SESSION[$ID][$special]))
					$_SESSION[$ID][$special][$key] = $value;

				// Serial keywords have flags as well
				if(array_key_exists($key, $_SESSION[$ID][$serial]))
				{
					// If "keyvalue" was posted, check if it matches configured serial
					if($key == 'keyvalue')
					{
						$_SESSION[$ID][$serial]['keyvalue'] = $value;
						$_SESSION[$ID][$serial]['isTrial'] = false;
						$_SESSION[$ID][$serial]['isMatch'] = IsSerialKeyMatch($value);
					}

					// If trial was clicked, clear the serial entered as it does not matter
					// when serial is selected
					else if($key == 'isTrial')
					{
						$_SESSION[$ID][$serial]['keyvalue'] = '';
						$_SESSION[$ID][$serial]['isTrial'] = true;
						$_SESSION[$ID][$serial]['isMatch'] = false;
					}
				}

				// Connection keywords need proper caring :)
				else if(array_key_exists($key, $_SESSION[$ID][$connect]))
				{
					// If encryption is enabled, encrypt the login to session
					if ($steps[STEP_DBCONNECT]['encryptlogin'] && in_array($key, array('password','username','hostname','database')) )
						$_SESSION[$ID][$connect][$key] = Encrypt($value);

					// prefix is set using a function to enable the installer to 
					// update the value directly if needed
					else if($key == 'dbprefix')
						SetSessionPrefix($value);

					// The other keywords are treated normally
					else 
						$_SESSION[$ID][$connect][$key] = $value;
				}

				// The data posted when root user is being created
				else if(array_key_exists($key, $_SESSION[$ID][$admin]))
				{
					if($steps[STEP_ROOTUSER]['encryptdata'])
						 $_SESSION[$ID][$admin][$key] = $value;
					else $_SESSION[$ID][$admin][$key] = $value;
				}
			}
		}
    }


	//========================================[ DETERMINE THE CURRENT STEP ]========================================//
   
    // If the step session is not set, set it to the first 
	// steps depending on the configuration
	if(!isset($_SESSION[$ID][$stepkey]))
	{
		/**
		*     NOTE: IF YOU WANT THE TWO FIRST STEPS TO BE "SKIPPED" BUT STILL MAKE IT AVAILABLE
		*           AS IN - THE INSTALLER WILL START ON WELCOME MESSAGE BUT THE USER CAN CLICK
		*           [BACK] TO SEE THE TESTS HIM SELF = THEN CHANGE THE STEP_MODULECHECK to STEP_WELCOME
		*
		*/

		// Get the first step-key and ishidden in $steps
		reset($steps);
		$firstStep = key($steps);
		$firstIsHidden = (isset($steps[$firstStep]['ishidden'])) ? $steps[$firstStep]['ishidden'] : false;

		// Set the session to the first step, or the next available step
		if($steps[$firstStep]['enabled'] && !$firstIsHidden)
			 $_SESSION[$ID][$stepkey] = $firstStep;
		else $_SESSION[$ID][$stepkey] = GetNextStep($firstStep);
	}

	// If the step has been changed by POST or GET, update
	// the step session if the key exists in $steps	
	if(isset($_REQUEST[$stepkey]) && isset($steps[trim($_REQUEST[$stepkey])]))
	{
		$requested = trim($_REQUEST[$stepkey]);
		
		// If the requested step key is either disabled or set to ishidden, select the
		// next available step that is enabled or does not have an ishidden
		if( (isset($steps[$requested]['enabled']) && !$steps[$requested]['enabled'])  || 
	        (isset($steps[$requested]['ishidden']) && $steps[$requested]['ishidden'])  )
		{
			$step = GetNextStep($requested);
		}
		else
			$step = $requested;

		// Update the session with requested step key
		$_SESSION[$ID][$stepkey] = $step;
	}

	// The page was just reloaded, no step was set so keep the installer stationary
	else
		$step = $_SESSION[$ID][$stepkey];


	//========================================[ LICENSE AGREEMENT ]========================================//
        
    // License or Terms-Of-Use agreement must be approved if enabled in config
    if(!isset($_SESSION[$ID][$agreemt])) 
		$_SESSION[$ID][$agreemt] = false;
    if(isset($_REQUEST[$agreemt]))
    {
        if($_REQUEST[$agreemt] == 'approved')
             $_SESSION[$ID][$agreemt] = true;
        else $_SESSION[$ID][$agreemt] = false;
    }
    if($steps[STEP_TERMSOFUSE]['enabled'])
         $LICENSE_APPROVED = $_SESSION[$ID][$agreemt];
    else $LICENSE_APPROVED = true;
         
	
	//========================================[ SAVE CHANGES ]========================================//

	// Set the keywords with the updated session arrays and 
    // update the masks class with the changed values
    $keywords[$connect] = $_SESSION[$ID][$connect];
	$keywords[$serial] = $_SESSION[$ID][$serial];
    $keywords[$special] = $_SESSION[$ID][$special];
	$keywords[$admin] = $_SESSION[$ID][$admin];
	$keywords[STEP_ADDEDINFO] = $_SESSION[$ID][STEP_ADDEDINFO];

	// If the login is encrypted, it must be decrypted
	// before the values are to be used in the installer
	if($steps[STEP_DBCONNECT]['encryptlogin'])
	{
		// Trim is added here because when Blowfish is decrypted it adds four
		// unprintable characters at the end of the string, which trim removes
		$keywords[$connect]['hostname'] = trim(Decrypt($_SESSION[$ID][$connect]['hostname']));
		$keywords[$connect]['username'] = trim(Decrypt($_SESSION[$ID][$connect]['username']));
		$keywords[$connect]['password'] = trim(Decrypt($_SESSION[$ID][$connect]['password'])); 
		$keywords[$connect]['database'] = trim(Decrypt($_SESSION[$ID][$connect]['database'])); 
	}

	// If admin data is encrypted, decrypt the data before continue
	if($steps[STEP_ROOTUSER]['encryptdata'])
	{
		foreach($_SESSION[$ID][$admin] as $adminKey=>$defaultValue)
			$keywords[$admin][$adminKey] = trim($defaultValue);
	}


	//========================================[ CLEAN-UP ]========================================//

	// Remove the variables not used again
	unset($ID);
    unset($connect);
	unset($admin);
    unset($special);
    unset($stepkey);
    unset($agreemt);
	unset($requested);