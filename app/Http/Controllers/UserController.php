<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'phone_number' => 'required|regex:/^\+3706\d{7}$/'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        // Flash a success message to the session
        $request->session()->flash('status', 'Registration successful!');

        // Log the user in
        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginData)) {
            return back()->withErrors([
                'message' => 'Invalid Credentials'
            ]);
        }

        return redirect()->route('index');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', ['user' => $user]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $messages = [
            'phone_number.regex' => 'The phone number must start with +3706 and be followed by 7 digits.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'phone_number' => 'required|regex:/^\+3706\d{7}$/'
        ], $messages);

        if ($validator->fails()) {
            return redirect('profile')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $request->all();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('profile')->with('status', 'Profile updated successfully!');
    }

    public function management()
    {
        $users = User::where('admin', '!=', 1)->with('bans')->paginate(5);
        return view('user_management', ['users' => $users]);
    }

    public function ban(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $banDuration = $request->input('ban_duration');

        if ($banDuration === 'permanent') {
            $ban = new Ban([
                'expired_at' => null, // Permanent ban
            ]);
        } else {
            $ban = new Ban([
                'expired_at' => now()->addHours((int)$banDuration),
            ]);
        }

        $user->bans()->save($ban);

        return redirect()->back()->with('status', 'User banned successfully');
    }

    public function unban($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->bans()->delete();

        return redirect()->back()->with('status', 'User unbanned successfully');
    }

    public function check_products($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found');
    }

    $products = $user->products()->paginate(10);

    return view('user_products', ['products' => $products]);
}
}
