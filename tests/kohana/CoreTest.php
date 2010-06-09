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
			array('classes', 'date', SYSPATH.'classes/date.php'),
			array('views', 'kohana/error', SYSPATH.'views/kohana/error.php'),
			array('config', 'credit_cards', array(SYSPATH.'config/credit_cards.php', SYSPATH.'config/credit_cards.php'))// Why is this set twice?
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
		$this->assertSame($result, Kohana::find_file($folder, $class));
	}

	/**
	 * Provides test data for testListFiles()
	 * 
	 * @return array
	 */
	function providerListFiles()
	{
		return array(
			// $folder, $result
			array('i18n', array(
				'i18n/en.php' => SYSPATH.'i18n/en.php',
				'i18n/es.php' => SYSPATH.'i18n/es.php',
				'i18n/fr.php' => SYSPATH.'i18n/fr.php',
			)),
			array('messages', array(
				'messages/validate.php' => SYSPATH.'messages/validate.php'
			)),
		);
	}

	/**
	 * Tests Kohana::list_files()
	 *
	 * @test
	 * @dataProvider providerListFiles
	 * @param boolean $folder Input for Kohana::list_files
	 * @param boolean $result Output for Kohana::list_files
	 */
	function testListFiles($folder, $result)
	{
		$this->assertSame($result, Kohana::list_files($folder));
	}
}