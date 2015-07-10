<?php
//1-testing Class must extend PHPUnit_Framework_TestCase
class MathTests extends PHPUnit_Framework_TestCase {
 
  public function testisPrime()
  {
    //2-create an object of the Class that you want to MathTests
     
    //3-MathTests object method
    $this->assertTrue(   PhpAlgo\Math\isEqFraction( array(1,2/4,20/40)) );
 
  }
 
  public function testreciprocal(){
       $this->assertEquals( "3/4",PhpAlgo\Math\reciprocal("12/7") );
  }
  
  
}
