<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $leadCount = Lead::count();
        $clientCount = Client::count();
        $expenseTotal = Expense::sum('amount');
        $projectCount = Project::count();

        // الحصول على الشهر والسنة الحاليين
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // جلب بيانات المصاريف حسب الفئة لهذا الشهر
        $expensesByCategory = Expense::selectRaw('category, SUM(amount) as total')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('category')
            ->pluck('total', 'category');

        // جلب بيانات تحويل العملاء المحتملين حسب الشهر لكل حالة (Won, Contacted, Lost)
        $leadsStats = Lead::selectRaw('MONTH(created_at) as month, status, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at), status')
            ->get()
            ->groupBy('month');

        // إعادة ترتيب البيانات بحيث يكون لكل شهر عدد لكل حالة
        $formattedLeadsStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedLeadsStats[$i] = [
                'won' => 0,
                'contacted' => 0,
                'lost' => 0,
            ];
            if (isset($leadsStats[$i])) {
                foreach ($leadsStats[$i] as $stat) {
                    $formattedLeadsStats[$i][strtolower($stat->status)] = $stat->total;
                }
            }
        }

        return view('index', compact(
            'leadCount',
            'clientCount',
            'expenseTotal',
            'projectCount',
            'expensesByCategory',
            'formattedLeadsStats'
        ));
    }
}
