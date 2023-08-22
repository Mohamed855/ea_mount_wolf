<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use GeneralTrait;
    public function dashboard()
    {
        return $this->ifAdmin(
            $this->ifAdminAuthenticated('admin.dashboard.index')
        );
    }
}
