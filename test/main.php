<?php
include 'backend/_api/get_metrics/helpers.php';

class HelpersTest extends PHPUnit_Framework_TestCase {
  public function testReduceArrayOne() {
    $input = [[1476364219000,1]];
    $result = reduce_array($input, 1);
    $this->assertEquals($input, $result);
  }
  public function testReduceArrayTwo() {
    $input = [[1476364219000,1],[1476364220000,2]];
    $result = reduce_array($input, 1);
    $this->assertEquals(Array($input[0]), $result);
  }
  public function testReduceArrayThree() {
    $input = [[1476364219000,1],[1476364220000,2]];
    $result = reduce_array($input, 2);
    $this->assertEquals($input, $result);
  }
  public function testReduceArrayFour() {
    $input = [[1476364219000,1],[1476364220000,2],[1476364221000,3],[1476364222000,4]];
    $result = reduce_array($input, 2);
    $this->assertEquals(Array($input[0],$input[2]), $result);
  }
  public function testReduceArrayFive() {
    $input = [[1476364219000,1],[1476364220000,2],[1476364221000,3],[1476364222000,4]];
    $result = reduce_array($input, 3);
    $this->assertEquals(Array($input[0],$input[2],$input[3]), $result);
  }
}
