<?php

namespace Plugin\ZeusPayment4\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use \Plugin\ZeusPayment4\Validator\Constraints as ZeusPaymentAssert;

/*
 * クレカ決済パラメーター設定画面フォーム定義
 */
class ConfigFormCreditType extends AbstractType
{
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientip', TextType::class, array(
                'label' => '加盟店IPコード',
                'attr' => array(
                    'class' => 'ZeusPayment_config_form',
                    'style' => 'ime-mode:disabled;',
                    'maxlength' => '10',
                ),
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Type(array('type' => 'numeric', 'message' => 'form.type.numeric.invalid')),
                    new ZeusPaymentAssert\OrLength(array('options' => array(5,10))),
                ),
                'required' => true,
            ))
            ->add('clientauthkey', TextType::class, array(
                'label' => '加盟店認証キー',
                'attr' => array(
                    'class' => 'ZeusPayment_config_form',
                    'style' => 'ime-mode:disabled;',
                    'maxlength' => '40',
                ),
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
                'required' => true,
            ));
        //->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ZeusPayment_config_credit';
    }
}
