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

namespace Plugin\JoolenPointsForMemberRegistration4\Entity;

use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\BaseInfo")
 */
trait BaseInfoTrait
{
    /**
     * 会員登録時付与ポイント
     *
     * @ORM\Column(name="member_registration_point", type="decimal", precision=10, scale=0, options={"unsigned":true, "default":0}, nullable=false)
     * @var string
     */
    private $member_registration_point;

    /**
     * 付与期間（開始）
     *
     * @var boolean|null
     *
     * @ORM\Column(name="apply_datetime_start", type="datetimetz", nullable=true)
     */
    private $apply_datetime_start;

    /**
     * 付与期間（終了）
     *
     * @var boolean|null
     *
     * @ORM\Column(name="apply_datetime_end", type="datetimetz", nullable=true)
     */
    private $apply_datetime_end;

    /**
     * @param $memberRegistrationPoint
     *
     * @return $this
     */
    public function setMemberRegistrationPoint($memberRegistrationPoint)
    {
        $this->member_registration_point = $memberRegistrationPoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getMemberRegistrationPoint()
    {
        return $this->member_registration_point;
    }

    /**
     * Set apply_datetime_start
     *
     * @param boolean|null $apply_datetime_start
     *
     * @return $this
     */
    public function setApplyDatetimeStart($apply_datetime_start = null)
    {
        $this->apply_datetime_start = $apply_datetime_start;
        return $this;
    }

    /**
     * Get apply_datetime_start
     *
     * @return boolean|null
     */
    public function getApplyDatetimeStart()
    {
        return $this->apply_datetime_start;
    }

    /**
     * Set apply_datetime_end
     *
     * @param boolean|null $apply_datetime_end
     *
     * @return $this
     */
    public function setApplyDatetimeEnd($apply_datetime_end = null)
    {
        $this->apply_datetime_end = $apply_datetime_end;
        return $this;
    }

    /**
     * Get apply_datetime_end
     *
     * @return boolean|null
     */
    public function getApplyDatetimeEnd()
    {
        return $this->apply_datetime_end;
    }
}
