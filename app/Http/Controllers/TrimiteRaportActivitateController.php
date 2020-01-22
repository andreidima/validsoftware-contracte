<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contract;
use App\RaportActivitateTrimis;

class TrimiteRaportActivitateController extends Controller
{
    public function trimiteRaportCronJob(Contract $contract_nr)
    {
        dd(\Carbon\Carbon::now()->isoFormat('D'));
        // if (
        //     (\Carbon\Carbon::now()->isoFormat('D') === 8) && 
        //     (RaportActivitateTrimis::where )
        // \Carbon\Carbon::parse($raport->created_at)->isoFormat('D')
    }
}
