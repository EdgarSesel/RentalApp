<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $user;

    public function __construct($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.rent_confirmation')
                    ->with([
                        'productName' => $this->product->name,
                        'userName' => $this->user->name,
                        'cardNumber' => '1234 5678 9012 3456', // Replace with actual card number
                    ]);
    }
}
