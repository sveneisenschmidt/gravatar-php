<?php

namespace Gravatar\Tests;

use Gravatar\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceUrl()
    {
        $service = new Service(array(
            'size' => 999,
            'rating' => Service::RATING_PG,
            'default' => Service::DEFAULT_MM
        ));

        $url = $service->get('sven.eisenschmidt@gmail.com', array(
            'size' => 666,
            'default' => Service::DEFAULT_MI,
            'secure'  => true
        ));
            
        $this->assertContains('https://', $url);
        $this->assertContains('r=pg', $url);
        $this->assertContains('s=666', $url);
        $this->assertContains('d=monsterid', $url);
    }
    
    public function testServiceExist()
    {
        $service = new Service();
        
        $this->assertTrue($service->exist('sven.eisenschmidt@gmail.com'));
        $this->assertFalse($service->exist(time() . '@wonder.land'));
    }
}