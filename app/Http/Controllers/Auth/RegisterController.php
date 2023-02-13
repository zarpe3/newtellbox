<?php

namespace App\Http\Controllers\Auth;
use App\Actions\Customer\AvailableAccountCode;
use App\Actions\CGrates\Connect;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use Connect;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function customerValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data, Customer $customer)
    {
        return User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'customer_id' => $customer->id,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Create a new company instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Customer
     */
    protected function createCustomer(array $data)
    {
        $accountCode = (new AvailableAccountCode())->execute();
        if(env('ENABLE_CGRATES', true)){
            $this->sendDataToCGRates(['method' => 'APIerSv1.SetRatingProfile','params'=> [
                ["TPid" => "RatingProfile_VoiceCalls", "Overwrite" => true, "LoadId" => "API", "Tenant" => $accountCode, "Category" => "call", "Subject" => "*any", "RatingPlanActivations" => [
                        ["ActivationTime" => "2014-01-14T00:00:00Z", "RatingPlanId" => "RatingPlan_VoiceCalls", "FallbackSubjects" => ""],
                    ],
                ]
            ]]);

            $this->sendDataToCGRates(["method" => "APIerSv1.LoadTariffPlanFromStorDb", "params" =>[
                ["TPid" => "cgrates.org", "DryRun" => false,"Validate" => true, "APIOpts" => null, "Caching" => null]
            ],"id" => 0]);
        }

        return Customer::create([
            'name' => $data['name'],
            'accountcode' => $accountCode
        ]);
    }

}
