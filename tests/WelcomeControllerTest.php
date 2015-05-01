<?php

class WelcomeControllerTest extends TestCase{
	
	public function testBasic(){
		$response = $this->call('GET', '/');
		$this->assertEquals(200, $response->getStatusCode());
	}
	
}
