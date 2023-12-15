<?php


namespace Plugin\ProductReserve4\Form\Subscriber;


use Plugin\ProductReserve4\Form\Extension\ProductClassReservationExtension;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductClassExtraSubscriber implements EventSubscriberInterface
{

    /**
     * @var ProductClassReservationExtension
     */
    private $extension;

    /**
     * ProductClassExtraSubscriber constructor.
     * @param ProductClassReservationExtension $extension
     */
    public function __construct(ProductClassReservationExtension $extension)
    {
        $this->extension = $extension;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }

    public function onRequest($event){

        $id = $event->getRequest()->attributes->get('id');
        $this->extension->setProductId((int)$id);
//        dump($id);
//        exit();
    }
}