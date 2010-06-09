<?php

/**
 * Unit tests for request class
 *
 * @group kohana
 *
 * @package    Unittest
 * @author     Kohana Team
 * @author     BRMatt <matthew@sigswitch.com>
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class Kohana_RequestTest extends Kohana_Unittest_TestCase
{
	/**
	 * Route::matches() should return false if the route doesn't match against a uri
	 *
	 * @test
	 */
	function testCreate()
	{
		$request = Request::factory('foo/bar')->execute();

		$this->assertEquals(200, $request->status);
		$this->assertEquals('foo', $request->response);

		try
		{
			$request = new Request('bar/foo');
			$request->execute();
		}
		catch (Exception $e)
		{
			$this->assertEquals(TRUE, $e instanceof ReflectionException);
			$this->assertEquals('404', $request->status);
		}
	}

	function testAcceptType()
	{
		$this->assertEquals(array('*/*' => 1), Request::accept_type());
	}
}

class Controller_Foo extends Controller {
	public function action_bar()
	{
		$this->request->response = 'foo';
	}
}