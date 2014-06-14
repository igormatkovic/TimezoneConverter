<?php


	/**
	 * TimestampWriter.php 
	 * 
	 * Manipulate XML data
	 * 
	 * @file		TimestampWritter.php
	 * @path		classes/TimestampWritter.php
	 * @date		14/06/2014/
	*/


class TimestampWriter extends XMLWriter
{

	protected $datetime = '';
	
	public $exclude_prime = true;

       
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->openMemory();
         $this->setIndent(true);
		 $this->startDocument('1.0', 'UTF-8');
		 $this->startElement('timestamps');
	}

	/**
	 * addTime to the XMl document.
	 * 
	 * @access public
	 * @param mixed $time
	 * @param string $timezone (default: 'GMT')
	 * @return void
	 */
	public function addTime($time, $timezone = 'GMT') {
	
		$this->datetime = new DateTime($time, new DateTimeZone($timezone));
		       
		//Check if we want the primer years
		if ( $this->exclude_prime && Common::isPrime( $this->datetime->format('Y'))) return;
                
                
		$this->startElement('timestamp');
		$this->writeAttribute('time', $this->datetime->getTimestamp());
		$this->writeAttribute('text', $this->datetime->format('Y-m-d H:i:s'));
		$this->endElement();
	}
	
	
    
	/**
	 * Get the generated document out of the Memory.
	 * 
	 * @access public
	 * @return string
	 */
	public function getDocument() 
	{
	    
	    $this->endElement();
	    $this->endDocument();
	    
	    return $this->outputMemory();
	}
        
}