<?php

namespace App\Http\Controllers\Admin;

use App\Constants\CommissionRates;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Invoice;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SalesKpiController extends Controller
{
    protected ?Collection $teams = null;
    protected ?Collection $brands = null;

    public function __construct(Request $request)
    {
        $this->teams = Team::where('status', 1)->orderBy('name')->get();
        $this->brands = Brand::where('status', 1)->orderBy('name')->get();
        view()->share(['teams' => $this->teams, 'brands' => $this->brands]);
    }

    public function index()
    {
        return view('admin.sales.index');
    }

    public function index_2()
    {
        return view('admin.sales.index-2');
    }

    public function index_update(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'team_key' => 'sometimes|string',
            'brand_key' => 'sometimes|string'
        ]);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $teamKey = $validated['team_key'] ?? 'all';
        $brandKey = $validated['brand_key'] ?? 'all';
        $users = $this->getFilteredUsers($teamKey);
        $timePeriods = $this->prepareTimePeriods($startDate, $endDate);
        // Process each user's performance data
        $data = $users->map(function ($user) use ($startDate, $endDate, $teamKey, $brandKey, $timePeriods) {
            return $this->calculateUserPerformance(
                $user,
                $startDate,
                $endDate,
                $teamKey,
                $brandKey,
                $timePeriods
            );
        });
        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'period' => $this->formatDateRange($startDate, $endDate),
                'filters' => compact('teamKey', 'brandKey')
            ]
        ]);
    }

    public function index_update_2(Request $request)
    {

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'team_key' => 'sometimes|string',
            'brand_key' => 'sometimes|string'
        ]);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $teamKey = $validated['team_key'] ?? 'all';
        $brandKey = $validated['brand_key'] ?? 'all';
        $users = $this->getFilteredUsers($teamKey);
        $data = [];
        foreach ($users as $user) {
            // Calculate individual performance
            $invoices = Invoice::where('status', Invoice::STATUS_PAID)
                ->where('agent_id', $user->id)
                ->whereHas('payment', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('payment_date', [$startDate, $endDate]);
                })
                ->get();
            $achieved = $invoices->sum('total_amount');
            $target = $user->target??0;
            $percentage = $target > 0 ? round(($achieved / $target) * 100, 2) : 0;
            $upToTarget = min($achieved, $target);
            $aboveTarget = max(0, $achieved - $target);
            $aboveTargetPercentage = $target > 0 ? ($aboveTarget / $target * 100) : 0;
            // Individual commission (4% up to target, 6% above target)
            $individual4x = $percentage >= 85 ? $upToTarget * 4 : 0;
            $individual6x = $percentage >= 85 ? $aboveTarget * 6 : 0;
            $individualCommission = $individual4x + $individual6x;
            $teamsCommissionData = $this->calculateTeamsCommission($user, $startDate, $endDate, $teamKey, $brandKey);
            $timePeriods = $this->prepareTimePeriods($startDate, $endDate);
            // Wire commission
            $wirePayments = $this->calculateWirePayments($user, $startDate, $endDate, $timePeriods, $teamKey, $brandKey, $target);
            $bonusTiers = $this->calculateTieredBonus($achieved, $target, $percentage);
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'target' => $target,
                'achieved' => $achieved,
                'up_to_target' => $upToTarget,
                'above_target' => $aboveTarget,
                'achieved_percentage' => $percentage,
                'above_target_percentage' => $aboveTargetPercentage,
                'individual_4x' => $individual4x,
                'individual_6x' => $individual6x,
                'individual_commission' => $individualCommission,
                'total_team_commission' => $teamsCommissionData['teamsData']['total_team_commission'] ?? 0,
                'wire' => $wirePayments,
                'above_target2x' => $bonusTiers['tier1'],
                'above_target2_5x' => $bonusTiers['tier2'],
                'above_target3x' => $bonusTiers['tier3'],
                'total_bonus' => $bonusTiers['total'],
                'lead_bonus' => round(($teamsCommissionData['teamsData']['lead_bonus'] ?? 0)),
                'total_amount' => round(($individualCommission + ($teamsCommissionData['teamsData']['total_team_commission'] ?? 0))),
                ...$teamsCommissionData
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data,
            'draw' => $request->input('draw', 1),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data)
        ]);
    }

    protected function getFilteredUsers(string $teamKey, string $department = 'Sales')
    {
        return User::with(['teams' => fn($q) => $q->select('teams.team_key', 'teams.name', 'teams.lead_id')])
            ->department($department)
            ->when($teamKey !== 'all', fn($q) => $q->whereHas('teams', fn($q) => $q->where('assign_team_members.team_key', $teamKey)
            ))
            ->get(['users.id', 'users.name', 'users.target']);
    }

    protected function prepareTimePeriods(Carbon $startDate, Carbon $endDate): array
    {
        $daysInRange = $startDate->diffInDays($endDate);
        return [
            'previous' => [
                'start' => $startDate->copy()->subDays($daysInRange),
                'end' => $startDate->copy()
            ],
            'sixtyDays' => [
                'start' => $startDate->copy()->subDays($daysInRange * 2),
                'end' => $startDate->copy()->subDays($daysInRange)
            ]
        ];
    }

    protected function calculateUserPerformance(
        User   $user,
        Carbon $startDate,
        Carbon $endDate,
        string $teamKey,
        string $brandKey,
        array  $timePeriods
    ): array
    {
        $target = $user->target;
        // Main invoice calculations
        $invoices = $this->getUserInvoices($user->id, $startDate, $endDate, $teamKey, $brandKey);
        $achieved = $invoices->sum('total_amount');
        $percentage = $target > 0 ? round(($achieved / $target) * 100, 2) : 0;
        $upToTarget = min($achieved, $target);
        $aboveTarget = max(0, $achieved - $target);
        // Commission calculations
        $individualCommission = $this->calculateIndividualCommission($achieved, $target, $percentage);
        // Team commission if user is a team lead
        $teamsCommissionData = $this->calculateTeamsCommission($user, $startDate, $endDate, $teamKey, $brandKey);
        // Spiffs
        // Wire transfers
        $wirePayments = $this->calculateWirePayments($user, $startDate, $endDate, $timePeriods, $teamKey, $brandKey, $target);
        // Above Target Spiff
        $bonusTiers = $this->calculateTieredBonus($achieved, $target, $percentage);
        // Above Target Spiff
        return [
            'id' => $user->id,
            'name' => $user->name,
            'target' => $target,
            'achieved' => $achieved,
            'up_to_target' => $upToTarget,
            'above_target' => $aboveTarget,
            'achieved_percentage' => $percentage,
            'above_target_percentage' => $aboveTarget > 0 ? round(($aboveTarget / $target) * 100, 2) : 0,
            'commission' => $individualCommission,
            'wire' => $wirePayments,
            'above_target2x' => $bonusTiers['tier1'],
            'above_target2_5x' => $bonusTiers['tier2'],
            'above_target3x' => $bonusTiers['tier3'],
            'total_bonus' => $bonusTiers['total'],
            'total_amount' => round((($individualCommission['amount'] ?? 0) + ($teamsCommissionData['teamsData']['total_team_commission'] ?? 0))),
            ...$teamsCommissionData
        ];
    }

    protected function getUserInvoices(
        int    $userId,
        Carbon $startDate,
        Carbon $endDate,
        string $teamKey,
        string $brandKey
    ): Collection
    {
        return Invoice::where('status', Invoice::STATUS_PAID)
            ->where('agent_id', $userId)
            ->whereHas('payment', fn($q) => $q->whereBetween('payment_date', [$startDate, $endDate]))
            ->when($teamKey !== 'all', fn($q) => $q->where('team_key', $teamKey))
            ->when($brandKey !== 'all', fn($q) => $q->where('brand_key', $brandKey))
            ->get(['total_amount', 'invoice_key']);
    }

    protected function calculateIndividualCommission(float $achieved, float $target, float $percentage): array
    {
        if ($percentage < CommissionRates::MIN_INDIVIDUAL_COMMISSION_THRESHOLD) {
            return [];
        }
        $base = min($achieved, $target);
        $above = max(0, $achieved - $target);
        return [
            'base' => $base * CommissionRates::INDIVIDUAL_BASE_RATE,
            'above' => $above * CommissionRates::INDIVIDUAL_BONUS_RATE,
            'amount' => ($base * CommissionRates::INDIVIDUAL_BASE_RATE) + ($above * CommissionRates::INDIVIDUAL_BONUS_RATE),
        ];
    }

    protected function calculateWirePayments(
        User   $user,
        Carbon $startDate,
        Carbon $endDate,
        array  $timePeriods,
        string $teamKey,
        string $brandKey,
        float  $target
    ): array
    {
        return [
            'current' => $this->getWireCommission(
                $user->id,
                $startDate,
                $endDate,
                $teamKey,
                $brandKey,
                $target
            ),
            'previous' => $this->getWireCommission(
                $user->id,
                $timePeriods['previous']['start'],
                $timePeriods['previous']['end'],
                $teamKey,
                $brandKey,
                $target
            ),
            'sixtyDays' => $this->getWireCommission(
                $user->id,
                $timePeriods['sixtyDays']['start'],
                $timePeriods['sixtyDays']['end'],
                $teamKey,
                $brandKey,
                $target
            ),
        ];
    }

    protected function getWireCommission(
        int    $userId,
        Carbon $start,
        Carbon $end,
        string $teamKey,
        string $brandKey,
        float  $target
    ): array
    {
        $invoices = Invoice::with(['payment' => function ($query) {
            $query->select('id', 'invoice_key', 'amount', 'payment_method', 'payment_date');
        }])->where('status', Invoice::STATUS_PAID)
            ->where('agent_id', $userId)
            ->whereHas('payment', fn($q) => $q
                ->where('payment_method', 'bank transfer')
                ->whereBetween('payment_date', [$start, $end]))
            ->when($teamKey !== 'all', fn($q) => $q->where('team_key', $teamKey))
            ->when($brandKey !== 'all', fn($q) => $q->where('brand_key', $brandKey))
            ->get(['id', 'invoice_key', 'team_key', 'brand_key', 'total_amount']);
        return $this->calculateWireCommission($invoices, $target);
    }

    /**
     * Wire Spiff Calculation
     */
    protected function calculateWireCommission(Collection $invoices, float $target): array
    {
        $tiers = [
            'wire3x' => 0,
            'wire2x' => 0,
            'wire1x' => 0
        ];
        $wire_amount = 0;
        foreach ($invoices as $invoice) {
            $amount = $invoice->payment->amount;
            if ($amount >= CommissionRates::WIRE_TIERS['3x']) {
                $wire_amount += $amount;
                $tiers['wire3x'] += ($amount * 3);
            } elseif ($amount >= CommissionRates::WIRE_TIERS['2x']) {
                $wire_amount += $amount;
                $tiers['wire2x'] += ($amount * 2);
            } elseif ($amount >= CommissionRates::WIRE_TIERS['1x']) {
                $wire_amount += $amount;
                $tiers['wire1x'] += ($amount * 1);
            }
        }
        $commission = $tiers['wire3x'] + $tiers['wire2x'] + $tiers['wire1x'];
        return [
            'wire_amount' => $wire_amount,
            'commission' => $commission,
            'percentage' => $target > 0 ? ($commission / $target * 100) : 0,
            ...$tiers
        ];
    }

    protected function calculateTeamsCommission(
        User   $user,
        Carbon $startDate,
        Carbon $endDate,
        string $teamKey,
        string $brandKey
    ): array
    {
        $teams = [];
        $totalBase = 0;
        $totalAbove = 0;
        $totalCommission = 0;
        $leadBonus = 0;
        $isLead = false;
        foreach ($user->teams as $team) {
            $teamTarget = $team->users->sum('target');
            $teamAchieved = $team->users->sum(function ($member) use ($startDate, $endDate, $teamKey, $brandKey) {
                return Invoice::where('status', Invoice::STATUS_PAID)
                    ->where('agent_id', $member->id)
                    ->whereHas('payment', fn($q) => $q->whereBetween('payment_date', [$startDate, $endDate]))
                    ->when($teamKey !== 'all', fn($q) => $q->where('team_key', $teamKey))
                    ->when($brandKey !== 'all', fn($q) => $q->where('brand_key', $brandKey))
                    ->sum('total_amount');
            });
            $teamPercentage = $teamTarget > 0 ? round($teamAchieved / $teamTarget * 100, 2) : 0;
            $teamUpToTarget = min($teamAchieved, $teamTarget);
            $teamAboveTarget = max(0, $teamAchieved - $teamTarget);
            $baseCommission = $teamPercentage >= CommissionRates::MIN_TEAM_COMMISSION_THRESHOLD ? $teamUpToTarget * 2 : 0;
            $aboveCommission = $teamPercentage >= CommissionRates::MIN_TEAM_COMMISSION_THRESHOLD ? $teamAboveTarget * 4 : 0;
            $teamCommission = $baseCommission + $aboveCommission;
            if ($team->lead_id === $user->id) {
                $isLead = true;
                $totalBase += $baseCommission;
                $totalAbove += $aboveCommission;
                $totalCommission += $teamCommission;
                $teams[$team->team_key] = [
                    'name' => $team->name,
                    'target' => $teamTarget,
                    'achieved' => $teamAchieved,
                    'percentage' => $teamPercentage,
                    'is_lead' => $isLead,
                    'commission' => [
                        'base' => $baseCommission,
                        'above' => $aboveCommission,
                        'amount' => $teamCommission,
                    ]
                ];
                if ($isLead && $teamPercentage > CommissionRates::LEAD_BONUS) {
                    $leadBonus = $teamAboveTarget * 3;
                    $teams[$team->team_key]['lead_bonus'] = $leadBonus;
                    $leadBonus += $leadBonus;

                }
            } else {
                $teams[$team->team_key] = [
                    'name' => $team->name,
                ];
            }
        }
        return [
            'teams' => $teams,
            'is_lead' => $isLead,
            'teamsData' => [
                'total_team_commission' => $totalCommission,
                'lead_bonus' => $leadBonus,
                'is_lead' => $isLead,
                'commission' => [
                    'base' => $totalBase,
                    'above' => $totalAbove,
                    'amount' => $totalCommission
                ]],
        ];
    }

    protected function calculateTeamCommission(
        User   $user,
        Carbon $startDate,
        Carbon $endDate,
        string $teamKey,
        string $brandKey
    ): array
    {
        $team = $user->teams->first();
        if (!$team || $team->lead_id !== $user->id) {
            return [];
        }
        $teamAchieved = $team->users->sum(function ($member) use ($startDate, $endDate, $teamKey, $brandKey) {
            return Invoice::where('status', Invoice::STATUS_PAID)
                ->where('agent_id', $member->id)
                ->whereHas('payment', fn($q) => $q->whereBetween('payment_date', [$startDate, $endDate]))
                ->when($teamKey !== 'all', fn($q) => $q->where('team_key', $teamKey))
                ->when($brandKey !== 'all', fn($q) => $q->where('brand_key', $brandKey))
                ->sum('total_amount');
        });
        $teamTarget = $team->users->sum('target');
        $teamPercentage = $teamTarget > 0 ? round($teamAchieved / $teamTarget * 100, 2) : 0;
        if ($teamPercentage < CommissionRates::MIN_TEAM_COMMISSION_THRESHOLD) {
            return [
                'target' => $teamTarget,
                'achieved' => $teamAchieved,
                'commission' => []
            ];
        }
        $teamUpToTarget = min($teamAchieved, $teamTarget);
        $teamAboveTarget = max(0, $teamAchieved - $teamTarget);
        return [
            'target' => $teamTarget,
            'achieved' => $teamAchieved,
            'percentage' => $teamPercentage,
            'above_target_percentage' => $teamAboveTarget > 0 ? ($teamAboveTarget / $teamTarget * 100) : 0,
            'commission' => [
                'base' => $teamUpToTarget * 2,
                'above' => $teamAboveTarget * 4,
                'amount' => ($teamUpToTarget * 2) + ($teamAboveTarget * 4),
            ]
        ];
    }

    protected function formatDateRange(Carbon $start, Carbon $end): array
    {
        return [
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d')
        ];
    }

    /**
     * Team Lead Spiff Calculation
     */
    protected function calculateTieredBonus(float $achieved, float $target, float $percentage): array
    {
        $tier1 = $tier2 = $tier3 = 0;
        $percentage -= 100;
        if ($percentage >= CommissionRates::BONUS_TIERS['3x']) {
            $tier3 = max(0, $achieved - ($target * 3.5)) * 3;
        } else if ($percentage >= CommissionRates::BONUS_TIERS['2_5x']) {
            $tier2 = max(0, $achieved - ($target * 3)) * 2.5;
        } else if ($percentage >= CommissionRates::BONUS_TIERS['2x']) {
            $tier1 = max(0, $achieved - ($target * 2.5)) * 2;
        }
        return [
            'tier1' => $tier1,
            'tier2' => $tier2,
            'tier3' => $tier3,
            'total' => $tier1 + $tier2 + $tier3
        ];
    }
//        public function exportExcel(Request $request)
//    {
//        $request->validate([
//            'start_date' => 'required|date',
//            'end_date' => 'required|date|after_or_equal:start_date'
//        ]);
//
//        // Similar data preparation as getData() method
//        // Then use Laravel Excel to export
//
//        return Excel::download(new SalesKpiExport($request->start_date, $request->end_date), 'sales-kpi-export.xlsx');
//    }
}





