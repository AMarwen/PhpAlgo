<?php
//1-testing Class must extend PHPUnit_Framework_TestCase
class MathTests extends PHPUnit_Framework_TestCase {
 
  public function testisPrime()
  {
    //2-create an object of the Class that you want to MathTests
     
    //3-MathTests object method
    $this->assertTrue(   PhpAlgo\Math\isEqFraction( array(1/3,2/6)) );
 
  }
 
  public function testreciprocal(){
       $this->assertEquals( "7/12",PhpAlgo\Math\reciprocal("12/7") );
  }
  
  
}
