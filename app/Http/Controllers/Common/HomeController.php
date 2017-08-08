<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Redirect the login page if not authenticated
     *
     * Render the dashboard if authenticated.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::guard('restaurant')->check() && !Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        if (Auth::guard('restaurant')->check()) {
            return redirect()->route('dashboard');
        } else if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
    }
}
