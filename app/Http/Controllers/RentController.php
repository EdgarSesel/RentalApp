<?php

namespace App\Http\Controllers;

use App\Mail\RentConfirmation;
use App\Models\Product;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RentController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'rent_start_date' => 'required|date',
        'rent_end_date' => 'required|date|after_or_equal:rent_start_date',
    ]);

    $overlappingRentals = Rent::where('product_id', $request->product_id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('rent_start_date', [$request->rent_start_date, $request->rent_end_date])
                ->orWhereBetween('rent_end_date', [$request->rent_start_date, $request->rent_end_date]);
        })
        ->get();

    if (!$overlappingRentals->isEmpty()) {
        $rentDates = $overlappingRentals->map(function ($rent) {
            return $rent->rent_start_date . ' to ' . $rent->rent_end_date;
        })->join(', ');

        return back()->withErrors(['rent_date' => 'The product is already rented for the selected period: ' . $rentDates]);
    }

    $rent = new Rent();
    $rent->user_id = Auth::id();
    $rent->product_id = $request->product_id;
    $rent->rent_start_date = $request->rent_start_date;
    $rent->rent_end_date = $request->rent_end_date;
    $rent->save();

    $product = Product::find($request->product_id);
    $user = User::find($product->user_id);

    Mail::to($user->email)->send(new RentConfirmation($product, $user));

    return redirect()->route('products.index');
}
}
