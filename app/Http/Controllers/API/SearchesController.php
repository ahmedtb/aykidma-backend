<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class SearchesController extends Controller
{
    public function servicesSearch(string $q)
    {
        return Service::where('title', 'LIKE', "%{$q}%")->get();
    }
    public function servicesCategorySearch(int $category_id, string $q)
    {
        return Service::where('category_id', $category_id)->where('title', 'LIKE', "%{$q}%")->get();
    }
    public function providerNewOrdersSearch(string $q)
    {
        return Auth::user()->Orders()
            ->where('status', 'new')
            ->whereHas('service', function (Builder $query) use ($q) {
                $query->where('title', 'LIKE', "%{$q}%");
            })
            ->get();
    }
    public function providerResumedOrdersSearch(string $q)
    {
        return Auth::user()->Orders()
            ->where('status', 'resumed')
            ->whereHas('service', function (Builder $query) use ($q) {
                $query->where('title', 'LIKE', "%{$q}%");
            })
            ->get();
    }
    public function providerDoneOrdersSearch(string $q)
    {
        return Auth::user()->Orders()
            ->where('status', 'done')
            ->whereHas('service', function (Builder $query) use ($q) {
                $query->where('title', 'LIKE', "%{$q}%");
            })
            ->get();
    }
}
