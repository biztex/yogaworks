<?php

namespace Plugin\ZeusPayment4\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * 桁数検証
 */
class OrLengthValidator extends ConstraintValidator
{

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (! $constraint instanceof OrLength) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\OrLength');
        }
        
        if (($value != null) && (! is_scalar($value) && ! (is_object($value) && method_exists($value, '__toString')))) {
            throw new UnexpectedTypeException($value, 'string');
        }
        
        $length = strlen((string) $value);
        if ($constraint->options && is_array($constraint->options)) {
            $valid = false;
            foreach ($constraint->options as $opt) {
                if ($length == (int) $opt) {
                    $valid = true;
                    break;
                }
            }
            if (! $valid) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->addViolation();
            }
        }
    }
}
