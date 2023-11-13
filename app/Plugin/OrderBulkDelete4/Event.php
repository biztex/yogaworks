<?php

/*
 * This file is part of OrderBulkDelete4
 *
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 *
 * https://umebius.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\OrderBulkDelete4;

use Eccube\Event\TemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            '@admin/Order/index.twig' => 'onAdminOrderIndexTwig',
        ];
    }

    public function onAdminOrderIndexTwig(TemplateEvent $event)
    {
        $event->addSnippet('@OrderBulkDelete4/admin/Order/index_js.twig');
    }
}
