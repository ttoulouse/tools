<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class feistockpo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($stockpoinfo,$stockpodetails,$PONum,$vendorinfo)
    {
        //
        $this->stockpoinfo = $stockpoinfo;
        $this->stockpodetails = $stockpodetails;
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
        return $this->from('poconfirm@factory-express.com')->view('mail.feistockpo')->subject('Please confirm po #'.$this->PONum)->with([
                  'PONum' => $this->PONum,
                  'stockpoinfo' => $this->stockpoinfo,
                  'stockpodetails' => $this->stockpodetails,
                  'vendorinfo' => $this->vendorinfo,
                ]);;
    }
}
