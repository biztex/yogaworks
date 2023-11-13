<?php

namespace Plugin\ZeusPayment4\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\Master\OrderStatus;
/**
 * Config
 *
 * @ORM\Table(name="plg_zeus_payment_config")
 * @ORM\Entity(repositoryClass="Plugin\ZeusPayment4\Repository\ConfigRepository")
 */
class Config extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="clientip", type="string", length=10, nullable=true)
     */
    private $clientip;

    /**
     * @var string
     *
     * @ORM\Column(name="clientauthkey", type="string", length=40, nullable=true)
     */
    private $clientauthkey;

    /**
     * @var int
     *
     * @ORM\Column(name="cvvflg", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $cvvflg;

    /**
     * @var int
     *
     * @ORM\Column(name="quickchargeflg", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $quickchargeflg;

    /**
     * @var int
     *
     * @ORM\Column(name="saletype", type="smallint", nullable=false, options={"unsigned":true,"default":0})
     * 1 - 仮売上 　0 - 即時売上　 
     */
    private $saleType = 0;
    
    /**
     * @var int
     *
     * @ORM\Column(name="secure3dflg", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $secure3dflg;

    /**
     * @var string
     *
     * @ORM\Column(name="detailname", type="string", length=256, nullable=true)
     */
    private $detailname;

    /**
     * @var string
     *
     * @ORM\Column(name="clientip_cvs", type="string", length=10, nullable=true)
     */
    private $clientip_cvs;

    /**
     * @var string
     *
     * @ORM\Column(name="siteurl", type="string", length=256, nullable=true)
     */
    private $siteurl;

    /**
     * @var string
     *
     * @ORM\Column(name="sitestr", type="string", length=256, nullable=true)
     */
    private $sitestr;

    /**
     * @var string
     *
     * @ORM\Column(name="clientip_edy", type="string", length=10, nullable=true)
     */
    private $clientip_edy;

    /**
     * @var string
     *
     * @ORM\Column(name="success_url", type="string", length=256, nullable=true)
     */
    private $success_url;

    /**
     * @var string
     *
     * @ORM\Column(name="success_str", type="string", length=256, nullable=true)
     */
    private $success_str;

    /**
     * @var string
     *
     * @ORM\Column(name="failure_url", type="string", length=256, nullable=true)
     */
    private $failure_url;

    /**
     * @var string
     *
     * @ORM\Column(name="failure_str", type="string", length=256, nullable=true)
     */
    private $failure_str;

    /**
     * @var string
     *
     * @ORM\Column(name="clientip_ebank", type="string", length=10, nullable=true)
     */
    private $clientip_ebank;

    /**
     * @var string
     *
     * @ORM\Column(name="ebank_siteurl", type="string", length=256, nullable=true)
     */
    private $ebank_siteurl;

    /**
     * @var string
     *
     * @ORM\Column(name="ebank_sitestr", type="string", length=256, nullable=true)
     */
    private $ebank_sitestr;

    /**
     * @var string
     *
     * @ORM\Column(name="cvs_key", type="string", length=256, nullable=true)
     */
    private $cvs_key;

    /**
     * @var string
     *
     * @ORM\Column(name="edy_key", type="string", length=256, nullable=true)
     */
    private $edy_key;

    /**
     * @var string
     *
     * @ORM\Column(name="ebank_key", type="string", length=256, nullable=true)
     */
    private $ebank_key;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="\Eccube\Entity\Payment")
     * @ORM\JoinColumn(name="credit_payment_id", referencedColumnName="id")
     */
    private $creditPayment;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="\Eccube\Entity\Payment")
     * @ORM\JoinColumn(name="cvs_payment_id", referencedColumnName="id")
     */
    private $cvsPayment;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="\Eccube\Entity\Payment")
     * @ORM\JoinColumn(name="edy_payment_id", referencedColumnName="id")
     */
    private $edyPayment;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="\Eccube\Entity\Payment")
     * @ORM\JoinColumn(name="ebank_payment_id", referencedColumnName="id")
     */
    private $ebankPayment;

    /**
     * Set id
     *
     * @param integer $id
     * @return Config
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clientip
     *
     * @param string $clientip
     * @return Config
     */
    public function setClientip($clientip)
    {
        $this->clientip = $clientip;
        
        return $this;
    }

    /**
     * Get clientip
     *
     * @return string
     */
    public function getClientip()
    {
        return $this->clientip;
    }

    /**
     * Set clientauthkey
     *
     * @param string $clientauthkey
     * @return Config
     */
    public function setClientauthkey($clientauthkey)
    {
        $this->clientauthkey = $clientauthkey;
        
        return $this;
    }

    /**
     * Get clientauthkey
     *
     * @return string
     */
    public function getClientauthkey()
    {
        return $this->clientauthkey;
    }
    public static $cvv_on = 1;
    public static $cvv_first_use = 2;
    public static $cvv_first_on_quick_opt = 3;
    public static $cvv_first_opt_quick_opt = 4;

    /**
     * Set cvvflg
     *
     * @param integer $cvvflg
     * @return Config
     */
    public function setCvvflg($cvvflg)
    {
        $this->cvvflg = $cvvflg;
        
        return $this;
    }

    /**
     * Get cvvflg
     *
     * @return integer
     */
    public function getCvvflg()
    {
        return $this->cvvflg;
    }

    /**
     * Set quickchargeflg
     *
     * @param integer $quickchargeflg
     * @return Config
     */
    public function setQuickchargeflg($quickchargeflg)
    {
        $this->quickchargeflg = $quickchargeflg;
        
        return $this;
    }

    /**
     * Get quickchargeflg
     *
     * @return integer
     */
    public function getQuickchargeflg()
    {
        return $this->quickchargeflg;
    }

    /**
     * Set saleType
     *
     * @param integer $saleType
     * @return Config
     */
    public function setSaleType($saleType)
    {
        $this->saleType = $saleType;
        
        return $this;
    }
    
    /**
     * Get saleType
     *
     * @return integer
     */
    public function getSaleType()
    {
        return $this->saleType;
    }
    
    public function getSaleTypeString()
    {
        if ($this->saleType == 1)
            return "仮売上";
        else
            return "即時";
    }
    
    public function getOrderStatusForSaleType() {
        if ($this->saleType == 1) { //仮売上
            return OrderStatus::NEW;
        } else {
            return OrderStatus::PAID;
        }
    }
    
    /**
     * Set secure3dflg
     *
     * @param integer $secure3dflg
     * @return Config
     */
    public function setSecure3dflg($secure3dflg)
    {
        $this->secure3dflg = $secure3dflg;
        
        return $this;
    }

    /**
     * Get secure3dflg
     *
     * @return integer
     */
    public function getSecure3dflg()
    {
        return $this->secure3dflg;
    }

    /**
     * Set detailname
     *
     * @param string $detailname
     * @return Config
     */
    public function setDetailname($detailname)
    {
        $this->detailname = $detailname;
        
        return $this;
    }

    /**
     * Get detailname
     *
     * @return string
     */
    public function getDetailname()
    {
        return $this->detailname;
    }

    /**
     * Set clientip_cvs
     *
     * @param string $clientipCvs
     * @return Config
     */
    public function setClientipCvs($clientipCvs)
    {
        $this->clientip_cvs = $clientipCvs;
        
        return $this;
    }

    /**
     * Get clientip_cvs
     *
     * @return string
     */
    public function getClientipCvs()
    {
        return $this->clientip_cvs;
    }

    /**
     * Set siteurl
     *
     * @param string $siteurl
     * @return Config
     */
    public function setSiteurl($siteurl)
    {
        $this->siteurl = $siteurl;
        
        return $this;
    }

    /**
     * Get siteurl
     *
     * @return string
     */
    public function getSiteurl()
    {
        return $this->siteurl;
    }

    /**
     * Set sitestr
     *
     * @param string $sitestr
     * @return Config
     */
    public function setSitestr($sitestr)
    {
        $this->sitestr = $sitestr;
        
        return $this;
    }

    /**
     * Get sitestr
     *
     * @return string
     */
    public function getSitestr()
    {
        return $this->sitestr;
    }

    /**
     * Set clientip_edy
     *
     * @param string $clientipEdy
     * @return Config
     */
    public function setClientipEdy($clientipEdy)
    {
        $this->clientip_edy = $clientipEdy;
        
        return $this;
    }

    /**
     * Get clientip_edy
     *
     * @return string
     */
    public function getClientipEdy()
    {
        return $this->clientip_edy;
    }

    /**
     * Set success_url
     *
     * @param string $successUrl
     * @return Config
     */
    public function setSuccessUrl($successUrl)
    {
        $this->success_url = $successUrl;
        
        return $this;
    }

    /**
     * Get success_url
     *
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->success_url;
    }

    /**
     * Set success_str
     *
     * @param string $successStr
     * @return Config
     */
    public function setSuccessStr($successStr)
    {
        $this->success_str = $successStr;
        
        return $this;
    }

    /**
     * Get success_str
     *
     * @return string
     */
    public function getSuccessStr()
    {
        return $this->success_str;
    }

    /**
     * Set failure_url
     *
     * @param string $failureUrl
     * @return Config
     */
    public function setFailureUrl($failureUrl)
    {
        $this->failure_url = $failureUrl;
        
        return $this;
    }

    /**
     * Get failure_url
     *
     * @return string
     */
    public function getFailureUrl()
    {
        return $this->failure_url;
    }

    /**
     * Set failure_str
     *
     * @param string $failureStr
     * @return Config
     */
    public function setFailureStr($failureStr)
    {
        $this->failure_str = $failureStr;
        
        return $this;
    }

    /**
     * Get failure_str
     *
     * @return string
     */
    public function getFailureStr()
    {
        return $this->failure_str;
    }

    /**
     * Set clientip_ebank
     *
     * @param string $clientipEbank
     * @return Config
     */
    public function setClientipEbank($clientipEbank)
    {
        $this->clientip_ebank = $clientipEbank;
        
        return $this;
    }

    /**
     * Get clientip_ebank
     *
     * @return string
     */
    public function getClientipEbank()
    {
        return $this->clientip_ebank;
    }

    /**
     * Set ebank_siteurl
     *
     * @param string $ebankSiteurl
     * @return Config
     */
    public function setEbankSiteurl($ebankSiteurl)
    {
        $this->ebank_siteurl = $ebankSiteurl;
        
        return $this;
    }

    /**
     * Get ebank_siteurl
     *
     * @return string
     */
    public function getEbankSiteurl()
    {
        return $this->ebank_siteurl;
    }

    /**
     * Set ebank_sitestr
     *
     * @param string $ebankSitestr
     * @return Config
     */
    public function setEbankSitestr($ebankSitestr)
    {
        $this->ebank_sitestr = $ebankSitestr;
        
        return $this;
    }

    /**
     * Get ebank_sitestr
     *
     * @return string
     */
    public function getEbankSitestr()
    {
        return $this->ebank_sitestr;
    }

    /**
     * Set cvs_key
     *
     * @param string $cvsKey
     * @return Config
     */
    public function setCvsKey($cvsKey)
    {
        $this->cvs_key = $cvsKey;
        
        return $this;
    }

    /**
     * Get cvs_key
     *
     * @return string
     */
    public function getCvsKey()
    {
        return $this->cvs_key;
    }

    /**
     * Set edy_key
     *
     * @param string $edyKey
     * @return Config
     */
    public function setEdyKey($edyKey)
    {
        $this->edy_key = $edyKey;
        
        return $this;
    }

    /**
     * Get edy_key
     *
     * @return string
     */
    public function getEdyKey()
    {
        return $this->edy_key;
    }

    /**
     * Set ebank_key
     *
     * @param string $ebankKey
     * @return Config
     */
    public function setEbankKey($ebankKey)
    {
        $this->ebank_key = $ebankKey;
        
        return $this;
    }

    /**
     * Get ebank_key
     *
     * @return string
     */
    public function getEbankKey()
    {
        return $this->ebank_key;
    }

    /**
     * Set creditPayment
     *
     * @param \Eccube\Entity\Payment $creditPayment
     * @return Config
     */
    public function setCreditPayment(\Eccube\Entity\Payment $creditPayment = null)
    {
        $this->creditPayment = $creditPayment;
        
        return $this;
    }

    /**
     * Get creditPayment
     *
     * @return \Eccube\Entity\Payment
     */
    public function getCreditPayment()
    {
        return $this->creditPayment;
    }

    /**
     * Set cvsPayment
     *
     * @param \Eccube\Entity\Payment $cvsPayment
     * @return Config
     */
    public function setCvsPayment(\Eccube\Entity\Payment $cvsPayment = null)
    {
        $this->cvsPayment = $cvsPayment;
        
        return $this;
    }

    /**
     * Get cvsPayment
     *
     * @return \Eccube\Entity\Payment
     */
    public function getCvsPayment()
    {
        return $this->cvsPayment;
    }

    /**
     * Set edyPayment
     *
     * @param \Eccube\Entity\Payment $edyPayment
     * @return Config
     */
    public function setEdyPayment(\Eccube\Entity\Payment $edyPayment = null)
    {
        $this->edyPayment = $edyPayment;
        
        return $this;
    }

    /**
     * Get edyPayment
     *
     * @return \Eccube\Entity\Payment
     */
    public function getEdyPayment()
    {
        return $this->edyPayment;
    }

    /**
     * Set ebankPayment
     *
     * @param \Eccube\Entity\Payment $ebankPayment
     * @return Config
     */
    public function setEbankPayment(\Eccube\Entity\Payment $ebankPayment = null)
    {
        $this->ebankPayment = $ebankPayment;
        
        return $this;
    }

    /**
     * Get ebankPayment
     *
     * @return \Eccube\Entity\Payment
     */
    public function getEbankPayment()
    {
        return $this->ebankPayment;
    }

    /**
     * Set Payment according to type string
     *
     * @return Config
     */
    public function setPayment($type, \Eccube\Entity\Payment $payment = null)
    {
        switch ($type) {
            case 'ebank':
                $this->setEbankPayment($payment);
                break;
            case 'edy':
                $this->setEdyPayment($payment);
                break;
            case 'cvs':
                $this->setCvsPayment($payment);
                break;
            default:
                $this->setCreditPayment($payment);
                break;
        }
        return $this;
    }

    /**
     * Get Payment according to type string
     *
     * @return \Eccube\Entity\Payment
     */
    public function getPayment($type)
    {
        switch ($type) {
            case 'ebank':
                return $this->getEbankPayment();
            case 'edy':
                return $this->getEdyPayment();
            case 'cvs':
                return $this->getCvsPayment();
            default:
                return $this->getCreditPayment();
        }
    }

    /**
     * Set key according to type string
     *
     * @return Config
     */
    public function setKey($type, $key)
    {
        switch ($type) {
            case 'ebank':
                $this->setEbankKey($key);
                break;
            case 'edy':
                $this->setEdyKey($key);
                break;
            case 'cvs':
                $this->setCvsKey($key);
                break;
            default:
                break;
        }
        return $this;
    }

    /**
     * Get Key according to type string
     *
     * @return String
     */
    public function getKey($type)
    {
        switch ($type) {
            case 'ebank':
                return $this->getEbankKey();
            case 'edy':
                return $this->getEdyKey();
            case 'cvs':
                return $this->getCvsKey();
            default:
                return "";
        }
    }

    /**
     * Get clientip　according to type
     *
     * @return string
     */
    public function getClientipByType($type)
    {
        switch ($type) {
            case 'ebank':
                return $this->clientip_ebank;
            case 'edy':
                return $this->clientip_edy;
            case 'cvs':
                return $this->clientip_cvs;
            default:
                return $this->clientip;
                ;
        }
    }

    /**
     * Get all Payments
     *
     * @return Array of \Eccube\Entity\Payment
     */
    public function getPayments()
    {
        $payments = array();
        if ($this->creditPayment) {
            $payments[] = $this->creditPayment;
        }
        if ($this->cvsPayment) {
            $payments[] = $this->cvsPayment;
        }
        if ($this->edyPayment) {
            $payments[] = $this->edyPayment;
        }
        if ($this->ebankPayment) {
            $payments[] = $this->ebankPayment;
        }
        return $payments;
    }

    /**
     * Get Payment type string
     *
     * @return String
     */
    public function getPaymentType($payment)
    {
        if ($payment == null) {
            return null;
        }
        if ($this->creditPayment == $payment) {
            return 'credit';
        }
        if ($this->cvsPayment == $payment) {
            return 'cvs';
        }
        if ($this->edyPayment == $payment) {
            return 'edy';
        }
        if ($this->ebankPayment == $payment) {
            return 'ebank';
        }
        return null;
    }
}
