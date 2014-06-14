<?php
/**
 * Tests for World class
 *
 */

require_once('./classes/XMLTest.php');
require_once('./classes/TimestampWriter.php');
require_once('./classes/Common.php');

class XmlUnitTest extends PHPUnit_Framework_TestCase {
	
	
	public function setUp() {
		
		//Just in case the timezone default is not set
		date_default_timezone_set('Europe/London');
		
		
		$this->file = 'TestFile.xml';
		$this->converted_file = 'converted_TestFile.xml';
		
		
	}
	
	
	//XMLTest.php
	
    public function testCanCreateXmlFile() {
		
        $this->assertTrue( XMLTest::create($this->file, 'GMT') );
    }
    
    

    public function testCanConvertXmlFileToPST() {
		
        $this->assertTrue( XMLTest::convert($this->file, 'PST') );
    }
    
    

    public function testDetectRightTimeZone() {
		
		//Correct Timezones
		$this->assertTrue( XMLTest::checkTimezone('GMT') );
		$this->assertTrue( XMLTest::checkTimezone('PST') );
		$this->assertTrue( XMLTest::checkTimezone('America/New_York') );
		$this->assertTrue( XMLTest::checkTimezone('Europe/London') );
		
		//Gibberish 
		$this->assertFalse( XMLTest::checkTimezone('Europe/New_York') );
		$this->assertFalse( XMLTest::checkTimezone('Jupiter') );
		$this->assertFalse( XMLTest::checkTimezone('AppleSouce') );
		$this->assertFalse( XMLTest::checkTimezone('John Wayne') );
		$this->assertFalse( XMLTest::checkTimezone('03858') );
		
    }
    
    
    //Common.php
    
    public function testIsCli() {
	    
	    $this->assertTrue( Common::checkCli() );
    }
    
    
    public function testCheckPrimeNumbers() {
	    
		//Correct PrimeNumbers
		$this->assertTrue( Common::isPrime(2) );
		$this->assertTrue( Common::isPrime(449) );
		$this->assertTrue( Common::isPrime(691) );
		$this->assertTrue( Common::isPrime(997) );
		
		
		//False PrimeNumbers
		$this->assertFalse( Common::isPrime(1) );
		$this->assertFalse( Common::isPrime(224) );
		$this->assertFalse( Common::isPrime(642) );
		$this->assertFalse( Common::isPrime(885) );
	    
	    
    }
    
    
    public function CheckCorrectTimestampsForCreate() {
	    
	    //CorrectGMT Times
	    
	    $correct_times = array(15598800, 47134800, 78757200);
	    
	    XMLTest::create($this->file, 'GMT');
	    
		$xml_file = simplexml_load_file($this->file);
		
		foreach ($xml_file as $line) 
		{
			$times[] = (string)$line['time'];
		}
		
		foreach($correct_times as $t) {
			
			$this->assertTrue( in_array($t, $times) );
		}

    }
    
    
    
    
    public function CheckCorrectTimestampsForConvert() {
	    
	    //CorrectGMT Times
 
	    $correct_times = array(362779200, 394315200, 425851200);
	    
	    //Create in GMT
	    XMLTest::create($this->file, 'GMT');
	    
	    
	    XMLTest::convert($this->file, 'PST');
	    
	    
	    
		$xml_file = simplexml_load_file($this->converted_file);
		
		foreach ($xml_file as $line) 
		{
			$times[] = (string)$line['time'];
		}
		
		foreach($correct_times as $t) {
			
			$this->assertTrue( in_array($t, $times) );
		}

    }
}