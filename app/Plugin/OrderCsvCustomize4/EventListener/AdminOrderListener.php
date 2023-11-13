<?php
namespace Plugin\OrderCsvCustomize4\EventListener;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Controller\Admin\Product\ProductClassController;
use Eccube\Controller\ShoppingController;
use Eccube\Entity\CartItem;
use Eccube\Entity\Master\OrderItemType;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Repository\Master\OrderItemTypeRepository;
use Plugin\Point4\Entity\AddPoint;
use Plugin\Point4\Repository\AddPointRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;

use Eccube\Service\CartService;
use Eccube\Repository\CartRepository;
use Eccube\Repository\CartItemRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eccube\Repository\MemberRepository;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Eccube\Request\Context;


use Plugin\OrderCsvCustomize4\Repository\OrderItemExtensionRepository;

use Eccube\Repository\ProductRepository;
use function GuzzleHttp\Psr7\str;

class AdminOrderListener implements EventSubscriberInterface
{
    /**
    * @var EntityManagerInterface
    */
    protected $entityManager;
    protected $orderItemRepository;
    protected $orderItemTypeRepository;

    /**
    * CartAddCompleteListener constructor.
    *
     * @param EntityManagerInterface $entityManager
     * @param OrderItemExtensionRepository $orderItemRepository
     * @param OrderItemTypeRepository $orderItemTypeRepository
    */
    public function __construct(
        EntityManagerInterface $entityManager,
        OrderItemExtensionRepository $orderItemRepository,
        OrderItemTypeRepository $orderItemTypeRepository
        ) {
        $this->entityManager = $entityManager;
        $this->orderItemRepository = $orderItemRepository;
        $this->orderItemTypeRepository = $orderItemTypeRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            EccubeEvents::ADMIN_ORDER_CSV_EXPORT_ORDER => 'onAdminOrderCsvLoader',
        ];
    }

    public function onAdminOrderCsvLoader(EventArgs $eventArgs)
    {
        $csvService = $eventArgs->getArgument('csvService');
        $Csv = $eventArgs->getArgument('Csv');
       // if (strpos($Csv->getFieldName(), 'order_csv_customize_add_')===false) return;

        $OrderItem = $eventArgs->getArgument('OrderItem');
        $ExportCsvRow = $eventArgs->getArgument('ExportCsvRow');

        $data = $csvService->getData($Csv, $OrderItem->getOrder());
        if (empty($data)) {
            $data = $csvService->getData($Csv, $OrderItem);
        }
        if (empty($data) && $Shipping = $OrderItem->getShipping()) {
            // 受注明細データにない場合は, 出荷を検索.
            $data = $csvService->getData($Csv, $Shipping);
        }


        $field_name = $Csv->getFieldName();

        if(str_contains($field_name, 'order_csv_customize_add_')){
            $order_item_type_id = str_replace('order_csv_customize_add_', '', $field_name);
            $OrderItemType = $this->orderItemTypeRepository->find($order_item_type_id);

            $OrderItems = $this->orderItemRepository->getListAddType($OrderItem->getOrder(), $OrderItemType);
            if(!empty($OrderItems)){
                $OrderItem = $OrderItems[0];
                $data = $OrderItem->getPrice();
            }
            
            $ExportCsvRow->setData($data);
            $eventArgs->setArgument('ExportCsvRow', $ExportCsvRow);
        }

        if(!empty($data)){
            if (DateTime::createFromFormat('Y-m-d H:i:s', $data) !== false) {
                $data = date('Y/m/d', strtotime($data));
            }
            if (is_numeric( $data)) {
                $data = intval($data);
            }
            
            $ExportCsvRow->setData($data);
            $eventArgs->setArgument('ExportCsvRow', $ExportCsvRow);
        }  
        
    }

}
?>
