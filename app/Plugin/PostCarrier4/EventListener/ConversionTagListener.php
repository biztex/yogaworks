<?php

/*
 * This file is part of PostCarrier for EC-CUBE
 *
 * Copyright(c) IPLOGIC CO.,LTD. All Rights Reserved.
 *
 * http://www.iplogic.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PostCarrier4\EventListener;

use Eccube\Event\TemplateEvent;
use Plugin\PostCarrier4\Repository\PostCarrierConfigRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConversionTagListener implements EventSubscriberInterface
{
    /**
     * @var PostCarrierConfigRepository
     */
    protected $configRepository;

    /**
     * ConversionTagListener constructor.
     *
     * @param PostCarrierConfigRepository $configRepository
     */
    public function __construct(PostCarrierConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function shopping_complete(TemplateEvent $event)
    {
        $event->addSnippet('@PostCarrier4/cv.twig');
    }

    public static function getSubscribedEvents()
    {
        return [
            'Shopping/complete.twig' => 'shopping_complete',
        ];
    }
}
