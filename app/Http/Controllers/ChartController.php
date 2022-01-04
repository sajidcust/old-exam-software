<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class ChartController extends Controller
{
    public function print(Request $request){
    	//Getting chart data from hidden input field
    	$data[0] = $request->pieData;
    	$data[1] = $request->barData;
        //passing data to temp view blade file 
    	$pdf = PDF::loadView('temp',compact('data'));
        //generating pdf
    	return $pdf->download('charts.pdf');
    }
}
