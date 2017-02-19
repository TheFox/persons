<?php

namespace Tests\Unit;

use Tests\TestCase;

class HomeControllerTest extends TestCase{
	
	public function testBasic(){
		$response = $this->call('GET', '/home');
		$this->assertEquals(302, $response->getStatusCode());
	}
	
}
