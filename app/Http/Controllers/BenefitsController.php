<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\Order;
use App\Seller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\PaytmController;
use App\CustomerPackage;
use App\Http\Controllers\CustomerPackageController;
use Auth;

class BenefitsController extends Controller
{


    public function payment()
    {
        // $input = Input::all();
         $benefit= new BenefitController;
                    return $benefit->done();
   
             
            
          
       
    }
}
