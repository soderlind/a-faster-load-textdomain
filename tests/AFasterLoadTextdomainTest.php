<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class AFasterLoadTextdomainTest extends TestCase {
	public function test_load_textdomain() {
		// Set up test data.
		$domain = 'my-plugin';
		$mofile = '/path/to/my-plugin.mo';
		$locale = 'en_US';

		// Mock the `is_readable` function to return true.
		$this->assertTrue( function_exists( 'is_readable' ) );
		$mock_is_readable = $this->getMockBuilder( 'stdClass' )
								 ->setMethods( [ 'is_readable' ] )
								 ->getMock();
		$mock_is_readable->expects( $this->once() )
						 ->method( 'is_readable' )
						 ->with( $mofile )
						 ->willReturn( true );
		$this->assertTrue( $mock_is_readable->is_readable( $mofile ) );

		// Mock the `get_transient` function to return null.
		$this->assertTrue( function_exists( 'get_transient' ) );
		$mock_get_transient = $this->getMockBuilder( 'stdClass' )
								   ->setMethods( [ 'get_transient' ] )
								   ->getMock();
		$mock_get_transient->expects( $this->once() )
						   ->method( 'get_transient' )
						   ->with( md5( $mofile ) )
						   ->willReturn( null );
		$this->assertNull( $mock_get_transient->get_transient( md5( $mofile ) ) );

		// Mock the `filemtime` function to return the current time.
		$this->assertTrue( function_exists( 'filemtime' ) );
		$mock_filemtime = $this->getMockBuilder( 'stdClass' )
							  ->setMethods( [ 'filemtime' ] )
							  ->getMock();
		$mock_filemtime->expects( $this->once() )
					   ->method( 'filemtime' )
					   ->with( $mofile )
					   ->willReturn( time() );
		$this->assertEquals( time(), $mock_filemtime->filemtime( $mofile ) );

		// Mock the `set_transient` function to return true.
		$this->assertTrue( function_exists( 'set_transient' ) );
		$mock_set_transient = $this->getMockBuilder( 'stdClass' )
								   ->setMethods( [ 'set_transient' ] )
								   ->getMock();
		$mock_set_transient->expects( $this->once() )
						   ->method( 'set_transient' )
						   ->with( md5( $mofile ), $this->anything() )
						   ->willReturn( true );
		$this->assertTrue( $mock_set_transient->set_transient( md5( $mofile ), [] ) );

		// Call the function and assert that it returns true.
		$this->assertTrue( a_faster_load_textdomain( null, $domain, $mofile, $locale ) );
	}
}
