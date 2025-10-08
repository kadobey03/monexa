<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plans;
use App\Models\Signal;
use App\Models\User_plans;
use App\Models\User_signal;




class InvPlanController extends Controller
{
     //Add plan requests
     public function addplan(Request $request){

        $plan=new Plans();
        $plan->name= $request['name'];
        $plan->price= $request['price'];
        $plan->min_price= $request['min_price'];
        $plan->max_price= $request['max_price'];
        $plan->minr=$request['minr'];
        $plan->maxr=$request['maxr'];
        $plan->gift=$request['gift'];
        $plan->expected_return= $request['return'];
        $plan->increment_type= $request['t_type'];
        $plan->increment_interval= $request['t_interval'];
        $plan->increment_amount= $request['t_amount'];
        $plan->expiration= $request['expiration'];
        $plan->tag = $request['tag'];
        $plan->investment_type = $request['investment_type'];
        $plan->type= 'Main';
        $plan->save();
        return redirect()->back()->with('success', 'Plan created Sucessfully!');
    }






    //Update plan
    public function updateplan(Request $request){
        Plans::where('id', $request['id'])
        ->update([
            'name' => $request['name'],
            'price' => $request['price'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
            'minr' => $request['minr'],
            'maxr' => $request['maxr'],
            'gift' => $request['gift'],
            'expected_return' => $request['return'],
            'increment_type' => $request['t_type'],
            'increment_amount' => $request['t_amount'],
            'increment_interval' => $request['t_interval'],
             'tag' => $request['tag'],
            'investment_type' => $request['investment_type'],
            'type' => 'Main',
            'expiration' => $request['expiration'],
        ]);
        return redirect()->back()->with('success', 'Plan Successfully Updated');
    }

    //Trash Plans route
    public function trashplan($id){

        // Delete this plan from every user account that have bought this plan
        $usersplan = User_plans::where('plan', $id)->get();
        if (count($usersplan) > 0) {
            foreach($usersplan as $plns){
                User_plans::where('id', $plns->id)->delete();
            }
        }

        //remove users from the plan before deleting
        $users=User::where('plan',$id)->get();
        foreach($users as $user){
            User::where('id',$user->id)
            ->update([
                'plan' => 0,
                //'confirmed_plan' => 0,
            ]);
        }
        Plans::where('id',$id)->delete();
        return redirect()->back()
        ->with('success', 'Investment Plan deleted Successfully!');
    }



    //Add signal requests
    public function addsignal(Request $request){

        $signal=new Signal();
        $signal->name= $request['name'];
        $signal->price= $request['price'];
        $signal->increment_amount= $request['increment_amount'];
        $signal->type= 'Main';
        $signal->save();
        return redirect()->back()->with('success', 'Signal created Sucessfully!');
    }



     //Update plan
     public function updatesignal(Request $request){

        Signal::where('id', $request['id'])
        ->update([
            'name' => $request['name'],
            'price' => $request['price'],
            'increment_amount'=> $request['increment_amount'],
            'type' => 'Main',

        ]);
        return redirect()->back()->with('success', ' Successfully Updated');
    }



    //Trash Plans route
    public function trashsignal($id){

        // Delete this plan from every user account that have bought this plan
        $usersignal = User_signal::where('signals', $id)->get();
        if (count($usersignal) > 0) {
            foreach($usersignal as $slns){
                User_signal::where('id', $slns->id)->delete();
            }
        }

        //remove users from the plan before deleting
        $users=User::where('signals',$id)->get();
        foreach($users as $user){
            User::where('id',$user->id)
            ->update([
                'signals' => 0,
                //'confirmed_plan' => 0,
            ]);
        }
        Signal::where('id',$id)->delete();
        return redirect()->back()
        ->with('success', 'Signals deleted Successfully!');
    }

    //Create default investment plans
    public function createDefaultPlans(){

        // Stock Plans
        $stockPlans = [
            [
                'name' => 'Stock Starter Plan',
                'price' => '100',
                'min_price' => '100',
                'max_price' => '500',
                'minr' => '5',
                'maxr' => '8',
                'gift' => '0',
                'expected_return' => '7',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '1.5',
                'expiration' => '30',
                'tag' => 'Popular',
                'investment_type' => 'stock',
                'type' => 'Main'
            ],
            [
                'name' => 'Stock Growth Plan',
                'price' => '500',
                'min_price' => '500',
                'max_price' => '2000',
                'minr' => '8',
                'maxr' => '12',
                'gift' => '10',
                'expected_return' => '10',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '2.5',
                'expiration' => '45',
                'tag' => 'Recommended',
                'investment_type' => 'stock',
                'type' => 'Main'
            ],
            [
                'name' => 'Stock Premium Plan',
                'price' => '2000',
                'min_price' => '2000',
                'max_price' => '10000',
                'minr' => '12',
                'maxr' => '18',
                'gift' => '50',
                'expected_return' => '15',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '4.0',
                'expiration' => '60',
                'tag' => 'Premium',
                'investment_type' => 'stock',
                'type' => 'Main'
            ],
            [
                'name' => 'Stock Elite Plan',
                'price' => '10000',
                'min_price' => '10000',
                'max_price' => '50000',
                'minr' => '18',
                'maxr' => '25',
                'gift' => '200',
                'expected_return' => '22',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '6.0',
                'expiration' => '90',
                'tag' => 'Elite',
                'investment_type' => 'stock',
                'type' => 'Main'
            ]
        ];

        // Crypto Plans
        $cryptoPlans = [
            [
                'name' => 'Crypto Starter Plan',
                'price' => '50',
                'min_price' => '50',
                'max_price' => '300',
                'minr' => '8',
                'maxr' => '12',
                'gift' => '0',
                'expected_return' => '10',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '2.0',
                'expiration' => '14',
                'tag' => 'Hot',
                'investment_type' => 'crypto',
                'type' => 'Main'
            ],
            [
                'name' => 'Crypto Growth Plan',
                'price' => '300',
                'min_price' => '300',
                'max_price' => '1500',
                'minr' => '12',
                'maxr' => '18',
                'gift' => '15',
                'expected_return' => '15',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '3.5',
                'expiration' => '21',
                'tag' => 'Popular',
                'investment_type' => 'crypto',
                'type' => 'Main'
            ],
            [
                'name' => 'Crypto Premium Plan',
                'price' => '1500',
                'min_price' => '1500',
                'max_price' => '7500',
                'minr' => '18',
                'maxr' => '25',
                'gift' => '75',
                'expected_return' => '22',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '5.5',
                'expiration' => '30',
                'tag' => 'Premium',
                'investment_type' => 'crypto',
                'type' => 'Main'
            ],
            [
                'name' => 'Crypto Elite Plan',
                'price' => '7500',
                'min_price' => '7500',
                'max_price' => '30000',
                'minr' => '25',
                'maxr' => '35',
                'gift' => '300',
                'expected_return' => '30',
                'increment_type' => 'Daily',
                'increment_interval' => '1',
                'increment_amount' => '8.0',
                'expiration' => '45',
                'tag' => 'Elite',
                'investment_type' => 'crypto',
                'type' => 'Main'
            ]
        ];

        // Real Estate Plans
        $realEstatePlans = [
            [
                'name' => 'Real Estate Starter Plan',
                'price' => '200',
                'min_price' => '200',
                'max_price' => '1000',
                'minr' => '4',
                'maxr' => '6',
                'gift' => '0',
                'expected_return' => '5',
                'increment_type' => 'Weekly',
                'increment_interval' => '7',
                'increment_amount' => '1.2',
                'expiration' => '90',
                'tag' => 'Stable',
                'investment_type' => 'real_estate',
                'type' => 'Main'
            ],
            [
                'name' => 'Real Estate Growth Plan',
                'price' => '1000',
                'min_price' => '1000',
                'max_price' => '5000',
                'minr' => '6',
                'maxr' => '9',
                'gift' => '25',
                'expected_return' => '7.5',
                'increment_type' => 'Weekly',
                'increment_interval' => '7',
                'increment_amount' => '2.0',
                'expiration' => '120',
                'tag' => 'Popular',
                'investment_type' => 'real_estate',
                'type' => 'Main'
            ],
            [
                'name' => 'Real Estate Premium Plan',
                'price' => '5000',
                'min_price' => '5000',
                'max_price' => '25000',
                'minr' => '9',
                'maxr' => '14',
                'gift' => '150',
                'expected_return' => '12',
                'increment_type' => 'Weekly',
                'increment_interval' => '7',
                'increment_amount' => '3.5',
                'expiration' => '180',
                'tag' => 'Premium',
                'investment_type' => 'real_estate',
                'type' => 'Main'
            ],
            [
                'name' => 'Real Estate Elite Plan',
                'price' => '25000',
                'min_price' => '25000',
                'max_price' => '100000',
                'minr' => '14',
                'maxr' => '20',
                'gift' => '500',
                'expected_return' => '17',
                'increment_type' => 'Weekly',
                'increment_interval' => '7',
                'increment_amount' => '5.0',
                'expiration' => '365',
                'tag' => 'Elite',
                'investment_type' => 'real_estate',
                'type' => 'Main'
            ]
        ];

        // Combine all plans
        $allPlans = array_merge($stockPlans, $cryptoPlans, $realEstatePlans);

        // Create plans
        $createdCount = 0;
        foreach($allPlans as $planData) {
            // Check if plan already exists to avoid duplicates
            $existingPlan = Plans::where('name', $planData['name'])->first();
            if (!$existingPlan) {
                Plans::create($planData);
                $createdCount++;
            }
        }

        return redirect()->back()->with('success', "Successfully created {$createdCount} investment plans (4 Stock, 4 Crypto, 4 Real Estate)!");
    }


}
