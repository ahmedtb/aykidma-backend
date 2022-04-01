<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Report;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceProvider;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use App\Models\ProviderNotification;
use App\Models\ProviderEnrollmentRequest;

class HomeController extends Controller
{

    public function home(){
        
        return [
            'usersCount' => User::count(),
            
            'ProvidersCount' => ServiceProvider::count(),
            'activatedProvidersCount' => ServiceProvider::activated()->count(),

            'adminsCount' => Admin::count(),
            'categoriesCount' => Category::count(),

            'ordersCount' => Order::count(),
            'latestOrders'=> Order::latest()->take(5)->get(),

            'reviewsCount' => Review::count(),
            'latestReviews'=> Review::latest()->take(5)->get(),

            'providerEnrollmentRequestsCount' => ProviderEnrollmentRequest::count(),
            // 'latestProviderEnrollmentRequests'=> ProviderEnrollmentRequest::latest()->take(5)->get(),

            'providerNotificationsCount' => ProviderNotification::count(),

            'reportsCount' => Report::count(),
            'latestReports'=> Report::latest()->take(5)->get(),

            'approvedServicesCount' => Service::approved()->count(),
            'notApprovedServicesCount' => Service::approved(false)->count(),

            'userNotificationsCount' => UserNotification::count(),
        ];
    }
  
}
