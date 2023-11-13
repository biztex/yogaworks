<?php

namespace Plugin\ZeusPayment4\Validator\Constraints;

use Plugin\ZeusPayment4\Entity\Config;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * ClientIP検証
 */
class ClientIpValidator extends ConstraintValidator
{
    public function __construct($zeusPaymentService)
    {
        $this->zeusPaymentService = $zeusPaymentService;
    }
    
    /**
     * Validate clientip and clientauthkey
     */
    public function validate($value, Constraint $constraint)
    {
        if (! $constraint instanceof ClientIp) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\ClientIp');
        }
        
        $errorCode = '';
        if ($value && $value instanceof Config) {
            $clientip = $value->getClientIp();
            $clientauthkey = $value->getClientauthkey();
            if (strlen($clientauthkey) > 0 && is_numeric($clientip) && (strlen($clientip) == 5 or strlen($clientip) == 10)) {
                $errorCode = $this->zeusPaymentService->verifyConfig($clientip, $clientauthkey, $value);
            }
        }
        
        if ($errorCode != '') {
            $errorMessage = $constraint->getDetailError($errorCode);
            $this->context->buildViolation($errorMessage)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}
