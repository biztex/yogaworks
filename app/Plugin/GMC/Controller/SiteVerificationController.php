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

namespace Plugin\GMC\Controller;

use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SiteVerificationController extends AbstractController
{
    public function verifyUrl()
    {
        $verificationFile = $this->eccubeConfig['plugin_data_realdir']."/GMC/google-site-verification.txt";
        if (file_exists($verificationFile)) {
            return new BinaryFileResponse($verificationFile);
        }
        throw new NotFoundHttpException();
    }
}
