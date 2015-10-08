<?php if(!defined('INST_BASEDIR')) die('Direct access is not allowed!');

    /* ====================================================================
    *
    *                             PHP Setup Wizard
	*
    *                            -= CONFIGURATION =-
    *
    *  ================================================================= */
    


	/*=====================================================================================================================================*\
    |*                                                                                                                                     *|
    |*                                                             INSTALLATION STEPS                                                      *|
	|*                                                                                                                                     *|
    \*=====================================================================================================================================*/

	define('STEP_PHPREQUIRES',	'phprequires');
	define('STEP_IOFILES',		'iopermission');
	define('STEP_WELCOME',		'welcomemsg');
	define('STEP_TERMSOFUSE',	'termsofuse');
	define('STEP_SERIALKEY',	'serialkey');
	define('STEP_TIMEZONE',		'timezones');
	define('STEP_LANGUAGE',		'languages');
	define('STEP_ADDEDINFO',	'additional');
	define('STEP_DBCONNECT',	'dbserverlogon');
	define('STEP_DBSELECT',		'dbselection');
	define('STEP_DBACCESS',		'dbaccesstest');
	define('STEP_DBPREFIX',		'dbprefix');
	define('STEP_RUNSQL',		'installsql');
	define('STEP_ROOTUSER',		'rootuser');
	define('STEP_WRITECONFIG',	'writeconfig');
	define('STEP_FINISHED',		'finishedmsg');

	// This constant is used in overview.php as a "special" step to show the contents
	// of this file! This step IS NOT IMPLEMENTED in the installer.php - only overview.php
	define('STEP_SETTOVERVIEW',	'settoverview');


	$steps = array(

	/*--------------------------------------------------------------------|
	|  Welcome Message                                                    |
	|---------------------------------------------------------------------|
	|  Show welcome message or short introduction to what is being 
	|  installed
	|  
	|  > title    : The title of this step in the process box
	|  > enabled  : Should this step be included or not
	|  > maskname : The mask filename - HTML is supported   
	\---------------------------------------------------------------------*/
	STEP_WELCOME => array(
		'title'        =>  'Welcome',
		'enabled'      =>  true,
		'maskname'     =>  'welcome_message.html',
		),


	/*--------------------------------------------------------------------|
	|  PHP Requirements Checks                                            |
	|---------------------------------------------------------------------|
	|  Does the hosting service support the necessary PHP modules for this
	|  installer to function or not
	|  
	|  > title      : The title of this step in the process box
	|
	|  > enabled    : Should this step be included or not
	|
	|  > ishidden   : If all requirements are met, this step is not visible
	|
	|  > extensions : List of PHP extensions that must be loaded. NOTE: that
	|                 the array MUST be configured with the indices as the 
	|                 actual extension names, the values are the titles. Like
	|                 this: array('extension_name' => 'Friendly Title')
	| 
	|                 Example: If you want to check 'mysql' and 'mbstring'
	|                          array('mysql'=>'MySQL', 'mbstring'=>'MB Strings')
	|
	|  > directives : Should the installer verify list of directives or not.
	|                 If TRUE, then this step will use the $php_directives
	|                 array that is defined at the bottom of this config
	|
	|  > phpversion : Defines the required PHP version. If the system only
	|                 requires PHP 5 for instance, then '5' is enough and all
	|                 versions starting with 5 and above will be accepted. 
	|                 If you need to be very spesific you can set '5.2.10' and
	|                 any newer version will be accepted. Set this to false
	|                 to disable PHP version check
	|
	|  > maxversion : The 'phpversion' setting will accept any newer version
	|                 unless specified here. In other words, in what PHP 
	|                 version begins your system not to work?
	|
	|                 Example: phpversion = '5.2' and maxversion = '6' means
	|                          all versions after 5.2.0 (including 5.2.0) up
	|                          to 6.99.99 will be accepted, in other words, any 
	|                          PHP 5 and 6 versions after 5.2. Set max version
	|                          to '6.0.0' or '5' to limit only versions 5
	|
	|                 Example: phpversion = '4.3.9' and maxversion = '5.3.0'
	|                          means accept any version starting from 4.3.9
	|                          and up to (not including) 5.3.0
	\---------------------------------------------------------------------*/
	STEP_PHPREQUIRES => array(
		'title'       =>  'PHP Requirements',
		'enabled'     =>  true,
		'ishidden'    =>  true,
		'extensions'  =>  array(
							'mysql'  => 'MySQL Databases',
							'mcrypt' => 'Encryption',
							),
		'directives'  =>  true,
		'phpversion'  =>  '5', # treated as: 5.0.0 and up
		'maxversion'  =>  '5', # treated as: below 5.99.99
		),


	/*---------------------------------------------------------------------|
	|  I/O File Permissions Test                                           |
	|----------------------------------------------------------------------|
	|  Checks wherther if the installer can in fact create and write to 
	|  files on the server, which is the core purpose of the installer
	|
	|  !!NOTE!!:  This step will verify the "Create Configuration File" 
	|             step configuration. So IF this step has been passed the
	|             output config will be able to be created/updated
	|  
	|  > title     : The title of this step in the process box
	|
	|  > enabled  : Should this step be included or not
	|
	|  > ishidden  : If permission is granted, this step will be hidden
	|                whitout notifying the user at all. Othervice the user
	|                will be prompted "can create files" success message
	|
	|  > enabled   : If disabled, the installer continues without the 
	|                certany that files can be created and written to
	\---------------------------------------------------------------------*/
	STEP_IOFILES => array(
		'title'        =>  'File Permissions',
		'enabled'      =>  true,
		'ishidden'     =>  true,
		),


	/*---------------------------------------------------------------------|
	|  Terms Of Use Agreement                                              |
	|----------------------------------------------------------------------|
	|  If enabled the user MUST approve the "terms of use" agreement before
	|  continuing with the install
	|  
	|  > title    : The title of this step in the process box
	|  > enabled  : Should this step be included or not
	|  > maskname : The mask filename - plain-text only!   
	\---------------------------------------------------------------------*/
	STEP_TERMSOFUSE => array(
		'title'        =>  'Terms Of Use Agreement',
		'enabled'      =>  false,
		'maskname'     =>  'terms_of_use.txt',
		),


	/*---------------------------------------------------------------------|
	|  Serial Key Confirmation                                             |
	|----------------------------------------------------------------------|
	|  If enabled the user MUST enter valid serial key that matches a value
	|  in this config in order to continue. However, "try it out" trial is
	|  also supported if enabled in this step.
	|
	|  !!NOTE!!:  This step will be rather useless if used in your setup
	|             and the PHP code is not obfuscated. Meaning, PHP is in 
	|             clear text and anyone with very basic understanding of
	|             programming could easily just copy 'serialkey' and paste
	|             it during installation. Consider using some obfuscation,
	|             and with that said - obfuscating these array keys might
	|             also be a good idea.
	|
	|  > title      : The title of this step in the process box
	|  > enabled    : Should this step be included or not
	|  > allowtrial : Permits the user to press "Trial" button and avoid
	|                 entering some serial
	|  > serialkey  : The one or more serial keys the user must enter in
	|                 order to continue
	\---------------------------------------------------------------------*/
	STEP_SERIALKEY => array(
		'title'        =>  'Serial Key Confirmation',
		'enabled'      =>  false,
		'allowtrial'   =>  true,
		'serialkeys'   =>  array('ABC123', '123ABC'),		
		),


	/*---------------------------------------------------------------------|
	|  Language Selection                                                  |
	|----------------------------------------------------------------------|
	|  Does the system you are installing require a language selection?
	|
	|  > title        : The title of this step in the process box
	|  > enabled      : Should this step be included or not
	|  > supported    : Array of supported languages, with country code and name
	\---------------------------------------------------------------------*/
	STEP_LANGUAGE => array(
		'title'        =>  'Select Language',
		'enabled'      =>  false,
		'default'      =>  'uk',
		'supported'    =>  array(
							'uk'=>'English (UK)',
							'usa'=>'English (USA)',
							'de'=>'German',
							'fr'=>'French'),
		),


	/*---------------------------------------------------------------------|
	|  Timezone Selection                                                  |
	|----------------------------------------------------------------------|
	|  Does the system you are installing require a timezone selection?
	|
	|  > title        : The title of this step in the process box
	|  > enabled      : Should this step be included or not
	\---------------------------------------------------------------------*/
	STEP_TIMEZONE => array(
		'title'        =>  'Select Timezone',
		'enabled'      =>  false,
		),


	/*---------------------------------------------------------------------|
	|  Additional Information                                              |
	|----------------------------------------------------------------------|
	|  Does the system you are installing require some custom inputs from
	|  the user, like the "title" of the website or other related things
	|  that should go into the configs but are not related to login, db,
	|  admin account or any of the other steps available.
	|
	|  > title        : The title of this step in the process box
	|  > enabled      : Should this step be included or not
	\---------------------------------------------------------------------*/
	STEP_ADDEDINFO => array(
		'title'        =>  'Additional Information',
		'enabled'      =>  false,
		'form'         =>  array(						
			  array('type' => 'paragraph',
					'text' => 'This step is not used in this example.'),
			),
		),	

	/*---------------------------------------------------------------------|
	|  Database Server Connection                                          |
	|----------------------------------------------------------------------|
	|  Prompts username, password and host input fieldss that the user 
	|  fills out to logon to the server.
	|  
	|  > title        : The title of this step in the process box
	|
	|  > enabled      : Should this step be included or not
	|
	|  > portoptional : If enabled, the user has the option to fill in port
	|                   value. If keept empty it will be ignored when 
	|                   connection is made
	|
	|  > encryptlogin : When login is successful, this flag will make sure
	|                   the username, password, host and database name will 
	|                   be encrypted in session using the Blowfish encryption. 
	|                   It is highly recommended that you enable this feature 
	|                   to enhance security during the installation. 
	\---------------------------------------------------------------------*/
	STEP_DBCONNECT => array(
		'title'        =>  'Server Connection',
		'enabled'      =>  true,
		'portoptional' =>  true,
		'encryptlogin' =>  false, 
		),


	/*---------------------------------------------------------------------|
	|  Database Selection / Creation                                       |
	|----------------------------------------------------------------------|
	|  Lists all databases available and total number of tables in each 
	|  database. Offers the user to choose one database for the installation. 
	|  New databasew can also be created in this step
	|  
	|  > title        : The title of this step in the process box
	|
	|  > enabled      : Should this step be included or not
	|
	|  > allowcreate  : Can the user create new databases as well
	|
	|  > selecttype   : This setting controls how databases are selected.
	|                   You can set this to be manual or list only, but
	|                   setting this to 'both' enables the installer to
	|                   automatically determine which one to use at any
	|                   given time
	|
	|                   - 'manual' : Only show a input box to type in a 
	|                                database name manually
	|
	|                   - 'dblist' : Databases are listed such that the user
	|                                can select one of them. But, when the 
	|                                database list is empty or the 
	|                                SHOW DATABASES; query is restricted, 
	|                                the manual box is shown so the user can
	|                                attempt to enter it manually
	|
	|                   - 'both'   : Both options are shown togehter
	\---------------------------------------------------------------------*/
	STEP_DBSELECT => array(
		'title'        =>  'Database Selection',
		'enabled'      =>  true,
		'allowcreate'  =>  true,
		'selecttype'   =>  'both', 
		),


	/*---------------------------------------------------------------------|
	|  Database Access Test                                                | 
	|----------------------------------------------------------------------|
	|  A test is made to see if the selected user has the permit to create
	|  tables, insert, update, delete etc. If this step is set to ishidden,
	|  then it will only be shown if something in the test will render fail
	|  
	|  > title    : The title of this step in the process box
	|  > ishidden : Possible to hide this step if all tests are successful
	|  > enabled  : Should this step be included or not
	\---------------------------------------------------------------------*/
	STEP_DBACCESS => array(
		'title'        =>  'Database Access Test',
		'ishidden'     =>  true,
		'enabled'      =>  true,
		),


	/*---------------------------------------------------------------------|
	|  Database Table Prefix                                               |
	|----------------------------------------------------------------------|
	|  A very usefull option when you want to make sure that the table names 
	|  will be unique and not collide with other table names. Either from 
	|  other systems or another version of this same system 
	|
	|  > title      : The title of this step in the process box
	|
	|  > enabled    : Should this step be included or not
	|
	|  > optional   : The table prefix is not always wanted, though it is
	|                 a nice feature to offer. If you want the table prefix
	|                 to be enabled but not forced - set optional to true
	|                 so the user can self deside if he wants a prefix. Set
	|                 it to false and the prefix must have a value, thus
	|                 forced to have some value
	|
	|  > separator  : This string value is added at the end of the prefix.
	|                 If it is already at the end (the user added it) then
	|                 it will not be repeated. Keep the box empty if you
	|                 wish not to use a separator
	\---------------------------------------------------------------------*/
	STEP_DBPREFIX => array(
		'title'        =>  'Table Prefix',
		'enabled'      =>  false,
		'optional'     =>  true,
		'separator'    =>  '',  
		),


	/*---------------------------------------------------------------------|
	|  Execute SQL Queries (Install Tables)                                |
	|----------------------------------------------------------------------|
	|  A block of SQL well be executed, assuming the system needs to run 
	|  SQL commands to create tables and perhaps insert few rows as well. 
	|
	|  > title        : The title of this step in the process box
	|  > enabled      : Should this step be included or not
	|  > viewsql      : Should the install script be visible to the user,
	|                   if true then showin in a box with scrollbars
	|  > maskname     : The mask filename - plain-text only!
	\---------------------------------------------------------------------*/
	STEP_RUNSQL => array(
		'title'        =>  'Install Database Tables',
		'enabled'      =>  true,
		'viewsql'      =>  false,
		'maskname'     =>  'database_commands.sql',
		),


	/*---------------------------------------------------------------------|
	|  Create Administrator Account                                        |
	|----------------------------------------------------------------------|
	|  Should the installer include "Create Administrator Account" for the 
	|  system that is beeing installed? 
	|
	|  !!NOTE!!:  This step has to be customized to fit the needs of the
	|             system being installed. It is nearly impossible to count 
	|             for all possibilities when it comes to install users to 
	|             various systems. 
	|
	|  > title        : The title of this step in the process box
	|  > enabled      : Should this step be included or not
	|  > encryptdata  : The administrator data will be encrypted in sessions
	|  > maskname     : Name of the mask file containing the "insert" query
	\---------------------------------------------------------------------*/
	STEP_ROOTUSER => array(
		'title'        =>  'Create Administrator Account',
		'enabled'      =>  false,
		'encryptdata'  =>  false,
		'maskname'     =>  '',
		),


	/*---------------------------------------------------------------------|
	|  Create Configuration File(s)                                        |
	|----------------------------------------------------------------------|
	|  Create one or more config files for the system being installed. 
	|  This step writes any information you want from what the setup 
	|  has been collecting.
	|
	|  > title        : The title of this step in the process box
	|
	|  > enabled      : Should this step be included or not
	|
	|  > ishidden     : If creation is successful, this step will be hidden
	|                   whitout notifying the user at all. Othervice the user
	|                   will be prompted "config created" success message
	|
	|  > configs      : The names of the configs in your system and where to 
	|                   save them. Each config name must match a mask name which
	|                   will be a building block for creating that config. This
	|                   is because no system has the exactly the same config
	|                   structure. Therefore rename each mask file accordingly.
	|                   
	|      - maskname :     The name of the maskfile which will become the output config
	|                       file after installation (with all keywords replaced).
	|
	|      - savetofolder : Where will the config file be saved. This setting will 
	|                       create these folders from where the installer was launched 
	|                       from, which usually is index.php. Some tips:
	|
	|                         "folder/" : Create new folder and put the config
	|                                     inside that folder
	|
	|                      "../folder/" : Go back one folder, create the new folder
	|                                     there and put the config in it
	|
	|                                "" : No folder should be created, the config
	|                                     will be created at the same place as the
	|                                     file that launched the installer (index.php)
	|
	|                       NOTE: If some string is presented, that string will 
	|                             be put in the PHP function "mkdir()". To read
	|                             more about creating folders - check PHP documentation	                       
	|
	|  > updateonzero : In some cases, the config files have to be created 
	|                   manually due to security reasons. When that happens
	|                   the installer cannot rely on the fact that if a
	|                   config exists, we are done. So, the work around is
	|                   that you create a file manually and make it totally
	|                   empty! If the installer detects the output file, and
	|                   this setting is set to true - then if the file has 
	|                   zero bytes, we are not done and will keep installing!
	\---------------------------------------------------------------------*/
	STEP_WRITECONFIG => array(
		'title'        =>  'Create Configuration Files',
		'enabled'      =>  true,
		'ishidden'     =>  true,
		'updateonzero' =>  true,
		'configs'      =>  array(
		  array(
			'maskname'     =>  'database.php',
			'savetofolder' =>  '../_database/'),
			),
		),


	/*---------------------------------------------------------------------|
	|  Finished Message                                                    |
	|----------------------------------------------------------------------|
	|  Show finished message or short outro to what has been installed
	|  
	|  > title    : The title of this step in the process box
	|  > enabled  : Should this step be included or not
	|  > maskname : The mask filename - HTML is supported   
	\---------------------------------------------------------------------*/
	STEP_FINISHED => array(
		'title'        =>  'All done!',
		'enabled'      =>  true,
		'maskname'     =>  'finished_message.html',
		),
	);




    
	/*=====================================================================================================================================*\
    |*                                                                                                                                     *|
    |*                                                             ADDITIONAL SETTINGS                                                     *|
	|*                                                                                                                                     *|
    \*=====================================================================================================================================*/
    $config = array(


	/*--------------------------------------------------------------------|
	|  Installer Title                                                    |
	|---------------------------------------------------------------------|
	|  What should the name of the installer be
	\--------------------------------------------------------------------*/
	'installer_title_name' => 'ClanWars',

	
    /*--------------------------------------------------------------------|
	|  PHP Error Messages                                                 |
	|---------------------------------------------------------------------|
	|  Should the installer show PHP error messages or not. The installer
	|  will display errors in a mush more friendly fashion. Set to TRUE if 
	|  you are creating custom steps and need some debugging. 
	\--------------------------------------------------------------------*/
	'show_php_error_messages' => false,

     
    /*--------------------------------------------------------------------|
	|  Show Database Error Messages                                       |
	|---------------------------------------------------------------------|
	|  Error messages generated by the database server when SQL queries
	|  are unsuccessful. Useful when users are at "advanced" level, but 
	|  not considered needed when users are at "novice" level.
	\--------------------------------------------------------------------*/
    'show_database_error_messages' => false,


    /*--------------------------------------------------------------------|
	|  Masks Folder name                                                  |
	|---------------------------------------------------------------------|
	|  What is the name of the masks folder. Default: "masks"
	\--------------------------------------------------------------------*/
    'mask_folder_name' => 'masks',


	/*--------------------------------------------------------------------|
	|  Ignore Installer When Process Is Done                              |
	|---------------------------------------------------------------------|
	|  When the installer detects that the output config file exists and 
	|  it contains some data, it can simply "ignore itself" and continue
	|  running the website. Else it will notify the user to remove the
	|  installer folder
	\--------------------------------------------------------------------*/
    'ignore_installer_when_done' => false,


	/*--------------------------------------------------------------------|
	|  Allow Overriding Current Config                                    |
	|---------------------------------------------------------------------|
	|  When the installer detects that the output config file exists and 
	|  it contains some data, and "ignore" setting is set to false, should 
	|  the installer offer a "start all over" button. If pressed, the 
	|  current config will be deleted from the server as the installer 
	|  reloads and then acknowledges that there is a need for config creation
	|
	|  NOTE: 'ignore_installer_when_done' must be FALSE for this to work!
	\--------------------------------------------------------------------*/
    'allow_overriding_oldconfig' => false,
    

	/*--------------------------------------------------------------------|
	|  Allow Complete Self-Destruction                                    |
	|  Automatically launch Self-Destruction                              |
	|---------------------------------------------------------------------|
	|  When the installer detects that the output config file exists and 
	|  it contains some data, and "ignore" setting is set to false, should 
	|  the installer offer a "remove files" button. If pressed, all files
	|  in the Installer folder will be deleted from the server, or at least 
	|  an attempt will be made to do so
	|
	|  If the setting 'allow_self_destruction' is set to true, this setting
	|  can enforce that mechanism to execute automatically when installer 
	|  is done, and the user simply presses "Done" or "Finished" button and
	|  the installer files will be removed as the installed system is 
	|  starting up for the first time
	\--------------------------------------------------------------------*/
    'allow_self_destruction'       => true,    
	'automatically_self_destruct'  => true,


	/*--------------------------------------------------------------------|
	|  Self-Destruction Filter / Folder Removal                           |
	|---------------------------------------------------------------------|
	|  If for some reason, you do not want the installer to remove some
	|  spesific extensions from the Installer folder, specify the ones that
	|  you want to remove, but keep the array empty to remove everything
	|
	|  - Example:  array('php', 'css');  = Removes only PHP and CSS files
	|  - Example:  array();              = Removes ALL files!
	\--------------------------------------------------------------------*/
	'self_destruct_filter'          => array(),
	'self_destruct_removes_folders' => true,


	/*--------------------------------------------------------------------|
	|  Session Prefix                                                     |
	|---------------------------------------------------------------------|
	|  Uniquely identifies the sessions for the installer, important! 
	|  Default value is 'INST_' but change it if you are using it yourself
	\--------------------------------------------------------------------*/
    'session_prefix' => 'INST_',


	/*--------------------------------------------------------------------|
	|  Session Encryption Hash                                            |
	|---------------------------------------------------------------------|
	|  The sever connection credentials will be encrypted using a blowfish
	|  encryption. It will need a key that is used to encrypt/decrypt the
	|  the login info. To keep the encryption safe and unique for your 
	|  installer - replace the key below and try to obscure it as much as
	|  you can for added security.
	\--------------------------------------------------------------------*/
    'encryption_key' => '*r3p14ce_tHiz-w1Th>y0uR<paS5phr4ze!2*',


	/*--------------------------------------------------------------------|
	|  Debug Sessions / Posts / Gets                                      |
	|---------------------------------------------------------------------|
	|  Do you want to know the values of Sessions, Posts and Gets at the
	|  start of each reload? This is very helpful when adding custom steps
	\--------------------------------------------------------------------*/
    'debug_sessions' => false,
	'debug_posts'    => false,
	'debug_gets'     => false,
    );	



    /*=====================================================================================================================================*\
    |*                                                                                                                                     *|
    |*                                                              MASK KEYWORDS                                                          *|
	|*                                                                                                                                     *|
    \*=====================================================================================================================================*/
    $keywords = array(
    
    /*--------------------------------------------------------------------|
	|  Opening-Closing Brackets                                           |
	|---------------------------------------------------------------------|
	|  These are the symbols that represents starting and closing of 
	|  keywords, curly braces are default values. Example: {username}
	\--------------------------------------------------------------------*/
    'open_bracket'  => '{',
    'close_bracket' => '}',


	/*--------------------------------------------------------------------|
	|  [RESERVED] Installer Keywords : Connection                        |
	|---------------------------------------------------------------------|
	|  These keywords in this list MUST be here in order for the installer 
	|  to function properly! Fill in the empty brackets if you want to set 
	|  some default values. If default values are "correct" or accepted by 
	|  some of the steps, the user will be promted a success message when
	|  that step is entered, like it was posted by the user himself.
	\--------------------------------------------------------------------*/
    'connection' => array(
        'hostname' => 'localhost',  # default: localhost
        'username' => '',
        'password' => '',
        'database' => '',
		'dbport'   => '', # optional: enable it in STEP_DBCONNECT in $steps
        'dbprefix' => '', # optional: enable it in STEP_DBPREFIX in $steps
		),  


	/*--------------------------------------------------------------------|
	|  Installer Keywords : Additional Information step                   |
	|---------------------------------------------------------------------|
	|  The additional step allows the configurer to add a simple step
	|  to the installer without any programming. The form itself is setup 
	|  in the STEP_ADDEDINFO $step. This array should be kept empty as
	|  any values in here will be reset anyways
	\--------------------------------------------------------------------*/
    STEP_ADDEDINFO => array(						
		
			/*  This is configured in STEP_ADDEDINFO step 
			 *  and the keywords are the components names.
			 *  Keep this empty - it will be reset anyways
			 */
		),


	/*--------------------------------------------------------------------|
	|  Installer Keywords : Serial Key Confirmation step                  |
	|---------------------------------------------------------------------|
	|  The data used and entered by user in STEP_SERIALKEY is stored here.
	|  If you want the serial key check step to have "default" serial 
	|  typed in the serial box during setup then put it here. If the user
	|  changes the serial during setup the value here will change. All 
	|  these values will be available in the mask files 
	\--------------------------------------------------------------------*/
	'serial' => array(
		// The "default" serial value, keep empty if 
		// no pre-filled serial should be prompted
		'keyvalue'  => '',

		// Just something to indicate some time length,
		// if changed remember to change it in installer.php 
		'trialtime' => 10,

		// These two are set at runtime by the installer
		// to indicate what the user did in the step
		'isTrial'   => false, # was the "Trial" button clicked
		'isMatch'   => false  # did the user enter valid serial
		),
    

	/*--------------------------------------------------------------------|
	|  Installer Keywords : Administrator Account step                    |
	|---------------------------------------------------------------------|
	|  If the step STEP_ROOTUSER is enabled, these are the keywords that 
	|  will be used with that step. Here you can specify the default values
	|  and add more keywords that you might need
	|
	|  NOTE: The current keys and values are only for demonstration on how
	|        to use the installer mechanics to your advantage. Change these
	|        keys to what ever you like and add more if you need. Remember
	|        to keep your mask file updated with the keywords here
	|
	|  NOTE: The prefix "admin_" is added here to prevent the 'connection'
	|        keywords overriding these. In other worder - if a keyword here
	|        is "username" then the "username" in 'connection' will override
	|        the value here and the installer would be broken!
	\--------------------------------------------------------------------*/
    'admin' => array(
        'admin_username'  => '', 
        'admin_password'  => '', 
		'admin_passagain' => '', 
		'admin_realname'  => '', 
        'admin_email'     => '',
		
		// This value is not set by the "installer user" but should be specified
		// by the system's developer of the system being installed. So, 
		// this key is kept here to be available to the mask files instead 
		// of putting this value directly into the mask file.
		'admin_level'     => 10,

		// In some systems there are "hashkeys" to protect the data from
		// being updated outside the system itself. So, this is generated
		// when all the "admindata" is valid and ready to be inserted. This
		// key is set by the step when process is done. 
		'admin_hashkey'   => '',
		),


	/*--------------------------------------------------------------------|
	|  Installer Keywords : Special / Custom                              |
	|---------------------------------------------------------------------|
	|  These keywords are custom to your installation. Any keyword can be
	|  added as long as it does not collide with reserved keywords. If 
	|  collision occurs, the reserved keyword will override the special one. 
	|  You can either use these keywords for some custom steps  or just to have
	|  them available to use in the mask files (like welcome message etc.)
	\--------------------------------------------------------------------*/
    'special' => array(    

		// These three keywords are used in welcome and finished
		// messages, just a demonstration on special keywords
        'company' => 'WarLion', 
        'product' => 'ClashWars',
        'version' => '1.0',

		// These keywords are used with Timezone and Language steps
		'timezone' => '0',
		'language' => 'uk',

		// Want to show the todays date
		// in welcome/outro message?
		'datenow'  => date('H:m:s, F j, Y'),
		), 
    );
   


	/*=====================================================================================================================================*\
    |*                                                                                                                                     *|
    |*                                                            PHP DIRECTIVE REQUIREMENTS                                               *|
	|*                                              (enable these checks in $steps under STEP_PHPREQUIRES)                                 *|
    \*=====================================================================================================================================*/


	/*--------------------------------------------------------------------|
	|  Define Required PHP Directives                                     |
	|---------------------------------------------------------------------|
	|  If the system requires some directive to be set to true, false, have
	|  some spesific 'string' value, or numeric value that can be either
	|  higher or lower than something - put all that into this list!
	|
	|  NOTE: This list below is simply to get you started with these settings,
	|        you can add new and remove from the list - or simply disable 
	|        some directives by removing them or out commenting.
	|
	|  > title    : More readable title of the directive, makes the display
	|               of these checks more user friendly :)
	|
	|  > inikey   : The actual php.ini key, used with ini_get('*key*')
	|
	|  > mustbe   : This can be 'Off', 'On', 123 or 'some string. This is
	|               simply "equals" to something. If Off/On is set, then the
	|               value will be treated as boolean. Numeric values are
	|               turned into strings and it must match (case-insensitive)
	|
	|  > orhigher : Ini values will be turned as numeric values and they 
	|               must be equal or HIGHER than the one defined
	|               
	|  > orlower  : Ini values will be turned as numeric values and they 
	|               must be equal or LOWER than the one defined
	\--------------------------------------------------------------------*/
	$php_directives = array
	(
		// --- BOOLEAN SETTINGS : On/Off ---
		array('title'  => 'Running Safe Mode',
			  'inikey' => 'safe_mode',
			  'mustbe' => 'Off',
			),
		array('title'  => 'Register Globals',
			  'inikey' => 'register_globals',
			  'mustbe' => 'Off',
			),
		array('title'  => 'Magic Quotes Runtime',
			  'inikey' => 'magic_quotes_runtime',
			  'mustbe' => 'Off',
			),
		/*array('title'  => 'Display PHP Errors',
			  'inikey' => 'display_errors',
			  'mustbe' => 'On',
			),
		array('title'  => 'Short Open Tags',
			  'inikey' => 'short_open_tag',
			  'mustbe' => 'On',
			),
		array('title'  => 'Automatic Session Start',
			  'inikey' => 'session.auto_start',
			  'mustbe' => 'Off',
			),
		array('title'  => 'File Uploading',
			  'inikey' => 'file_uploads',
			  'mustbe' => 'On',
			),

		// --- NUMERIC SETTINGS : Ints ---
		array('title'    => 'Maximum Upload File Size',
			  'inikey'   => 'upload_max_filesize',
			  'orhigher' => '64M',
			),
		array('title'    => 'Max Simultaneous Uploads',
			  'inikey'   => 'max_file_uploads',
			  'orlower'  => '12', #-------------- OR LOWER <<
			),
		array('title'    => 'Floating Point Precision',
			  'inikey'   => 'precision',
			  'orhigher' => '10', #-------------- OR HIGHER >>
			),			
		array('title'    => 'Memory Capacity Limit',
			  'inikey'   => 'memory_limit',
			  'orhigher' => '32M',
			),
		array('title'    => 'POST Form Maximum Size',
			  'inikey'   => 'post_max_size',
			  'orhigher' => '64M',
			),*/
	);


	/*--------------------------------------------------------------------|
	|  Setting current PHP.INI values                                     |
	|---------------------------------------------------------------------|
	|  The Installer should be the first thing a system checks for, and 
	|  includes if exists, and the very first file included by the Installer 
	|  is the configuration - this file! 
	|
	|  So, this array is populated at the bottom and filled with current 
	|  values from PHP.INI >before< any code gets the opertunity to alter 
	|  it. That could break the installation if the directives check is 
	|  very important for the installed system!
	\--------------------------------------------------------------------*/
	foreach($php_directives as $idx=>$directive)
		$php_directives[$idx]['value'] = ini_get($directive['inikey']);