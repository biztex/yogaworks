<?php

namespace Plugin\ZeusPayment4\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * 桁数検証
 */
class OrLength extends Constraint
{
    public $message = '桁数が正しくありません。';
    public $options;
}
