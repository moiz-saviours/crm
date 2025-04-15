<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CustomerContact;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    protected \Illuminate\Contracts\Auth\Authenticatable|null|User $user;
    protected $teamKeys;
    protected $teamBrandKeys;
    protected \Illuminate\Database\Eloquent\Collection $allInvoices;
    protected int $currentMonth;
    protected int $currentYear;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->teamKeys = $this->user->teams->pluck('team_key')->toArray();
        $this->teamBrandKeys = $this->user->teams->flatMap(function ($team) {
            return $team->brands->pluck('brand_key');
        })->toArray();
        $this->allInvoices = $this->getInvoicesForCurrentMonth();
    }

//    public function __construct()
//    {
//        $user = auth()->user();
//        $AllInvoices = $user->invoices()->whereMonth('created_at', Carbon::now()->month);
//        $userTarget = $user->target;
//        $totalSalesAmount = $AllInvoices->whereHas('payment', fn($query) => $query->where('status', 1))->with('payment')->get()->sum(fn($invoice) => $invoice->payment->amount ?? 0);
//        $targetAchieved = $userTarget && $totalSalesAmount ? ($totalSalesAmount / $userTarget) * 100 : 0;
//        $freshInvoices = $AllInvoices->where('type', 0)->whereHas('payment', fn($query) => $query->where('status', 1))->with('payment')->get()->sum(fn($invoice) => $invoice->payment->amount ?? 0);
//        $upsaleInvoices = $AllInvoices->where('type', 1)->whereHas('payment', fn($query) => $query->where('status', 1))->with('payment')->get()->sum(fn($invoice) => $invoice->payment->amount ?? 0);
//        $freshInvoiceProgress = ($freshInvoices + $upsaleInvoices) > 0 ? ($freshInvoices / ($freshInvoices + $upsaleInvoices)) * 100 : 0;
//        $upsaleInvoiceProgress = ($freshInvoices + $upsaleInvoices) > 0 ? ($upsaleInvoices / ($freshInvoices + $upsaleInvoices)) * 100 : 0;
//        view()->share(compact('AllInvoices', 'totalSalesAmount', 'userTarget', 'freshInvoices', 'upsaleInvoices', 'targetAchieved', 'freshInvoiceProgress', 'upsaleInvoiceProgress'));
//    }
    protected function getInvoicesForCurrentMonth()
    {
        return $this->user->invoices()
            ->whereIn('team_key', $this->teamKeys)
            ->whereMorphedTo('agent', $this->user)
            ->whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->with('payment')
            ->get();
    }

    protected function calculateInvoiceMetrics($invoices)
    {
        $totalSalesAmount = $invoices->sum('payment.amount');
        $userTarget = $this->user->target ?? 0;
        $targetAchieved = $userTarget ? ($totalSalesAmount / $userTarget) * 100 : 0;
        $freshInvoices = $invoices->where('type', 0)->sum('payment.amount');
        $upsaleInvoices = $invoices->where('type', 1)->sum('payment.amount');
        $totalInvoicesAmount = $freshInvoices + $upsaleInvoices;
        $freshInvoiceProgress = $totalInvoicesAmount ? ($freshInvoices / $totalInvoicesAmount) * 100 : 0;
        $upsaleInvoiceProgress = $totalInvoicesAmount ? ($upsaleInvoices / $totalInvoicesAmount) * 100 : 0;
        return compact('totalSalesAmount', 'userTarget', 'targetAchieved', 'freshInvoices', 'upsaleInvoices', 'freshInvoiceProgress', 'upsaleInvoiceProgress');
    }

    protected function calculateInvoiceStatuses($invoices)
    {
        $invoiceStatus = [
            'due' => 0,
            'paid' => 0,
            'refund' => 0,
            'chargeback' => 0,
        ];
        foreach ($invoices as $key => $invoice) {
            $amount = $invoice->total_amount ?? 0;
            $status = $invoice->status ?? null;
            switch ($status) {
                case 0:
                    $invoiceStatus['due'] += $amount;
                    break;
                case 1:
                    $invoiceStatus['paid'] += $amount;
                    break;
                case 2:
                    $invoiceStatus['refund'] += $amount;
                    break;
                case 3:
                    $invoiceStatus['chargeback'] += $amount;
                    break;
            }
        }
        $totalAmount = array_sum($invoiceStatus);
        $invoicesProgress = $totalAmount > 0 ? array_map(
            fn($value) => ($value / $totalAmount) * 100,
            $invoiceStatus
        ) : array_fill_keys(array_keys($invoiceStatus), 0);
        return compact('invoiceStatus', 'invoicesProgress');
    }

    protected function getRecentPayments()
    {
        return Payment::where(function ($query) {
            $query->whereIn('team_key', $this->teamKeys)
                ->whereHas('team', function ($q) {
                    $q->where('lead_id', $this->user->id);
                });
            $query->orWhere(function ($q) {
                $q->whereIn('team_key', $this->teamKeys)
                    ->where('agent_id', $this->user->id);
            });
        })
            ->with('brand')
            ->status(1)
            ->latest()
            ->limit(5)
            ->get();
    }

    protected function getLeadCounts()
    {
        $leads = Lead::where(function ($query) {
            $query->whereIn('team_key', $this->teamKeys)->orWhereIn('brand_key', $this->teamBrandKeys);
        })->get();
        $totalLeads = $leads->count();
        $leadStatuses = LeadStatus::all();
        $leadCounts = [];
        foreach ($leadStatuses as $status) {
            $leadCounts[$status->name] = Lead::where('lead_status_id', $status->id)
                ->where(function ($query) {
                    $query->whereIn('team_key', $this->teamKeys)->orWhereIn('brand_key', $this->teamBrandKeys);
                })
                ->count();
        }
        return compact('totalLeads', 'leadStatuses', 'leadCounts');
    }

    protected function getDailyPayments()
    {
        $daysInMonth = Carbon::now()->daysInMonth;
        $dailyPayments = [];
        $dailyLabels = [];
        $payments = Payment::where('agent_id', $this->user->id)
            ->whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->selectRaw('DAY(created_at) as day, SUM(amount) as total')
            ->groupBy('day')
            ->get()
            ->keyBy('day');
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dailyPayments[] = $payments->get($day)->total ?? 0;
            $dailyLabels[] = Carbon::createFromDate($this->currentYear, $this->currentMonth, $day)->format('d');
        }
        return compact('dailyPayments', 'dailyLabels');
    }

    protected function getAnnualPayments()
    {
        $annualPayments = Payment::whereYear('created_at', $this->currentYear)
            ->where('agent_id', $this->user->id)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->get()
            ->keyBy('month');
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $annualPaymentsData = [];
        foreach ($months as $index => $month) {
            $annualPaymentsData[] = $annualPayments->get($index + 1)->total ?? 0;
        }
        return compact('annualPaymentsData', 'months');
    }

    protected function getPayments()
    {
        $totalPayments = Payment::where('agent_id', $this->user->id)
            ->whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->count();
        $paymentCounts = Payment::where('agent_id', $this->user->id)
            ->whereMonth('created_at', $this->currentMonth)
            ->whereYear('created_at', $this->currentYear)
            ->selectRaw("
            COUNT(CASE WHEN status = 1 THEN 1 END) as paid,
            COUNT(CASE WHEN status = 2 THEN 1 END) as refund,
            COUNT(CASE WHEN status = 3 THEN 1 END) as chargeback
        ")
            ->first();
        $paymentsProgress = $totalPayments > 0 ? [
            'paid' => ($paymentCounts->paid / $totalPayments) * 100,
            'refund' => ($paymentCounts->refund / $totalPayments) * 100,
            'chargeback' => ($paymentCounts->chargeback / $totalPayments) * 100,
        ] : [
            'paid' => 0,
            'refund' => 0,
            'chargeback' => 0,
        ];
        return [
            'totalPayments' => $totalPayments,
            'paymentCounts' => $paymentCounts,
            'paymentsProgress' => $paymentsProgress,
        ];
    }

    protected function getCustomers()
    {
        $customers = CustomerContact::where(function ($query) {
            $query->whereIn('team_key', $this->teamKeys)->orWhereIn('brand_key', $this->teamBrandKeys);
            if (isset($this->user)) {
                $query->orWhereMorphedTo('creator', $this->user);
            }
        })->get();
        return [
            'customers' => $customers,
            'totalCustomers' => $customers->count(),
        ];
    }

    public function index()
    {
        $invoiceMetrics = $this->calculateInvoiceMetrics($this->allInvoices);
        $invoiceStatuses = $this->calculateInvoiceStatuses($this->allInvoices);
        $recentPayments = $this->getRecentPayments();
        $leadData = $this->getLeadCounts();
        $dailyData = $this->getDailyPayments();
        $annualData = $this->getAnnualPayments();
        $paymentData = $this->getPayments();
        $customerData = $this->getCustomers();
        return view('user.dashboard', [
            'totalInvoices' => $this->allInvoices->count(),
            'dueInvoices' => $invoiceStatuses['invoiceStatus']['due'],
            'paidInvoices' => $invoiceStatuses['invoiceStatus']['paid'],
            'refundInvoices' => $invoiceStatuses['invoiceStatus']['refund'],
            'chargebackInvoices' => $invoiceStatuses['invoiceStatus']['chargeback'],
            'invoicesProgress' => $invoiceStatuses['invoicesProgress'],
            'recentPayments' => $recentPayments,
            'leadStatuses' => $leadData['leadStatuses'],
            'leadCounts' => $leadData['leadCounts'],
            'dailyPayments' => $dailyData['dailyPayments'],
            'dailyLabels' => $dailyData['dailyLabels'],
            'annualPayments' => $annualData['annualPaymentsData'],
            'totalPayments' => $paymentData['totalPayments'],
            'paymentsProgress' => $paymentData['paymentsProgress'],
            'paymentCounts' => $paymentData['paymentCounts'],
            'totalLeads' => $leadData['totalLeads'],
            'totalCustomers' => $customerData['totalCustomers'],
            ...$invoiceMetrics,
        ]);
    }
//    public function old_index()
//    {
//        $user = auth()->user();
//        $team_keys = $user->teams->pluck('team_key')->toArray();
//        $AllInvoices = $user->invoices()
//            ->whereIn('team_key', $team_keys)
//            ->whereMorphedTo('agent', [$user])
//            ->whereMonth('created_at', Carbon::now()->month)
//            ->with('payment')->get();
//        $totalInvoices = $AllInvoices->count();
//        $invoiceStatus = [
//            'due' => 0,
//            'paid' => 0,
//            'refund' => 0,
//            'chargeback' => 0
//        ];
//        foreach ($AllInvoices as $invoice) {
//            $amount = $invoice->payment->amount ?? 0;
//            switch ($invoice->payment->status ?? null) {
//                case 0:
//                    $invoiceStatus['due'] += $amount;
//                    break;
//                case 1:
//                    $invoiceStatus['paid'] += $amount;
//                    break;
//                case 2:
//                    $invoiceStatus['refund'] += $amount;
//                    break;
//                case 3:
//                    $invoiceStatus['chargeback'] += $amount;
//                    break;
//            }
//        }
//        $totalAmount = array_sum($invoiceStatus);
//        $invoicesProgress = $totalAmount > 0 ? array_map(
//            fn($value) => ($value / $totalAmount) * 100,
//            $invoiceStatus
//        ) : array_fill_keys(array_keys($invoiceStatus), 0);
//        $recentPayments = Payment::where(function ($query) use ($user, $team_keys) {
//            $query->whereIn('team_key', $team_keys)
//                ->whereHas('team', function ($q) use ($user) {
//                    $q->where('lead_id', $user->id);
//                });
//            $query->orWhere(function ($q) use ($user, $team_keys) {
//                $q->whereIn('team_key', $team_keys)
//                    ->where('agent_id', $user->id);
//            });
//        })
//            ->with('brand')
//            ->latest()
//            ->limit(5)
//            ->get();
//        $leadStatuses = LeadStatus::all();
//        $leadCounts = [];
//        foreach ($leadStatuses as $status) {
//            $leadCounts[$status->name] = Lead::where('lead_status_id', $status->id)->whereIn('team_key', $team_keys)->count();
//        }
//        return view('user.dashboard', [
//            'totalInvoices' => $totalInvoices,
//            'dueInvoices' => $invoiceStatus['due'],
//            'paidInvoices' => $invoiceStatus['paid'],
//            'refundInvoices' => $invoiceStatus['refund'],
//            'chargebackInvoices' => $invoiceStatus['chargeback'],
//            'invoicesProgress' => $invoicesProgress,
//            'recentPayments' => $recentPayments,
//            'leadStatuses' => $leadStatuses,
//            'leadCounts' => $leadCounts,
//            ...$invoiceMetrics,
//        ]);
//    }
}
