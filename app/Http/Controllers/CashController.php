<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashResource;
use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CashController extends Controller
{

    public function index()
    {
        $from = request('from');
        $to = request('to');
        if($from && $to) {
            $debit = Auth::user()->cashes()->whereBetween('when', [ $from, $to ])->where('amount', '>=', 0)->get('amount')->sum('amount');
            $credit = Auth::user()->cashes()->whereBetween('when', [ $from, $to ])->where('amount', '<', 0)->get('amount')->sum('amount');
            $transaction = Auth::user()->cashes()->whereBetween('when', [ $from, $to ])->latest()->get();
        }else{  
            $debit = Auth::user()->cashes()->whereBetween('when', [ now()->firstOfMonth(), now() ])->where('amount', '>=', 0)->get('amount')->sum('amount');
            $credit = Auth::user()->cashes()->whereBetween('when', [ now()->firstOfMonth(), now() ])->where('amount', '<', 0)->get('amount')->sum('amount');
            $transaction = Auth::user()->cashes()->whereBetween('when', [ now()->firstOfMonth(), now() ])->latest()->get();
        }


        return response()->json([
            'balances' => Str_replace(',', '.', number_format($debit + $credit)),
            'debit' => Str_replace(',', '.', number_format($debit)),
            'credit' => Str_replace(',', '.', number_format($credit)),
            'transaction' => CashResource::collection($transaction),
            'now' => now()->format("Y-m-d"),
            'firstOfMonth' => now()->firstOfMonth()->format("Y-m-d"),
        ]);
    }

    public function store()
    {
        sleep(1);
        request()->validate([
            'name' =>'required',
            'amount' =>'required|numeric',
        ]);

        $slug = request('name') . "-" . Str::random(6);
        $when = request('when') ?? now();

       $cash = Auth::user()->cashes()->create([
            'name' => request('name'),
            'slug' => Str::slug($slug),
            'when' =>$when,
            'amount' => request('amount'),
            'description' => request('description'),
        ]);

        return response()->json([
            'message' => 'the transaction been saved.',
            'cash' => new CashResource($cash)
        ]);
    }

        public function show(Cash $cash)
        {
            if(Auth::id() !== $cash->user_id){
                abort(403);
            }
            return new CashResource($cash); 
        }

}