<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Report;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use App\Models\ProviderNotification;
use App\Models\ProviderEnrollmentRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\MessageNotification;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{

    public function home(){
        
        return [
            'usersCount' => User::count(),
            'adminsCount' => Admin::count(),
            'categoriesCount' => Category::count(),
            'ordersCount' => Order::count(),
            'latestOrders'=> Order::latest()->take(5)->get(),
            'reviewsCount' => Review::count(),
            'providerEnrollmentRequestsCount' => ProviderEnrollmentRequest::count(),
            'providerNotificationsCount' => ProviderNotification::count(),
            'reportsCount' => Report::count(),
            'servicesCount' => Service::count(),
            'userNotificationsCount' => UserNotification::count(),
        ];
    }
  
}
