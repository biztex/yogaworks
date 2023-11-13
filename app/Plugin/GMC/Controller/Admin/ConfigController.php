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

namespace Plugin\GMC\Controller\Admin;

use Eccube\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    /**
     * @Route("/%eccube_admin_route%/gmc/config", name="gmc_admin_config")
     * @Template("@GMC/admin/config.twig")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(FormType::class);

        return [
            'form' => $form->createView(),
            'gmc_proxy_url' => env('GMC_PROXY_URL', $this->eccubeConfig['gmc_proxy_url']),
        ];
    }
}
