<?php if(!defined('INST_BASEDIR')) die('Direct access is not allowed!');

    /* ====================================================================
    *
    *                            PHP Setup Wizard
    *
    *                         -= MASK READ/WRITER =-
    *
    *  ================================================================= */
    

    /** 
	 *  Manipulates mask files 
	 */
    class Inst_Masks
    {
        private $words;
        
        /** 
		 *  Manipulates mask files 
		 */
        function Inst_Masks()
        {
            $this->SetKeywords();
        }
        
        
        /********************************[ CORE FUNCTIONS ]********************************/
        
        /** 
		 *  Set the keywords that will be replaced in the masks 
		 */
        function SetKeywords()
        {
			global $keywords;

			// Merge the keyword arrays together, if there is collision in the arrays the
			// connection array will be dominant - meaning that it will override the
			// keys in special and admin arrays
			$this->words = array();
			$this->words = array_merge($keywords['special'], $keywords['connection']);
			$this->words = array_merge($keywords['serial'], $this->words);
			$this->words = array_merge($keywords['admin'], $this->words);

			if(is_array($keywords[STEP_ADDEDINFO]))
				$this->words = array_merge($keywords[STEP_ADDEDINFO], $this->words);
        }

		/**
		 *  Get the merged keyword array
		 */
		function GetMergedKeywords()
		{
			return $this->words;
		}
            
        /** 
		 *  Replace keywords in a mask content 
		 */
        function ReplaceKeywords($maskContent)
        {
			global $keywords;

            // Skip replace if no string to work with
            if(!$maskContent || strlen($maskContent) == 0)
                return $maskContent;
            
            // Do the replacement
            foreach($this->words as $keyword=>$value)
            {				
				$keyword = $keywords['open_bracket'].$keyword.$keywords['close_bracket'];
                $maskContent = str_replace($keyword, $this->FormatKeywordValue($value), $maskContent);
            }
            return $maskContent;
        }

		/** 
		 *  When boolean values are replaced in files they are '1' for true and nothing for false, 
		 *  which does not work very well with "define" statements in mask files.
		 */
		function FormatKeywordValue($value)
		{
			if(is_bool($value))
				 return ($value) ? 'true' : 'false';
			else return $value;
		}

		/**
		 *  Get how many keywords are replaced in some mask content
		 */
		function GetReplaceKeywordCount($maskContent)
		{
			global $keywords;

            // Skip replace if no string to work with
            if(!$maskContent || strlen($maskContent) == 0)
                return $maskContent;
            
            // Do the replacement
			$count = array();
            foreach($this->words as $keyword=>$value)
            {
				$searchWord = $keywords['open_bracket'].$keyword.$keywords['close_bracket'];
				$wordCount = substr_count($maskContent, $searchWord);
				
				if($wordCount > 0)
					$count[$keyword] = $wordCount;
            }
            return $count;
		}

		/**
		 *  Check if the mask file exists and is readable
		 */
		function DoesMaskExistAndIsReadable($maskname)
		{
			global $config;
			$file = INST_RUNFOLDER.$config['mask_folder_name'].DIRECTORY_SEPARATOR.$maskname;
			return (is_file($file) && is_readable($file)) ? true : false;
		}

		/** 
		 *  Get a mask content with the keywords replaced
		 */
		function GetMask($maskname, $replaceKeywords=true)
		{
			global $config;
			$file = INST_RUNFOLDER.$config['mask_folder_name'].DIRECTORY_SEPARATOR.$maskname;

			if(is_file($file) && is_readable($file))
			{
				$content = file_get_contents($file);

				if($replaceKeywords)
					 return $this->ReplaceKeywords($content);
				else return $content;
			}
			else
				return false;
		}

		/**
		 *  Get the extension of the mask - determines the type of it
		 */
		function GetMaskExtension($maskname, $getInLowercase=false)
		{
			// Get the file extension (+1 to skip the dot)
			if(strrpos($maskname, '.') != false)
			{
				$ext = substr($maskname, (strrpos($maskname, '.') + 1 ));
				if($getInLowercase)
					 return strtolower($ext);
				else return $ext;
			}
			else 
				return false;
		}

		/**
		 *  If a SQL mask does not contain the query separator string, then this function can try to
		 *  parse the SQL mask and detect the query separation. 
		 *
		 *  NOTE: In order for this to work - the queries MAY NOT start after each other. They must
		 *        be separated with newlines after the semicolon (;). Comments will be ignored!
		 *        
		 *  CORRECT MASK: CREATE TABLE `name1` ( ... ) ... ; 
		 *                CREATE TABLE `name2` ( ... ) ... ; 
		 *
		 *  ERROR MASK:   CREATE TABLE `name1` ( ... ) ... ; CREATE TABLE `name2` ( ... ) ... ; 
		 */
		function GetSqlMaskParsed($maskname, $replaceKeywords=true)
		{
			global $config;
			$file = INST_RUNFOLDER.$config['mask_folder_name'].DIRECTORY_SEPARATOR.$maskname;

			if(is_file($file) && is_readable($file))
			{
				// The array that will contain the output queries
				$queries = array();
				$buffer = '';
				
				// Split up the file, line by line
				$fileLines = file($file);
				foreach($fileLines as $line)
				{
					// Make sure trim does not remove \n newlines
					$line = trim($line, " \t\r\0\x0B");

					// Ignore if line starts with a comment or is empty
					if(substr($line, 0, 2) == '--' || strlen($line) == 0)
						continue;

					// Add line to buffer
					$buffer .= $line;

					// If there is a semi-colon in the line, and there is a
					// newline after the semi-colon (white spaces ignored)
					// then this is an end of a query
					$pos = strpos($line, ";");		
					if($pos >= 0)
					{
						// While the padding is still within bounds of the line
						$pad = 0;
						while(strlen($line) > ($pos+$pad))
						{
							// If newline found - query ends (if buffer has data)
							if($line[$pos+$pad] == "\n" && strlen(trim($buffer)) > 0)
							{
								$queries[] = trim($buffer); # normally!
								$buffer = "";
								break;
							}

							// Increment pad for next iteration, 
							// but only if it is a white space!
							else if($line[$pos+$pad] == " ")
								$pad++;

							// If neither white-space or newline,
							// this is NOT the end of a query!
							else break;				
						}
					}

				} // End parsing queries

				// If there is something in the buffer, this might be the
				// last query, but there was no newline after the ;
				if(strlen($buffer) > 0)
					$queries[] = trim($buffer);

				// If keywords are to be replaced, replace each query at a time
				if($replaceKeywords)
				{
					foreach($queries as $idx=>$query)
						$queries[$idx] = $this->ReplaceKeywords($query);

					return $queries;
				}
				else
					return $queries;
			}
			else
				return false;

		}

        /********************************[ GET SPESIFIC MASKS ]********************************/
        
        /** 
		 *  Get the welcome message with keywords replaced 
		 */
        function GetWelcomeMessage()
        {
			global $steps;
			return $this->GetMask($steps[STEP_WELCOME]['maskname']);
        }       
        
        /** 
		 *  Get the Terms-Of-Agreement with keywords replaced 
		 */
        function GetTermsOfAgreement()
        {
			global $steps;
			return $this->GetMask($steps[STEP_TERMSOFUSE]['maskname']);
        } 

		/** 
		 *  Get all the configuration files with keywords replaced
		 */
        function GetConfigFiles()
        {
			global $steps;
			$configs = array();

			foreach($steps[STEP_WRITECONFIG]['configs'] as $conf)
			{
				$conf['content'] = $this->GetMask($conf['maskname']);
				$configs[] = $conf;
			}

			return $configs;
        } 

		/** 
		 *  Get the finished message with keywords replaced 
		 */
        function GetFinishedMessage()
        {
			global $steps;
			return $this->GetMask($steps[STEP_FINISHED]['maskname']);
        }  

		/** 
		 *  Get the SQL queries that will create tables for the system
		 */
        function GetSqlInstallQueries($getAsArray=false)
        {
			global $steps;
			global $keywords;
			
			// If the content should be returned normally
			if($getAsArray === false)
			{
				return $this->GetMask($steps[STEP_RUNSQL]['maskname']);
			}

			// The mask should be divided into an array, each element
			// containing a "keyword replaced" query to execute
			else
			{
				return $this->GetSqlMaskParsed($steps[STEP_RUNSQL]['maskname']);
			}
        } 

		/** 
		 *  Get the SQL queries that will be used to insert root access
		 */
        function GetSqlRootAccessQueries($getAsArray=false)
        {
			global $steps;
			global $keywords;
			
			// If the content should be returned normally
			if($getAsArray === false)
			{
				return $this->GetMask($steps[STEP_ROOTUSER]['maskname']);
			}

			// The mask should be divided into an array, each element
			// containing a "keyword replaced" query to execute
			else
			{
				return $this->GetSqlMaskParsed($steps[STEP_ROOTUSER]['maskname']);
			}
        } 
    }
