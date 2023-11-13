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

namespace Plugin\PostCarrier4\Controller;

use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Eccube\Repository\CustomerRepository;
use Plugin\PostCarrier4\Entity\PostCarrierGroupCustomer;
use Plugin\PostCarrier4\Form\Type\PostCarrierMailmagaBlockType;
use Plugin\PostCarrier4\Repository\PostCarrierGroupCustomerRepository;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Service\PostCarrierUtilService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailmagaBlockController extends AbstractController
{
    /**
     * @var PostCarrierService
     */
    protected $postCarrierService;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var PostCarrierGroupCustomerRepository
     */
    protected $postCarrierGroupCustomerRepository;

    /**
     * @var PostCarrierUtil
     */
    protected $postCarrierUtil;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * PostCarrierHistoryController constructor.
     *
     * @param PostCarrierService $postCarrierService
     * @param CustomerRepository $customerRepository
     * @param PostCarrierGroupCustomerRepository $postCarrierGroupCustomerRepository
     * @param PostCarrierUtil $postCarrierUtil
     */
    public function __construct(
        PostCarrierService $postCarrierService,
        CustomerRepository $customerRepository,
        PostCarrierGroupCustomerRepository $postCarrierGroupCustomerRepository,
        PostCarrierUtilService $postCarrierUtil,
        RequestStack $requestStack
    ) {
        $this->postCarrierService = $postCarrierService;
        $this->customerRepository = $customerRepository;
        $this->postCarrierGroupCustomerRepository = $postCarrierGroupCustomerRepository;
        $this->postCarrierUtil = $postCarrierUtil;
        $this->requestStack = $requestStack;
    }

    /**
     * メルマガ会員登録解除.
     *
     * @Route("/postcarrier/mailmaga", name="postcarrier_mailmaga")
     *
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        $postCarrierService = $this->postCarrierService;

        $builder = $this->formFactory->createNamedBuilder('', PostCarrierMailmagaBlockType::class);
        $form = $builder->getForm();

        $action = $request->get('action');
        $return_page = '';
        if ($action == 'subscribe') {
            $return_page = 'postcarrier_subscribe_complete';
        } else if ($action == 'unsubscribe') {
            $return_page = 'postcarrier_unsubscribe_complete';
        } else {
            return $this->redirectToRoute('homepage');
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = $formData['email'];
            $uniqid = '';
            $GroupCustomer = $this->postCarrierGroupCustomerRepository->findOneBy(['group_id' => 1, 'email' => $email]);
            if ($action == 'subscribe') {
                if (is_null($GroupCustomer)) {
                    $uniqid = $this->postCarrierGroupCustomerRepository->getUniqueSecretKey();
                    $now = new \DateTime();
                    $GroupCustomer = new PostCarrierGroupCustomer();
                    $GroupCustomer->setGroupId(1);
                    $GroupCustomer->setStatus(1); // 仮登録
                    $GroupCustomer->setEmail($email);
                    $GroupCustomer->setSecretKey($uniqid);
                    $GroupCustomer->setCreateDate($now);
                    $GroupCustomer->setUpdateDate($now);
                    $this->entityManager->persist($GroupCustomer);
                    $this->entityManager->flush($GroupCustomer);
                } else {
                    // 既にメルマガ本会員(status==2)でも仮登録メールを送信する。
                    $uniqid = $GroupCustomer->getSecretKey();
                }

                $formData = [
                    'email' => $email,
                    'regist_url' => $this->generateUrl('post_carrier_receive', ['mode'=>'regist','id'=>$uniqid], UrlGeneratorInterface::ABSOLUTE_URL),
                ];
                $this->postCarrierUtil->sendRegistrationMail($formData);
            } else if ($action == 'unsubscribe') {
                if (is_null($GroupCustomer) || $GroupCustomer->getStatus() != 2) {
                    // メルマガ会員でないなら本会員の停止
                    $Customer = $this->customerRepository->findOneBy(['email' => $email]);
                    if (is_null($Customer) || $Customer->getPostcarrierFlg() == Constant::DISABLED) {
                        // メルマガ会員でも本会員でもない または
                        // メルマガ会員でなく本会員であるがメルマガ希望でない
                        return $this->redirectToRoute($return_page, ['status' => 'failure']);
                    } else if (is_null($GroupCustomer)) {
                        // メルマガ会員でなく本会員でメルマガ希望なので、仮解除用のメルマガ会員レコードを作成する
                        $GroupCustomer = new PostCarrierGroupCustomer();
                        $GroupCustomer->setGroupId(1);
                        $GroupCustomer->setStatus(1); // 仮登録状態
                        $GroupCustomer->setEmail($email);
                    } else {
                        // 既に仮会員状態でエントリーが存在する場合、再送信する
                    }
                }

                $uniqid = $this->postCarrierGroupCustomerRepository->getUniqueSecretKey();
                $GroupCustomer->setSecretKey($uniqid);
                $GroupCustomer->setUpdateDate(new \DateTime());
                $this->entityManager->persist($GroupCustomer);
                $this->entityManager->flush($GroupCustomer);

                $formData = [
                    'email' => $email,
                    'regist_url' => $this->generateUrl('post_carrier_receive', ['mode'=>'unsubscribe','id'=>$uniqid], UrlGeneratorInterface::ABSOLUTE_URL),
                ];
                $this->postCarrierUtil->sendUnsubscribeMail($formData);
            }
            return $this->redirectToRoute($return_page, ['status' => 'temporary']);
        } else {
            return $this->redirectToRoute($return_page, ['status' => 'failure']);
            //return new \Symfony\Component\HttpFoundation\Response($form->getErrors(true));
            //dump($form->getErrors(true));
            //return $this->render('@PostCarrier4/Mailmaga/postcarrier_subscribe_complete.twig');
        }
    }

    /**
     * @Route("/block/postcarrier_mailmaga_block", name="block_postcarrier_mailmaga_block")
     * @Route("/block/postcarrier_mailmaga_block_sp", name="block_postcarrier_mailmaga_block_sp")
     * @Template("Block/postcarrier_mailmaga_block.twig")
     */
    public function postcarrier_mailmaga_block(Request $request)
    {
        $builder = $this->formFactory
            ->createNamedBuilder('', PostCarrierMailmagaBlockType::class)
            ->setMethod('POST');

        $request = $this->requestStack->getMasterRequest();

        $form = $builder->getForm();
        $form->handleRequest($request);

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/postcarrier_subscribe_complete", name="postcarrier_subscribe_complete")
     * @Template("PostCarrier4/Resource/template/Mailmaga/postcarrier_subscribe_complete.twig")
     */
    public function postcarrier_subscribe_complete(Request $request)
    {
        return [];
    }

    /**
     * @Route("/postcarrier_unsubscribe_complete", name="postcarrier_unsubscribe_complete")
     * @Template("PostCarrier4/Resource/template/Mailmaga/postcarrier_unsubscribe_complete.twig")
     */
    public function postcarrier_unsubscribe_complete(Request $request)
    {
        return [];
    }

    /**
     * @Route("/postcarrier_unsubscribe", name="postcarrier_unsubscribe")
     * @Template("PostCarrier4/Resource/template/Mailmaga/postcarrier_unsubscribe.twig")
     */
    public function postcarrier_unsubscribe(Request $request)
    {
        $builder = $this->formFactory
            ->createNamedBuilder('', PostCarrierMailmagaBlockType::class)
            ->setMethod('POST');

        $request = $this->requestStack->getMasterRequest();

        $form = $builder->getForm();
        $form->handleRequest($request);

        return [
            'form' => $form->createView(),
        ];
    }
}
