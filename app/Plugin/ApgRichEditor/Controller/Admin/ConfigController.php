<?php

namespace Plugin\ApgRichEditor\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Controller\AbstractController;
use Plugin\ApgRichEditor\Domain\RichEditorType;
use Plugin\ApgRichEditor\Entity\Config;
use Plugin\ApgRichEditor\Form\Type\Admin\ConfigType;
use Plugin\ApgRichEditor\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $Config;


    /**
     * @var EntityManagerInterface
     */
    protected $EntityManager;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository, EntityManagerInterface $entityManager)
    {
        $this->Config = $configRepository;
        $this->EntityManager = $entityManager;
    }

    /**
     * @Route("/%eccube_admin_route%/apg_rich_editor/config", name="apg_rich_editor_admin_config")
     * @Template("@ApgRichEditor/admin/config.twig")
     */
    public function index(Request $request)
    {
        /** @var Config $PersistConfig */
        $Config = $this->Config->getOrNew();
        $form = $this->createForm(ConfigType::class, $Config);
        $PersistConfig = clone $Config; // 旧データとの比較用
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Config $Config */
            $Config = $form->getData();
            // Markdownの場合、それぞれmarkdown用フィールドにコピー
            if ($PersistConfig->getProductDescriptionDetail() != RichEditorType::MARKDOWN
                && $Config->getProductDescriptionDetail() == RichEditorType::MARKDOWN
            ) {
                $q = $this->EntityManager->createQuery("UPDATE Eccube\Entity\Product p SET p.plg_markdown_description_detail = p.description_detail");
                $numUpdated = $q->execute();
            }
            if ($PersistConfig->getProductFreeArea() != RichEditorType::MARKDOWN
                && $Config->getProductFreeArea() == RichEditorType::MARKDOWN
            ) {
                $q = $this->EntityManager->createQuery("UPDATE Eccube\Entity\Product p SET p.plg_markdown_free_area = p.free_area");
                $numUpdated = $q->execute();
            }
            if ($PersistConfig->getNewsDescription() != RichEditorType::MARKDOWN
                && $Config->getNewsDescription() == RichEditorType::MARKDOWN
            ) {
                $q = $this->EntityManager->createQuery("UPDATE Eccube\Entity\News n SET n.plg_markdown_description = n.description");
                $numUpdated = $q->execute();
            }

            $this->Config->save($Config);
            $this->entityManager->flush($Config);
            $this->addSuccess('登録しました。', 'admin');

            return $this->redirectToRoute('apg_rich_editor_admin_config');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
