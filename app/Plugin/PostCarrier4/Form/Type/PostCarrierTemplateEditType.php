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

/*
 * メルマガテンプレート設定用
 */

namespace Plugin\PostCarrier4\Form\Type;

use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PostCarrierTemplateEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['d__kind']) {
        case 1:
            $choices = ['名前' => '{name}', 'メールアドレス' => '{email}', 'ポイント' => '{point}', '会員ID' => '{id}'];
            break;
        case 2:
            $choices = ['メールアドレス' => '{email}', '自由項目1' => '{memo01}', '自由項目2' => '{memo02}', '自由項目3' => '{memo03}', '自由項目4' => '{memo04}', '自由項目5' => '{memo05}', '自由項目6' => '{memo06}', '自由項目7' => '{memo07}', '自由項目8' => '{memo08}', '自由項目9' => '{memo09}', '自由項目10' => '{memo10}'];
            break;
        case 3:
            $choices = ['メールアドレス' => '{email}'];
            break;
        default:
            assert(false);
        }

        $checkInsertItem = function ($data, ExecutionContextInterface $context) {
            $kind = $context->getRoot()->get('d__kind')->getData();
            switch ($kind) {
            case 1:
                $items = ['name','email','point','id'];
                break;
            case 2:
                $items = ['email','memo01','memo02','memo03','memo04','memo05','memo06','memo07','memo08','memo09','memo10'];
                break;
            case 3:
                $items = ['email'];
                break;
            default:
                assert(false);
            }

            $errors = PostCarrierUtil::checkInsertItem($data, $items);
            foreach ($errors as $msg) {
                $context->buildViolation($msg)
                    ->addViolation();
            }
        };

        $builder
            // 管理情報
            ->add('adm_name', TextType::class, array(
                'label' => '管理用名称',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => 255)),
                ),
            ))
            ->add('adm_note', TextAreaType::class, array(
                'label' => '備考',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => 5000)),
                ),
            ))
            // テンプレート編集
            ->add('d__kind', ChoiceType::class, array(
                'label' => 'テンプレート種別',
                'required' => false,
                'expanded' => true,
                'placeholder' => false, // Noneを出さない
                'choices' => array('EC会員向け' => 1, 'メルマガ専用会員向け' => 2, '両方向け' => 3),
                'label_attr' => array(
                    'class' => 'radio-inline'
                )
            ))
            ->add('d__mail_method', ChoiceType::class, array(
                'label' => 'メール形式',
                'required' => true,
                'expanded' => true,
                'choices' => array('HTML' => 1, 'テキスト'=> 2),
                'label_attr' => array(
                    'class' => 'radio-inline'
                )
            ))
            ->add('sendFor', ChoiceType::class, array(
                'label' => 'メール種別',
                'required' => false,
                'expanded' => true,
                'choices' => array('パソコン向け' => 'PC', '携帯電話向け' => 'MOBILE'),
                'empty_data' => 'PC',
            ))
            ->add('d__fromAddr', EmailType::class, array(
                'label' => '送信者アドレス',
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(),
                    // configでこの辺りは変えられる方が良さそう
                    new Assert\Email(array('strict' => true)),
                    new Assert\Regex(array(
                        'pattern' => '/^[[:graph:][:space:]]+$/i',
                        'message' => 'form.type.graph.invalid',
                    )),
                    new Assert\Length(array('max' => 128)),
                ),
            ))
            ->add('d__fromDisp', TextType::class, array(
                'label' => '送信者表示名',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => 50)),
                ),
            ))
            ->add('replytoAddr', EmailType::class, array(
                'label' => '返信先アドレス',
                'required' => false,
                'constraints' => array(
                    new Assert\Email(array('strict' => true)),
                    new Assert\Regex(array(
                        'pattern' => '/^[[:graph:][:space:]]+$/i',
                        'message' => 'form.type.graph.invalid',
                    )),
                    new Assert\Length(array('max' => 128)),
                ),
            ))
            ->add('replytoDisp', TextType::class, array(
                'label' => '返信先表示名',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => 50)),
                ),
            ))
            ->add('d__subject', TextType::class, array(
                'label' => 'postcarrier.select.label_subject',
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array('max' => 100)),
                    new Assert\Callback($checkInsertItem),
                )
            ))
            ->add('d__body', TextAreaType::class, array(
                'label' => 'postcarrier.select.label_body',
                'required' => false,
                'attr' => array('cols' => '90', 'rows' => '30'),
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(array('max' => 100000)),
                ],
            ))
            ->add('d__htmlBody', TextAreaType::class, array(
                'label' => 'postcarrier.select.label_body_html',
                'required' => false,
                'attr' => array('cols' => '90', 'rows' => '15'),
                'constraints' => new Assert\Callback(function (
                    $data, ExecutionContextInterface $context
                ) {
                    $mail_method = $context->getRoot()->get('d__mail_method')->getData();
                    if ($mail_method == 1) {
                        $context
                            ->getValidator()
                            ->inContext($context)
                            ->validate($data, [
                                new Assert\NotBlank(),
                                new Assert\Length(array('max' => 100000)),
                            ]);
                    }
                }),

            ))
            ->add('d__varList',  ChoiceType::class, [
                'label' => '差し込み項目',
                'required' => false,
                'placeholder' => '-- 差し込み項目 --',
                'choices' => $choices,
                'data' => null,
            ])
            ->add('d__varList2',  ChoiceType::class, [
                'label' => '差し込み項目',
                'required' => false,
                'placeholder' => '-- 差し込み項目 --',
                'choices' => $choices,
                'data' => null,
            ])
            // ->add('d__varList_mail',  ChoiceType::class, [
            //     'label' => '差し込み項目',
            //     'required' => false,
            //     'placeholder' => '-- 差し込み項目 --',
            //     'choices' => ['メールアドレス' => '{email}', '自由項目1' => '{memo01}', '自由項目2' => '{memo02}', '自由項目3' => '{memo03}', '自由項目4' => '{memo04}', '自由項目5' => '{memo05}', '自由項目6' => '{memo06}', '自由項目7' => '{memo07}', '自由項目8' => '{memo08}', '自由項目9' => '{memo09}', '自由項目10' => '{memo10}'],
            //     'data' => null,
            // ])
            // ->add('d__varList2_mail',  ChoiceType::class, [
            //     'label' => '差し込み項目',
            //     'required' => false,
            //     'placeholder' => '-- 差し込み項目 --',
            //     'choices' => ['メールアドレス' => '{email}', '自由項目1' => '{memo01}', '自由項目2' => '{memo02}', '自由項目3' => '{memo03}', '自由項目4' => '{memo04}', '自由項目5' => '{memo05}', '自由項目6' => '{memo06}', '自由項目7' => '{memo07}', '自由項目8' => '{memo08}', '自由項目9' => '{memo09}', '自由項目10' => '{memo10}'],
            //     'data' => null,
            // ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'd__kind' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'post_carrier_template_edit';
    }
}
