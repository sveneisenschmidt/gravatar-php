<?php

namespace Gravatar\Extension\Twig;

use Gravatar\Service;

class GravatarExtension extends \Twig_Extension
{
    /**
     * @var Gravatar\Service $service
     */
    protected $service;

    /**
     * @param Gravatar\Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getFunctions()
    {
        return array(
            'gravatar'          => new \Twig_Function('gravatar', array($this, 'get'), array('is_safe' => array('html'))),
            'gravatar_exist'    => new \Twig_Function('gravatar_exist', array($this, 'exist')),
        );
    }
    
    /**
     *
     * @param string $email
     * @param array $options
     * @return string
     */
    public function get($email, array $options = array())
    {
        return $this->service->get($email, $options);
    }
    
    /**
     *
     * @param string $email
     * @return boolean
     */
    public function exist($email)
    {
        return $this->service->exist($email);
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return 'gravatar';
    }
}
