<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mobilpay;
use Storage;
use App\PlataOnline;

class PlataOnlineController extends Controller
{

    public function testarePlataCard(Request $request)
    {
        $rezervare = \App\Rezervare::where('id', '25216')->first();
        dd($rezervare->ora->ora);


        return view('testare-plata-card');
    }

    public function trimitereCatrePlata(Request $request)
    {
        $rezervare = $request->session()->get('rezervare');

        $comanda = Mobilpay::setOrderId(md5(uniqid(rand())))
        ->setAmount(0.1)
        // ->setAmount($rezervare->pret_total)
        ->setDetails('Plata online pentru biletul - ' . $rezervare->id)
        ->setAdditionalParams([
            'rezervare_id' => $rezervare->id
            // 'email' => 'andrei.dima@usm.ro',
            // 'firstName' => 'Andrei Dima'
        ])
        ->purchase();
    }

    public function confirmarePlata(Request $request)
    {
        $response = Mobilpay::response();

        $data = $response->getData(); //array

                
        DB::table('plata_online')->insert([
            'order_id' => $data['orderId'],
            'action' => $data['objPmNotify']['action'],
            'error_code' => $data['objPmNotify']['errorCode'],
            'error_message' => $data['objPmNotify']['errorMessage'],
            'notify_date' => $data['objPmNotify']['timestamp'],
            'original_amount' => $data['objPmNotify']['originalAmount'],
            'processed_amount' => $data['objPmNotify']['processedAmount'],
            'rezervare_id' => $data['params']['rezervare_id'],
            'nume' => $data['objPmNotify']['customer']['firstName'],
            'telefon' => $data['objPmNotify']['customer']['mobilePhone'],
            'email' => $data['objPmNotify']['customer']['email'],
            'adresa' => $data['objPmNotify']['customer']['address'],
            'created_at' => \Carbon\Carbon::now(),
        ]);

        switch ($response->getMessage()) {
            case 'confirmed_pending': // transaction is pending review. After this is done, a new IPN request will be sent with either confirmation or cancellation

                //update DB, SET status = "pending"

                break;
            case 'paid_pending': // transaction is pending review. After this is done, a new IPN request will be sent with either confirmation or cancellation

                //update DB, SET status = "pending"

                break;
            case 'paid': // transaction is pending authorization. After this is done, a new IPN request will be sent with either confirmation or cancellation

                //update DB, SET status = "open/preauthorized"

                break;
            case 'confirmed': // transaction is finalized, the money have been captured from the customer's account

                //update DB, SET status = "confirmed/captured"
                $plata_online = DB::table('plata_online')->where('order_id', $data['orderId'])->first();
                DB::table('rezervari')->where('id', $plata_online->rezervare_id)->update(['plata_efectuata' => 1]);

                break;
            case 'canceled': // transaction is canceled

                //update DB, SET status = "canceled"

                break;
            case 'credit': // transaction has been refunded

                //update DB, SET status = "refunded"

                break;
        }	
    }
}
