<?php if(!defined('INST_BASEDIR')) die('Direct access is not allowed!');

    /* ====================================================================
    *
    *                            PHP Setup Wizard
    *
    *                         -= HELPER FUNCTIONS =-
    *
    *  Do not change anything in this file unless you are certain what
    *  you are doing. Any modifycations here might break the installer!
    *
    *  ================================================================= */


	
	
	/* =========================[ SESSION FUNCTIONS ]========================= */

	/* --------------------( Database Installation Status )------------------- */

	/** 
	 *  The progress of executing SQL queries in a database are set outside this 
	 *  helper, and the installer should not handle any sessions. So, this method 
	 *  is a work-around to allow the installer to update a session without direct 
	 *  manipulation. A database status is set by status message and a prefix
	 */
	function SetDatabaseInstallStatus($database, $state, $prefix='', $successCount=0, $failedCount=0) 
	{
		global $config;
		$ID = $config['session_prefix'];
		$sql = 'dbinstall';

		// Set the session to empty array if not set
		if(!isset($_SESSION[$ID][$sql])) 
			$_SESSION[$ID][$sql] = array();

		// Set a status for a given database (name)
		$_SESSION[$ID][$sql][$database] = array('state'=>$state, 'prefix'=>$prefix, 'okaycount'=>$successCount, 'failcount'=>$failedCount);
	}

	/**
	 *  Get the list of databases or some spesific database only, and their
	 *  installation status. This is a work-around function to allow installer
	 *  to access data directly from sessions
	 */
	function GetDatabaseInstallStatus($database='') 
	{
		global $config;
		$ID = $config['session_prefix'];
		$sql = 'dbinstall';

		// Set the session to empty array if not set
		if(!isset($_SESSION[$ID][$sql])) 
			$_SESSION[$ID][$sql] = array();

		// If get all database statuses
		if($database == '')
			return $_SESSION[$ID][$sql];

		// If the database has been spesified - return only its status
		else if(array_key_exists($database, $_SESSION[$ID][$sql]))
			return $_SESSION[$ID][$sql][$database];

		// The database does not have a status yet
		else
			return false;
	}

	/**
	 *  Remove some spesific database from sessions, rendering it
	 *  "unknown" or available for installation again. Used when a
	 *  database has a successful install but does not exist, thus
	 *  needs to be removed from sessions
	 */ 
	function RemoveDatabaseInstallStatus($database)
	{
		global $config;
		$ID = $config['session_prefix'];
		$sql = 'dbinstall';

		if(array_key_exists($database, $_SESSION[$ID][$sql]))
			unset($_SESSION[$ID][$sql][$database]);
	}

	/**
	 *  Reset installation session
	 */
	function ResetDatabaseInstallStatus()
	{
		global $config;
		$ID = $config['session_prefix'];
		$sql = 'dbinstall';

		unset($_SESSION[$ID][$sql]);
	}

	
	/* --------------------( Table Prefix )------------------- */
	
	/**
	 *  Set the prefix value to sessions. The installer might need to update
	 *  the session outside the prefix step.
	 */ 
	function SetSessionPrefix($prefix='')
	{
		global $steps;
		global $config;
		$ID = $config['session_prefix'];
		$connect = 'connection'; 
		$key = 'dbprefix';

		// If a separator must be added at the end of the prefix
		if(strlen($steps[STEP_DBPREFIX]['separator']) > 0)
		{
			// If the prefix is empty, and the separator is not
			// optional - the prefix becomes the separator
			if(strlen($prefix) == 0)
			{
				if(!$steps[STEP_DBPREFIX]['optional'])
					$prefix = $steps[STEP_DBPREFIX]['separator'];
			}

			// Prefix has value, make sure the separator is not 
			// added multiple times at the end of it
			else
			{
				$serp = $steps[STEP_DBPREFIX]['separator'];
				$start = strlen($prefix) - strlen($serp); # where does the $serp string start in $prefix 
				$start = ($start < 0) ? 0 : $start; # make sure $start does not go below zero

				// If the last part of $prefix does not match the separator then add
				// the separator at the end of $prefix before storing it to session
				if(substr($prefix, $start, strlen($serp)) != $steps[STEP_DBPREFIX]['separator'])
					$prefix = $prefix.$steps[STEP_DBPREFIX]['separator'];
			}
		}

		// Finally set the prefix to session
		$_SESSION[$ID][$connect][$key] = $prefix;
	}


	/* --------------------( Administrator Account )------------------- */

	/**
	 *  Set if a administrator account exists, or has been approved
	 */ 
	function SetAdminAccountStatus($status='none') # success , failed
	{
		global $config;
		$ID = $config['session_prefix'];
		$admin = 'adminaccount';

		// Set the session to false if not set
		if(!isset($_SESSION[$ID][$admin])) 
			$_SESSION[$ID][$admin] = 'none';

		// Set a status for administrator creation
		$_SESSION[$ID][$admin] = $status;
	}

	/**
	 *  Get a administrator account status
	 */ 
	function GetAdminAccountStatus()
	{
		global $config;
		$ID = $config['session_prefix'];
		$admin = 'adminaccount';

		// Set the session to false if not set
		if(!isset($_SESSION[$ID][$admin])) 
			$_SESSION[$ID][$admin] = 'none';

		// Get the administrator creation status
		return $_SESSION[$ID][$admin];
	}

	/**
	 *  Get if an administrator account has been created or not
	 */
	function AdminAccountExists()
	{
		return (GetAdminAccountStatus() != 'none') ? true : false;
	}

	/**
	 *  Get if an administrator account has been created successfully
	 */
	function AdminAccountSuccess()
	{
		return (GetAdminAccountStatus() == 'success') ? true : false;
	}

	/**
	 *  Get if an administrator account failed to insert 
	 */
	function AdminAccountFailed()
	{
		return (GetAdminAccountStatus() == 'failed') ? true : false;
	}


	/* --------------------( Serial Key Confirmation )------------------- */

	/**
	 *  Verify that the entered serial key matches the one kept in 
	 *  the configuration file
	 */
	function IsSerialKeyMatch($serialInput)
	{
		/* IF YOU PLAN ON USING A WEBSERVICE FOR THIS - MODIFY THIS FUNCION TO DO SO!! */

		global $steps;

		if(is_array($steps[STEP_SERIALKEY]['serialkeys']))
			return in_array(strtoupper($serialInput), $steps[STEP_SERIALKEY]['serialkeys']);
		else
			return (strtoupper($serialInput) == strtoupper($steps[STEP_SERIALKEY]['serialkeys'])) ? true : false;
	}


	/* --------------------( Additional Information )------------------- */

	/**
	 *  Get additional step's control value that has been posted, or 
	 *  empty string if not set 
	 */
	function HasAnyAdditionalStepValueBeenPostedYet()
	{
		global $config;
		$ID = $config['session_prefix'];
		return is_array($_SESSION[$ID][STEP_ADDEDINFO]);
	}

	/**
	 *  Get additional step's control value that has been posted, or 
	 *  empty string if not set 
	 */
	function GetAdditionalControlValue($keywordName, $defaultValue)
	{
		global $config;
		$ID = $config['session_prefix'];
	
		// If the session contains this value - return it as string format	
		if(isset($_SESSION[$ID][STEP_ADDEDINFO][$keywordName]))
		{
			 if(strlen($_SESSION[$ID][STEP_ADDEDINFO][$keywordName]) > 0)
				  return strval($_SESSION[$ID][STEP_ADDEDINFO][$keywordName]);
			 else return strval($defaultValue);
		}

		// If it does not - get boolean "false" instead
		else 
			return false;
	}

	/**
	 *  Evaluate text input controls (DOM objects, components or what ever you like to call them)
	 *  on the page and display warning boxes if is invalid
	 */
	function HasTextInputErrors($data, $value)
	{
		global $page;		

		// Do not even evaluate if no value has yet to be posted
		if(!HasAnyAdditionalStepValueBeenPostedYet())
			return false;

		// Only check textboxes and textareas
		if(isset($data['type']) && ($data['type'] == 'textbox' || $data['type'] == 'textarea'))
		{
			// If the box must be filled with some value	
			$mustfill = (isset($data['mustfill']) && $data['mustfill'] === true) ? true : false;

			// Numeric value
			if(isset($data['numeric']) && $data['numeric'] === true)
			{
				// Minval defines the lowest accepted value, and maxval the maximum accepted value
				$minval = (isset($data['minval']) && is_numeric($data['minval'])) ? $data['minval'] : false;
				$maxval = (isset($data['maxval']) && is_numeric($data['maxval'])) ? $data['maxval'] : false;				
				
				// Check numeric bounds
				$errorMsg = IsNumericInBounds($value, $minval, $maxval, $mustfill);
				if($errorMsg == '')
					return false;
				else
				{
					$page->WarningBox($errorMsg);
					return true;
				}
			}


			// String value
			else
			{
				$MAX = 2147483647;

				// If minlen is set, it must be 0 or higher. 1 or higher if "mustfill" flag is enabled
				if($mustfill)
					 $minlen = (isset($data['minlen']) && $data['minlen'] >  0) ? $data['minlen'] : 1;
				else $minlen = (isset($data['minlen']) && $data['minlen'] >= 0) ? $data['minlen'] : false;

				// If maxlen is set, it must be equal-or-higher than minlen, othervice just very very hight number
				$maxlen = (isset($data['maxlen']) && $data['maxlen'] >= $minlen) ? $data['maxlen'] : false;

				// Check string bounds
				$errorMsg = IsStringInBounds($value, $minlen, $maxlen, $mustfill);
				if($errorMsg == '')
					return false;
				else
				{
					$page->WarningBox($errorMsg);
					return true;
				}
			}
		}
		
		return false;
	}

	/**
	 *  Is some numeric value within the min-max bounds
	 */
	function IsNumericInBounds($value, $minval, $maxval, $mustfill)
	{
		// If range is configured badly - ignore it!
		if($minval != false && $maxval != false && $minval > $maxval)
		{
			$minval = false;
			$maxval = false;
		}

		// Get if the ranges are set or not
		$minset = ($minval === false) ? false : true;
		$maxset = ($maxval === false) ? false : true;
		$orBlank = (!$mustfill) ? ', or keep this field blank' : '';

		// If there is some value, it must be numeric
		if(strlen($value) > 0 && !is_numeric($value))
			return 'The value <b>'.$value.'</b> is not numeric, please enter only numeric digits in this box';

		// No need to check anything if empty values are accepted
		else if(!$mustfill && strlen($value) == 0)
			return '';

		// If no range is defined, but there must be some value
		else if(!$minset && !$maxset)
		{
			if($mustfill && strlen($value) == 0)
				return 'This field must contain numeric value';
		}

		// If minimum is set, but not maximum
		else if($minset && !$maxset)
		{
			if($mustfill && strlen($value) == 0)
				return 'This field must contain numeric value, starting from <b>'.$minval.'</b>';

			else if($value < $minval)
				return 'The value must be equal or higher than <b>'.$minval.'</b>'.$orBlank;
		}

		// If maximum is set, but not minimum
		else if(!$minset && $maxset)
		{
			if($mustfill && strlen($value) == 0)
				 return 'This field must contain numeric value, up to maximum of <b>'.$maxval.'</b>';

			else if($value > $maxval)
				return 'The value must be equal or lower than <b>'.$maxval.'</b>'.$orBlank;
		}

		// If both limits are set
		else if($minset && $maxset)
		{
			if($mustfill && $minval == $maxval && $value != $minval)
				return 'This field only accepts the value <b>'.$minval.'</b>';

			else if($mustfill && strlen($value) == 0)
				 return 'This field must contain numeric value between <b>'.$minval.'</b> and <b>'.$maxval.'</b>';

			else if($value < $minval || $value > $maxval)
				return 'The value must be between <b>'.$minval.'</b> and <b>'.$maxval.'</b>'.$orBlank;
		}

		return '';
	}

	function IsStringInBounds($value, $minlen, $maxlen, $mustfill)
	{
		// If range is configured badly - ignore it!
		if($minlen != false && $maxlen != false && $minlen > $maxlen)
		{
			$minlen = false;
			$maxlen = false;
		}

		// Get if the ranges are set or not
		$minset = ($minlen === false) ? false : true;
		$maxset = ($maxlen === false) ? false : true;
		$valueLength = strlen($value);
		$orBlank = (!$mustfill) ? ', or keep this field blank' : '';


		// No need to check anything if empty values are accepted
		if(!$mustfill && $valueLength == 0)
			return '';

		// If no range is defined, but there must be some value
		else if(!$minset && !$maxset)
		{
			if($mustfill && $valueLength == 0)
				return 'This field cannot be empty';
		}

		// If minimum is set, but not maximum
		else if($minset && !$maxset)
		{
			if($mustfill && $valueLength == 0)
				return 'This field must contain text that is at least <b>'.$minlen.'</b> characters long';

			else if($valueLength < $minlen)
				return 'The current value is '.$valueLength.' long, but it must be at least <b>'.$minlen.'</b> characters long'.$orBlank;
		}

		// If maximum is set, but not minimum
		else if(!$minset && $maxset)
		{
			if($mustfill && $valueLength == 0)
				 return 'This field must contain text that is equal or below <b>'.$maxlen.'</b> characters long';

			else if($valueLength > $maxlen)
				return 'The current value is '.$valueLength.' long, but it cannot be longer than <b>'.$maxlen.'</b> characters long'.$orBlank;
		}

		// If both limits are set
		else if($minset && $maxset)
		{
			if($mustfill && $minlen == $maxlen && $valueLength != $minlen)
				return 'This field only accepts values of length <b>'.$minlen.'</b>, current length is '.$valueLength;

			else if($mustfill && $valueLength == 0)
				 return 'This field must contain value of length between <b>'.$minlen.'</b> and <b>'.$maxlen.'</b>, current is '.$valueLength;

			else if($valueLength < $minlen || $valueLength > $maxlen)
				return 'The current value is '.$valueLength.' long, but it must be between <b>'.$minlen.'</b> and <b>'.$maxlen.'</b> characters long'.$orBlank;
		}

		return '';
	}




	/* =========================[ $STEPS FUNCTIONS ]========================= */

	/**
	 *  Get the next step index key, taking configuration into account
	 *  NOTE: false is returned if there is none
	 */
	function GetNextStep($stepKey)
	{
		global $steps;

		$next = false;
		$breakNext = false;
		foreach($steps as $key=>$step)
		{
			$next = $key;

			if($breakNext)
			{
				if( (isset($steps[$next]['enabled']) && !$steps[$next]['enabled']) || 
					(isset($steps[$next]['ishidden']) && $steps[$next]['ishidden']) )
					 continue;
				else break;
			}

			if($stepKey == $key)
				$breakNext = true;
		}
		return $next;
	}

	/**
	 *  Get the previous step index key, taking configuration into account.
	 *  NOTE: false is returned if there is none
	 */
	function GetPrevStep($stepKey)
	{
		global $steps;

		$prev = false;
		$breakNext = false;

		end($steps);
		while($current = prev($steps))
		{
			$prev = key($steps);

			if($breakNext)
			{
				if( (isset($steps[$prev]['enabled']) && !$steps[$prev]['enabled']) || 
					(isset($steps[$prev]['ishidden']) && $steps[$prev]['ishidden']) )
					 continue;
				else break;
			}

			if($stepKey == key($steps))
				$breakNext = true;
		}

		// Return false if the same as current
		if($prev == $stepKey) 
			 return false;

		// If the while ended and the $prev value
		// is set to disabled or ishidden step, then
		// return false!
		if( (isset($steps[$prev]['enabled']) && !$steps[$prev]['enabled']) || 
			(isset($steps[$prev]['ishidden']) && $steps[$prev]['ishidden']) )
			return false;
		
		// The step must be valid then :)
		else 
			return $prev;
	}


	/* =========================[ ENCRYPTION / DECRYPTION ]========================= */

	/**
	 *  Encrypt string
	 */
	function Encrypt($string) 
	{
		if(IsExtensionInstalled('mcrypt'))
		{
			global $config;
			return mcrypt_ecb(MCRYPT_BLOWFISH, $config['encryption_key'], $string, MCRYPT_ENCRYPT);
		}
		return $string;
	}

	/**
	 *  Decrypt string
	 */
	function Decrypt($string) 
	{
		if(IsExtensionInstalled('mcrypt'))
		{
			global $config;
			return mcrypt_ecb(MCRYPT_BLOWFISH, $config['encryption_key'], $string, MCRYPT_DECRYPT);
		}
		return $string;
	}


	/* =========================[ READ/WRITEABLE TESTS ]========================= */

	/** 
	 *  Test if some folder can be created if it does not exist, and then check if it is writeable or not
	 */
	function TestFolderWriteability($folderPath='')
	{
		global $page;

		if(strlen($folderPath) == 0)
			return TestResults('ignored', 'There is no folder to check');	

		else if(is_dir($folderPath))
		{
			if(is_writeable($folderPath))
				 return TestResults('success', 'Config folder <b>'.$folderPath.'</b> is writeable');
			else return TestResults('failed',  'Config folder <b>'.$folderPath.'</b> is not writeable');
		}
		else
		{
			if(mkdir($folderPath))
			{
				if(is_writeable($folderPath))
					 return TestResults('success', 'Config folder <b>'.$folderPath.'</b> has been created successfully, and it is writeable');
				else return TestResults('failed',  'Config folder <b>'.$folderPath.'</b> has been created successfully, but it is not writeable');
			}
			else 
			{
				$page->ErrorBox('The Installer is unable to create the folder <b>'.$folderPath.'</b>, check your <tt>chmod</tt> '.
							    'permissions or contact support to get this issue resolved.');
				return TestResults('failed', 'Unable to create the folder <b>'.$folderPath.'</b>');
			}
		}
	}

	/** 
	 *  Test if some mask file can be read or not
	 */
	function TestFileReadability($maskname)
	{
		global $mask;
		global $page;
		global $config;

		// Test the read ability (very likely to pass in most cases)
		$maskContent = $mask->GetMask($maskname);
		if($maskContent === false)
			return TestResults('failed', 'The mask file <b>'.$maskname.'</b> cannot be found! Error in installer setup!');
		else if(strlen($maskContent) > 0)
			return TestResults('success', 'The mask file for <b>'.$maskname.'</b> is readable');
		else
		{
			$page->ErrorBox('The Installer is unable to read the mask file <b>'.$config['mask_folder_name']. 
							DIRECTORY_SEPARATOR.$maskname.'</b>, check your <tt>chmod</tt> '.
							'permissions or contact support to get this issue resolved.');
			return TestResults('failed', 'Unable to read the mask of <b>'.$maskname.'</b>');
		}
	}

	/** 
	 *  Test if a file can be written to or not
	 */
	function TestFileWriteability($folderPath, $fileName)
	{
		global $mask;
		global $page;		

		if(file_put_contents($folderPath.$fileName, "Installer: can I write to a file... "))
			return TestResults('success', 'The test-file <b>'.$fileName.'</b> was written too successfully');
		else
		{
			$page->ErrorBox('The Installer is unable to create and write to <b>'.$folderPath.$fileName.'</b>, check your <tt>chmod</tt> '.
							'permissions or contact support to get this issue resolved.');

			return TestResults('failed', 'Unable to create the test-file <b>'.$fileName.'</b>');
		}
	}

	/** 
	 *  Test if a file can be deleted or not
	 */
	function TestFileDeletion($folderPath, $fileName)
	{
		if(unlink($folderPath.$fileName))
			return TestResults('success', 'The test-file <b>'.$fileName.'</b> has been removed');
		else
		{			
			$page->ErrorBox('The Installer is unable to delete <b>'.$folderPath.$fileName.'</b>, check your <tt>chmod</tt> permissions or contact '.
							'support to get this issue resolved.');

			return TestResults('failed', 'Unable to delete the test-file <b>'.$fileName.'</b>');
		}
	}


	/**
	 *  Get test results in custom array
	 */
	function TestResults($state, $msg)
	{
		return array(
				'state' => $state,
				'msg'   => $msg);
	}


	/* =========================[ FINAL CONFIG FUNCTIONS ]========================= */

	/** 
	 *  Combine the final output path and the config filename. This is important
	 *  method because if broken - the installer will not function
	 */
	function FixPath($configSavePath='')
	{
		// Do not check slashes if value is empty
		$configSavePath = trim($configSavePath);
		if(strlen($configSavePath) == 0)
			return '';

		// If for some reason the Php does not support both types of slashes,
		// this small clean-up script is to fix all slashes such that they
		// are all facing the same way - and the same way as DIRECTORY_SEPARATOR,
		// and if there are two slashes together, replace them with a single one
		$slashes = array("\\","/","\\\\","//");
		foreach($slashes as $slash)
			$configSavePath = str_replace($slash, DIRECTORY_SEPARATOR, $configSavePath);

		// If the 'savetofolder' does not end with a slash, add it!
		if(substr($configSavePath, -1, 1) != DIRECTORY_SEPARATOR)
			$configSavePath .= DIRECTORY_SEPARATOR;

		return $configSavePath;
	}
	
	/** 
	 *  Does the final output config file exist or not. If in $steps, the setting 
	 *  'updateonzero' is enabled - this method will check if the config has 
	 *  zero bytes or not as well.
	 */
	function IsInstallerDone()
	{
		global $steps;

		$isDone = true;

		foreach($steps[STEP_WRITECONFIG]['configs'] as $file)
		{
			$savepath = FixPath($file['savetofolder']);

			// Directory exists - check the output config file
			if(is_dir($savepath) || strlen($savepath) == 0)
			{
				// Update savepath to include the filename and get 
				// "onzero" setting to variable for simpler code
				$savepath = $savepath.$file['maskname'];
				$updateOnZero = $steps[STEP_WRITECONFIG]['updateonzero'];				
			
				// The config does not exist, check next config or continue with installing
				if(!is_file($savepath))
				{
					$isDone = false;
					break;
				}
				
				// If the config does exists, and file should NOT be
				// updated if it contains zero bytes - we are done!
				else if(is_file($savepath) && !$updateOnZero)
					continue;

				// The output config file does exist, but we only continue
				// if the file does only contain zero bytes
				else
				{
					$bytes = filesize($savepath);
					if ($bytes == 0)
					{
						$isDone = false;
						break;
					}
					else 
						continue;
				}
			}
			else
			{
				$isDone = false;
				break;
			}
		}

		return $isDone;
	}

	/**
	 *  Delete the final output config and return a boolean
	 *  notifing if it was successful or not
	 */
	function DeleteFinalOutputConfig()
	{
		global $steps;

		// Get the name of final output name and path folder
		$folder = FixPath($steps[STEP_WRITECONFIG]['savetofolder']);
		$file = trim($steps[STEP_WRITECONFIG]['maskname']);

		// If deletion was successful
		if(is_file($folder.$file) && unlink($folder.$file))
			 return true;
		else return false;
	}


	/* =========================[ VERSION AND EXTENSIONS ]========================= */

	/**
	 *  Is some extensions loaded or not
	 */
	function IsExtensionInstalled($moduleName)
	{
		// The faster "less-reliable" alternative which is not used because
		// a module (or extension) names could be in different casing, so
		// 'Mysql' should be approved even though only 'mysql' is loaded		
		## return extension_loaded($moduleName);

		// Set the module name to lower case and get all loaded extensions 
		$moduleName = strtolower($moduleName);
		$extensions = get_loaded_extensions();
		foreach($extensions as $ext)
		{
			if($moduleName == strtolower($ext))
				return true;
		}

		return false;
	}

	/**
	 *  Convert version string to parts array
	 */
	function VersionStringToArray($anyVersion, $paddedValue='x')
	{
		$anyVersion = str_replace('x', $paddedValue, $anyVersion);
		$parts = explode('.', $anyVersion);
		while(count($parts) < 3)
			$parts[] = $paddedValue;
		return $parts;
	}

	/**
	 *  Get version bounds from two version strings, that can be on the
	 *  format '5', '5.2', '5.x.x' even be 'false'
	 */
	function GetVersionBounds($minimumVersion, $maximumVersion)
	{
		$current = VersionStringToArray(phpversion()); # PHP ALWAYS HAS FULL VERSION STRING!!
		$minimum = VersionStringToArray($minimumVersion, '0');

		// Any higher version is accepted!
		if($maximumVersion === false)
		{
			return array(
				'current' => $current,
				'lower' => $minimum,
				'upper' => VersionStringToArray('99.99.99'));
		}

		// If max version is defined - check within range
		else if($maximumVersion !== false)
		{
			return array(
				'current' => $current,
				'lower' => $minimum,
				'upper' => VersionStringToArray($maximumVersion, '99'));
		}

		// Only validate the defined minimum version string (which can NEVER
		// occur because the first if catches FALSE, and the other if catches
		// ANY other state - so this is kept here for future versions if needed
		else 
		{
			// Create upper bounds from the required version, such that
			// any undefined values will be maximum
			return array(
				'current' => $current,
				'lower' => $minimum,
				'upper' => VersionStringToArray($minversion, '99'));
		}
	}

	/**
	 *  Check if version is within bounds of lower and upper, in mathematical
	 *  sens it would be:  $lowerBound <= $currentVersion < $upperBound
	 */
	function VersionInBounds($currentVersion, $lowerBound, $upperBound)
	{
		$CurLow = CompareVersons($currentVersion, $lowerBound);
		$CurHig = CompareVersons($currentVersion, $upperBound);

		// If current version is equal or higher than lower bound
		// and is below the upper bound - then accepted!
		if ($CurLow >= 0 && $CurHig < 0)
			 return true;
		else return false;
	}
	
	/** 
	 *  Compare two versions and get which is higher
	 *  returns are:  A<B : -1, A=B : 0, A>B : 1
	 */
	function CompareVersons($versionA, $versionB)
	{
		if($versionA[0] < $versionB[0]) 
			return -1;
		else if($versionA[0] == $versionB[0])
		{
			if($versionA[1] < $versionB[1]) 
				return -1;
			else if($versionA[1] == $versionB[1])
			{
				if($versionA[2] < $versionB[2]) 
					return -1;
				else if($versionA[2] == $versionB[2])
					return 0;
				else if($versionA[2] > $versionB[2])
					return 1;
			}
			else if($versionA[1] > $versionB[1])
				return 1;
		}
		else if($versionA[0] > $versionB[0])
			return 1;
	}


	/* =========================[ MISC FUNCTIONS ]========================= */

	/** 
	 *  Does the given input only contain numeric digits from 0 to 9  
	 */
	function IsNumericOnly($input)
	{
		/*  NOTE: The PHP function "is_numeric()" evaluates "1e4" to true
		 *        and "is_int()" only evaluates actual integers, not 
		 *        numeric strings. */

		return preg_match("/^[0-9]*$/", $input);
	}

	function GetAsRed($string, $inBold=false)
	{
		return GetAsColor($string, 'FF0000', $inBold);
	}

	function GetAsGreen($string, $inBold=false)
	{
		return GetAsColor($string, '279B00', $inBold);
	}

	function GetAsBlue($string, $inBold=false)
	{
		return GetAsColor($string, '0000FF', $inBold);
	}

	function GetAsOrange($string, $inBold=false)
	{
		return GetAsColor($string, 'FF9933', $inBold);
	}

	function GetAsColor($string, $colorHex, $inBold)
	{
		$string = ($string === false || $string === 0) ? '0' : $string;
		if($inBold) $string = '<b>'.$string.'</b>';
		return '<span style="color:#'.$colorHex.'">'.$string.'</span>';
	}