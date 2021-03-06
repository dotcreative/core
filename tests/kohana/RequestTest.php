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

	/**
	 * Provides test data for testInstance()
	 * 
	 * @return array
	 */
	function providerInstance()
	{
		return array(
			// $route, $is_cli, $_server, $status, $response
			array('foo/bar', TRUE, array(), 200, ''), // Shouldn't this be 'foo' ?
			array('foo/foo', TRUE, array(), 200, ''), // Shouldn't this be a 404?
			array(
				'foo/bar',
				FALSE,
				array(
					'REQUEST_METHOD' => 'get',
					'HTTP_REFERER' => 'http://www.kohanaframework.org',
					'HTTP_USER_AGENT' => 'Kohana Unit Test',
					'REMOTE_ADDR' => '127.0.0.1',
				), 200, ''), // Shouldn't this be 'foo' ?
		);
	}

	/**
	 * Tests Request::instance()
	 *
	 * @test
	 * @dataProvider providerInstance
	 * @param boolean $value  Input for Kohana::sanitize
	 * @param boolean $result Output for Kohana::sanitize
	 */
	function testInstance($route, $is_cli, $server, $status, $response)
	{
		$old_server = $_SERVER;
		$_SERVER = $server+array('argc' => $old_server['argc']);
		Kohana::$is_cli = $is_cli;
		Request::$instance = NULL;
		$request = Request::instance($route);

		$this->assertEquals($status, $request->status);
		$this->assertEquals($response, $request->response);
		$this->assertEquals($route, $request->uri);

		if ( ! $is_cli)
		{
			$this->assertEquals($server['REQUEST_METHOD'], Request::$method);
			$this->assertEquals($server['HTTP_REFERER'], Request::$referrer);
			$this->assertEquals($server['HTTP_USER_AGENT'], Request::$user_agent);
		}
		Request::$instance = NULL;
		Kohana::$is_cli = TRUE;
		$_SERVER = $old_server;
	}
}

class Controller_Foo extends Controller {
	public function action_bar()
	{
		$this->request->response = 'foo';
	}
}