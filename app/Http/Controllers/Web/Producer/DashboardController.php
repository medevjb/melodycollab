<?php

namespace App\Http\Controllers\Web\Producer;

use Carbon\Carbon;
use App\Models\Pack;
use App\Models\Melody;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show Producer Dashboard
     */
    public function index()
    {
        $playes = Melody::where('user_id', auth()->user()->id)->sum('playes');
        $totalDownloads = Melody::where('user_id', auth()->user()->id)
            ->sum('downloads');

        $revenue = auth()->user()->packs()
            ->withSum(['orders' => function ($query) {
                $query->whereDate('created_at', today());
            }], 'price')
            ->where('status', 'active')
            ->get()
            ->sum('orders_sum_price');

        // Tops
        $latestMelodies = Melody::where('status', 'active')
            ->where('user_id', auth()->user()->id)
            ->orderBy('playes', 'desc')
            ->limit(4)
            ->get();
        $packs = Pack::where('status', 'active')
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->with('user')
            ->limit(3)
            ->get();
        $data = [
            'playes' => $playes,
            'downloads' => $totalDownloads,
            'revenue' => $revenue,
            'latestMelodies' => $latestMelodies,
            'packs' => $packs,
        ];
        return view('producer.layout.dashboard', compact('data'));
    }

    public function getDownloadGraphData(Request $request)
    {
        $filter = $request->query('filter');

        switch ($filter) {
            case 'last7days':
                // Fetch orders data for the last 7 days
                $orders = DB::table('my_downloads')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                    ->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();

                // Prepare values and categories
                $categories = [];
                $values = [];

                foreach ($orders as $order) {
                    $categories[] = Carbon::parse($order->date)->format('D'); // Day of the week (e.g., 'Sun', 'Mon')
                    $values[] = $order->total; // Total number of orders per day
                }

                // Fill missing days with 0 if needed
                for ($i = 0; $i < 7; $i++) {
                    $day = Carbon::now()->subDays($i)->format('D');
                    if (!in_array($day, $categories)) {
                        $categories[] = $day;
                        $values[] = 0;
                    }
                }

                $data = [
                    'values' => $values,
                    'categories' => $categories,
                ];
                break;

            case 'thismonth':
                // Get the first day of the current month
                $startOfMonth = Carbon::now()->startOfMonth();
                // Get the last day of the current month
                $endOfMonth = Carbon::now()->endOfMonth();

                // Fetch orders data for the current month, grouped by week
                $orders = DB::table('my_downloads')
                    ->select(DB::raw('WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as week_of_month'), DB::raw('count(*) as total'))
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->groupBy('week_of_month')
                    ->orderBy('week_of_month', 'ASC')
                    ->get();

                // Prepare values and categories
                $categories = ['Week 1', 'Week 2', 'Week 3', 'Week 4']; // Assuming 4 weeks for simplicity, you might need to adjust if there are more weeks
                $values = array_fill(0, 4, 0); // Initialize weeks with 0 orders

                foreach ($orders as $order) {
                    $weekIndex = $order->week_of_month - 1; // Week index starts from 1, adjust for array index
                    if (isset($values[$weekIndex])) {
                        $values[$weekIndex] = $order->total;
                    }
                }

                $data = [
                    'values' => $values,
                    'categories' => $categories,
                ];
                break;

            case 'ytd':
                // Fetch orders data for the current year grouped by month
                $orders = DB::table('my_downloads')
                    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('month')
                    ->orderBy('month', 'ASC')
                    ->get();

                // Prepare values and categories
                $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $values = array_fill(0, 12, 0); // Initialize months with 0 orders

                foreach ($orders as $order) {
                    $monthIndex = $order->month - 1; // Month index starts from 1, adjust for array index
                    $values[$monthIndex] = $order->total;
                }

                $data = [
                    'values' => $values,
                    'categories' => $categories,
                ];
                break;

            default:
                $data = [
                    'values' => [],
                    'categories' => [],
                ];
                break;
        }

        return response()->json($data);
    }
    public function getSalesGraphData(Request $request)
    {
        $membersship = Auth::user()->hasMembership();
        $filter = $request->query('filter');

        switch ($filter) {
            case 'last7days':
                // Fetch orders data for the last 7 days
                $orders = DB::table('orders')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                    ->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();

                // Prepare values and categories
                $categories = [];
                $values = [];

                foreach ($orders as $order) {
                    $categories[] = Carbon::parse($order->date)->format('D'); // Day of the week (e.g., 'Sun', 'Mon')
                    $values[] = $order->total; // Total number of orders per day
                }

                // Fill missing days with 0 if needed
                for ($i = 0; $i < 7; $i++) {
                    $day = Carbon::now()->subDays($i)->format('D');
                    if (!in_array($day, $categories)) {
                        $categories[] = $day;
                        $values[] = 0;
                    }
                }

                $data = [
                    'values' => $membersship ? $values : [0, 0, 0, 0, 0, 0, 0],
                    'categories' => $membersship ? $categories : ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                ];
                break;

            case 'thismonth':
                // Get the first day of the current month
                $startOfMonth = Carbon::now()->startOfMonth();
                // Get the last day of the current month
                $endOfMonth = Carbon::now()->endOfMonth();

                // Fetch orders data for the current month, grouped by week
                $orders = DB::table('orders')
                    ->select(DB::raw('WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as week_of_month'), DB::raw('count(*) as total'))
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->groupBy('week_of_month')
                    ->orderBy('week_of_month', 'ASC')
                    ->get();

                // Prepare values and categories
                $categories = ['Week 1', 'Week 2', 'Week 3', 'Week 4']; // Assuming 4 weeks for simplicity, you might need to adjust if there are more weeks
                $values = array_fill(0, 4, 0); // Initialize weeks with 0 orders

                foreach ($orders as $order) {
                    $weekIndex = $order->week_of_month - 1; // Week index starts from 1, adjust for array index
                    if (isset($values[$weekIndex])) {
                        $values[$weekIndex] = $order->total;
                    }
                }

                $data = [
                    'values' => $membersship ? $values : [0, 0, 0, 0],
                    'categories' => $membersship ? $categories : ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                ];
                break;

            case 'ytd':
                // Fetch orders data for the current year grouped by month
                $orders = DB::table('orders')
                    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('month')
                    ->orderBy('month', 'ASC')
                    ->get();

                // Prepare values and categories
                $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $values = array_fill(0, 12, 0); // Initialize months with 0 orders

                foreach ($orders as $order) {
                    $monthIndex = $order->month - 1; // Month index starts from 1, adjust for array index
                    $values[$monthIndex] = $order->total;
                }

                $data = [
                    'values' =>  $membersship ? $values : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    'categories' => $membersship ? $categories : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                ];
                break;

            default:
                $data = [
                    'values' => [],
                    'categories' => [],
                ];
                break;
        }

        return response()->json($data);
    }

}
