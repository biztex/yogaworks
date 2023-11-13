<?php

namespace Plugin\ZeusPayment4\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * カード有効期限検証
 */
class CardExpiration extends Constraint
{
    public $message = '有効期限の選択に誤りが有ります。';
}
