<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/23
 */

namespace Plugin\QuantityDiscount\DependencyInjection\Compiler;


use Eccube\Service\PurchaseFlow\Processor\DeliveryFeeFreeByShippingPreprocessor;
use Eccube\Service\PurchaseFlow\Processor\PointProcessor;
use Eccube\Service\PurchaseFlow\Processor\TaxProcessor;
use Plugin\QuantityDiscount\Service\PurchaseFlow\Processor\PriceResetShippingPreprocessor;
use Plugin\QuantityDiscount\Service\PurchaseFlow\Processor\PriceResetValidator;
use Plugin\QuantityDiscount\Service\PurchaseFlow\Processor\QuantityDiscountDiscountProcessor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PurchaseFlowPassEx implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {

        $plugins = $container->getParameter('eccube.plugins.enabled');

        if (empty($plugins)) {
            $container->log($this, 'enabled plugins not found.');
            return;
        }

        $pluginsCheck = array_flip($plugins);

        if(isset($pluginsCheck['QuantityDiscount'])) {

            $this->addPriceResetValidator($container);

            $this->addPriceResetShippingPreprocessor($container);

            $this->addQuantityDiscountDiscountProcessor($container);
        }

    }

    /**
     * @param ContainerBuilder $container
     */
    private function addPriceResetValidator(ContainerBuilder $container)
    {
        $validatorsAddList = [
            'eccube.purchase.flow.cart.item_validators',
            'eccube.purchase.flow.shopping.item_validators',
        ];

        foreach ($validatorsAddList as $addKey) {
            $definition = $container->getDefinition($addKey);
            $itemValidators = $definition->getArgument(0);

            // 先頭に追加
            array_unshift(
                $itemValidators,
                new Reference(PriceResetValidator::class)
            );

            $definition->setArgument(0, $itemValidators);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addPriceResetShippingPreprocessor(ContainerBuilder $container)
    {
        $holderPreprocessorsAddList = [
            'eccube.purchase.flow.shopping.holder_preprocessors',
        ];

        foreach ($holderPreprocessorsAddList as $addKey) {
            $definition = $container->getDefinition($addKey);
            $itemValidators = $definition->getArgument(0);

            $taxIndex = -1;
            $feeFreeIndex = -1;
            $index = 0;

            /** @var Reference $itemValidator */
            foreach ($itemValidators as $itemValidator) {
                if(TaxProcessor::class == $itemValidator->__toString()) {
                    // 最後に見つかったもの
                    $taxIndex = $index;
                }
                if(DeliveryFeeFreeByShippingPreprocessor::class == $itemValidator->__toString()) {
                    if($feeFreeIndex == -1) {
                        $feeFreeIndex = $index;
                    }
                }
                $index++;
            }

            if($feeFreeIndex >= 0) {
                if($feeFreeIndex + 1 == $index) {
                    // 最後に追加
                    $itemValidators[] = new Reference(PriceResetShippingPreprocessor::class);
                    $itemValidators[] = new Reference(TaxProcessor::class);
                } else {
                    array_splice(
                        $itemValidators,
                        $feeFreeIndex + 1,
                        0,
                        [new Reference(PriceResetShippingPreprocessor::class)]
                    );
                }
            } elseif ($taxIndex >= 0) {
                array_splice(
                    $itemValidators,
                    $taxIndex,
                    0,
                    [new Reference(PriceResetShippingPreprocessor::class)]
                );
            } else {
                // 最後に追加
                $itemValidators[] = new Reference(PriceResetShippingPreprocessor::class);
                $itemValidators[] = new Reference(TaxProcessor::class);
            }

            $definition->setArgument(0, $itemValidators);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addQuantityDiscountDiscountProcessor(ContainerBuilder $container)
    {
        $purchaseAddList = [
            'eccube.purchase.flow.shopping.discount_processors',
        ];

        foreach ($purchaseAddList as $addKey) {
            $definition = $container->getDefinition($addKey);
            $itemValidators = $definition->getArgument(0);

            $index = 0;

            /** @var Reference $itemValidator */
            foreach ($itemValidators as $itemValidator) {
                if (PointProcessor::class == $itemValidator->__toString()) {
                    break;
                }
                $index++;
            }

            if ($index > 0 && $index == count($itemValidators)) {
                // 先頭に追加
                array_unshift(
                    $itemValidators,
                    new Reference(QuantityDiscountDiscountProcessor::class)
                );
            } else {
                // PointProcessorの前に追加
                array_splice(
                    $itemValidators,
                    $index,
                    0,
                    [new Reference(QuantityDiscountDiscountProcessor::class)]
                );
            }

            $definition->setArgument(0, $itemValidators);
        }
    }

}
