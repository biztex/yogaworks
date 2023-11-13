<?php

namespace Plugin\ZeusPayment4\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * カード有効期限検証
 */
class CardExpirationValidator extends ConstraintValidator
{

    /**
     * Validate clientip and clientauthkey
     */
    public function validate($value, Constraint $constraint)
    {
        if (! $constraint instanceof CardExpiration) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\CardExpiration');
        }
        if ($value && !$value['Quick']) {
            $yearMonth = $value['ExpireYear'] . $value['ExpireMonth'];
            if ($yearMonth < date('Ym', mktime(0, 0, 0, date("m"), date("d"), date("Y")))) {
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->atPath('[ExpireMonth]')
                ->addViolation();
            }
        }
    }
}
