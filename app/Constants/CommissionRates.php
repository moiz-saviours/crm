<?php

namespace App\Constants;
class CommissionRates
{
    public final const INDIVIDUAL_BASE_RATE = 4;
    public const INDIVIDUAL_BONUS_RATE = 6;
    public const TEAM_BASE_RATE = 2;
    public const TEAM_BONUS_RATE = 4;
    public const MIN_INDIVIDUAL_COMMISSION_THRESHOLD = 85;
    public const MIN_TEAM_COMMISSION_THRESHOLD = 85;
    public const WIRE_TIERS = [
        '1x' => 3000,
        '2x' => 5000,
        '3x' => 10000
    ];
    public const BONUS_TIERS = [
        '2x' => 150,
        '2_5x' => 200,
        '3x' => 250
    ];
    public const LEAD_BONUS = 150;
}
