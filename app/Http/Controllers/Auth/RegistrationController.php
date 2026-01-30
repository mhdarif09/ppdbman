<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\SystemSetting;
use App\Models\User;
use App\Services\KemendikbudService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    protected $kemendikbudService;

    public function __construct()
    {
        // No service dependency needed
    }

    /**
     * Show the registration page.
     */
    public function index()
    {
        return view('auth.register-multi-step');
    }

    /**
     * Store new user and applicant.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|digits:10|unique:users,nisn',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create User
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nisn' => $request->nisn,
            'is_active' => true,
        ]);

        $user->assignRole('pendaftar');

        // Create Applicant (Basic Data)
        $activeYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));

        Applicant::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'full_name' => $request->full_name,
            'academic_year' => $activeYear,
            'status' => 'pending',
        ]);

        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('applicant.dashboard');
    }
}
