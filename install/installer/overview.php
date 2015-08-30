<?php 

    /* ====================================================================
    *
    *                            PHP Setup Wizard
	*
    *                      -= FILE/SETTINGS OVERVIEW =-
	*
	*  This script is intended to give an overview of what has been configured,
	*  if all files exists, if mask files contain any of the keywords etc. In
	*  final "deployment" of your product, this file should not be included as
	*  this is only indented for those who are configuring the Installer
    *
    *  ================================================================= */   



	/********************************[ DO CONFIGURATION/INSTALLER EXIST ]********************************/

	if(!is_file('configuration.php') || !is_readable('configuration.php'))
		die('The configuration file <b>configuration.php</b> is either not found or is unreadable');

	if(!is_file('installer.php') || !is_readable('installer.php'))
		die('The main Installer file <b>installer.php</b> is either not found or is unreadable');


	/********************************[ DO CLASSES/HELPERS EXIST ]********************************/

	// Asset folder
	$assetFolder = 'assets';

	// Files that MUST be in Assets folder
	$includes = array(
		'class.databases.php', 
		'class.htmlmaker.php', 
		'class.masks.php', 
		'helper.functions.php', 
		'helper.sessions.php', 
		'helper.adminaccount.php'
		);


	// The folder "assets" contains classes and helpers
	if(!is_dir($assetFolder))
	{
		echo 'The folder <b>'.$assetFolder.'</b> is not found, it contains core Installer classes and helpers:';
		echo '<ul>';
		foreach($includes as $include)
			echo '<li>'.$include.'</li>';
		echo '</ul>';
		die();
	}	
	
	// Check availability of files
	foreach($includes as $include)
	{
		$file = $assetFolder.DIRECTORY_SEPARATOR.$include;
		if(!is_file($file) || !is_readable($file))
		{
			die('The file <b>'.$file.'</b> is either not found or is unreadable');
		}
	}



	/********************************[ ENABLED STEPS ]********************************/

	define('INST_RUNSCRIPT', pathinfo(__FILE__, PATHINFO_BASENAME));
    define('INST_BASEDIR',	 str_replace(INST_RUNSCRIPT, '', __FILE__));
    define('INST_RUNFOLDER', '');
	define('INST_RUNINSTALL', 'installer.php');

	include('configuration.php');
	include($assetFolder.DIRECTORY_SEPARATOR.'class.htmlmaker.php');
	include($assetFolder.DIRECTORY_SEPARATOR.'class.masks.php');
	include($assetFolder.DIRECTORY_SEPARATOR.'helper.functions.php');

	$page = new Inst_HtmlMaker();
    $mask = new Inst_Masks();

	$page->HideDisabledSteps(false);
	$page->HideIsHiddenSteps(false);
	$page->UseStepWait(false);
	
	// Get the settings for some requested step
	$step = (isset($_REQUEST['step'])) ? $_REQUEST['step'] : 'overview';
	$sett = false;
	if(isset($steps[$step]))
		$sett = $steps[$step];

	$keywords[STEP_ADDEDINFO] = array();
	foreach($steps[STEP_ADDEDINFO]['form'] as $control)
	{
		if(is_array($control) && isset($control['keyword']))
		{
			if(isset($control['value']))
				$keywords[STEP_ADDEDINFO][$control['keyword']] = $control['value'];
			else if(isset($control['value_off']))
				$keywords[STEP_ADDEDINFO][$control['keyword']] = $control['value_off'];
			else
				$keywords[STEP_ADDEDINFO][$control['keyword']] = false;
		}
	}
	
	$mask->SetKeywords();

	/* ===================================================[ SHOWING MASK CONTENTS ]=================================================== */

	// If the name of the mask matches the settings for the selected step
	if ( isset($_GET['showmask']) && (isset($sett['configs']) || (isset($sett['maskname']) && $_GET['showmask'] == $sett['maskname'])))		 
	{
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Configuration Overview: Mask content</title>
<link rel="stylesheet" type="text/css" href="<?php echo INST_RUNFOLDER ?>css/style.css" />
</head><body>
<div style="clear:both;"><a href="?step=<?php echo $step; ?>">&lt;&lt; Go back</a></div>
<?php

		// SQL masks are rendered differently
		$ext = $mask->GetMaskExtension($_GET['showmask'], true);
		if($ext == 'sql')
		{		
			$queries = $mask->GetSqlMaskParsed($_GET['showmask'], false);
			if(count($queries) > 0)
			{
				$words = $mask->GetMergedKeywords();
				foreach($queries as $query)
				{
					// Replace keywords OUTSIDE the mask class in order to
					// highlight the keywords in the queries with bold
					foreach($words as $key=>$word)
					{
						$keyword = $keywords['open_bracket'].$key.$keywords['close_bracket'];
						$query = str_replace($keyword, '<b>'.$keyword.'</b>', $query);
					}

					// Replace newlines with html break before displaying
					$query = str_replace("\n", "<br />", $query);
					echo '<div class="query">'.$query.'</div>';
				}			
			}
		}

		// Load the mask normally
		else
		{
			$content = $mask->GetMask($_GET['showmask'], true);

			// Text files do not contain HTML
			if($ext == 'txt')
				echo '<div class="query">'.str_replace("\n", "&nbsp;<br />", $content).'</div>';

			else if($ext == 'php')
				echo '<div class="phpcode">'.str_replace("\n", "&nbsp;<br />", htmlentities($content)).'</div>';

			else 
				echo '<div class="query">'.$content.'</div>';
		}
?>
</body>
</html>
<?
		// Stop running after content has been shown
		die();
	}


	/* ===================================================[ CONFIGURATION OVERVIEW ]=================================================== */

	// If the settings are 'false', then the step is not
	// configured in the $steps variable - show $config overview!
	if($sett === false)
	{
		/* -----------------------( GLOBAL SETTINGS )----------------------- */
		$page->MainTitle('Main Configuration', 'settings');
		$page->StartTable(2, array('class'=>'dbtests'));
		foreach($config as $key=>$value)
		{
			$show = GetSettingsValue($value);
			$page->AddTableData('<b>'.$key.'</b>', array('style'=>'text-align:right; padding-right:12px;'));
			$page->AddTableData('<tt>'.$show.'</tt>');
		}
		$page->EndTable();
		$page->Paragraph();

		/* -----------------------( INSTALLER KEYWORDS )----------------------- */
		$page->MainTitle('Installer Keywords', 'keywords');
		$page->StartTable(2, array('class'=>'dbtests'));
		foreach($keywords as $key=>$value)
		{
			if(is_array($value))
			{
				$page->AddTableData('<b>'.$key.'</b>', array('style'=>'text-align:right; padding-right:12px;'));
				$page->AddTableData('<span style="color:#BEBEBE">'.count($value).' keywords</span>');

				foreach($value as $wordkey=>$wordvalue)
				{
					$show = GetSettingsValue($wordvalue);
					$page->AddTableData('');
					
					if(strlen($show) > 0)
						 $page->AddTableData('<tt>'.$wordkey.' = <b>'.$show.'</b></tt>');
					else $page->AddTableData('<tt>'.$wordkey.'</tt>');
				}
			}
			else
			{
				$show = GetSettingsValue($value);
				$page->AddTableData('<b>'.$key.'</b>', array('style'=>'text-align:right; padding-right:12px;'));
				$page->AddTableData('<tt>'.$show.'</tt>');
			}
		}
		$page->EndTable();
		$page->Paragraph();

		/* -----------------------( PHP DIRECTIVES )----------------------- */
		$page->MainTitle('PHP Directives', 'phplogo');

		if(count($php_directives) > 0)
		{
			$page->StartTable(3, array('class'=>'dbtests'));

			$page->AddTableData('Directive Key', array('style'=>'text-align:right; padding-right:12px;'), array('style'=>'color:#838383;'));
			$page->AddTableData('Required', array('style'=>'padding:0 12px 0 12px;'));
			$page->AddTableData('Current', array('style'=>'padding:0 12px 0 12px;'));		

			foreach($php_directives as $idx=>$directive)
			{
				// Set the ini key to the most left
				$page->AddTableData('<b>'.$directive['inikey'].'</b>', array('style'=>'text-align:right; padding-right:12px;'));

				// Prepair variables
				$current = $directive['value'];
				$required = '';

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
							 $current = GetAsRed('On', true);
						else $current = GetAsRed('Off', true);
					}

					// Any other value MUST be equal!
					else if($current == $required)
						 $current = GetAsGreen($current, true);
					else $current = GetAsRed($current, true);
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
						$required = $required.' or more';
						if($curInt >= $reqInt)
							 $current = GetAsGreen($current, true);
						else $current = GetAsRed($current, true);
					}
					else if(isset($directive['orlower']))
					{
						$required = $required.' or less';
						if($curInt <= $reqInt)
							 $current = GetAsGreen($current, true);
						else $current = GetAsRed($current, true);
					}
				}
		
				$page->AddTableData('<tt>'.$required.'</tt>', array('style'=>'text-align:center;'));
				$page->AddTableData('<tt>'.$current.'</tt>', array('style'=>'text-align:center;'));			
			}
			$page->EndTable();
		}
		else
		{
			$page->Quotation('No directives are required');
		}
	}


	/* ===================================================[ ALL OTHER STEPS ]=================================================== */

	// Do some step checking
	else
	{
		// For the additional step checks
		$keyCtrl = array();
		$txtCtrl = array();
		$keyCount = array();
		$txtCount = array();

		// Show the title of the step and a "for all" icon
		if(isset($steps[$step]['title']))
			 $title = $steps[$step]['title'];
		else $title = 'Installer step';
		$page->MainTitle($title, 'allsteps');

		// Display the keys and values
		$page->StartTable(2, array('class'=>'dbtests'));
		foreach($sett as $key=>$value)
		{
			$show = GetSettingsValue($value);
			$page->AddTableData('<b>'.$key.'</b>', array('style'=>'text-align:right; padding-right:12px;'));
	
			/* -----------------------( PHP VERSION STRING )----------------------- */
			if($key == 'phpversion')
			{
				$version = implode('.', VersionStringToArray($value, '0'));
				if($version != $value)
					$show .= ' <span style="color:#8F8F8F; font-size:11px;">(becomes minimum: '.$version.')</span>';

				$page->AddTableData('<tt>'.$show.'</tt>');
			}

			/* -----------------------( PHP VERSION STRING )----------------------- */
			else if($key == 'maxversion')
			{
				if($value === false)
					$value = 'x';

				$version = implode('.', VersionStringToArray($value, '99'));
				if($version != $value)
					$show .= ' <span style="color:#8F8F8F; font-size:11px;">(becomes maximum: '.$version.')</span>';

				$page->AddTableData('<tt>'.$show.'</tt>');
			}

			/* -----------------------( PHP EXTENSIONS )----------------------- */
			else if($key == 'extensions' && is_array($value))
			{
				$show = '';
				foreach($value as $ext=>$title)
				{
					if(IsExtensionInstalled($ext))
						 $show .= '['.GetAsGreen($ext).'] '.$title.'<br />';
					else $show .= '['.GetAsRed($ext).'] '.$title.'<br />';
				}		
				$page->AddTableData('<tt>'.$show.'</tt>');
			}

			/* -----------------------( ADDITIONAL INFORMATION )----------------------- */
			else if($key == 'form')
			{
				$keyCtrl = array();
				$txtCtrl = array();
				$keyCount = array();
				$txtCount = array();

				// Separate the controls into two arrays
				foreach($steps[$step]['form'] as $control)
				{
					if(isset($control['type']))
					{
						if(isset($control['keyword']) && in_array($control['type'], array('textbox', 'textarea', 'radiobox', 'checkbox')))
						{
							$keyCtrl[] = $control;

							if(!isset($keyCount[$control['type']]))
								 $keyCount[$control['type']] = 1;
							else $keyCount[$control['type']]++;
						}
						else
						{
							$txtCtrl[] = $control;

							if(!isset($txtCount[$control['type']]))
								 $txtCount[$control['type']] = 1;
							else $txtCount[$control['type']]++;
						}					
					}
				}
				$page->AddTableData('<b>'.(count($keyCtrl) + count($txtCtrl)).'</b>&nbsp;&nbsp;<tt>elements</tt>');
				
				$page->AddTableData('&nbsp;');
				$page->AddTableData('<b>'.count($keyCtrl).'</b>&nbsp;&nbsp;<tt>for keywords</tt>');

				foreach($keyCount as $type=>$count)
				{
					$page->AddTableData('&nbsp;');
					$page->AddTableData('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>'.$count.'&nbsp;&nbsp;<tt>'.$type.'</tt></i>');
				}

				$page->AddTableData('&nbsp;');
				$page->AddTableData('<b>'.count($txtCtrl).'</b>&nbsp;&nbsp;<tt>for display</tt>');

				foreach($txtCount as $type=>$count)
				{
					$page->AddTableData('&nbsp;');
					$page->AddTableData('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>'.$count.'&nbsp;&nbsp;<tt>'.$type.'</tt></i>');
				}
				
			}

			/* -----------------------( MULTIPLE CONFIGS )----------------------- */
			else if($key == 'configs')
			{
				$page->AddTableData('<b>'.count($value).'</b>&nbsp;<tt>&nbsp;in total</tt>');

				foreach($steps[$step]['configs'] as $conf)
				{
					$savetofolder = (strlen($conf['savetofolder']) > 0) ? '<tt>savetofolder</tt> = <tt>'.$conf['savetofolder'].'</tt>' : '';
					$page->AddTableData('&nbsp;');
					$page->AddTableData('<span style="color:#ffffff;">____</span><tt>maskname</tt> = <tt>'.$conf['maskname'].'</tt><br />'.$savetofolder);
				}				
			}

			else
				$page->AddTableData('<tt>'.$show.'</tt>');
		}
		$page->EndTable();		


		/* -----------------------( CHECK PHP VERSION )----------------------- */

		// If the php version is defined here
		if(isset($steps[$step]['phpversion']))
		{
			$max = $steps[$step]['maxversion'];
			if($max === false)
				$max = 'x';

			// Get the current, lower and upper
			$bounds = GetVersionBounds($steps[$step]['phpversion'], $max);
			$CurLow = CompareVersons($bounds['current'], $bounds['lower']);
			$CurHig = CompareVersons($bounds['current'], $bounds['upper']);
			$MinMax = CompareVersons($bounds['lower'], $bounds['upper']);
			$maxStr = ($steps[$step]['maxversion']) ? ' - '.implode('.', $bounds['upper']) : '';
			$verStr = '<br />&nbsp;<br />PHP Version: '.phpversion().'<br />PHP Required: '.implode('.', $bounds['lower']).$maxStr;

			// If minimum is above maximum!
			if($MinMax == 1)
			{
				$page->ErrorBox('Minimum version requirements are higher than maximum requirements. '.
				                'This check will always fail due to incorrect configuration! <br />&nbsp;<br />'.
								'This must be corrected: [min '.$steps[$step]['phpversion'].' &gt; '.$steps[$step]['maxversion'].' max]');
			}

			// If current version is equal or higher than lower bound
			// and is below the upper bound - then accepted!
			if ($CurLow >= 0 && $CurHig < 0)
				$page->SuccessBox('Current PHP version is supported!'.$verStr);			
			else if($CurLow < 0)
				$page->WarningBox('Current PHP version is below minimum requirements!'.$verStr);
			else if($CurHig > 0)
				$page->WarningBox('Current PHP version is above maximum requirements!'.$verStr);
			else if($CurHig == 0)
				$page->WarningBox('Current PHP version is the same as the maximum requirement, which is not supported!'.$verStr);
			else
				$page->WarningBox('Current PHP version not supported!'.$verStr);
		}

		/* -----------------------( VERIFY FORM STRUCTURE )----------------------- */
		if($step == STEP_ADDEDINFO)
		{
			$page->Paragraph('&nbsp;');
			$page->MainTitle('Your custom form', 'userinfo');

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
						CheckControlAttributes($data, 
							array('type','keyword','value_on','value_off','text'),
							array('checked'), 							
							array('value','numeric','mustfill','minval','maxval','minlen','maxlen'));
						
						$data = FillInAllAttributes($data);
						$checked = (isset($data['checked']) && $data['checked'] === true) ? array('checked') : array();
						$page->FormCheckbox($data['value_on'], $data['keyword'], $mask->ReplaceKeywords($data['text']), $checked);
						break;

					case 'radiobox':
						CheckControlAttributes($data, 
							array('type','keyword','value','text'),
							array('checked'), 							
							array('value_on','value_off','numeric','mustfill','minval','maxval','minlen','maxlen'));
						
						$data = FillInAllAttributes($data);
						$checked = (isset($data['checked']) && $data['checked'] === true) ? array('checked') : array();
						$page->FormRadiobox($data['value'], $data['keyword'], $mask->ReplaceKeywords($data['text']), $checked);
						break;

					case 'textbox':
						CheckControlAttributes($data, 
							array('type','keyword','value','numeric','mustfill'),
							array('minval','maxval','minlen','maxlen'), 							
							array('text','value_on','value_off','checked'));
						
						$data = FillInAllAttributes($data);							
						$page->FormInput($data['value'], $data['keyword']);
						break;
					case 'textarea':
						CheckControlAttributes($data, 
							array('type','keyword','value','numeric','mustfill'),
							array('minval','maxval','minlen','maxlen'), 							
							array('text','value_on','value_off','checked'));

						$data = FillInAllAttributes($data);
						$page->FormTextarea($data['value'], $data['keyword']);
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
		}


		/* -----------------------( IF MASK IS DEFINED - VERIFY IT! )----------------------- */

		// Make sure this mask file exists!
		if(isset($sett['maskname']))
			ShowMaskState($sett['maskname']);

		else if(isset($sett['configs']))
		{
			if(is_array($sett['configs']))
			{
				foreach($sett['configs'] as $conf)
				{
					ShowMaskState($conf['maskname']);
				}
			}
			else
				$page->ErrorBox("The config item <b><tt>configs</tt></b> is not an array!");
		}
	}

	
	/* ===================================================[ CREATE STEP PROCESS ]=================================================== */

	// Create a new array with the configuration overview as first element
	// and copy the rest of the $steps array into the new array
	$newSteps = array(STEP_SETTOVERVIEW => array('title'=>'Configuration Overview'));
	foreach($steps as $key=>$value)
		$newSteps[$key] = $value;

	// Clear the original steps and update with the modified version
	$steps = array();
	$steps = $newSteps;

	if(!isset($steps[$step]))
		$step = STEP_SETTOVERVIEW;

	// Show the page with the modified steps array
	$page->ShowPage($step, true, true, 'Configuration Overview');



	//=================================[ Functions used in Overview Script ]=================================//

	function ShowMaskState($maskname)
	{
		global $keywords;
		global $mask;
		global $page;
		global $step;

		if($mask->DoesMaskExistAndIsReadable($maskname))
		{
			$page->SuccessBox('The mask file <b>'.$maskname.'</b> exists and is readable');

			// The mask is checked for few things
			$maskContent = $mask->GetMask($maskname, false);

			// Get if ANY keyword is found in the mask
			$counts = $mask->GetReplaceKeywordCount($maskContent);
			if(is_array($counts) && count($counts) > 0)
			{
				$str = '';
				foreach($counts as $word=>$count)
					$str .= "\n".'<br /><tt><b>'.$keywords['open_bracket'].$word.$keywords['close_bracket'].'</b></tt> = <b>'.$count.'</b>';

				$page->SuccessBox('The mask file contains the following keywords:'.$str);
			}
			else
			{
				$page->InfoBox('This mask file does not contain any keywords to replace.');
			}

			// If the mask is SQL mask, then show different message
			$ext = $mask->GetMaskExtension($maskname, true);
			if($ext == 'sql')
			{
				$queries = $mask->GetSqlMaskParsed($maskname, false);
				if(count($queries) > 0)
				{
					$page->SuccessBox('Detected <b>'.count($queries).'</b> queries in this SQL mask. '.
						'<a href="?step='.$step.'&showmask='.$maskname.'">Take a look</a> at your mask file to verify!');
				}
				else
				{
					$page->WarningBox('No queries detected, <a href="?step='.$step.'&showmask='.$maskname.'">take a look</a> at your mask file to verify!');
				}
			}

			// Any other mask is displayed normally
			else
			{
				$page->SuccessBox('Do you want to see what mask looks after the keywords have been replaced? <a href="?step='.
								  $step.'&showmask='.$maskname.'">Take a look</a>.');
			}
		}
		else
			$page->WarningBox('The mask file <b>'.$maskname.'</b> does not exists, make sure filenames are correct!');
	}

	function CheckControlAttributes($control, $required, $optional, $notSupported)
	{
		global $page;

		foreach($required as $attrib)
		{
			if(!isset($control[$attrib]))
			{
				if($attrib == 'keyword')
					$page->ErrorBox('This <b>'.$control['type'].'</b> does not have <tt>'.$attrib.'</tt> setting!!');
				else
				{
					$keywTxt = (isset($control['keyword'])) ? 'for <b>'.$control['keyword'].'</b>' : '';
					$page->ErrorBox('This <b>'.$control['type'].'</b> '.$keywTxt.' does not have <tt>'.$attrib.'</tt> setting!');
				}
			}
		}

		foreach($notSupported as $attrib)
		{
			if(isset($control[$attrib]))
			{
				$keywTxt = (isset($control['keyword'])) ? 'for <b>'.$control['keyword'].'</b>' : '';
				$page->WarningBox('The <b>'.$control['type'].'</b> '.$keywTxt.' does not support the <tt>'.$attrib.'</tt> setting');
			}
		}

		foreach($optional as $attrib)
		{
			if(!isset($control[$attrib]))
			{
				$keywTxt = (isset($control['keyword'])) ? 'for <b>'.$control['keyword'].'</b>' : '';
				$page->InfoBox('The <b>'.$control['type'].'</b> '.$keywTxt.' does have the optional <tt>'.$attrib.'</tt> setting');
			}
		}
	}

	function FillInAllAttributes($control)
	{
		// All possible control attributes
		$allAttributes = array( 'type','keyword','value','value_on','value_off',
								'text','checked','numeric','mustfill','minval',
								'maxval','minlen','maxlen');

		foreach($allAttributes as $attrib)
		{
			if(!isset($control[$attrib]))
				$control[$attrib] = '';
		}

		return $control;
	}

	function GetSettingsValue($value)
	{
		$show = '';
		if(is_array($value))
		{
			if(count($value) == 0)
				$show = '<i style="color:#9A9A9A;">*empty*</i>';
			else
			{
				foreach($value as $idx=>$item)
				{
					if(IsNumericOnly($idx))
						 $show .= $item.', ';
					else $show .= '['.$idx.']='.$item.', ';
				}
				$show = substr($show, 0, strlen($show)-2);
			}
		}
		else
		{
			if($value === true)
				 $show = GetAsBlue('TRUE');
			else if($value === false)
				$show = GetAsOrange('FALSE');
			else
				$show = htmlentities($value);
		}

		return $show;
	}

