<?php

/*
 * Plugin Name: JoolenPointsForMemberRegistration4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPointsForMemberRegistration4\Form\Extension;

use Eccube\Common\EccubeConfig;
use Eccube\Form\Type\Admin\ShopMasterType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;

class ShopMasterTypeExtension extends AbstractTypeExtension
{
    public function __construct(
        EccubeConfig $eccubeConfig
    ) {
        $this->eccubeConfig = $eccubeConfig;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('member_registration_point', NumberType::class, [
                'label' => 'admin.setting.shop.shop.member_registration_point',
                'mapped' => true,
                'required' => true,
                'constraints' => [
                    new Assert\Range(['min' => 0, 'max' => 99999]),
                    new Assert\Regex([
                        'pattern' => "/^\d+$/u",
                        'message' => 'form_error.numeric_only',
                    ]),
                ],
            ])
        ;

        // 日付期間 系formの置き換え ＆ 新規追加
        // ・日付期間 系form情報一覧
        $formDatas = [
            // 変更期間
            [
                'start' => [
                    'form'   => 'apply_datetime_start',
                    'label'  => '変更期間（開始）',
                    'method' => 'getApplyDatetimeStart',
                ],
                'end' => [
                    'form'   => 'apply_datetime_end',
                    'label'  => '変更期間（終了）',
                    'method' => 'getApplyDatetimeEnd',
                ],
                // 期間のバリデーションを実行[する:true]
                'doValidate' => true,
            ]
        ];

        // 日付期間フォームの追加
        $builder = $this->addDateTimeForm($builder, $formDatas);
    }

    /**
     * 日付期間フォームの追加
     */
    private function addDateTimeForm($builder, $formDatas)
    {
        foreach ($formDatas as $formDataStartEnd) {

            // formの設置
            foreach ($formDataStartEnd as $type => $formData) {
                // form名
                $formName = isset($formData['form'])  ? $formData['form']  : null;
                if (!$formName) {
                    continue;
                }
                // label
                $label    = isset($formData['label']) ? $formData['label'] : null;

                // formの設置
                $builder
                    ->add($formName, DateType::class, [
                        'label' => $label,
                        'required' => false,
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'yyyy-MM-dd',
                        'attr' => [
                            'class' => 'datetimepicker-input',
                            'data-target' => '#' . $this->getBlockPrefix() . '_' . $formName,
                            'data-toggle' => 'datetimepicker',
                        ],
                    ]);
            }

            // バリデーションの設置
            // ・開始日のメソッド名
            $methodStart  = isset($formDataStartEnd['start']['method']) ? $formDataStartEnd['start']['method'] : null;
            // ・終了日のメソッド名
            $methodEnd    = isset($formDataStartEnd['end']['method'])   ? $formDataStartEnd['end']['method']   : null;
            // ・エラーを設置するための代表のform名
            $formNameMain = isset($formDataStartEnd['start']['form'])   ? $formDataStartEnd['start']['form']   : null;
            // ・期間のバリデーションを実施[する:true / しない:false]
            $doValidate   = isset($formDataStartEnd['doValidate'])      ? $formDataStartEnd['doValidate']      : false;

            // ・バリデーションの設置
            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($methodStart, $methodEnd, $formNameMain, $doValidate) {
                $Config = $event->getData();
                $form   = $event->getForm();

                // 開始日 が 終了日 より[未来]だとNG
                if ($doValidate) {
                    // 期間のバリデーションを実施する場合
                    $DateTimeStart = $Config->$methodStart();
                    $DateTimeEnd = $Config->$methodEnd();
                    if ($DateTimeStart && $DateTimeEnd && $DateTimeEnd < $DateTimeStart) {
                        // 期間の指定が不正な場合: 代表で開始日の方にエラーをセットする
                        $form[$formNameMain]->addError(new FormError('開始日と終了日の組み合わせが不正です'));
                    }
                }
            })
            ;

        }
        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shop_master';
    }

    /**
     * 4.0用
     *
     * @return string
     */
    public function getExtendedType()
    {
        return ShopMasterType::class;
    }

    /**
     * 4.1用
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable {
        return [ShopMasterType::class];
    }
}
