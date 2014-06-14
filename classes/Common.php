<?php




	/**
	 * Common.php 
	 * 
	 * Simple Helper Class with common functions
	 * 
	 * @file		helper.php
	 * @path		classes/helper/common.php
	 * @date		14/06/2014/
	*/




class Common
{
		
		/**
		 * Check if the current session is running in a Command line or not.
		 * 
		 * @access public
		 * @static
		 * @return bool
		 */
		public static function checkCli() 
		{
               return ( php_sapi_name() === 'cli' );
        }
        
        
        
        
        
        /**
         * CHeck if the number is prime
         * 
         * @access public
         * @static
         * @param int $number (default: 1)
         * @return void
         */
        public static function isPrime($number = 1) 
        {
	        // 1 is not prime
		    if ( $number == 1 ) {
		        return false;
		    }
		    // 2 is the only even prime number
		    if ( $number == 2 ) {
		        return true;
		    }
		    // square root algorithm speeds up testing of bigger prime numbers
		    $x = floor(sqrt($number));
		    for ( $i = 2 ; $i <= $x ; ++$i ) {
		        if ( $number % $i == 0 ) {
		            break;
		        }
		    }
		    
		    return ( $x == $i-1 ? true : false );
	        
        }

        
        
        
        /**
         * Style the command line a little bit.
         * 
         * @access public
         * @static
         * @param string $string (default: '')
         * @param string $color (default: 'white')
         * @return void
         */
        public static function cliWrite($string = '', $color = 'white') 
        {
			
			// Set up shell colors
			$colors = array(
						'black' 		=> '0;30',
						'dark_gray' 	=> '1;30',
						'blue' 			=> '0;34',
						'light_blue' 	=> '1;34',
						'green' 		=> '0;32',
						'light_green' 	=> '1;32',
						'cyan' 			=> '0;36',
						'light_cyan' 	=> '1;36',
						'red' 			=> '0;31',
						'light_red' 	=> '1;31',
						'purple' 		=> '0;35',
						'light_purple' 	=> '1;35',
						'brown' 		=> '0;33',
						'yellow' 		=> '1;33',
						'light_gray' 	=> '0;37',
						'white' 		=> '1;37'
						);
			
			//Check if the color exits
			if( isset($colors[$color]) ) {
				echo "\033[" . $colors[$color] . "m" . $string . "\033[0m " . PHP_EOL;
			} else {
				//No color Defined.. Just return String
				echo $string . PHP_EOL;
			}
			
		}

}