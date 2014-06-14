<?php



	/**
	 * XMLTest.php 
	 * 
	 * XML Testing Class for the purpose of this test
	 * 
	 * @file		XMLTest.php
	 * @path		classes/XMLTest.php
	 * 
	*/




class XMLTest
{
	
	protected static $timezones = [];
	
	/**
	 * Create the XML document.
	 * 
	 * @access public
	 * @static
	 * @param mixed $file
	 * @param mixed $timezone
	 * @param bool $exlude_prime (default: true)
	 * @return void
	 */
	public static function create($file, $timezone, $exlude_prime = true) {
		// Load Writer
		$xml = new TimestampWriter();
		$xml->exclude_prime = $exlude_prime;

        //Loop the years from EPOCH and set it to the correct datetime
        foreach(range(1970, date('Y')) as $year) 
        {
        	$xml->addTime('30th June '.$year.' 1PM', $timezone);
        }
        
        //Get the document that was generated
        if($file_data = $xml->getdocument()) 
        {
        	//If we cant write then whats the point?
        	if(! file_put_contents($file, $file_data) ) {
        		throw new Exception('File Could Not be saved');
        	}
        	
        } else {
	        
	        throw new Exception('The document could not be retrieved from the parser');
        }
        
        
		//Return true ... since no exceptions were thrown
		return true;
	}
	
	
	
	
	/**
	 * Convert the XML document.
	 * 
	 * @access public
	 * @static
	 * @param mixed $file
	 * @param mixed $timezone
	 * @param bool $exlude_prime (default: true)
	 * @return void
	 */
	public static function convert($file, $timezone, $exlude_prime = true) {
		
		
		
		
		// Load the file
		if( ! $xml_file = @simplexml_load_file($file) ) {
			throw new Exception('File: '.$file.' Could Not be Loaded ');
		}
		
		
		// Load Writer
		$xml = new TimestampWriter();
		$xml->exclude_prime = $exlude_prime;
		
		
		//Load Old times
		$times = array();
		foreach ($xml_file as $line) 
		{
			$times[] = (string)$line['text'];
		}
		
		// Reverse order and loop through timestamp array
		foreach ($times as $time) 
		{
			$xml->addTime($time, $timezone);
		}
		
		//Get the document that was generated and save it as a converted document
        if($file_data = $xml->getdocument()) 
        {
        	$file_name = 'convert_' . $file;
        	
        	//If we cant write then whats the point?
        	if(! file_put_contents($file_name, $file_data) ) {
        		throw new Exception('File Could Not be saved');
        	}
        	
        } else {
	        
	        throw new Exception('The document could not be retrieved from the parser');
        }
        
		//Return true ... since no exceptions were thrown
		return true;

	}
	
	
	/**
	 * Simple Display of the CLI Guide.
	 * 
	 * @access public
	 * @static
	 * @param bool $notice (default: false)
	 * @return void
	 */
	public static function guide($notice = false) 
	{
		
		Common::cliWrite("\nTimeStamp XML parser\n", 'green');
		
		//Are we writing a Error notice with the guide?
		if( $notice ) 
		{
			Common::cliWrite('-------------------------------', 'red');
		    Common::cliWrite($notice, 'red');
			Common::cliWrite('-------------------------------', 'red');
		}
		
		Common::cliWrite("\nUSAGE:\n", 'yellow');
		Common::cliWrite('FILENAME: GMT.xml');
		Common::cliWrite('TIMEZONE: GMT (optional, default GMT)');
		Common::cliWrite('EXCLUDE_PRIME_YEARS: true (optional, default true)');
		Common::cliWrite("- php console xml:create {FILENAME} {TIMEZONE?} {EXCLUDE_PRIME_YEARS?}\n", 'yellow');
		
		Common::cliWrite('FILENAME: GMT.xml');
		Common::cliWrite('TIMEZONE: PST');
		Common::cliWrite('EXCLUDE_PRIME_YEARS: false (optional, default true)');
		Common::cliWrite("- php console xml:convert {FILENAME} {TIMEZONE} {EXCLUDE_PRIME_YEARS?}\n", 'yellow');
		
	}
	
	
	/**
	 * Check if the supplied timezon is correct.
	 * 
	 * @access public
	 * @static
	 * @param mixed $timezone
	 * @return bool
	 */
	public static function checkTimezone($timezone) {
		
		//Since we are going to use this often.. lets just move it to the memory
		if(count(static::$timezones) == 0) 
		{	
			//Need to get All Timezones Loaded so we know whats going on
			$time_zones = timezone_abbreviations_list();
			
			//Load DateTime class
			$datetime = new DateTime('now');
			
			foreach ($time_zones as $key => $time_zone_array) 
			{
			    foreach ($time_zone_array as $key => $info) 
			    {
			    	
			        if(empty($info['timezone_id'])) continue;
			        
			        $datetime->setTimeZone(new DateTimeZone($info['timezone_id']));
			        
			        $abbreviation = $datetime->format('T');
			        
			        if (!in_array($abbreviation, array_keys(static::$timezones))) 
			        {
			            static::$timezones[$abbreviation] = $info['timezone_id'];
			        }
			    }
			}
			
		}
		
		//Check If its a acronym first
		if( in_array( $timezone, array_keys(static::$timezones) )) 
		{
			return true;
		}
		
		
		//Hm.. looks like its not.. lets try it the other way then
		$dateTime = new DateTime('now');
		try
		{
			$dateTime->setTimeZone(new DateTimeZone($timezone));
			
			return true;
		
		} catch (Exception $e)
		{
			//Ok its not... forget it then
			return false;
			
		}
	    
	}
}