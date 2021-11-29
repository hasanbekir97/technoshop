<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderInformation;
    public $order_date;
    public $order_code;
    public $orderProducts;
    public $subTotalPrice;
    public $cargoPrice;
    public $totalPrice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderInformation, $order_date, $order_code, $orderProducts, $subTotalPrice, $cargoPrice, $totalPrice)
    {
        $this->orderInformation = $orderInformation;
        $this->order_date = $order_date;
        $this->order_code = $order_code;
        $this->orderProducts = $orderProducts;
        $this->subTotalPrice = $subTotalPrice;
        $this->cargoPrice = $cargoPrice;
        $this->totalPrice = $totalPrice;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Message')
            ->view('emails.order');
    }
}
