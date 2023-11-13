<?php

namespace Plugin\ZeusPayment4\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CsvImportType extends AbstractType
{
    /**
     * @var int CSVの最大アップロードサイズ
     */
    private $csvMaxSize;

    /**
     * CsvImportType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->csvMaxSize = $eccubeConfig['eccube_csv_size'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('import_file', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\File([
                        'maxSize' => $this->csvMaxSize.'M',
                    ]),
                ],
            ])
            ->add('is_split_csv', CheckboxType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('csv_file_no', IntegerType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_csv_import';
    }
}
