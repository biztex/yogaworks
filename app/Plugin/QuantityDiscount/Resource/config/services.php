<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/23
 */

use Plugin\QuantityDiscount\DependencyInjection\Compiler\PurchaseFlowPassEx;

$container->addCompilerPass(new PurchaseFlowPassEx());
