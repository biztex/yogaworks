<?php

namespace Plugin\ApgRichEditor;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\News;
use Eccube\Entity\Product;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\ApgRichEditor\Domain\RichEditorType;
use Plugin\ApgRichEditor\Entity\Config;
use Plugin\ApgRichEditor\Entity\RichEditorContent;
use Plugin\ApgRichEditor\Repository\ConfigRepository;
use Plugin\ApgRichEditor\Repository\RichEditorContentRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;

class Event implements EventSubscriberInterface
{

    const TEMPLATE_NAMESPACE = '@ApgRichEditor';

    /**
     * @var ConfigRepository
     */
    protected $Config;

    protected $em;

    protected $twig;

    public function __construct(
        ConfigRepository $configRepository,
        EntityManagerInterface $em,
        \Twig_Environment $twig
    )
    {
        $this->Config = $configRepository;
        $this->em = $em;
        $this->twig = $twig;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            '@admin/Product/product.twig' => 'onAdminProductRender',
            EccubeEvents::ADMIN_PRODUCT_EDIT_COMPLETE => 'onAdminProductEditComplete',
            '@admin/Content/news_edit.twig' => 'onAdminNewsRender',
            EccubeEvents::ADMIN_CONTENT_NEWS_EDIT_COMPLETE => 'onAdminNewsEditComplete',
        ];
    }

    /**
     * @param TemplateEvent $event
     * @throws \Twig_Error_Loader
     */
    public function onAdminProductRender(TemplateEvent $event)
    {

        $source = $event->getSource();

        // data
        $parameters = $event->getParameters();
        // setting
        $ApgRichEditorConfig = $this->Config->getOrNew();
        $parameters['ApgRichEditorConfig'] = $ApgRichEditorConfig;

        // help
        if ($ApgRichEditorConfig->isEnableProductMarkdown()) {
            $pattern = '|<div id="ex-conversion-action"|s';
            $addRow = $this->twig->getLoader()->getSourceContext(self::TEMPLATE_NAMESPACE . '/admin/markdown_help.twig')->getCode();

            if (preg_match($pattern, $source, $matches, PREG_OFFSET_CAPTURE)) {
                $replacement = $addRow . $matches[0][0];
                $source = preg_replace($pattern, $replacement, $source);
            }
        }

        $event->setSource($source);


        $event->setParameters($parameters);

        $event->addAsset(self::TEMPLATE_NAMESPACE . '/admin/rich_editor_product_css.twig');
        $event->addSnippet(self::TEMPLATE_NAMESPACE . '/admin/rich_editor_product_js.twig');
    }

    /**
     * @param Event $event
     */
    public function onAdminProductEditComplete(EventArgs $event)
    {
        /** @var Product $Product */
        $Product = $event->getArgument('Product');
        /** @var FormInterface $form */
        $form = $event->getArgument('form');
        /** @var Config $RichEditorConfig */
        $RichEditorConfig = $this->Config->getOrNew();

        // Product - description detail
        if ($RichEditorConfig->getProductDescriptionDetail() === RichEditorType::MARKDOWN) {
            $convertedContent = $Product->getPlgMarkdownDescriptionDetail();
            $markdownContent = $Product->getDescriptionDetail();
            $Product->setDescriptionDetail($convertedContent);
            $Product->setPlgMarkdownDescriptionDetail($markdownContent);
        }
        if ($RichEditorConfig->getProductFreeArea() === RichEditorType::MARKDOWN) {
            $convertedContent = $Product->getPlgMarkdownFreeArea();
            $markdownContent = $Product->getFreeArea();
            $Product->setFreeArea($convertedContent);
            $Product->setPlgMarkdownFreeArea($markdownContent);
        }
        $this->em->persist($Product);
        $this->em->flush();

    }

    /**
     * @param TemplateEvent $event
     * @throws \Twig_Error_Loader
     */
    public function onAdminNewsRender(TemplateEvent $event)
    {

        $source = $event->getSource();

        // data
        $parameters = $event->getParameters();
        // setting
        $ApgRichEditorConfig = $this->Config->getOrNew();
        $parameters['ApgRichEditorConfig'] = $ApgRichEditorConfig;

        // help
        if ($ApgRichEditorConfig->isEnableNewsMarkdown()) {
            $pattern = '|<div id="ex-conversion-action"|s';
            $addRow = $this->twig->getLoader()->getSourceContext(self::TEMPLATE_NAMESPACE . '/admin/markdown_help.twig')->getCode();

            if (preg_match($pattern, $source, $matches, PREG_OFFSET_CAPTURE)) {
                $replacement = $addRow . $matches[0][0];
                $source = preg_replace($pattern, $replacement, $source);
            }
        }

        $event->setSource($source);


        $event->setParameters($parameters);

        $event->addAsset(self::TEMPLATE_NAMESPACE . '/admin/rich_editor_news_css.twig');
        $event->addSnippet(self::TEMPLATE_NAMESPACE . '/admin/rich_editor_news_js.twig');
    }

    /**
     * @param Event $event
     */
    public function onAdminNewsEditComplete(EventArgs $event)
    {
        /** @var News $News */
        $News = $event->getArgument('News');
        /** @var Config $RichEditorConfig */
        $RichEditorConfig = $this->Config->getOrNew();

        // Product - description detail
        if ($RichEditorConfig->getNewsDescription() === RichEditorType::MARKDOWN) {
            $convertedContent = $News->getPlgMarkdownDescription();
            $markdownContent = $News->getDescription();
            $News->setDescription($convertedContent);
            $News->setPlgMarkdownDescription($markdownContent);
        }
        $this->em->persist($News);
        $this->em->flush();

    }
}
