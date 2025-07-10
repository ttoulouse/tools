<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class feivendorpo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($poinfo,$podetails,$OrderID,$PONum,$vendorinfo)
    {
        //
        $this->poinfo = $poinfo;
        $this->podetails = $podetails;
        $this->OrderID = $OrderID;
        $this->PONum = $PONum;
        $this->vendorinfo = $vendorinfo;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	if(($this->poinfo[0]->ShippingMethod != 'UPS Ground') && ($this->poinfo[0]->ShippingMethod != 'Freight')) {
		$subject = 'Please confirm po #'.$this->PONum.'-'.$this->poinfo[0]->ShippingMethod;
	}
	else {
		$subject = 'Please confirm po #'.$this->PONum;
	}

        return $this->from('poconfirm@factory-express.com')->view('mail.feivendorpo')->subject($subject)->with([
                  'PONum' => $this->PONum,
                  'poinfo' => $this->poinfo,
                  'podetails' => $this->podetails,
                  'OrderID' => $this->OrderID,
                  'vendorinfo' => $this->vendorinfo,
                ]);;
    }
}
