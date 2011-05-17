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
            'gravatar'          => new \Twig_Function_Method($this, 'get'),
            'gravatar_exists'   => new \Twig_Function_Method($this, 'exists'),
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
    public function exists($email)
    {
        return $this->service->exists($email);
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
