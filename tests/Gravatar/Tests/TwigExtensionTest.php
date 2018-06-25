<?php

namespace Gravatar\Tests;

use Gravatar\Service;
use Gravatar\Extension\Twig\GravatarExtension;

use Twig_Environment;
use Twig_Loader_Array;

use PHPUnit\Framework\TestCase;

class TwigExtensionTest extends TestCase
{
    public function testRegisterExtension()
    {
        $twig = new Twig_Environment(new Twig_Loader_Array(array()));
        $gravatarService = new Service();
        $twig->addExtension(new GravatarExtension($gravatarService));

        $this->assertInstanceOf(GravatarExtension::class, $twig->getExtension(GravatarExtension::class));
    }

    public function testRenderGravatarUrl()
    {
        $twig = new Twig_Environment(new Twig_Loader_Array(array(
            'index.html' => '{{gravatar(email, {"size": 50})}}',
        )));

        $gravatarService = new Service();

        $twig->addExtension(new GravatarExtension($gravatarService));

        $url = $twig->render('index.html', array(
            'email' => 'user@example.com'
        ));

        $this->assertEquals('http://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?s=50&r=g', $url);
    }

    public function testRenderGravatarExists()
    {
        $twig = new Twig_Environment(new Twig_Loader_Array(array(
            'exists' => '{{gravatar_exist(email)}}',
        )));

        $gravatarService = new Service();

        $twig->addExtension(new GravatarExtension($gravatarService));

        $this->assertEquals("", $twig->render('exists', array('email' => 'user@example.com')));
        $this->assertEquals("1", $twig->render('exists', array('email' => 'm@michaelheap.com')));
    }

}
