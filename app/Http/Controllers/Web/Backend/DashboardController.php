<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\Pack;
use App\Models\Order;
use App\Models\Melody;
use Illuminate\View\View;
use App\Models\UserMembership;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User; // Make sure you import the User model

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return View
     */

    public function index(): View
    {
        /*For user count start  */

        $newUsers = User::whereYear('created_at', now()->year)->get();

        // Define all months of the year
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        // Group the users by the month they were created
        $userCountsByMonth = array_fill_keys($months, null); // Initialize all months with null (no bar)

        $usersGroupedByMonth = $newUsers->groupBy(function ($user) {
            return $user->created_at->format('F'); // Group by month name
        });

        // Populate the count of users in the correct month
        foreach ($usersGroupedByMonth as $month => $users) {
            $userCountsByMonth[$month] = count($users); // Set actual count where users exist
        }

        // Prepare chart data with usernames and types
        $chartData = [
            'labels' => $months, // Show all months as labels
            'data' => array_values($userCountsByMonth),
            'usernames' => $usersGroupedByMonth->map(function ($users) {
                return $users->map(fn($user) => [
                    'full_name' => $user->name,
                    'type' => $user->type,
                ])->all();
            }),
        ];

        /*For user count end  */

        /*Order-chart start  */
        // Order data processing for the line chart
        $newOrders = Order::whereYear('created_at', now()->year)->get();
        // dd($newOrders);
        $orderCountsByMonth = array_fill_keys($months, 0); // Initialize all months with 0 orders

        $ordersGroupedByMonth = $newOrders->groupBy(function ($order) {
            return $order->created_at->format('F');
        });

        foreach ($ordersGroupedByMonth as $month => $orders) {
            $orderCountsByMonth[$month] = count($orders);
        }
        // Get current month's order count
        $currentMonthOrdersCount = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $orderChartData = [
            'labels' => $months,
            'data' => array_values($orderCountsByMonth),
        ];

        // Total revenue of all orders
        $TotalPrice = Order::sum('price');

        //Total Revenue from Membership
        $TotalMembershipAmount = UserMembership::sum('plan_amount');

        //Membership Cancellation rate
        $activeMembershipCount = UserMembership::where('status', 'active')->count();
        $cancelledMembershipCount = UserMembership::where('status', 'cancelled')->count();
        $totalMembershipCount = $activeMembershipCount + $cancelledMembershipCount;
        if ($totalMembershipCount > 0) {
            $MembershipCancellationRate = round(($cancelledMembershipCount / $totalMembershipCount) * 100, 2);
        } else {
            $MembershipCancellationRate = 0;
        }

        //Total Number Of uploaded melody
        $TotalMelody = Melody::where('type', 'melody')->count();

        // Top Sold Packs
        $TopSoldPack = Order::select('packs.name')
            ->join('packs', 'packs.id', '=', 'orders.pack_id')  // Join with the packs table
            ->selectRaw('count(*) as total_orders')
            ->groupBy('orders.pack_id', 'packs.name')  // Group by pack_id and pack name
            ->orderByDesc('total_orders')  // Order by total orders in descending order
            ->first();
        
        //All Downloaded melodies
        $TotalDownloadMelody = Melody::where('type', 'melody')->sum('downloads');
        
        //Top Download Melody Name
        $TopDownloadMelody = Melody::orderByDesc('downloads')->first();

        //total pack
        $totalPack = Pack::count();


        // Pass both user and order chart data to the view
        return view('backend.layouts.dashboard', compact('chartData', 'orderChartData', 'currentMonthOrdersCount', 'TotalPrice', 'TotalMembershipAmount', 'MembershipCancellationRate', 'TotalMelody', 'TopSoldPack', 'TopDownloadMelody', 'TotalDownloadMelody','totalPack'));
    }
    /*Order-chart end  */

    
}
