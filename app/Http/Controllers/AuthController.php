<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function registerView()
    {
        return view('auth.register');
    }
    public function createRegister(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|unique:users|min:11|max:11',
            'password' => 'required|string|min:3|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user if validation passes
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        return redirect()->route('customer.login') // Redirect to the login page
            ->with('success', 'Registration successful. Please log in.'); // Flash success message
    }
    public function loginView()
    {
        return view('auth.login');
    }
    public function createLogin(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt user login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->route('admin.home'); // Admin redirect
            }

            return redirect()->route('customer.home'); // Customer redirect
        }

        return redirect()->back()
            ->withErrors(['email' => 'Invalid credentials.'])
            ->withInput();
    }



    public function customerLogout(Request $request)
    {
        Auth::logout(); // Logout user
        return redirect()->route('customer.login')->with('success', 'Successfully logged out.');
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('customer.login')->with('success', 'Admin logged out successfully.');
    }
    public function forgotPasswordView(){
        return view('auth.forgotPassword');
    }
    public function sendResetLink(Request $request)
{

    $request->validate(['email' => 'required|email']);

    // Try to send the password reset link to the user
    $status = Password::sendResetLink(
        $request->only('email')
    );

    // Check if the email was sent successfully or if the user wasn't found
    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('status', 'Reset link sent to your email.');
    } else {
        return back()->withErrors(['email' => 'Account not found.']);
    }
}
public function showResetForm(Request $request)
    {
        // Retrieve token and email from the query parameters
        $token = $request->query('token');
        $email = $request->query('email');

        // Pass token and email to the view
        return view('auth.newPassword', compact('token', 'email'));
    }

public function reset(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'token' => 'required|string',
        'password' => 'required|string|min:3|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found with that email.']);
    }

    // Update the user's password
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('customer.login')->with('success', 'Your password has been reset successfully. Please log in.');
}

}
