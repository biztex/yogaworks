<?php
/**
 * Created by SYSTEM_KD
 * Date: 2018/08/15
 */

namespace Plugin\QuantityDiscount\Controller\Admin;


use Eccube\Controller\AbstractController;
use Plugin\QuantityDiscount\Form\Type\QdConfigType;
use Plugin\QuantityDiscount\Repository\QdConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{

    protected $configRepository;

    public function __construct(QdConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     *
     * @Route("/%eccube_admin_route%/quantity_discount/config", name="quantity_discount_admin_config")
     * @Template("@QuantityDiscount/admin/config.twig")
     *
     * @param Request $request
     * @return RedirectResponse|array
     */
    public function index(Request $request)
    {

        $QdConfigs = $this->configRepository->findAllOrderGroup();

        /** @var FormBuilderInterface $builder */
        $builder = $this->formFactory->createBuilder(QdConfigType::class, $QdConfigs);
        $form = $builder->getForm();

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $Configs = $form->get('qdConfigs');

                // 設定情報登録
                /** @var FormBuilderInterface $configForm */
                foreach ($Configs as $configForm) {
                    $config = $configForm->getData();
                    $this->entityManager->persist($config);
                }
                $this->entityManager->flush();
                $this->addSuccess('quantity_discount.admin.config_save', 'admin');

                return $this->redirectToRoute('quantity_discount_admin_config');
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

}
