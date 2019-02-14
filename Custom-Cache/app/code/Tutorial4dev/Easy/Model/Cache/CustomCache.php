<?php

namespace Tutorial4dev\Easy\Model\Cache;

class CustomCache extends \Magento\Framework\Cache\Frontend\Decorator\TagScope
{
    const TYPE_IDENTIFIER = 'custom_cache';
    const CACHE_TAG = 'CUSTOM_CACHE';


    public function __construct(\Magento\Framework\App\Cache\Type\FrontendPool $cacheFrontendPol)
    {
        parent::__construct($cacheFrontendPol->get(self::TYPE_IDENTIFIER), self::CACHE_TAG);

    }


}