<?php

namespace Plugin\ZeusPayment4\Form\Type\Admin;

use \Plugin\ZeusPayment4\Validator\Constraints as ZeusPaymentAssert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Eccube\Common\EccubeConfig;

/*
 * 銀行振込決済パラメーター設定画面フォーム定義
 */
class ConfigFormEbankType extends AbstractType
{
    private $eccubeConfig;

    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('clientip_ebank', TextType::class, array(
            'label' => '加盟店IPコード',
            'attr' => array(
                'class' => 'ZeusPayment_config_form',
                'style' => 'ime-mode:disabled;',
                'maxlength' => '10'
            ),
            'constraints' => array(
                new Assert\Type(array(
                    'type' => 'numeric',
                    'message' => 'form.type.numeric.invalid'
                )),
                new ZeusPaymentAssert\OrLength(array(
                    'options' => array(
                        5,
                        10
                    )
                ))
            ),
            'required' => true
        ))
            ->add('ebank_siteurl', TextType::class, array(
            'label' => '完了ページ戻りURL(PC/スマートフォン用)',
            'attr' => array(
                'class' => 'ZeusPayment_config_form',
                'style' => 'ime-mode:disabled;',
                'maxlength' => '256'
            ),
            'constraints' => array(
                new Assert\Url()
            ),
            'required' => false
        ))
            ->add('ebank_sitestr', TextType::class, array(
            'label' => '完了ページ戻りURL文言(PC/スマートフォン用)',
            'attr' => array(
                'class' => 'ZeusPayment_config_form',
                'maxlength' => '256'
            ),
            'constraints' => array(
                new Assert\Regex(array(
                    'pattern' => '/[\!-\/:-@\[-`\{-~]/',
                    'match' => false,
                    'message' => '完了ページ戻りURLの文言に、半角記号はご利用できません。',
                )),
            ),
            'required' => false
        ));
        //    ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ZeusPayment_config_ebank';
    }
}
