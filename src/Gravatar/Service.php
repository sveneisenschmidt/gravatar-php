<?php

namespace Gravatar;

/**
 * @see http://de.gravatar.com/site/implement/images/
 */
class Service
{
    /**
     * Service url
     * 
     * @const
     */
    const URL = '%s://www.gravatar.com/avatar/%s';
    
    /**
     * Stands for:
     * Suitable for display on all websites with any audience type.
     * 
     * @const
     */
    const RATING_G = 'g';
    
    /**
     * Stands for:
     * May contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
     * 
     * @const
     */
    const RATING_PG = 'pg';
    
    /**
     * Stands for:
     * May contain such things as harsh profanity, intense violence, nudity, or hard drug use.
     * 
     * @const
     */
    const RATING_R = 'r';
    
    /**
     * Stands for:
     * May contain hardcore sexual imagery or extremely disturbing violence.
     * 
     * @const
     */
    const RATING_X = 'pg';
    
    /**
     * @const
     */
    const DEFAULT_404 = '404';
    
    /**
     * @const
     */
    const DEFAULT_MM = 'mm';
    
    /**
     * @const
     */
    const DEFAULT_IC = 'identicon';
    
    /**
     * @const
     */
    const DEFAULT_MI = 'monsterid';
    
    /**
     * @const
     */
    const DEFAULT_WA = 'wavatar';
    
    /**
     * @const
     */
    const DEFAULT_RETRO = 'retro';
    
    /**
     * @var array
     */
    protected $defaults = array(
        'size'   => 75,
        'rating' => self::RATING_G,
        'secure' => false,
        'default'   => null,
        'force_default' => false
    );
    
    /**
     * @var array
     */
    protected $options = array();
    
    /**
     *
     * @param array $options
     * @return void
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->defaults, $options);
    }
    
    /**
     *
     * @param string $email
     * @param array $options
     * @return string
     */
    public function get($email, array $options = array())
    {
        $options = array_merge($this->options, $options);
        
        $hash    = self::hash($email);
        $params  = array(
            's' => $options['size'],
            'd' => $options['default'],
            'r' => $options['rating'],
            'f' => ($options['force_default'] == true) ? 'y' : null
        );
        
        $url  = vsprintf(self::URL, array($options['secure'] ? 'https' : 'http', $hash));
        $url .= '?' . http_build_query(array_filter($params));
    
        return $url;
    }
    
    /**
     * Original code by Thibault Duplessis
     * see https://github.com/ornicar/GravatarBundle/blob/master/GravatarApi.php
     * 
     * @param string $email
     * @return boolean
     */
    public function exist($email)
    {
        $url   = $this->get($email, array('default' => self::DEFAULT_404));

        $sock = fsockopen('gravatar.com', 80, $errorNo, $error);
        fputs($sock, "HEAD " . $url . " HTTP/1.0\r\n\r\n");
        $header = fgets($sock, 128);
        fclose($sock);

        return  trim($header) == 'HTTP/1.1 404 Not Found' ? false : true;
    }
    
    /**
     *
     * @param string $string
     * @return string
     */
    public static function hash($string)
    {
        return md5(strtolower(chop($string)));
    }
}