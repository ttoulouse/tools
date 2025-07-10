<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class feicustomerinvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderinfo,$poinfo,$poshipped,$invoicenum,$vendorinfo,$unitcosts,$taxable,$checkshippingcharge)
    {
        //
        $this->poinfo = $poinfo;
        $this->orderinfo = $orderinfo;
        $this->poshipped = $poshipped;
        $this->invoicenum = $invoicenum;
        $this->vendorinfo = $vendorinfo;
        $this->unitcosts = $unitcosts;
        $this->taxable = $taxable;
        $this->checkshippingcharge = $checkshippingcharge;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('poconfirm@factory-express.com')->view('mail.feicustomerinvoice')->subject('Order Invoice #'.$this->invoicenum)->with([
                  'invoicenum' => $this->invoicenum,
                  'poinfo' => $this->poinfo,
                  'orderinfo' => $this->orderinfo,
                  'poshipped' => $this->poshipped,
                  'vendorinfo' => $this->vendorinfo,
                  'unitcosts' => $this->unitcosts,
                  'taxable' => $this->taxable,
                  'checkshippingcharge' => $this->checkshippingcharge


                ]);;
    }
}
