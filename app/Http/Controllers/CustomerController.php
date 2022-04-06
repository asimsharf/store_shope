<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Session;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $customer = Customer::with('orders')->get();
            return $this->success(1,  $customer);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $user = new Customer();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            return $this->done(1,  'Successfully customer created.');
        }else{
            return $this->done(1,  'Customer not created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $customer =  Customer::find($id);

            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
           
            if($customer->update()){
                return $this->success(1,  $customer);
            }else{
                return $this->error(0,'can not update custo$customer');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $customer =  Customer::find($id);

            if($customer->delete()){
                return $this->done(1,  'Successfully customer deleted');
            }else{
                return $this->error(0,'Can\'t remove this customer');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }


    public function login(Request $request){

        $data = ['email' => $request->email, 'password' => $request->password];
        if(!Auth::guard('customers')->attempt($data)){
            return response()->json([
                'success'=>false,
                'status'=>200,
            ]);
        }else{
       
            $customer = Auth::guard('customers')->user();
        
            $token = $customer->createToken('token');
            return response()->json([
                'success'=>true,
                'token' => $token->plainTextToken,
                'user'=>$customer
            ]);
        }
    }
}
