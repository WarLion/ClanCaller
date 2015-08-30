<?php if(!defined('INST_BASEDIR')) die('Installer cannot be started directly!');

    /* ====================================================================
    *
    *                             PHP Setup Wizard
	*
    *                             -= INSTALLER =-
    *
    *  ================================================================= */   

    // Load installer configuration and file handling class
    include('configuration.php');
	require('assets'.DIRECTORY_SEPARATOR.'helper.functions.php');
            
    // If the output config exists and installer should be ignored 
    if(IsInstallerDone() && $config['ignore_installer_when_done'])
    {
        // Bye bye! :)
        unset($config);
        unset($keywords);
		unset($steps);
    }
    
    // If the installer WILL display something
    else
    {
		session_start();

		// Turns of PHP error messages - or embraze them
		if($config['show_php_error_messages'])
			 error_reporting(E_ALL);
		else error_reporting(0);
        
        // Include and create instanses of the other classes
		include('assets'.DIRECTORY_SEPARATOR.'class.masks.php');
        require('assets'.DIRECTORY_SEPARATOR.'class.htmlmaker.php');        
        require('assets'.DIRECTORY_SEPARATOR.'class.databases.php');
        $page = new Inst_HtmlMaker();
        $mask = new Inst_Masks();
        $dbase = new Inst_Databases();
        
        // Load session helper, which handles all POST and GET, and stores 
		// changes automatically to sessions, encrypts and decrypts etc.
        require('assets'.DIRECTORY_SEPARATOR.'helper.sessions.php');

		// Add to page maker that some data has to be shown on the top of the page
		if($config['debug_sessions']) $page->AddToDebug('Sessions:', $_SESSION[$config['session_prefix']]);
		if($config['debug_posts']) $page->AddToDebug('POST data:', $_POST);
		if($config['debug_gets']) $page->AddToDebug('GET data:', $_GET);
        
        // Update the mask class with updated keywords (with login, database etc.)
        $mask->SetKeywords();
            
		
        /* ===================================================[ INSTALLATION BEGINS! ]=================================================== */
        
        // If the output config does not exist, or is totally empty
        if(IsInstallerDone() == false)
        {   					

            /* ===================================================[ WELCOME MESSAGE ]=================================================== */
            
            if($steps[STEP_WELCOME]['enabled'] && $step == STEP_WELCOME)
            {
                $page->MainTitle($steps[STEP_WELCOME]['title'], 'home');
                $page->Paragraph( $mask->GetWelcomeMessage() );
                                
                $page->FormStart(array('step'=>GetNextStep(STEP_WELCOME)));

				$prev = GetPrevStep(STEP_WELCOME);
				if($prev) $page->FormButton('Back', array('step'=>$prev));   

                $page->FormSubmit('Next');
                $page->FormClose();
                $page->ShowPage(STEP_WELCOME);  // <<<<<<<<<<<< PHP dies after the page has been shown!
            }


			/* ===================================================[ PHP REQUIREMENTS CHECKS ]=================================================== */

			if($steps[STEP_PHPREQUIRES]['enabled'])
			{
				$page->MainTitle($steps[STEP_PHPREQUIRES]['title'], 'phplogo');

				// Three variations of PHP checks, these will
				// indicate if there is a problem in certain part
				$phpversion = true;
				$extensions = true;
				$directives = true;

				// If minimum PHP version is required
				if($steps[STEP_PHPREQUIRES]['phpversion'] !== false)
				{
					$page->SubTitle('PHP Version', 'notepad');

					$bounds = GetVersionBounds($steps[STEP_PHPREQUIRES]['phpversion'], $steps[STEP_PHPREQUIRES]['maxversion']);
					$CurLow = CompareVersons($bounds['current'], $bounds['lower']);
					$CurHig = CompareVersons($bounds['current'], $bounds['upper']);

					// Start the version table
					$page->StartTable(4, array('class'=>'dbtests', 'cellspacing'=>'0', 'cellpadding'=>'0'));

					// Display the requirements
					$page->AddTableData('', array('class'=>'currentico'));
					$page->AddTableData('Required:', array('style'=>'padding-right:15px;'));

					// If range is defined or not
					if($steps[STEP_PHPREQUIRES]['maxversion'] === false)
						 $str = '&nbsp;&nbsp;or later';
					else $str = '&nbsp;&nbsp;-&nbsp;&nbsp;'.implode('.', VersionStringToArray($steps[STEP_PHPREQUIRES]['maxversion']));
					$page->AddTableData(implode('.', $bounds['lower']).$str, array('style'=>'padding-right:15px;'));
					$page->AddTableData('');

					// If current version is equal or higher than lower bound
					// and is below the upper bound - then accepted!
					if ($CurLow >= 0 && $CurHig < 0)
					{
						$page->AddTableData('', array('class'=>'okayico'));
						$page->AddTableData('You have:');
						$page->AddTableData(phpversion(), array('style'=>'text-align:center;'));
						$page->AddTableData('Supported!', array('class'=>'okay'));
					}
					else
					{
						$phpversion = false;
						if($CurLow < 0)
							 $str = 'Below required version!';
						else if($CurHig >= 0)
							 $str = 'Above required version!';
						else $str = 'Not supported!';

						$page->AddTableData('', array('class'=>'failico'));
						$page->AddTableData('You have:');
						$page->AddTableData(phpversion(), array('style'=>'text-align:center;'));
						$page->AddTableData($str, array('class'=>'fail'));
					}
					$page->EndTable();

				} // End Version check

				// If any PHP extensions are required
				if(count($steps[STEP_PHPREQUIRES]['extensions']) > 0)
				{
					$page->SubTitle('PHP Extensions', 'extensions');
					$page->StartTable(3, array('class'=>'dbtests', 'cellspacing'=>'0', 'cellpadding'=>'0'));
					foreach($steps[STEP_PHPREQUIRES]['extensions'] as $extKey=>$extTitle)
					{
						if(IsExtensionInstalled($extKey))
						{
							$page->AddTableData('', array('class'=>'okayico'));
							$page->AddTableData('<strong title="'.$extKey.'">'.$extTitle.'</strong>', array('style'=>'padding-right:15px;'));					
							$page->AddTableData('Installed!', array('class'=>'okay'));
						}
						else
						{
							$extensions= false;
							$page->AddTableData('', array('class'=>'failico'));							
							$page->AddTableData('<strong title="'.$extKey.'">'.$extTitle.'</strong>', array('style'=>'padding-right:15px;'));
							$page->AddTableData('Not Installed!', array('class'=>'fail'));
						}
					}
					$page->EndTable();

				} // End extensions checks
			
				// If PHP directives should be checked
				if($steps[STEP_PHPREQUIRES]['directives'] && count($php_directives) > 0)
				{
					$page->SubTitle('PHP Directives', 'settings2');
					$page->StartTable(4, array('class'=>'dbtests'));
					$page->AddTableData('', array(), array('style'=>'color:#838383;'));
					$page->AddTableData('Directive Title');
					$page->AddTableData('Required', array('style'=>'padding:0 9px 0 9px;'));
					$page->AddTableData('Current', array('style'=>'padding:0 9px 0 9px;'));		

					foreach($php_directives as $idx=>$directive)
					{
						// Prepair variables
						$current = $directive['value'];
						$required = '';
						$icon = 'okayico';

						// If this directive must be equal to something, works
						// with booleans, strings and numeric values
						if(isset($directive['mustbe']))
						{
							$required = $directive['mustbe']; 
							if($required == 'On' || $required == 'Off')
							{
								// Requirements are met
								if($current == '1' && $required == 'On')
									$current = GetAsGreen('On', true);
								else if($current != '1' && $required == 'Off')
									$current = GetAsGreen('Off', true);

								// Current switch is not correct
								else if($current == '1')
								{
									$current = GetAsRed('On', true);
									$icon = 'failico';
									$directives = false;
								}
								else 
								{
									$current = GetAsRed('Off', true);
									$icon = 'failico';
									$directives = false;
								}
							}

							// Any other value MUST be equal!
							else if($current == $required)
								$current = GetAsGreen($current, true);
							else
							{
								$current = GetAsRed($current, true);
								$icon = 'failico';
								$directives = false;
							}
						}

						// or Higher/Lower only works with numeric values
						else if(isset($directive['orhigher']) || isset($directive['orlower']))
						{
							$current = ($current === '') ? 0 : $current;
							$required = (isset($directive['orhigher'])) ? $directive['orhigher'] : $directive['orlower'];
							$reqInt = $required;
							$curInt = $current;
							settype($reqInt, 'integer');
							settype($curInt, 'integer');

							if(isset($directive['orhigher']))
							{
								$required = $required.' <span style="font-size:11px; color:#838383;">or more</span>';
								if($curInt >= $reqInt)
									$current = GetAsGreen($current, true);
								else 
								{
									$current = GetAsRed($current, true);
									$icon = 'failico';
									$directives = false;
								}
							}
							else if(isset($directive['orlower']))
							{
								$required = $required.' <span style="font-size:11px; color:#838383;">or less</span>';
								if($curInt <= $reqInt)
									$current = GetAsGreen($current, true);
								else
								{
									$current = GetAsRed($current, true);
									$icon = 'failico';
									$directives = false;
								}
							}
						}
				
						$page->AddTableData('', array('class'=>$icon));
						$page->AddTableData('<strong title="'.$directive['inikey'].'">'.$directive['title'].'</strong>', 
							array('style'=>'padding-right:12px;'));
						$page->AddTableData('<tt>'.$required.'</tt>', array('style'=>'text-align:center;'));
						$page->AddTableData('<tt>'.$current.'</tt>', array('style'=>'text-align:center;'));			
					}
					$page->EndTable();

				} // End directives check


				// If everything is approved - user can continue
				if($phpversion && $extensions && $directives)
				{
					$page->FormStart(array('step'=>GetNextStep(STEP_PHPREQUIRES))); 
					$prev = GetPrevStep(STEP_PHPREQUIRES);
					if($prev) $page->FormButton('Back', array('step'=>$prev));  
					$page->FormSubmit('Next');
					$page->FormClose();
				}

				// There where some errors or problems with the 
				// file IO - show "retry" button
				else
				{
					$page->Paragraph('Contact your webserver support (hosting service) to get the necessary PHP settings fixed.');

					$page->FormStart(array('step'=>STEP_PHPREQUIRES));  
					$prev = GetPrevStep(STEP_PHPREQUIRES);
					if($prev) $page->FormButton('Back', array('step'=>$prev));  
					$page->FormSubmit('Retry');
					$page->FormClose();
				}

				// If there are some modules not detected, or this step should not be
				// auto skipped and $step is currently set to view this step  
				if(!($phpversion && $extensions && $directives) || (!$steps[STEP_PHPREQUIRES]['ishidden'] && $step == STEP_PHPREQUIRES))
					$page->ShowPage(STEP_PHPREQUIRES);

				// Page should not be shown, so the html queue is cleared
				// so the next step can start fresh
				else
					$page->ClearHtmlQueue();
			}

			/* ===================================================[ FILE I/O PERMISSIONS ]=================================================== */

			// Only continue if IO should be checked. The installer might
			// be configured to only install sql tables (though unlikely)
			if($steps[STEP_IOFILES]['enabled'])
			{
				$ioable = true;	
				$results = array();
				$idx = 0;

				// Begin the page 
				$page->MainTitle($steps[STEP_IOFILES]['title'], 'filelocked'); 

				// Get all configs and see if they can be written to file, 
				// and if their folders can be created and are writeable
				$maskfiles = $steps[STEP_WRITECONFIG]['configs'];
				foreach($maskfiles as $conf)
				{
					// Configure the new folder value if set to fit the webserver. For instance "fld1/fld2" should be "fld1\fld2" 
					// on the server so this method will convert slashes to make it right
					$folderPath = FixPath($conf['savetofolder']);

					$results[$idx]['folder'] = TestFolderWriteability($folderPath);
					$results[$idx]['read']   = TestFileReadability($conf['maskname']);

					// Do not try to write or delete file if the folder failed
					if ($results[$idx]['read']['state'] == 'success' && 
						($results[$idx]['folder']['state'] == 'success' || $results[$idx]['folder']['state'] == 'ignored'))
					{
						$results[$idx]['write']  = TestFileWriteability($folderPath, $conf['maskname']);

						// Also do not try to delete a file if it cannot be written to
						if ($results[$idx]['write']['state'] != 'failed')
							$results[$idx]['delete'] = TestFileDeletion($folderPath, $conf['maskname']);
						else
							$results[$idx]['delete'] = TestResults('ignored', 'Unable to perform this test due to previous failures');
					}
					else
					{
						$results[$idx]['write']  = TestResults('ignored', 'Unable to perform this test due to previous failures');
						$results[$idx]['delete'] = TestResults('ignored', 'Unable to perform this test due to previous failures');
					}					

					// If any test failed, do not continue
					if ($results[$idx]['folder']['state'] == 'failed' || 
						$results[$idx]['read']['state']   == 'failed' || 
						$results[$idx]['write']['state']  == 'failed' || 
						$results[$idx]['delete']['state'] == 'failed')
					{
						$ioable = false;
					}

					$idx++;
				}

				if($ioable)
					$page->SuccessBox('The Installer has sufficient file permissions on this server.');		
				else
					$page->InfoBox('All tests have to be successful inorder to continue');

				// THIS TABLE USES THE SAME TABLE-CSS AS "USER ACCESS TEST" STEP!
				$page->StartTable(4, array('class'=>'dbtests', 'cellspacing'=>'0', 'cellpadding'=>'0'));
				foreach($results as $testTypes)
				{
					foreach($testTypes as $test=>$result)
					{
						if($result['state'] == 'success')
						{
							$page->AddTableData('', array('class'=>'okayico'));
							$page->AddTableData($test, array('class'=>'operation'));
							$page->AddTableData('Success!', array('class'=>'okay'));
							$page->AddTableData($result['msg'], array('class'=>'normalmsg'));
						}
						else if($result['state'] == 'failed')
						{
							$page->AddTableData('', array('class'=>'failico'));
							$page->AddTableData($test, array('class'=>'operation'));
							$page->AddTableData('Failed!', array('class'=>'fail'));
							$page->AddTableData($result['msg'], array('class'=>'errormsg'));
						}
						else if($result['state'] == 'exists')
						{
							$page->AddTableData('', array('class'=>'existico'));
							$page->AddTableData($test, array('class'=>'operation'));
							$page->AddTableData('Exists', array('class'=>'exist'));
							$page->AddTableData($result['msg'], array('class'=>'normalmsg'));
						}
						else 
						{
							$page->AddTableData('', array('class'=>'unknownico'));
							$page->AddTableData($test, array('class'=>'operation'));
							$page->AddTableData('Not tested', array('class'=>'unknown'));
							$page->AddTableData($result['msg'], array('class'=>'unknownmsg'));
						}
					}
				}
				$page->EndTable();

				// If all test where successful (or not tested)
				// then show "next" button
				if($ioable)
				{
					$page->FormStart(array('step'=>GetNextStep(STEP_IOFILES)));

					$prev = GetPrevStep(STEP_IOFILES);
					if($prev) $page->FormButton('Back', array('step'=>$prev));   

					$page->FormSubmit('Next');
					$page->FormClose();
				}

				// There where some errors or problems with the 
				// file IO - show "retry" button
				else
				{
					$page->FormStart(array('step'=>STEP_IOFILES));

					$prev = GetPrevStep(STEP_IOFILES);
					if($prev) $page->FormButton('Back', array('step'=>$prev));   
 
					$page->FormSubmit('Retry');
					$page->FormClose();
				}


				// If there are some IO conficts, or this step should not be
				// auto skipped and $step is currently set to view this step  
				if(!$ioable || (!$steps[STEP_IOFILES]['ishidden'] && $step == STEP_IOFILES))
					$page->ShowPage(STEP_IOFILES);

				// Page should not be shown, so the html queue is cleared
				// so the next step can start fresh
				else
					$page->ClearHtmlQueue();
				
			}
            
            
            /* ===================================================[ TERMS OF AGREEMENT ]=================================================== */
            
            if($steps[STEP_TERMSOFUSE]['enabled'] && (!$LICENSE_APPROVED || $step == STEP_TERMSOFUSE)) 
            {
                $page->MainTitle($steps[STEP_TERMSOFUSE]['title'], 'agreement');                
                
                // Notify the user that he must approve the terms of agreement, and if he
                // has - notfify him that he has done so and make the box "checked" so user
                // can simply press "next to continue"
                $checked = array();
                if($LICENSE_APPROVED)
                {
                    $page->SuccessBox('You have approved the terms of use agreement!');
                    $checked = array('checked');
                }
                else if($step != STEP_TERMSOFUSE)
                {
                    $page->InfoBox('You must approve the terms of use agreement if you want to continue!');
                }
                
                $page->Textarea( $mask->GetTermsOfAgreement() );
                $page->FormStart(array('step'=>GetNextStep(STEP_TERMSOFUSE)));
                $page->FormRadiobox('approved', 'agreement', 'I <b>accept</b> this terms of use', $checked);
                $page->FormRadiobox('denied', 'agreement', 'I <b>do not accept</b> this terms of use');
                
				$prev = GetPrevStep(STEP_TERMSOFUSE);
				if($prev) $page->FormButton('Back', array('step'=>$prev));   
                        
                $page->FormSubmit('Next');
                $page->FormClose();
                $page->ShowPage(STEP_TERMSOFUSE);
            }		


			/* ===================================================[ SERIAL KEY CONFIRMATION ]=================================================== */

			// Check if user has either selected trial or provided accepted serial
			$showSerialForm = false;
			$showSerialForm = (!$steps[STEP_SERIALKEY]['allowtrial'] && !$keywords['serial']['isMatch']) ? true : $showSerialForm;
			$showSerialForm = ($steps[STEP_SERIALKEY]['allowtrial'] && !$keywords['serial']['isMatch'] && !$keywords['serial']['isTrial']) ? true : $showSerialForm;
            
			// Only show form if step is enabled, and above checks are "false" or user wants to preview the step again (clicked back)
            if($steps[STEP_SERIALKEY]['enabled'] && ($showSerialForm || $step == STEP_SERIALKEY)) 
            {
                $page->MainTitle($steps[STEP_SERIALKEY]['title'], 'keys');                
                
                // Notify the user if he has entered valid serial or not
                if($keywords['serial']['isMatch'])
                    $page->SuccessBox('Your serial key is accepted and you can continue.');
                else if($step != STEP_SERIALKEY)
                    $page->InfoBox('You must enter valid serial key to be able to continue installation!');

				// Display required serial input part of the form
				$page->Paragraph('Please enter purchased serial key for <strong>'.$keywords['special']['product'].' '.
					             $keywords['special']['version'].'</strong> below.');

				$page->Label('Serial key:');
				$page->FormStart(array('step'=>GetNextStep(STEP_SERIALKEY)));
				$page->FormInput($keywords['serial']['keyvalue'], 'keyvalue');

				$prev = GetPrevStep(STEP_SERIALKEY);
				if($prev) $page->FormButton('Back', array('step'=>$prev));   
                        
                $page->FormSubmit('Next');
                $page->FormClose();

				// If "Trial" option is enabled, show more info and place button
				if($steps[STEP_SERIALKEY]['allowtrial'])
				{
					$page->SubTitle('Want to try it out first?', 'trial');
					$page->FormStart(array('step'=>GetNextStep(STEP_SERIALKEY), 'isTrial'=>'selected'));

					if($steps[STEP_SERIALKEY]['allowtrial'] && $keywords['serial']['isTrial'])
						$page->SuccessBox('You have selected <strong>Free trial</strong>, click Trial button again to continue.');

					$page->Paragraph('You can enjoy the full version for <strong>'.$keywords['serial']['trialtime'].
									 '</strong> days until it stops working and you have to purchase a serial. Do you '.
									 'want to try it out first?');

					$page->FormSubmit('Try it out for '.$keywords['serial']['trialtime'].' days');
					$page->FormClose();
				}
				
                
				
                $page->ShowPage(STEP_SERIALKEY);
			}


			/* ===================================================[ LANGUAGE SELECTION ]=================================================== */

			// If the language step is enabled and active, show "select language" form
			if($steps[STEP_LANGUAGE]['enabled'] && count($steps[STEP_LANGUAGE]['supported']) > 0 && $step == STEP_LANGUAGE)
			{
				$page->MainTitle($steps[STEP_LANGUAGE]['title'], 'language');
				$page->Paragraph('Select one of the following supported languages:');

				// Begin the language selection
				$page->FormStart(array('step'=>GetNextStep(STEP_LANGUAGE)));
				foreach($steps[STEP_LANGUAGE]['supported'] as $langCode=>$langName)
				{
					// If this language is the "default" one or the user
					// has selected this language before
					if($langCode == $steps[STEP_LANGUAGE]['default'])
						 $checked = array('checked');
					else $checked = array();

					// Get a flag icon to go with the name
					$flag = $page->GetFlagHtml($langCode);
					$page->FormRadiobox($langCode, 'language', '&nbsp;'.$flag.'&nbsp;'.$langName, $checked);
				}

				$prev = GetPrevStep(STEP_LANGUAGE);
				if($prev) $page->FormButton('Back', array('step'=>$prev));   
                                     
                $page->FormSubmit('Next');
                $page->FormClose();
				$page->ShowPage(STEP_LANGUAGE);
			}
            

			/* ===================================================[ TMEZONE SELECTION ]=================================================== */

			/*
			*  The TimeZone step can check the selected language (if enabled)
			*  to see what TimeZone to select automatically
			*/
	
			// If the timezone step is enabled and active, show "select timezone" form
			if($steps[STEP_TIMEZONE]['enabled'] && $step == STEP_TIMEZONE)
			{
				$page->MainTitle($steps[STEP_TIMEZONE]['title'], 'timezone');

				$page->Paragraph('Assuming that you have a "timezone" feature in your system already, you might '.
					             'want to design this step yourself to make it fit correctly with your system.');

				$page->FormStart(array('step'=>GetNextStep(STEP_TIMEZONE)));
				$page->Label('Select timezone:');
				$page->AddTimezoneDropdown('timezone', $keywords['special']['timezone']);

				$prev = GetPrevStep(STEP_TIMEZONE);
				if($prev) $page->FormButton('Back', array('step'=>$prev));   
                   
                $page->FormSubmit('Next');
                $page->FormClose();
				$page->ShowPage(STEP_TIMEZONE);
			}
			
			
			/* ===================================================[ ADDITIONAL INFORMATION ]=================================================== */

			// If the additional information step is enabled and active, show custom form
			if($steps[STEP_ADDEDINFO]['enabled'])
			{
				$hasErrors = false;

				$page->MainTitle($steps[STEP_ADDEDINFO]['title'], 'userinfo');

				// Begin form that tells the session helper that this form should
				// be processed for the additional step
				$page->FormStart(array('step'=>GetNextStep(STEP_ADDEDINFO)));
				$page->FormHidden('save_to_sessions', STEP_ADDEDINFO);

				// Here will either be Info box or Success box depending on how all the following
				// checks will go. So, add an empty entry, save the index and replace the index
				// later with either one
				$page->AddToQueue('');
				$msgBoxIndex = $page->GetQueueIndex();		

				// Construct a form based on the setup in $steps
				foreach($steps[STEP_ADDEDINFO]['form'] as $data)
				{
					// Determine the controls data and key 
					$key = '';
					$value = '';
					if(isset($data['type']))
						 $key = $data['type'];					
					else $key = '?';

					// Create different controls based on the key
					switch($key)
					{
						case 'checkbox':
							if(HasAnyAdditionalStepValueBeenPostedYet())
								 $checked = (GetAdditionalControlValue($data['keyword'], $data['value_off']) == $data['value_on']) ? array('checked') : array();
							else $checked = (isset($data['checked']) && $data['checked'] === true) ? array('checked') : array();
							$page->FormCheckbox($data['value_on'], $data['keyword'], $mask->ReplaceKeywords($data['text']), $checked);
							break;
						case 'radiobox':
							if(HasAnyAdditionalStepValueBeenPostedYet())
								 $checked = (GetAdditionalControlValue($data['keyword'], '') == $data['value']) ? array('checked') : array();
							else $checked = (isset($data['checked']) && $data['checked'] === true) ? array('checked') : array();
							$page->FormRadiobox($data['value'], $data['keyword'], $mask->ReplaceKeywords($data['text']), $checked);
							break;

						case 'textbox':
							$value = GetAdditionalControlValue($data['keyword'], $data['value']);		
							$value = ($value === false) ? $data['value'] : $value;
							$hasErrors = (HasTextInputErrors($data, $value) || $hasErrors) ? true : false;							
							$page->FormInput($value, $data['keyword']);
							break;
						case 'textarea':
							$value = GetAdditionalControlValue($data['keyword'], $data['value']);		
							$value = ($value === false) ? $data['value'] : $value;
							$hasErrors = (HasTextInputErrors($data, $value) || $hasErrors) ? true : false;
							$page->FormTextarea($value, $data['keyword']);
							break;

						case 'label':
							$page->Label($mask->ReplaceKeywords($data['text']));
							break;
						case 'paragraph':
							$page->Paragraph($mask->ReplaceKeywords($data['text']));
							break;
						case 'space':
							$page->Paragraph('&nbsp;');
							break;
						default: 
							if(isset($data['text']))
								 $page->Paragraph($mask->ReplaceKeywords($data['text']));
							else $page->Paragraph('&nbsp;');
							break;
					}
				}

				// If current step, or some inputs are invalid, or no data has yet been displayed - prompt the step
				if($step == STEP_ADDEDINFO || $hasErrors || !HasAnyAdditionalStepValueBeenPostedYet())
				{
					// Do not show any info or success if this is "first show"
					if(HasAnyAdditionalStepValueBeenPostedYet())
					{
						// Determine the box to show
						if($hasErrors)
							 $page->InfoBox('The form has not been properly filled out!'); 						
						else $page->SuccessBox('Inputs are accepted, please continue to the next step');

						// Pop it out of the queue and insert at top
						$page->UpdateQueueAtIndex($msgBoxIndex, $page->PopQueue());
					}

					// Close the form and offer next and previous like in any other steps
					$prev = GetPrevStep(STEP_ADDEDINFO);
					if($prev) $page->FormButton('Back', array('step'=>$prev));   
					   
					$page->FormSubmit('Next');
					$page->FormClose();
					$page->ShowPage(STEP_ADDEDINFO);
				}
				else
					$page->ClearHtmlQueue();
			}

			
			/* ===================================================[ DATABASE CONNECTION ]=================================================== */

			if($steps[STEP_DBCONNECT]['enabled'])
			{			
				// Try to connect to database
				$login = $keywords['connection'];
				$dbase->Connect($login);

				// Clear the plain-text password if encryption is enabled
				if($steps[STEP_DBCONNECT]['encryptlogin'])
					$login['password'] = '';
			   
				// If connection cannot be made, force show "connection" step! 
				if(!$dbase->IsConnected() || $step == STEP_DBCONNECT)
				{
					$page->MainTitle($steps[STEP_DBCONNECT]['title'], 'connection');
					
					// If the step is not STEP_DBCONNECT, then the installer was going 
					// somewhere else - so error message should be displayed
					if($step != STEP_DBCONNECT)
					{
						$page->WarningBox('Unable to establish a connection to <b>'.$login['hostname'].'</b>. '.
										  'Please fill in <i>hostname</i>, <i>username</i> and <i>password</i>.'); 
						
						if($config['show_database_error_messages'])
							$page->ErrorDatabaseBox($dbase->GetDatabaseError());
					}
					
					// If how ever the step IS set to 1 and the connection to database has been 
					// successful, let user know he does not have to set the values again or change them
					else if($step == STEP_DBCONNECT && $dbase->IsConnected())
					{
						$page->SuccessBox('Connection to database server is successful with login '. 
							'provided. Proceed to the next step');
					} 
					
					// If the port is optional and the port value contains 
					// non-digits then display warning message
					if($steps[STEP_DBCONNECT]['portoptional'] && !$dbase->IsConnected()
						&& strlen($login['dbport']) > 0 && !IsNumericOnly($login['dbport']))
					{
						$page->WarningBox('The port value <b>'.$login['dbport'].'</b> is not a valid numeric value'); 
					}

					// If the password is encrypted and connection has been made successfully - then pressing NEXT
					// in the 'else' clause below would send an empty string and reset the password to nothing. So,
					// either force the user to type in the password every time he visists this step (which sucks)
					// or just show success message and offer a "disconnect" button instead. Then the only info posted
					// on the "next" button here will be the step key
					if($steps[STEP_DBCONNECT]['encryptlogin'] && $dbase->IsConnected())
					{
						$page->FormStart(array('step'=>GetNextStep(STEP_DBCONNECT)));
						$prev = GetPrevStep(STEP_DBCONNECT);
						if($prev) $page->FormButton('Back', array('step'=>$prev));    
						$page->FormSubmit('Next');
						$page->FormClose();
						
						$page->SubTitle('Disconnect', 'disconnect');
						$page->Paragraph('The <i>username</i> and <i>password</i> provided to connect to <b>'.$login['hostname'].
										 '</b> are encrypted during the rest of this process. However, you can disconnect '.
										 'from current connection and enter new username and password if needed.');

						$page->FormStart(array('step'=>STEP_DBCONNECT, 'reset'=>'connection'));
						$page->FormSubmit('Disconnect');
						$page->FormClose();						
					}

					// Only shown when not connected to database server
					else
					{                    
						$page->FormStart(array('step'=>GetNextStep(STEP_DBCONNECT)));

						// If port is offered as option
						if($steps[STEP_DBCONNECT]['portoptional'])
						{
							$page->StartTable(2, array('class'=>'hostport', 'cellpadding'=>'0', 'cellspacing'=>'0'));

							// Insert the elements in wrong order, then when the
							// items are popped they are inserted in right order
							$page->FormInput($login['hostname'], 'hostname', array(), 'bigbox');
							$page->Label('Hostname:');
							$page->AddTableData($page->PopQueue().$page->PopQueue(), array('class'=>'port'));

							$page->FormInput($login['dbport'], 'dbport', array(), 'tinybox');
							$page->Label('Port:');
							$page->AddTableData($page->PopQueue().$page->PopQueue(), array('class'=>'host'));

							$page->EndTable();
						}

						// Display host normally
						else
						{
							$page->Label('Hostname:');
							$page->FormInput($login['hostname'], 'hostname');
						}

						$page->Label('Username:');
						$page->FormInput($login['username'], 'username');
						$page->Label('Password:');

						// Make the field a "password" field if encryption is enabled
						if($steps[STEP_DBCONNECT]['encryptlogin'])
							 $page->FormPassword($login['password'], 'password');
						else $page->FormInput($login['password'], 'password');

						$prev = GetPrevStep(STEP_DBCONNECT);
						if($prev) $page->FormButton('Back', array('step'=>$prev));   
						$page->FormSubmit('Next');
						$page->FormClose();
					}
					
					$page->ShowPage(STEP_DBCONNECT); 
				}
			}
			
			
			/* ===================================================[ DATABASE SELECTION/CREATION ]=================================================== */

			if($steps[STEP_DBSELECT]['enabled'])
			{	
				if(!$dbase->IsConnected())
				{
					$page->MainTitle($steps[STEP_DBSELECT]['title'], 'dbselect');
					$page->WarningBox('Connection has not been made to a database server. The step <a href="?step='.STEP_DBCONNECT.'">'.
									  '<b>'.$steps[STEP_DBCONNECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_DBSELECT);  
				}
				
				// Try to select a database if some value is provided
				if(strlen($login['database']) > 0)
					$dbase->SelectDatabase($login['database']);                
				
				// If unable to select database, force show "database" step!
				if(!$dbase->IsDatabaseSelected() || $step == STEP_DBSELECT)
				{   
					// Get the new database name if posted - or false if not. Then 
					// validate the name and try to insert this new database. Messages
					// are not added to queue right away
					$newdb = false;
					$msg = false;
					if(isset($_REQUEST['createdb']) && $steps[STEP_DBSELECT]['allowcreate'])
					{
						$newdb = trim($_REQUEST['createdb']);
						if(strlen($newdb) == 0)
						{
							$page->InfoBox('Please specify a name for the database');
							$msg[] = $page->PopQueue();
						}
						else if($dbase->DoesDatabaseExist($newdb))
						{
							$page->WarningBox('There exists a database with the name <b>'.$newdb.
								'</b> already, please choose another one.');
							$msg[] = $page->PopQueue();
						}
						else if(!$dbase->IsDatabaseFriendly($newdb))
						{
							$page->WarningBox('The database name <b>'.$newdb.
								'</b> is not valid, please choose another one.');
							$msg[] = $page->PopQueue();
						}
						else if($dbase->CreateNewDatabase($newdb))
						{
							$page->SuccessBox('The database <b>'.$newdb.'</b> has been created successfully!');
							$msg[] = $page->PopQueue();
						}
						else
						{
							$page->ErrorBox('Installer was unable to create the database <b>'.
								$newdb.'</b>, either select database from a list or contact support.');
							$msg[] = $page->PopQueue();
										
							if($config['show_database_error_messages'])
							{
								$page->ErrorDatabaseBox($dbase->GetDatabaseError());
								$msg[] = $page->PopQueue();
							}
						}
					}
					
					// Main title with an icon
					$page->MainTitle($steps[STEP_DBSELECT]['title'], 'dbselect');
					
					// -------------------( Option A: Select database from list )-------------------//
					
					// Do not show success box of selection IF creating new database!
					if($step != STEP_DBSELECT)
					{
						// If the database has a value and could not be selected, then either
						// the database no longer exists (or never did). 
						if(strlen($login['database']) > 0 && !$dbase->IsDatabaseSelected())
							$page->WarningBox('The database <b>'.$login['database'].'</b> cannot be selected');

						else if(!$dbase->IsDatabaseSelected())
							$page->InfoBox('You have to select a database or create a new one in order to continue');
					}
					else
					{
						if($dbase->IsDatabaseSelected())
							$page->SuccessBox('You have selected <b>'.$login['database'].'</b>, choose another '.
										  'database or proceed to the next step.');
					}

					// If the user has installed tables on some database, highlight those
					// databases as "success" to identify the ones the user should select,
					// but also show a success message with the others to show the user that
					// there have been successful installations					
					$successInstall = array();
					$successStr = '';
					foreach(GetDatabaseInstallStatus() as $database=>$status)
					{
						if($status['state'] == 'success')
						{
							$successInstall[] = $database;
						}
					}

					// Display the success databases in more "neat" fashion than
					// adding only commas in between. Make the last item be separated
					// with "and" which a human would do normally
					if(count($successInstall) > 0)
					{
						$str = '';
						if(count($successInstall) == 1)
							$str = '<b>'.$successInstall[0].'</b>';			
						else if(count($successInstall) > 1)
						{
							$serp = ' and ';
							foreach($successInstall as $database)
							{
								$str = $serp.'<b>'.$database.'</b>' . $str;
								$serp = ', ';
							}
							$str = substr($str, strlen($serp));
						}
						$page->SuccessBox('Database setup has been completed successfully on '.$str);
					}			

					// Only allow manual selection
					if($steps[STEP_DBSELECT]['selecttype'] == 'manual')
					{
						// Display some text on what the user is supposed to do
						$page->Paragraph('Enter the name of the database to use with this installation.');
						DatabaseManualBoxForm('Database name:');
					}

					// Show database list, but offer manual box if the list is empty
					else if($steps[STEP_DBSELECT]['selecttype'] == 'dblist' || $steps[STEP_DBSELECT]['selecttype'] == 'both')
					{
						// Get the list of databases (if possible)
						$dblist = $dbase->GetDatabaseList();
						if(count($dblist) > 0)
						{
							// Display some text on what the user is supposed to do
							$both = ($steps[STEP_DBSELECT]['selecttype'] == 'both') ? ', or enter the name manually in the box below' : '';
							$page->Paragraph('Select a database from a list of databases whitin the server '.
										 'you have logged on'.$both.'.');

							$page->Label('Database list:');
							DatabaseSelectionListForm();

							// Only show the manual box if set to 'both'
							if($steps[STEP_DBSELECT]['selecttype'] == 'both')
								DatabaseManualBoxForm('Or enter a database name manually:');
						}

						// There are no detected databases - getting the list of databases might
						// be denied so offer the user to type in the name of the database directly
						else
						{
							$page->Paragraph('Enter the name of the database to use with this installation.');
							$page->Label('Database list:');

							// If database error messages should be displayed
							$error = $dbase->GetDatabaseError();
							if(strlen($error) > 0)
							{						
								if($config['show_database_error_messages'])
								{
									$page->InfoBox('The user <b><tt>'.$login['username'].'</tt></b> is denied access to a list of databases');
									$page->ErrorDatabaseBox($error);
								}
								else
								{
									$page->Quotation('There are no databases available on '.$login['hostname']);
								}
							}
							else
								$page->Quotation('There are no databases available on '.$login['hostname']);
						
							DatabaseManualBoxForm('Enter database name manually:');
						}
					}

					
					// -------------------( Option B: Create new database )-------------------//
					if($steps[STEP_DBSELECT]['allowcreate'])
					{
						$page->Paragraph('&nbsp;');
						$page->MainTitle('Create new database', 'dbnew');
						
						if(is_array($msg))
						{
							foreach($msg as $item)
								$page->AddToQueue($item);
						}
						
						$page->Bookmark('newdb');
						$page->Paragraph('Create new database which the system will be installed on.');
						$page->FormStart(array('step'=>STEP_DBSELECT), array('#'=>'newdb'));
						$page->Label('Database name:');
						$page->FormInput($newdb, 'createdb', array(), 'mediumbox');
						$page->FormSubmit('Create new');
						$page->FormClose();
					}
					$page->ShowPage(STEP_DBSELECT);                    
				} 
			}

			/* ===================================================[ DATABASE ACCESS TESTING ]=================================================== */

			// Only continue with this step if enabled. NOTE: $dbtest is kept
			// outside this 'if' statement because it could be used in 
			// below steps, so this is done to keep the installer stable!
			if($steps[STEP_DBACCESS]['enabled'])
			{
				if(!$dbase->IsConnected())
				{
					$page->MainTitle($steps[STEP_DBACCESS]['title'], 'dbaccess');
					$page->WarningBox('Connection has not been made to a database server. The step <a href="?step='.STEP_DBCONNECT.'">'.
									  '<b>'.$steps[STEP_DBCONNECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_DBACCESS);  
				}				
				if(!$dbase->IsDatabaseSelected())
				{
					$page->MainTitle($steps[STEP_DBACCESS]['title'], 'dbaccess');
					$page->WarningBox('Database has not been selected. The step <a href="?step='.STEP_DBSELECT.'">'.
									  '<b>'.$steps[STEP_DBSELECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_DBACCESS);  
				}

				// Run multiple tests to see if user has the priviledge
				// to create tables and manipulate data
				$dbtest = $dbase->TestUserPrivileges();	

				// If some test failed, or ishidden is false and $step is set to this step
				if(!$dbtest['totalsuccess'] || (!$steps[STEP_DBACCESS]['ishidden'] && $step == STEP_DBACCESS))
				{
					$page->MainTitle($steps[STEP_DBACCESS]['title'], 'dbaccess'); 
					
					// Get the username to single variable
					$username = $keywords['connection']['username'];

					// If all the tests rendered successful, show success
					if($dbtest['totalsuccess'])
					{
						$page->SuccessBox('The user <b>'.$username.'</b> has sufficient database access. Proceed to the next step.');
					}

					// But, if the user was denied some of the commands, display warning
					else if(!$dbtest['totalsuccess'])
					{
						$page->WarningBox('The user <b>'.$username.'</b> must have permission to execute all of below commands '.
										  'in order to continue. Either <a href="?step='.STEP_DBCONNECT.'">try another login</a> '.
										  'or contact the support at your hosting service.');
					}

					
					// Explain litlebit what this is for
					$page->Paragraph('These commands are needed to install database tables, and then insert, update and delete data from those tables.');
					
					// Go through all the tests that where made
					$columnCount = ($config['show_database_error_messages']) ? 4 : 3;
					$page->StartTable($columnCount, array('class'=>'dbtests', 'cellspacing'=>'0', 'cellpadding'=>'0'));
					foreach($dbtest as $operation=>$result)
					{
						if($operation == 'totalsuccess')
							continue;

						if($result['success'])
						{
							$page->AddTableData('', array('class'=>'okayico'));
							$page->AddTableData($operation, array('class'=>'operation'));
							$page->AddTableData('Success!', array('class'=>'okay'));

							if($config['show_database_error_messages'])
								$page->AddTableData();
						}
						else
						{
							$page->AddTableData('', array('class'=>'failico'));
							$page->AddTableData($operation, array('class'=>'operation'));
							$page->AddTableData('Failed!', array('class'=>'fail'));

							if($config['show_database_error_messages'])
								$page->AddTableData($result['error'], array('class'=>'errormsg'));
						}
					}
					$page->EndTable();

					$page->FormStart(array('step'=>GetNextStep(STEP_DBACCESS)));
					$page->FormButton('Back', array('step'=>GetPrevStep(STEP_DBACCESS)));

					if($dbtest['totalsuccess'])
						 $page->FormSubmit('Next');
					else $page->FormSubmit('Retry');

					$page->FormClose();
					$page->ShowPage(STEP_DBACCESS);
				} 
			}
			
			
			/* ===================================================[ SQL TABLE PREFIX ]=================================================== */

			if($steps[STEP_DBPREFIX]['enabled'])
			{
				/*if(!$dbase->IsConnected()) --------- Table prefix does NOT require database connection or selection!!
				{
					$page->MainTitle($steps[STEP_DBPREFIX]['title'], 'prefix');
					$page->WarningBox('Connection has not been made to a database server. The step <a href="?step='.STEP_DBCONNECT.'">'.
									  '<b>'.$steps[STEP_DBCONNECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_DBPREFIX);  
				}				
				if(!$dbase->IsDatabaseSelected())
				{
					$page->MainTitle($steps[STEP_DBPREFIX]['title'], 'prefix');
					$page->WarningBox('Database has not been selected. The step <a href="?step='.STEP_DBSELECT.'">'.
									  '<b>'.$steps[STEP_DBSELECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_DBPREFIX);  
				}*/		
			
				// Get the prefix value to variable
				$prefix = $keywords['connection']['dbprefix'];

				// The prefix checks are too much for one if statement,
				// so the truth value is stored in $validPrefix
				$validPrefix = false;

				// If the prefix is empty, it is only valid if set to optional in config
				// If the prefix has value, it is only valid if it is database friendly
				if(strlen($prefix) == 0)
					$validPrefix = ($steps[STEP_DBPREFIX]['optional']) ? true : false;
				else if(strlen($prefix) > 0)
					$validPrefix = $dbase->IsDatabaseFriendly($prefix);
				
				// The prefix must either contain valid "database friendly" value, or
				// the prefix is set to "optional" in $steps and it is clear
				if($validPrefix == false || $step == STEP_DBPREFIX)
				{
					$page->MainTitle($steps[STEP_DBPREFIX]['title'], 'prefix');
					
					// If installer intended to go somewhere else but was forced to show 
					// this step - the prefix is not valid! If the prefix is empty then
					// the prefix is not optional and MUST have a value
					if($step != STEP_DBPREFIX)
					{
						if(strlen($prefix) == 0)
							$page->WarningBox('Prefix cannot be empty, please enter a table prefix');                            
						else if($dbase->IsDatabaseFriendly($prefix) == false)
							$page->WarningBox('You cannot use <b>'.$prefix.'</b> as prefix value, choose another!');                        
					}
					
					// The user was supposed to go to this step, show success ONLY
					// if prefix is valid - othervice the user is seeing this for
					// the first time and no error should be shown to him!  
					else
					{
						// Prefix is specified and valid, user is jumping between steps
						if(strlen($prefix) > 0 && $dbase->IsDatabaseFriendly($prefix))
						{
							$page->SuccessBox('The prefix <b>'.$prefix.'</b> is accepted. Proceed to the next step.');
						}

						// No prefix is presented, only show notification if prefixes are optional
						else if(strlen($prefix) == 0 && $steps[STEP_DBPREFIX]['optional'])
						{
							$page->Paragraph('The table prefix <b>is optional</b>, but highly recommended. '.
										   'Keep the box empty if you wish not to set a table prefix.');
						}
					}
					
					$page->Paragraph('The prefix is used to prevent collision with other database tables, please enter '.
									 'few characters to uniquely identify your tables from the others.');

					// If a separator will be added at the end of the prefix, notify the user
					if(strlen($steps[STEP_DBPREFIX]['separator']) > 0)
					{
						// If length is 1, then "symbol" - if more than one then "string"
						$word = (strlen($steps[STEP_DBPREFIX]['separator']) == 1) ? 'symbol' : 'string';
						$page->Paragraph('Note that the '.$word.' <b style="color:#FF0000;"><tt>'.$steps[STEP_DBPREFIX]['separator'].
										 '</tt></b> will be added automatically at the end of the prefix. If added manually, '.
										 'it will not be repeated.');
					}
					
					$page->FormStart(array('step'=>GetNextStep(STEP_DBPREFIX)));
					$page->Label('Table prefix:');
					$page->FormInput($prefix, 'dbprefix'); ## <<<<< MUST MATCH THE SPECIAL KEYWORD INDEX TO WORK!!!!
					$page->FormButton('Back', array('step'=>GetPrevStep(STEP_DBPREFIX)));   
					$page->FormSubmit('Next');
					$page->FormClose();
					$page->ShowPage(STEP_DBPREFIX);                     
				}
			}


			/* ===================================================[ INSTALL DATABASE TABLES ]=================================================== */

			if($steps[STEP_RUNSQL]['enabled'])
			{
				if(!$dbase->IsConnected())
				{
					$page->MainTitle($steps[STEP_RUNSQL]['title'], 'sql');
					$page->WarningBox('Connection has not been made to a database server. The step <a href="?step='.STEP_DBCONNECT.'">'.
									  '<b>'.$steps[STEP_DBCONNECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_RUNSQL);  
				}				
				if(!$dbase->IsDatabaseSelected())
				{
					$page->MainTitle($steps[STEP_RUNSQL]['title'], 'sql');
					$page->WarningBox('Database has not been selected. The step <a href="?step='.STEP_DBSELECT.'">'.
									  '<b>'.$steps[STEP_DBSELECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_RUNSQL);  
				}
			
				// If a request has been made to run SQL installation script on the selected database,
				// run the script and set installation status to sessions
				$databaseErrorMessage = '';
				if(isset($_REQUEST['runsql']) && $dbase->GetDatabaseName() == $_REQUEST['runsql'])
				{
					// Get the installation queries and split them by the "next query" separator,
					// and then run each query and get an array of results. If there is no split
					// then the query will be an array with only one cell - still an array :)
					$results = $dbase->RunQuery( $mask->GetSqlInstallQueries(TRUE) );

					// Go through all the results, and every one of them must be 'true'
					// othervice some query failed and installation is incomplete!
					$databaseSuccessCount = 0;
					$databaseFailedCount = 0;
					foreach($results as $result)
					{
						if($result['success'])
							$databaseSuccessCount++;
						else 
						{
							$databaseFailedCount++;
							$databaseErrorMessage .= $result['error']."<br />\n";
						}
					}

					// If some query failed					
					if($databaseFailedCount == 0)
						 $state = 'success';
					else $state = 'failed';
						
					// Save the installation status to sessions, with database name, the prefix
					// used to during installation and how many queries where successful and failed
					SetDatabaseInstallStatus($dbase->GetDatabaseName(), $state, $keywords['connection']['dbprefix'],
							$databaseSuccessCount, $databaseFailedCount);
				}
				
				// Will contain the name of a valid database installations
				$successInstall = array();
				$failedInstall = array();
				$databaseList = $dbase->GetDatabaseNameList();

				// Go through the list of databases to see if any database has 
				// gotten a "success" status, then installation is completed
				foreach(GetDatabaseInstallStatus() as $database=>$status)
				{
					// Only list a database "valid install" if it still exists :)
					if(in_array($database, $databaseList))
					{
						if($status['state'] == 'success')
							 $successInstall[] = $database;
						else $failedInstall[] = $database;
					}
				}
				unset($databaseList);

				// If there has not been any successful installation of database SQL queries yet, or this step is current
				if(count($successInstall) == 0 || $step == STEP_RUNSQL)
				{
					$page->MainTitle($steps[STEP_RUNSQL]['title'], 'sql');
					
					// If installer intended to go somewhere else but was 
					// forced to show this step - install not completed
					if($step != STEP_RUNSQL && count($successInstall) == 0)
					{
						$page->InfoBox('You must setup the database before going further.');
					}

					// There have been attempts to install, but failed!
					if(count($failedInstall) > 0)
					{
						if(count($failedInstall) == 1)
							$page->ErrorBox('There has been attempt to setup the database on <b>'.$failedInstall[0].'</b> but failed!');
						else
						{
							$str = '';
							$serp = ' and ';
							foreach($failedInstall as $database)
							{
								$str = $serp.'<b>'.$database.'</b>' . $str;
								$serp = ', ';
							}
							$str = substr($str, strlen($serp));
							$page->ErrorBox('There have been attempts to setup the database on '.$str.' but all failed!');
						}

						// If there are failed installs, and the database has some error message - show it
						if($config['show_database_error_messages'] && strlen($databaseErrorMessage) > 0)
							$page->ErrorDatabaseBox($databaseErrorMessage);
					}
					
					// If there are some successfull database 
					// installations, show success message
					if(count($successInstall) > 0)
					{
						// Notifycation of successful installations
						if(count($successInstall) == 1)
							$page->SuccessBox('Database setup has been completed successfully on <b>'.$successInstall[0].'</b>');
						else
						{
							$str = '';
							$serp = ' and ';
							foreach($successInstall as $database)
							{
								$str = $serp.'<b>'.$database.'</b>'.$str;
								$serp = ', ';
							}
							$str = substr($str, strlen($serp));
							$page->SuccessBox('Database setup has been completed successfully on '.$str);
						}


						// If there are successful installs and none of them matches the selected
						// database - then notify the user that he is about to install again on
						// another database and that he should rather just go back and select a 
						// database that has a valid install already
						if(!in_array($dbase->GetDatabaseName(), $successInstall))
						{
							$page->WarningBox('You are about to install tables on <b>'.$dbase->GetDatabaseName().'</b> '.
											  'though a valid install has been successfully done already.<br />&nbsp;<br />'.
											  'You can go back to <a href="?step='.STEP_DBSELECT.'">'.$steps[STEP_DBSELECT]['title'].'</a> '.
											  'and select a databases that has a valid installation.');
						}
					}

					/* 
					*  What happens if the user installs tables on database A, with prefix P1, and then
					*  after installation goes back to prefix step and changes P1 to P2. When the config
					*  is created the prefix value written to it will be P2 since the user changed it but
					*  the database will have prefix P1, causing failure in installation! 
					*
					*  The original implementation of the installer, the step STEP_DBPREFIX comes before 
					*  this step, or STEP_RUNSQL. Which means that if the prefix value is changed in 
					*  STEP_DBPREFIX step (and "next" is clicked in that step), this step is processed. 
					*  So, this prefix problem will be taken care of here.
					*
					*  This whole situation is still quite fragile because and change in the step order
					*  could prevent this issue to be fixed. To fully fix this problem - this fix has to be
					*  moved from here to the top (where queries are executed) so every time a step after
					*  this one is processed, the fix-check will modify the prefix value if needed.
					*
					*  In this version, however, the original implementation releys on the fact that the 
					*  step STEP_DBPREFIX is previous step from STEP_RUNSQL!  */					
					if(in_array($dbase->GetDatabaseName(), $successInstall))
					{
						// Get the status from sessions and check with the current set prefix
						$currentPrefix = $keywords['connection']['dbprefix'];
						$dbStatus = GetDatabaseInstallStatus($dbase->GetDatabaseName());
						if($currentPrefix != $dbStatus['prefix'])
						{
							// Change the prefix value to the one used during installation of SQL queries
							SetSessionPrefix($dbStatus['prefix']);
							$keywords['connection']['dbprefix'] = $dbStatus['prefix'];

							$text = ($dbStatus['prefix'] == '') ? '<i>empty</i>' : '<b>'.$dbStatus['prefix'].'</b>';

							// And then notify the user that the prefix has been changed!
							$page->WarningBox('During the setup of database <b>'.$dbase->GetDatabaseName().'</b>, the prefix '.
											  'was set to <tt><i>'.$dbStatus['prefix'].'</i></tt> but has been changed '.
											  'since then to <tt><i>'.$currentPrefix.'</i></tt><br />&nbsp;<br />'.
											  'The prefix has been reverted back to '.$text.' to prevent incorrect '.
											  'installation.');
						}
					}

					
					// Get the number of tables (and list of table names) from database to
					// know what to warn the user about and perhaps show a list of tables if needed
					$tableList = $dbase->GetTableListFromDatabase();
					if(count($tableList) > 0) 
					{
						$prefix = $keywords['connection']['dbprefix'];
						if(strlen($prefix) == 0 && $steps[STEP_DBPREFIX]['enabled'])
						{
							// Only show a "no prefix set" warning if there has NOT been a successful
							// database installation on the selected database!!
							if(!in_array($dbase->GetDatabaseName(), $successInstall))
							{
								$page->WarningBox('You have not specified a table prefix, and the database <b>'.$dbase->GetDatabaseName().'</b> '.
									'contains <b>'.count($tableList).'</b> table(s).<br />&nbsp;<br />'.
									'It is highly recommended and there is a much lower risk of table collision if you '. 
									'<a href="?step='.STEP_DBPREFIX.'">specify a table prefix</a>.');
							}
						}

						$page->Paragraph('The database <b>'.$dbase->GetDatabaseName().'</b> contains the following tables:');
						$page->StartTable(3, array('class'=>'tablelist'));
						$page->AddTableData($tableList);
						$page->EndTable();

						// Show a small paragraph notifying the user that he must be certain that
						// he wants to install the tables on a non-empty database. BUT, if the
						// selected database does have "success" and there are some tables, then
						// this list is most likely the results of the installation
						$dbStatus = GetDatabaseInstallStatus($dbase->GetDatabaseName());
						if($dbStatus['state'] != 'success')
						{
							$page->Paragraph('Be completly sure that this is the database you want to use, even though '.
											 'it is not empty before continuing with installation.');
						}
					}
					else
					{
						$page->Paragraph('The database <b>'.$dbase->GetDatabaseName().'</b> is empty and ready for installation.');
					}
					
					// If the installation script should be displayed to the user
					// display it in textarea. BUT - this is readonly and cannot
					// be changed! 
					if($steps[STEP_RUNSQL]['viewsql'])
					{
						// In case the prefix was modified above, update $mask
						// with the updated state of all keywords
						$mask->SetKeywords();
						$page->Label('The SQL installation script:');

						$sqlScript = $mask->GetSqlInstallQueries(FALSE);
						$page->Textarea($sqlScript, 'codeblock');
					}

					
					// If the selected database has successful installation - show "next" button
					$dbStatus = GetDatabaseInstallStatus($dbase->GetDatabaseName());
					if($dbStatus['state'] == 'success')
					{
						$page->FormStart(array('step'=>GetNextStep(STEP_RUNSQL)));
						$page->FormButton('Back', array('step'=>GetPrevStep(STEP_RUNSQL)));   
						$page->FormSubmit('Next');
						$page->FormClose();
					}
					
					// If the selected database has not yet been tried for installation
					else if($dbStatus == false)
					{
						$page->FormStart(array('step'=>STEP_RUNSQL, 'runsql'=>$dbase->GetDatabaseName()));
						$page->FormButton('Back', array('step'=>GetPrevStep(STEP_RUNSQL)));   
						$page->FormSubmit('Install Database Tables on ['.$dbase->GetDatabaseName().']');
						$page->FormClose();
					}

					// If the selected database does not have success, but something else
					// then there where some complications with the previous install
					else
					{
						$page->FormStart(array('step'=>STEP_RUNSQL, 'runsql'=>$dbase->GetDatabaseName()));
						$page->FormButton('Back', array('step'=>GetPrevStep(STEP_RUNSQL)));   
						$page->FormSubmit('Retry installation on '.$dbase->GetDatabaseName());
						$page->FormClose();
					}

					$page->ShowPage(STEP_RUNSQL);
				} 
			}

			/* ===================================================[ CREATE ADMINISTRATOR ACCOUNT ]=================================================== */

			if($steps[STEP_ROOTUSER]['enabled'])
			{
				if(!$dbase->IsConnected())
				{
					$page->MainTitle($steps[STEP_ROOTUSER]['title'], 'rootuser');
					$page->WarningBox('Connection has not been made to a database server. The step <a href="?step='.STEP_DBCONNECT.'">'.
									  '<b>'.$steps[STEP_DBCONNECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_ROOTUSER);  
				}				
				if(!$dbase->IsDatabaseSelected())
				{
					$page->MainTitle($steps[STEP_ROOTUSER]['title'], 'rootuser');
					$page->WarningBox('Database has not been selected. The step <a href="?step='.STEP_DBSELECT.'">'.
									  '<b>'.$steps[STEP_DBSELECT]['title'].'</b></a> must be processed first!');
					$page->ShowPage(STEP_ROOTUSER);  
				}
			
				/*
				 *  ALL POSTED DATA FROM ADMIN FORMS MUST MATCH THE KEYWORDS 
				 *  IN $keywords['admin'] CONFIGURED IN configuration.php
				 */				

				// If enabled and the administrator account does not exist yet, or force showing this step
				if(!AdminAccountSuccess() || $step == STEP_ROOTUSER)
				{
					$page->MainTitle($steps[STEP_ROOTUSER]['title'], 'rootuser');

					// Simplify the code litlebit with smaller variable
					$data = $keywords['admin'];

					// If the step is set to current, there is no administrator account 
					// and a request has been made to create administrator account...
					// - then validate the posted data (in $keywords['admin'], or $data)
					// - if data is valid, create the admin user and display success!
					if($step == STEP_ROOTUSER && !AdminAccountSuccess() && isset($_REQUEST['create']) 
						&& $_REQUEST['create'] == 'administrator')
					{

						// Include the methods used to validate the administrator account!
						require('assets'.DIRECTORY_SEPARATOR.'helper.adminaccount.php');
						
						/**************************************************************************************
						*                                                                                     *
						*            SPECIFY YOUR -RULES- OF CREATING ADMINISTRATOR ACCOUNTS HERE             *
						*         - these checks are simply a demonstration to help you get started -         *
						*                                                                                     *
						**************************************************************************************/

						// Assuming the data is valid
						$validData = true;

						// Usernames must have 4 characters or 
						if(strlen($data['admin_username']) < 4)
						{
							$need = 4 - strlen($data['admin_username']);
							$page->InfoBox('Usernames must be at least 4 characters long, you need <b>'.$need.'</b> more characters');
							$validData = false;
						}
						// Usernames cannot be constructed using special characters 
						// like # or %, or foreign special characters 
						if(!IsCommonCharacters($data['admin_username']))
						{
							$page->InfoBox('Usernames must only be constructed using common letters from <tt>A</tt> to <tt>Z</tt> and digits');
							$validData = false;
						}
						// If the two passwords do not match
						if($data['admin_password'] != $data['admin_passagain'])
						{
							$page->InfoBox('Passwords do not match, try again');
							$validData = false;
						}						
						// If the password must be more secure (since this is the root account)
						if(!IsValidPassword($data['admin_password']))
						{
							$page->InfoBox('Password is not secure enough, it must be 6 characters or longer and '.
										   'contain upper case character, digit or symbol as well.');
							$validData = false;
						}
						// If phone number set - it must be valid format
						if(strlen($data['admin_realname']) == 0)
						{
							$page->InfoBox('You must specify the display name');
							$validData = false;
						}						
						// If the password must be more secure (since this is the root account)
						if(!IsValidEmail($data['admin_email']))
						{
							$page->InfoBox('Email address <b>'.$data['admin_email'].'</b> is not valid email');
							$validData = false;
						}
						
						/////////// Root account data evaluation is done ///////////

						if($validData)
						{
							// Create an hashes for this valid data
							$keywords['admin']['admin_password'] = md5( $data['admin_password'] );
							$keywords['admin']['admin_hashkey'] = md5( $data['admin_username'].$keywords['admin']['admin_password'].$data['admin_email'] );

							// Update mask class with the changed keywords
							$mask->SetKeywords();

							// Get the installation queries and split them by the "next query" separator,
							// and then run each query and get an array of results. If there is no split
							// then the query will be an array with only one cell - still an array :)
							$results = $dbase->RunQuery( $mask->GetSqlRootAccessQueries(TRUE) );

							// Go through all the results, and every one of them must be 'true'
							// othervice some query failed and installation is incomplete!
							$databaseErrorMessage = '';
							$databaseSuccessCount = 0;
							$databaseFailedCount = 0;
							foreach($results as $result)
							{
								if($result['success'])
									$databaseSuccessCount++;
								else 
								{
									$databaseFailedCount++;
									$databaseErrorMessage .= $result['error']."<br />\n";
								}
							}

							// If some query failed					
							if($databaseFailedCount == 0)
							{
								SetAdminAccountStatus('success');
								$page->SuccessBox('Root user account has been created successfully. Proceed to the next step.');
							}
							else 
							{
								SetAdminAccountStatus('failed');
								$page->ErrorBox('Root user account could not be created!');

								if($config['show_database_error_messages'])
									$page->ErrorDatabaseBox($databaseErrorMessage);
							}
								
						}

					}
					

					// If selected step and admin account exists, show success message
					else if($step == STEP_ROOTUSER && AdminAccountSuccess())
					{
						$page->SuccessBox('Root user account has been created successfully. Proceed to the next step.');
					}

					// If the installer wanted to go further but could not,
					// the administrator account has not yet been created yet
					// or there was an error creating it
					else if($step != STEP_ROOTUSER)
					{
						if(AdminAccountFailed())
							$page->ErrorBox('Root user account failed to be created! Try again or contact support.');

						if(!AdminAccountExists())
							$page->InfoBox('Root user account does not exist yet! You must create one to continue!');
					}


					// Setup the administrator form if account does not exist
					// or it has failed before for some reason
					if(!AdminAccountSuccess())
					{
						// The form reloads the current step
						$page->FormStart(array('step'=>STEP_ROOTUSER, 'create'=>'administrator'));

						// Username, password and repeat password
						$page->Label($page->Must('* ').'Username:');
						$page->FormInput($data['admin_username'], 'admin_username');

						$page->Label($page->Must('* ').'Password:');
						$page->FormPassword('', 'admin_password');

						$page->Label($page->Must('* ').'Repeat password:');
						$page->FormPassword('', 'admin_passagain');

						// Subtitle to next section
						$page->SubTitle('Personal information:');

						// Display name and email
						$page->Label('Display name:');
						$page->FormInput($data['admin_realname'], 'admin_realname');

						$page->Label('Email address:');
						$page->FormInput($data['admin_email'], 'admin_email');

						
						// Buttons to create the admin and go back
						$page->FormButton('Back', array('step'=>GetPrevStep(STEP_ROOTUSER)));   
						$page->FormSubmit('Create administrator account');
						$page->FormClose();
					}

					// User account exists, display some data
					else
					{
						// The form reloads the current step
						$page->FormStart(array('step'=>GetNextStep(STEP_ROOTUSER)));

						$page->StartTable(2, array('class'=>'administrator'));

						$page->AddTableData('Username:', array('class'=>'label'));
						$page->AddTableData($data['admin_username'], array('class'=>'data'));

						$page->AddTableData('Display name:', array('class'=>'label'));
						$page->AddTableData($data['admin_realname'], array('class'=>'data'));

						$page->AddTableData('Email address:', array('class'=>'label'));
						$page->AddTableData($data['admin_email'], array('class'=>'data'));

						$page->EndTable();
						
						// Buttons to create the admin and go back
						$page->FormButton('Back', array('step'=>GetPrevStep(STEP_ROOTUSER)));   
						$page->FormSubmit('Next');
						$page->FormClose();
					}

					$page->ShowPage(STEP_ROOTUSER);
				}
			}

			/* ===================================================[ CREATE FINAL-OUTPUT CONFIGURATION FILE ]=================================================== */

			// If writing config is enabled - the code here MUST be executed!
			// but the page might not be needed to be displayed
			if($steps[STEP_WRITECONFIG]['enabled'])
			{
				$page->MainTitle($steps[STEP_WRITECONFIG]['title'], 'filenew');
				$allCreated = true;

				// Creation states will be stored in this array as well				
				$configs = $mask->GetConfigFiles();
				foreach($configs as $conf)
				{
					// Get the name of final output name and path folder
					$folder = FixPath($conf['savetofolder']);
					$file = trim($conf['maskname']);

					// Create the folder 
					if(strlen($folder) > 0 && !is_dir($folder))
					{
						if(!mkdir($folder))
							$allCreated = false;
					}

					// Write the config contents to a file
					if(file_put_contents($folder.$file, $conf['content']))
					{
						$page->SuccessBox('Config <b>'.$file.'</b> has been created successfully!');
					}
					else
					{
						$page->ErrorBox('The Installer is unable to create configuration <b>'.$folder.$file.'</b>, check your <tt>chmod</tt> '.
										'permissions or contact support to get this issue resolved.');
						$allCreated = false;
					}
				}

				// If the config was created - the installer is done!
				if($allCreated)
				{
					$page->FormStart(array('step'=>GetNextStep(STEP_WRITECONFIG)));
					$page->FormSubmit('Finished');
					$page->FormClose();
				}

				// Offer retry if creation failed
				else
				{
					$page->FormStart(array('step'=>STEP_WRITECONFIG));
					$page->FormButton('Back', array('step'=>GetPrevStep(STEP_WRITECONFIG)));   
					$page->FormSubmit('Retry');
					$page->FormClose();
				}

				// If there are some writing problems, or this step should not be
				// auto skipped and $step is currently set to view this step  
				if(!$allCreated || (!$steps[STEP_WRITECONFIG]['ishidden'] && $step == STEP_WRITECONFIG))
					$page->ShowPage(STEP_WRITECONFIG);

				// Page should not be shown, so the html queue is cleared
				// so the next step can start fresh
				else
					$page->ClearHtmlQueue();
			}

   

			/* ===================================================[ If there are no steps to process > DONE! ]=================================================== */

            TheLastInstallerStep();
            
        } // End if output config file does not exist or is empty
        
        
        /* ===================================================[ INSTALLER IS FINISHED ]=================================================== */
        
        else // the output config DOES exist!
        {
            TheLastInstallerStep();
        }
    }


	/** 
	 *  Display a form 
	 */
	function DatabaseManualBoxForm($boxLabelTitle='Type in database name manually:') 
	{
		global $page;
		global $login;

		// Offer the user to type in the database name directly
		$page->FormStart(array('step'=>GetNextStep(STEP_DBSELECT)));

		$page->Label($boxLabelTitle);
		$page->FormInput($login['database'], 'database', array(), 'mediumbox');

		$page->FormButton('Back', array('step'=>GetPrevStep(STEP_DBSELECT)));                        
		$page->FormSubmit('Next');  
		$page->FormClose();  
	}

	/**
	 *  Display a form with list of available databases
	 */
	function DatabaseSelectionListForm()
	{
		global $page;
		global $dbase;
		global $newdb;
		global $login;
		global $successInstall;

		$page->FormStart(array('step'=>GetNextStep(STEP_DBSELECT)));
		$page->StartTable(2, array('class'=>'dblist'));

		$dblist = $dbase->GetDatabaseList();
		foreach($dblist as $idx=>$db)
		{
			// $optional : Additional attributes to the <input> tag
			// $divClass : Added class value to the <div> that contains the <input>
			$optional = array();
			$divClass = '';

			// If a database has been selected, make this radiobox checked
			if($db['name'] == $login['database'])
				$optional[0] = 'checked'; # numeric keys are ignored in HtmlMaker

			// If however, the $newdb is in the list - it was just inserted,
			// then highlight that database as newly created database
			if($newdb && $newdb == $db['name'])
				$divClass = 'newdb';

			// If this database has successful installation, highlight it
			// as successful or approved database
			if(in_array($db['name'], $successInstall))
			{
				// if this IF-statement validates to true, then the database was 
				// JUST created but still marked as "successful installation". That
				// can ONLY happen if the user installs tables on a database, then
				// drops it using another tool and creates it again here
				if(strlen($divClass) > 0)
					 $divClass .= ' installdone'; 
				else $divClass = 'installdone';

				// The current database is removed from $successInstall, which
				// indicates that at the end of this foreach, $successInstall 
				// should be empty - meaning all successfully installed databases
				// do in fact exist. If $successInstall has any elements left when
				// this foreach is done - then remove those databases from sessions!
				$key = array_search($db['name'], $successInstall);
				unset($successInstall[$key]);
			}


			// The name caption of the database is formed in html
			$caption = $db['name'].' '.$page->Discrete('('.$db['tbcount'].')');							
			
			// Add a radio box for this database
			$page->FormRadiobox($db['name'], 'database', $caption, $optional, $divClass);

			// Get the data from HTML queue back, and add the HTML 'values'
			// from the returned queue item array into a table
			$html = $page->PopQueue();
			$page->AddTableData($html);
		}    
		$page->EndTable();

		// If there are some elements left in $successInstall, then those databases
		// do not exist and there cannot be a successfull installation on a database
		// that does not exist - sessions need to be updated
		if(count($successInstall) > 0)
		{
			foreach($successInstall as $database)
				RemoveDatabaseInstallStatus($database);
		}					

		$page->FormButton('Back', array('step'=>GetPrevStep(STEP_DBSELECT)));                        
		$page->FormSubmit('Next');  
		$page->FormClose();  
	}


	/**
	 *  The last installer step is shown:
	 *  - after STEP_WRITECONFIG if ishidden is enabled
	 *  - in the "else" statement above this function :)
	 */
	function TheLastInstallerStep()
	{
		global $page;
		global $mask;
		global $steps;
		global $config;

		// Only show "outro" message if enabled
		if($steps[STEP_FINISHED]['enabled'])
		{
			// Installation is done!
			$page->MainTitle($steps[STEP_FINISHED]['title'], 'cake');
			$page->Paragraph( $mask->GetFinishedMessage() . '<br />&nbsp;');
		}

		// If the installer will be ignored after installation
		// then do not offer the user to remove files or reset
		// the installation - Installer will be ignored either way
		if($config['ignore_installer_when_done'])
		{
			$page->FormStart();
			$page->FormSubmit('Finished!');
			$page->FormClose();
			$page->ShowPage(STEP_FINISHED, true, false);
		}

		// Only continue if self destruction is enabled
		if($config['allow_self_destruction'])  
		{
			// If the user requested all installer files should be deleted, 
			// or the installer should automatically self destruct
			if ($config['automatically_self_destruct'] || 
			   (isset($_REQUEST['doneaction']) && $_REQUEST['doneaction'] == 'selfdestruct') )
			{
				// Only include destroyer functions when they are needed
				require('assets'.DIRECTORY_SEPARATOR.'helper.destroyer.php');

				/* Since the PHP files have ALL been "included", their
				*  existance does not matter anymore. The rest of the 
				*  script will run normally even though all files have
				*  been deleted. */

				// Delete all files configured by config and display results
				$deletionStatus = DeleteYourself();
				if(is_array($deletionStatus))
				{
					$dirs = $deletionStatus['dirs'];
					$files = $deletionStatus['files'];

					// Removing files
					if($files['success'] == $files['total'] && $files['failed'] == 0)
						$page->SuccessBox('All Installer files where removed successfully!');

					else if($files['success'] == 0 && $files['total'] > 0)
						$page->WarningBox('Unable to remove Installer files, you have to remove them manually');

					else 
						$page->ErrorBox('Error occur removing Installer files, <b>'.$files['failed'].'</b> failed to be removed and need manual removal.');

					// Removing directories
					if($dirs['success'] == $dirs['total'] && $dirs['failed'] == 0)
						$page->SuccessBox('All Installer directories where removed successfully!');

					else if($dirs['success'] == 0)
						$page->WarningBox('Unable to remove Installer directories, you have to remove them manually');

					else
						$page->ErrorBox('Error occur removing Installer directories, <b>'.$dirs['failed'].'</b> failed to be removed and need manual removal.');


					$page->FormStart();
					$page->FormSubmit('Finished!');
					$page->FormClose();
					$page->ShowPage(STEP_FINISHED, true, false);
				}
			}
		}	

		/*
		*  Deletion has not been initiated, so show options on what to do depending
		*  on what is configured in the config
		*/
		
		// Should the current config be deleted and installation reset?
		if($config['allow_overriding_oldconfig'])
		{
			$page->SubTitle('Start all over', 'remconf');
			$page->Paragraph('If you are not happy with the installation, you can make the Installer remove '.
							 'current configuration and start all over again. <b>WARNING:</b> Any database '.
							 'change cannot be undone! You have to undo the database installation manually.');

			# NOTE!
			# this done-action is processed in [helper.sessions.php]!
			$page->FormStart(array('doneaction'=>'removeold')); 
			$page->FormSubmit('Remove current configuration and start over');
			$page->FormClose();
		}
		
		// If self-destruction is enabled but does not start it automatically
		if($config['allow_self_destruction'])              
		{
			$page->SubTitle('Delete Installer', 'exit');		
			$page->Paragraph('Installation is completed but the Installer is preventing the installed system to '.
							 'launch. You can make the Installer remove itself from the webserver if you wish '.
							 'not to remove them yourself.');

			$page->FormStart(array('doneaction'=>'selfdestruct')); 
			$page->FormSubmit('Delete all Installer files from the Webserver');
			$page->FormClose();
		}

		// If the installer is unable to do anything after installation!
		if(!$config['allow_overriding_oldconfig'] && !$config['allow_self_destruction'])
		{
			$page->WarningBox('You have to manually remove the Installer folder: <b>'.
				FixPath(INST_BASEDIR.INST_RUNFOLDER).'</b> in order to view the installed system');
		}

		
		$page->ShowPage(STEP_FINISHED, true, false);
	}