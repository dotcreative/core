<?php

/**
 * Tests Kohana Core
 *
 * @group kohana
 * @group kohana.url
 *
 * @package    Unittest
 * @author     Kohana Team
 * @author     Jeremy Bush <contractfrombelow@gmail.com>
 * @copyright  (c) 2008-2010 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class Kohana_CoreTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Provides test data for testSanitize()
	 * 
	 * @return array
	 */
	function providerSanitize()
	{
		return array(
			// $value, $result
			array('foo', 'foo'),
			array("foo\r\nbar", "foo\nbar"),
			array("foo\rbar", "foo\nbar"),
			array("Is your name O\'reilly?", "Is your name O'reilly?")
		);
	}

	/**
	 * Tests Kohana::santize()
	 *
	 * @test
	 * @dataProvider providerSanitize
	 * @param boolean $value  Input for Kohana::sanitize
	 * @param boolean $result Output for Kohana::sanitize
	 */
	function testSanitize($value, $result)
	{
		$old_quotes = Kohana::$magic_quotes;
		Kohana::$magic_quotes = TRUE;

		$this->assertSame($result, Kohana::sanitize($value));

		Kohana::$magic_quotes = $old_quotes;
	}

	/**
	 * Provides test data for testSanitize()
	 * 
	 * @return array
	 */
	function providerFindFile()
	{
		return array(
			// $folder, $class, $result
			array('classes', 'foo', FALSE),
			array('classes', 'date', TRUE),
			array('views', 'kohana/error', TRUE)
		);
	}

	/**
	 * Tests Kohana::santize()
	 *
	 * @test
	 * @dataProvider providerFindFile
	 * @param boolean $value  Input for Kohana::auto_load
	 * @param boolean $result Output for Kohana::auto_load
	 */
	function testFindFile($folder, $class, $result)
	{
		$this->assertSame($result, (bool) Kohana::find_file($folder, $class));
	}
}