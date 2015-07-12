<?php
//1-testing Class must extend PHPUnit_Framework_TestCase
class ArrayTests extends PHPUnit_Framework_TestCase {
 
  public function testisPrime()
  {
    //2-create an object of the Class that you want to MathTests
     
    //3-MathTests object method
    $this->assertTrue(   PhpAlgo\Arr\isSameVal(array(1,1,1)) );
 
  }
  
}
