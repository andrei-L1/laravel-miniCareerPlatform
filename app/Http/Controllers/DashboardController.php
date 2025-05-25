<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for admin users
        $totalUsers = null;
        $activeJobs = null;
        $totalApplications = null;
        
        if ($user->user_type === 'admin') {
            $totalUsers = User::count();
            // Add other statistics as needed
        }
        
        return view('dashboard', [
            'totalUsers' => $totalUsers,
            'activeJobs' => $activeJobs,
            'totalApplications' => $totalApplications
        ]);
    }
}
