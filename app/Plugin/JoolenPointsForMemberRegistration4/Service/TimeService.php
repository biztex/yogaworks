<?php

/*
 * Plugin Name: JoolenPointsForMemberRegistration4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPointsForMemberRegistration4\Service;

/*
 * 時間処理まとめサービス
 * ・時間を統一するためにも使用する
 *
 */
class TimeService
{
    private $Now = null;

    public function __construct()
    {
        $this->Now = new \DateTime();
        if (is_null(self::$instance)) {
            self::$instance = $this;
        }
    }

    // $TimeService = \Plugin\XXXX\Service\TimeService::getInstance();
    protected static $instance;
    public static function getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new TimeService();
        }

        return self::$instance;
    }


    // ---------- ---------- ---------- ----------

    // 現在時刻の取得
    // $NowDateTime = $this->TimeService->cloneNowDateTime();
    public function cloneNowDateTime()
    {
        return clone $this->Now;
    }


    // ---------- ---------- ---------- ----------
    // 期間判定

    /**
     * 現在日時）が、指定期間内（$DateTimeStart 〜 $DateTimeEnd）[である:true / でない:false]
     * ・開始日、終了日ともにnullの場合は、指定値（$valueBothNull）を返す
     *
     * @param $DateTimeStart        : 期間 開始日
     * @param $DateTimeEnd          : 期間 終了日
     * @param bool $valueBothNull   : 開始日、終了日ともにnullの場合に返す値の指定（指定なしの場合はtrue）
     * @return bool
     */
    public function isInTerm($DateTimeStart, $DateTimeEnd, $valueBothNull = true)
    {
        $NowDateTime = $this->cloneNowDateTime();
        return $this->isInTermCore($NowDateTime, $DateTimeStart, $DateTimeEnd, $valueBothNull);
    }

    /**
     * 指定日時（$NowDateTime）が、指定期間内（$DateTimeStart 〜 $DateTimeEnd）[である:true / でない:false]
     * ・開始日、終了日ともにnullの場合は、指定値（$valueBothNull）を返す
     *
     * @param $NowDateTime          : 指定日時
     * @param $DateTimeStart        : 期間 開始日
     * @param $DateTimeEnd          : 期間 終了日
     * @param bool $valueBothNull   : 開始日、終了日ともにnullの場合に返す値の指定（指定なしの場合はtrue）
     * @return bool
     */
    private function isInTermCore($NowDateTime, $DateTimeStart, $DateTimeEnd, $valueBothNull = true)
    {
        // ・開始日、終了日ともにnullの場合は、指定値（$valueBothNull）を返す
        if (!$DateTimeStart && !$DateTimeEnd) {
            return $valueBothNull;
        }

        // 期間開始前はNG
        if (!is_null($DateTimeStart) && $NowDateTime < $DateTimeStart) {
            return false;
        }

        // 期間終了後はNG
        if (!is_null($DateTimeEnd)) {
            $DateTimeEndTmp = clone $DateTimeEnd;
            $DateTimeEndTmp->modify('+ 1 day');
            if ($DateTimeEndTmp < $NowDateTime) {
                return false;
            }
        }

        return true;
    }

    /**
     * 開始日と終了日が期間として[正しい:true / 不正:false]
     *
     * @param $DateTimeStart  : 開始日
     * @param $DateTimeEnd    : 終了日
     * @return bool
     */
    public function isValidTerm($DateTimeStart, $DateTimeEnd)
    {
        // 開始日 が 終了日 より[未来]だとNG
        if ($DateTimeEnd < $DateTimeStart) {
            return false;
        }
        return true;
    }

}
