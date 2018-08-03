<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Services\Formatter;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class FormatScientificTest extends TestCase
{
	/**
	
	* @dataProvider valuesForTests
	
	*/
	public function testformatScientific($input, $expected)
	{
		$formatter = new Formatter();
		$result = $formatter->formatScientific($input);
		
		$this->assertEquals($expected, $result);
	}
	
	public function valuesForTests()
	{
		return [
				[0, 0],
				[0.01234, 1.23e-2],
				[0.01235, 1.24e-2]				
		];
	}
}