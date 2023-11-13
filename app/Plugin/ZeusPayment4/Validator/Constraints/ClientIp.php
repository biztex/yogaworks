<?php

namespace Plugin\ZeusPayment4\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * ClientIP検証
 */
class ClientIp extends Constraint
{
    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }

    public function getDetailError($code)
    {
        $errorArray = array(
            'NETERR' => '通信に失敗しました。',
            '02130114' => 'IP コードが未入力です。',
            '02130117' => 'IP コードの入力に誤りがあります。',
            '02130110' => '無効な IP コードです。',
            '02130118' => '無効な IP コードです。',
            '02130214' => '認証キーが未入力です。',
            '02130217' => '認証キーの入力に誤りがあります。',
            '02130210' => '無効な認証キーです。'
        );
        $msg = '';
        if (array_key_exists($code, $errorArray)) {
            $msg = $errorArray[$code];
        }
        return '[ゼウス通信結果] 加盟店IPコード/認証コードにて認証出来ません。' . $msg;
    }
    
    public function validatedBy()
    {
        return 'unique.clientip';
    }
}
