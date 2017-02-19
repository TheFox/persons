<?php

namespace Tests\Unit;

use Tests\TestCase;

class WelcomeControllerTest extends TestCase{
	
	public function testBasic(){
		$response = $this->call('GET', '/');
		$this->assertEquals(200, $response->getStatusCode());
	}
	
}
