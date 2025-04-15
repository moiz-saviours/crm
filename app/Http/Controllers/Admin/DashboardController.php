<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\ClientContact;
use App\Models\CustomerContact;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Payment;
use App\Models\Team;
use App\Models\TeamTarget;
use App\Models\User;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected int $currentMonth;
    protected int $currentYear;

    public function __construct()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $activeTime = Carbon::now()->subMinutes(5);
        $totalAdmins = Admin::count();
        $activeAdmins = Admin::where('last_seen', '>=', $activeTime)->get();
        $totalUsers = User::count();
        $activeUsers = User::where('last_seen', '>=', $activeTime)->get();
        $freshInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->where('type', 0)->where('status',1)->get();
        $upsaleInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->where('type', 1)->where('status',1)->get();
        $adminProgress = $totalAdmins > 0 && count($activeAdmins) > 0 ? (count($activeAdmins) / $totalAdmins) * 100 : 0;
        $userProgress = $totalUsers > 0 && count($activeUsers) > 0 ? (count($activeUsers) / $totalUsers) * 100 : 0;
        $freshInvoiceProgress = (count($freshInvoices) + count($upsaleInvoices)) > 0 ? (count($freshInvoices) / (count($freshInvoices) + count($upsaleInvoices))) * 100 : 0;
        $upsalInvoiceProgress = (count($freshInvoices) + count($upsaleInvoices)) > 0 ? (count($upsaleInvoices) / (count($freshInvoices) + count($upsaleInvoices))) * 100 : 0;
        view()->share(compact('activeUsers', 'totalUsers', 'userProgress', 'activeAdmins', 'totalAdmins', 'adminProgress', 'freshInvoices', 'upsaleInvoices', 'freshInvoiceProgress', 'upsalInvoiceProgress'));
    }

    public function index_1()
    {
        $totalInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->count();
        $paidInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->where('status', 1)
            ->get();
        $dueInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->where('status', 0)
            ->get();
        $refundInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->where('status', 2)
            ->get();
        $chargebackInvoices = Invoice::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->where('status', 3)
            ->get();
        $invoicesProgress = $totalInvoices > 0 ? [
            'due' => (count($dueInvoices) / $totalInvoices) * 100,
            'paid' => (count($paidInvoices) / $totalInvoices) * 100,
            'refund' => (count($refundInvoices) / $totalInvoices) * 100,
            'chargeback' => (count($chargebackInvoices) / $totalInvoices) * 100
        ] : ['due' => 0, 'paid' => 0, 'refund' => 0, 'chargeback' => 0];
        $totalPayments = Payment::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->count();
        $paymentCounts = Payment::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->selectRaw("
            COUNT(CASE WHEN status = 1 THEN 1 END) as paid,
            COUNT(CASE WHEN status = 2 THEN 1 END) as refund,
            COUNT(CASE WHEN status = 3 THEN 1 END) as chargeback
        ")->first();
        $paymentsProgress = $totalPayments > 0 ? [
            'paid' => ($paymentCounts->paid / $totalPayments) * 100,
            'refund' => ($paymentCounts->refund / $totalPayments) * 100,
            'chargeback' => ($paymentCounts->chargeback / $totalPayments) * 100
        ] : ['paid' => 0, 'refund' => 0, 'chargeback' => 0];
        $totalLeads = Lead::whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->count();
        $totalCustomers = CustomerContact::count();
        $recentPayments = Payment::whereStatus(1)->latest()->limit(5)->get();
        $leadStatuses = LeadStatus::all();
        $leadCounts = [];
        foreach ($leadStatuses as $status) {
            $leadCounts[$status->name] = Lead::where('lead_status_id', $status->id)->count();
        }
        $dailyPayments = [];
        $dailyLabels = [];
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        for ($day = 1; $day <= Carbon::now()->daysInMonth; $day++) {
            $DayPaymentsQuery = Payment::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereDay('created_at', $day)
                ->sum('amount');
            $dailyPayments[] = $DayPaymentsQuery;
            $dailyLabels[] = Carbon::createFromDate($currentYear, $currentMonth, $day)->format('d');
        }
        $year = Carbon::now()->year;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $annualPayments = [];
        foreach ($months as $index => $month) {
            $MonthPaymentsQuery = Payment::whereYear('created_at', $year)
                ->whereMonth('created_at', $index + 1)
                ->sum('amount');
            $annualPayments[] = $MonthPaymentsQuery;
        }
        return view('admin.dashboard.index-1', [
            'totalInvoices' => $totalInvoices,
            'dueInvoices' => $dueInvoices,
            'paidInvoices' => $paidInvoices,
            'refundInvoices' => $refundInvoices,
            'chargebackInvoices' => $chargebackInvoices,
            'invoicesProgress' => $invoicesProgress,
            'recentPayments' => $recentPayments,
            'leadStatuses' => $leadStatuses,
            'leadCounts' => $leadCounts,
            'dailyPayments' => $dailyPayments,
            'dailyLabels' => $dailyLabels,
            'annualPayments' => $annualPayments,
            'totalPayments' => $totalPayments,
            'paymentsProgress' => $paymentsProgress,
            'paymentCounts' => $paymentCounts,
            'totalLeads' => $totalLeads,
            'totalCustomers' => $totalCustomers,
        ]);
    }

    public function index_2()
    {
        $teams = Team::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('admin.dashboard.index-2', ['teams' => $teams, 'brands' => $brands]);
    }

    public function index_2_update_stats(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $teamKey = $request->input('team_key', 'all');
            $brandKey = $request->input('brand_key', 'all');
            if ($startDate > $endDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date range: start date cannot be greater than end date.'
                ], 400);
            }
            $dateRanges = [];
            $currentStart = $startDate;
            while ($currentStart <= $endDate) {
                $monthStart = date('Y-m-01', strtotime($currentStart));
                $monthEnd = date('Y-m-t', strtotime($currentStart));
                $rangeStart = max($currentStart, $monthStart);
                $rangeEnd = min($endDate, $monthEnd);
                $dateRanges[] = [
                    'start' => $rangeStart,
                    'end' => $rangeEnd,
                ];
                $currentStart = date('Y-m-01', strtotime($currentStart . ' +1 month'));
            }
            $mtdTotalSales = 0;
            $previousMtdTotalSales = 0;
            foreach ($dateRanges as $range) {
                $mtdStartDate = $range['start'];
                $mtdEndDate = $range['end'];
                $mtdSales = Invoice::where('status', Invoice::STATUS_PAID)
                    ->whereBetween('created_at', [$mtdStartDate, $mtdEndDate])
                    ->when($teamKey != 'all', function ($query) use ($teamKey) {
                        return $query->where('team_key', $teamKey);
                    })
                    ->when($brandKey != 'all', function ($query) use ($brandKey) {
                        return $query->where('brand_key', $brandKey);
                    })
                    ->sum('total_amount');
                $mtdTotalSales += $mtdSales;
                $previousMtdStartDate = date('Y-m-d', strtotime($mtdStartDate . ' -1 month'));
                $previousMtdEndDate = date('Y-m-d', strtotime($mtdEndDate . ' -1 month'));
                $previousMtdSales = Invoice::where('status', Invoice::STATUS_PAID)
                    ->whereBetween('created_at', [$previousMtdStartDate, $previousMtdEndDate])
                    ->when($teamKey != 'all', function ($query) use ($teamKey) {
                        return $query->where('team_key', $teamKey);
                    })
                    ->when($brandKey != 'all', function ($query) use ($brandKey) {
                        return $query->where('brand_key', $brandKey);
                    })
                    ->sum('total_amount');
                $previousMtdTotalSales += $previousMtdSales;
            }
            $lapsePercentage = 0;
            if ($previousMtdTotalSales != 0) {
                $lapsePercentage = (($mtdTotalSales - $previousMtdTotalSales) / $previousMtdTotalSales) * 100;
            } else {
                if ($mtdTotalSales > 0) {
                    $lapsePercentage = 100;
                }
            }
            $employees = User::with('teams')
                ->where('status', 1)
                ->when($teamKey !== 'all', function ($query) use ($teamKey) {
                    $query->whereHas('teams', function ($teamQuery) use ($teamKey) {
                        $teamQuery->where('teams.team_key', $teamKey);
                    });
                })
                ->get()->map(function ($employee) use ($startDate, $endDate, $teamKey, $brandKey) {
                    $employee->sales = Invoice::where('status', Invoice::STATUS_PAID)->where('agent_id', $employee->id)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->when($teamKey != 'all', function ($query) use ($teamKey) {
                            return $query->where('team_key', $teamKey);
                        })
                        ->when($brandKey != 'all', function ($query) use ($brandKey) {
                            return $query->where('brand_key', $brandKey);
                        })
                        ->sum('total_amount');
                    return $employee;
                });
            $totalSales = Invoice::where('status', Invoice::STATUS_PAID)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($teamKey != 'all', function ($query) use ($teamKey) {
                    return $query->where('team_key', $teamKey);
                })
                ->when($brandKey != 'all', function ($query) use ($brandKey) {
                    return $query->where('brand_key', $brandKey);
                })
                ->sum('total_amount');
            $totalUpSales = Invoice::where('status', Invoice::STATUS_PAID)
                ->where('type', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($teamKey != 'all', function ($query) use ($teamKey) {
                    return $query->where('team_key', $teamKey);
                })
                ->when($brandKey != 'all', function ($query) use ($brandKey) {
                    return $query->where('brand_key', $brandKey);
                })
                ->sum('total_amount');
            $refunded = Invoice::where('status', Invoice::STATUS_REFUNDED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($teamKey != 'all', function ($query) use ($teamKey) {
                    return $query->where('team_key', $teamKey);
                })
                ->when($brandKey != 'all', function ($query) use ($brandKey) {
                    return $query->where('brand_key', $brandKey);
                })
                ->sum('total_amount');
            $chargeBack = Invoice::where('status', Invoice::STATUS_CHARGEBACK)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($teamKey != 'all', function ($query) use ($teamKey) {
                    return $query->where('team_key', $teamKey);
                })
                ->when($brandKey != 'all', function ($query) use ($brandKey) {
                    return $query->where('brand_key', $brandKey);
                })
                ->sum('total_amount');
            $chargeBackRatio = $totalSales > 0 ? (($chargeBack / $totalSales) * 100) . ' ' : '0 ';
            $netSales = $totalSales - ($refunded + $chargeBack);
            $range = $this->getMonthsBetweenDates($startDate, $endDate);
            $teams = Team::with('targets')->where('status', 1)
                ->when($teamKey != 'all', function ($query) use ($teamKey) {
                    return $query->where('team_key', $teamKey);
                })->get();
            $team_targets = [];
            $total_target = 0;
            $total_target_achieved = 0;
            foreach ($range as $rangeval) {
                foreach ($teams as $team) {
                    $team_achieved = Invoice::where('status', Invoice::STATUS_PAID)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->where('team_key', $team->team_key)
                        ->sum('total_amount');
                    $total_target_achieved += $team_achieved;
                    $team_target = TeamTarget::where('team_key', $team->team_key)
                        ->where('month', $rangeval['month'])->where('year', $rangeval['year'])
                        ->first();
                    if ($team_target) {
                        $total_target += $team_target->target_amount;
                    }
                    $team_targets[] = [
                        'team_key' => $team->team_key,
                        'team_name' => $team->name,
                        'target_amount' => (float)($team_target?->target_amount ?? 0),
                        'achieved' => (float)($team_achieved ?? 0),
                        'achieved_percentage' => ($team_target && $team_target->target_amount > 0)
                            ? round(($team_achieved / $team_target->target_amount) * 100, 2)
                            : 0,
                        'month' => $rangeval['month'],
                        'year' => $rangeval['year'],
                    ];
                }
            }
            $total_achieved_percentage = ($total_target > 0) ? round(($total_target_achieved / $total_target) * 100, 2) : 0;
            return response()->json(['success' => true, 'message' => 'Fetched total sales successfully.',
                'total_sales' => $totalSales,
                'mtd_total_sales' => $mtdTotalSales,
                'net_sales' => $netSales,
                'refunded' => $refunded,
                'charge_back' => $chargeBack,
                'charge_back_ratio' => $chargeBackRatio,
                'reversal' => $reversal ?? 0,
                'lapse_percentage' => $lapsePercentage,
                'employees' => $employees,
                'teams' => $teams,
                'team_targets' => $team_targets,
                'total_target' => $total_target,
                'total_target_achieved' => $total_target_achieved,
                'total_achieved_percentage' => $total_achieved_percentage,
                'totalUpSales' => $totalUpSales,
            ]);
        } catch
        (\Exception $e) {
            Log::error("Error fetching total sales: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while fetching data', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all months between two dates.
     *
     * @param string $startDate The start date in Y-m-d format.
     * @param string $endDate The end date in Y-m-d format.
     * @throws \InvalidArgumentException If the dates are invalid or in the wrong format.
     */
    function getMonthsBetweenDates(string $startDate, string $endDate): \Illuminate\Support\Collection
    {
        if (!strtotime($startDate) || !strtotime($endDate)) {
            throw new \InvalidArgumentException('Invalid date format. Expected Y-m-d.');
        }
        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->startOfMonth();
        if ($start->gt($end)) {
            throw new \InvalidArgumentException('Start date must be before or equal to end date.');
        }
        $period = CarbonPeriod::create($start, '1 month', $end);
        return collect($period)->map(function (Carbon $date) {
            return [
                'month' => $date->format('m'),
                'year' => $date->format('Y'),
            ];
        });
    }
}
