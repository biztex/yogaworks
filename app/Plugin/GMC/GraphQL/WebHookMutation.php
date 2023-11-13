<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GMC\GraphQL;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use GraphQL\Type\Definition\Type;
use Plugin\Api\Entity\WebHook;
use Plugin\Api\GraphQL\Mutation;
use Plugin\Api\Repository\WebHookRepository;

class WebHookMutation implements Mutation
{
    /**
     * @var WebHookRepository
     */
    private $webHookRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;

    /**
     * WebHookMutation constructor.
     */
    public function __construct(WebHookRepository $webHookRepository, EntityManagerInterface $entityManager, EccubeConfig $eccubeConfig)
    {
        $this->webHookRepository = $webHookRepository;
        $this->entityManager = $entityManager;
        $this->eccubeConfig = $eccubeConfig;
    }

    public function getName()
    {
        return 'gmc_save_webhook';
    }

    public function getMutation()
    {
        return [
            'type' => Type::string(),
            'args' => [
                'secret' => [
                    'type' => Type::nonNull(Type::string()),
                ],
            ],
            'resolve' => [$this, 'saveWebHook'],
        ];
    }

    public function saveWebHook($root, $args)
    {
        $payloadUrl = env('GMC_PROXY_URL', $this->eccubeConfig['gmc_proxy_url']).'/eccube/webhook';
        $WebHook = $this->webHookRepository->findOneBy(['payloadUrl' => $payloadUrl]);
        if (!$WebHook) {
            $WebHook = new WebHook();
            $WebHook->setPayloadUrl($payloadUrl);
            $WebHook->setEnabled(true);
        }
        $WebHook->setSecret($args['secret']);
        $this->webHookRepository->save($WebHook);
        $this->entityManager->flush();

        return $WebHook->getSecret();
    }
}
