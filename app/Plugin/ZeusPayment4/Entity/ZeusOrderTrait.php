<?php


namespace Plugin\ZeusPayment4\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\Order")
 */
trait ZeusOrderTrait
{
    /**
     * トークンを保持するカラム.
     *
     * @var string
     */
    private $zeus_credit_payment_token;


    /**
     *
     * @var string
     */
    private $zeus_credit_payment_method;

    /**
     *
     * @var string
     * @ORM\Column(name="zeus_request_data", type="text", nullable=true)
     */
    private $zeus_request_data;

    /**
     *
     * @var string
     * @ORM\Column(name="zeus_response_data", type="text", nullable=true)
     */
    private $zeus_response_data;

    /**
     *
     * @var string
     * @ORM\Column(name="zeus_memo", type="text", nullable=true)
     */
    private $zeus_memo;

    /**
     *
     * @var string
     * @ORM\Column(name="zeus_order_id", type="text", nullable=true, options={"unsigned":true})
     */
    private $zeus_order_id;

    /**
     *
     * @var string
     * @ORM\Column(name="zeus_sale_type", type="smallint", nullable=false, options={"unsigned":true,"default":0})
     * 1 - 仮売上 　0 - 即時売上  
     */
    private $zeus_sale_type = 0;

    /**
     * @var string
     */
    private $zeus_credit_payment_card_no;

    /**
     * @var string
     */
    private $zeus_credit_payment_card_name1;

    /**
     * @var string
     */
    private $zeus_credit_payment_card_name2;


    /**
     * @var integer
     */
    private $zeus_credit_payment_card_year;

    /**
     * @var integer
     */
    private $zeus_credit_payment_card_month;

    /**
     * @var string
     */
    private $zeus_credit_payment_cvv;

    /**
     * @var integer
     */
    private $zeus_credit_payment_quick;

    /**
     * @var boolean
     */
    private $zeus_skip_cancel = false;
    
    /**
     * @return string
     */
    public function getZeusCreditPaymentToken()
    {
        return $this->zeus_credit_payment_token;
    }

    /**
     * @param string $zeus_credit_payment_token
     *
     * @return $this
     */
    public function setZeusCreditPaymentToken($zeus_credit_payment_token)
    {
        $this->zeus_credit_payment_token = $zeus_credit_payment_token;

        return $this;
    }

    /**
     * @return string
     */
    public function getZeusCreditPaymentMethod()
    {
        return $this->zeus_credit_payment_method;
    }

    /**
     * @param string $zeus_credit_payment_method
     *
     * @return $this
     */
    public function setZeusCreditPaymentMethod($zeus_credit_payment_method)
    {
        $this->zeus_credit_payment_method = $zeus_credit_payment_method;

        return $this;
    }

    /**
     * @return string
     */
    public function getZeusCreditPaymentCardNo()
    {
        return $this->zeus_credit_payment_card_no;
    }

    /**
     * @param string $zeus_credit_payment_card_no
     */
    public function setZeusCreditPaymentCardNo($zeus_credit_payment_card_no)
    {
        $this->zeus_credit_payment_card_no = $zeus_credit_payment_card_no;
    }

    /**
     * @return string
     */
    public function getZeusCreditPaymentCardName1()
    {
        return $this->zeus_credit_payment_card_name1;
    }

    /**
     * @param string $zeus_credit_payment_card_name1
     */
    public function setZeusCreditPaymentCardName1($zeus_credit_payment_card_name1)
    {
        $this->zeus_credit_payment_card_name1 = $zeus_credit_payment_card_name1;
    }

    /**
     * @return string
     */
    public function getZeusCreditPaymentCardName2()
    {
        return $this->zeus_credit_payment_card_name2;
    }

    /**
     * @param string $zeus_credit_payment_card_name2
     */
    public function setZeusCreditPaymentCardName2($zeus_credit_payment_card_name2)
    {
        $this->zeus_credit_payment_card_name2 = $zeus_credit_payment_card_name2;
    }

    /**
     * @return integer
     */
    public function getZeusCreditPaymentYear()
    {
        return $this->zeus_credit_payment_card_year;
    }

    /**
     * @param string $zeus_credit_payment_card_year
     */
    public function setZeusCreditPaymentYear($zeus_credit_payment_card_year)
    {
        $this->zeus_credit_payment_card_year = $zeus_credit_payment_card_year;
    }

    /**
     * @return integer
     */
    public function getZeusCreditPaymentMonth()
    {
        return $this->zeus_credit_payment_card_month;
    }

    /**
     * @param integer $zeus_credit_payment_card_month
     */
    public function setZeusCreditPaymentMonth($zeus_credit_payment_card_month)
    {
        $this->zeus_credit_payment_card_month = $zeus_credit_payment_card_month;
    }

    /**
     * @return string
     */
    public function getZeusCreditPaymentCvv()
    {
        return $this->zeus_credit_payment_cvv;
    }

    /**
     * @param string $zeus_credit_payment_cvv
     */
    public function setZeusCreditPaymentCvv($zeus_credit_payment_cvv)
    {
        $this->zeus_credit_payment_cvv = $zeus_credit_payment_cvv;
    }

    /**
     * @return integer
     */
    public function getZeusCreditPaymentQuick()
    {
        return $this->zeus_credit_payment_quick;
    }

    /**
     * @param integer $zeus_credit_payment_quick
     */
    public function setZeusCreditPaymentQuick($zeus_credit_payment_quick)
    {
        $this->zeus_credit_payment_quick = $zeus_credit_payment_quick;
    }

    /**
     * @return string
     */
    public function getZeusRequestData()
    {
        return $this->zeus_request_data;
    }

    /**
     * @param string $zeus_request_data
     *
     * @return $this
     */
    public function setZeusRequestData($zeus_request_data)
    {
        $this->zeus_request_data = $zeus_request_data;

        return $this;
    }

    /**
     * @return string
     */
    public function getZeusResponseData()
    {
        return $this->zeus_response_data;
    }

    /**
     * @param string $zeus_response_data
     *
     * @return $this
     */
    public function setZeusResponseData($zeus_response_data)
    {
        $this->zeus_response_data = $zeus_response_data;

        return $this;
    }

    /**
     * @return string
     */
    public function getZeusMemo()
    {
        return $this->zeus_memo;
    }

    /**
     * @param string $zeus_memo
     *
     * @return $this
     */
    public function setZeusMemo($zeus_memo)
    {
        $this->zeus_memo = $zeus_memo;

        return $this;
    }

    /**
     * @return string
     */
    public function getZeusOrderId()
    {
        return $this->zeus_order_id;
    }

    /**
     * @param string $zeus_order_id
     *
     * @return $this
     */
    public function setZeusOrderId($zeus_order_id)
    {
        $this->zeus_order_id = $zeus_order_id;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getZeusSaleType()
    {
        return $this->zeus_sale_type;
    }
    
    /**
     * @param string $zeus_sale_type
     *
     * @return $this
     */
    public function setZeusSaleType($zeus_sale_type)
    {
        $this->zeus_sale_type = $zeus_sale_type;
        
        return $this;
    }

    /**
     * @return boolean
     */
    public function isZeusSkipCancel()
    {
        return $this->zeus_skip_cancel;
    }
    
    /**
     * @param string $zeus_skip_cancel
     *
     * @return $this
     */
    public function setZeusSkipCancel($zeus_skip_cancel)
    {
        $this->zeus_skip_cancel = $zeus_skip_cancel;
        
        return $this;
    }
    
}
