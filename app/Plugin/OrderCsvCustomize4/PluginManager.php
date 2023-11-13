<?php

namespace Plugin\OrderCsvCustomize4;
use Eccube\Entity\Csv;
use Eccube\Entity\Master\CsvType;
use Eccube\Entity\Master\OrderItemType;
use Plugin\OrderCsvCustomize4\Entity\Config;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Eccube\Plugin\AbstractPluginManager;
use Eccube\Service\PluginService;

class PluginManager extends AbstractPluginManager
{

    public function __construct()
    {
    }

    public function install(array $config, ContainerInterface $container)
    {
    }


    public function enable(array $config, ContainerInterface $container)
    {
        $this->createConfig($container);
        $this->addCsvData($container);
    }


    public function disable(array $config, ContainerInterface $container)
    {
        $this->removeCsvData($container);
    }

    public function uninstall(array $config, ContainerInterface $container)
    {

    }

    private function createConfig($container)
    {
        $entityManager = $container->get('doctrine')->getManager();

        $configRepository = $entityManager->getRepository(Config::class);


        $Config = $configRepository->get();
        if(empty($Config)){
            $Config = new Config();
            $Config->setName('OrderCsvCustomize');
            $Config->setDateFormat('yyyy/mm/dd');
            $Config->setIsInteger(true);

            $entityManager->persist($Config);
            $entityManager->flush($Config);

        }
    }

    private function addCsvData($container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        $csvTypeRepository = $entityManager->getRepository(CsvType::class);
        $orderItemTypeRepository = $entityManager->getRepository(OrderItemType::class);

        $CsvType = $csvTypeRepository->find(CsvType::CSV_TYPE_ORDER);

        if(!empty($CsvType)){

            $Csvs = $entityManager->createQueryBuilder()
                ->select('csv')
                ->from('Eccube\Entity\Csv', 'csv')
                ->where('csv.CsvType = :CsvType')->setParameter('CsvType', $CsvType)
                ->andWhere('csv.field_name LIKE :add_field_name')->setParameter('add_field_name', 'order_csv_customize_add_'.'%')
                ->getQuery()
                ->getResult();

            foreach ($Csvs as $Csv){
                $entityManager->remove($Csv);
            }
            $entityManager->flush();

            $OrderItemTypes = $orderItemTypeRepository->findAll();
            $sort_no = 65;
            foreach ($OrderItemTypes as $OrderItemType){
                if($OrderItemType->getId()== OrderItemType::PRODUCT) continue;
                $Csv = new Csv();
                $Csv->setCsvType($CsvType);
                $Csv->setEntityName('Eccube\\Entity\\OrderItem');
                $Csv->setFieldName('order_csv_customize_add_'.$OrderItemType->getId());
                $displayName = $OrderItemType->getName().'(追加)';
                if($OrderItemType->getName()=='割引') $displayName = 'クーポン割引';
                if($OrderItemType->getName()=='ポイント') $displayName = 'ポイント割引';
                $Csv->setDispName($displayName);
                $Csv->setEnabled(true);
                $Csv->setSortNo($sort_no++);
                $entityManager->persist($Csv);
            }
            $entityManager->flush();
        }


        $CsvTypeShipping = $csvTypeRepository->find(CsvType::CSV_TYPE_SHIPPING);

        if(!empty($CsvTypeShipping)){

            $Csvs = $entityManager->createQueryBuilder()
                ->select('csv')
                ->from('Eccube\Entity\Csv', 'csv')
                ->where('csv.CsvType = :CsvType')->setParameter('CsvType', $CsvTypeShipping)
                ->andWhere('csv.field_name LIKE :add_field_name')->setParameter('add_field_name', 'order_csv_customize_add_'.'%')
                ->getQuery()
                ->getResult();

            foreach ($Csvs as $Csv){
                $entityManager->remove($Csv);
            }
            $entityManager->flush();

            $OrderItemTypes = $orderItemTypeRepository->findAll();
            $sort_no = 71;
            foreach ($OrderItemTypes as $OrderItemType){
                if($OrderItemType->getId()== OrderItemType::PRODUCT) continue;
                $Csv = new Csv();
                $Csv->setCsvType($CsvTypeShipping);
                $Csv->setEntityName('Eccube\\Entity\\OrderItem');
                $Csv->setFieldName('order_csv_customize_add_'.$OrderItemType->getId());
                $displayName = $OrderItemType->getName().'(追加)';
                if($OrderItemType->getName()=='割引') $displayName = 'クーポン割引';
                if($OrderItemType->getName()=='ポイント') $displayName = 'ポイント割引';
                $Csv->setDispName($displayName);
                $Csv->setEnabled(true);
                $Csv->setSortNo($sort_no++);
                $entityManager->persist($Csv);
            }

            $entityManager->flush();
        }
    }


    private function removeCsvData($container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        $csvTypeRepository = $entityManager->getRepository(CsvType::class);

        $CsvType = $csvTypeRepository->find(CsvType::CSV_TYPE_ORDER);

        if(!empty($CsvType)){

            $Csvs = $entityManager->createQueryBuilder()
                ->select('csv')
                ->from('Eccube\Entity\Csv', 'csv')
                ->where('csv.CsvType = :CsvType')->setParameter('CsvType', $CsvType)
                ->andWhere('csv.field_name LIKE :add_field_name')->setParameter('add_field_name', 'order_csv_customize_add_'.'%')
                ->getQuery()
                ->getResult();

            foreach ($Csvs as $Csv){
                $entityManager->remove($Csv);
            }

            $entityManager->flush();
        }

        $CsvTypeShipping = $csvTypeRepository->find(CsvType::CSV_TYPE_SHIPPING);

        if(!empty($CsvTypeShipping)){

            $Csvs = $entityManager->createQueryBuilder()
                ->select('csv')
                ->from('Eccube\Entity\Csv', 'csv')
                ->where('csv.CsvType = :CsvType')->setParameter('CsvType', $CsvTypeShipping)
                ->andWhere('csv.field_name LIKE :add_field_name')->setParameter('add_field_name', 'order_csv_customize_add_'.'%')
                ->getQuery()
                ->getResult();

            foreach ($Csvs as $Csv){
                $entityManager->remove($Csv);
            }

            $entityManager->flush();
        }
    }

}
