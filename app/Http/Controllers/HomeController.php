<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\CGrates\Connect;

class HomeController extends Controller
{
    use Connect;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user == null) {
            return redirect('/register');
        }

        if ($user->customer->plan == null) {
            $this->middleware('guest');

            return view('auth.register-product');
        }

        if ($request->route()->uri == 'home') {
            return view('dashboard');
        }

        return view('welcome');
    }

    public function test()
    {
        dump('ApierV2.SetTPDestination');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.SetTPDestination', 'params' => [
            ['TPid' => 'webdec', 'ID' => 'Dest_BR_Fixed', 'Prefixes' => ['993', '983', '973', '963', '953', '943', '933', '923', '913', '893', '883', '873', '863', '853', '843', '833', '823', '813', '793', '773', '753', '743', '733', '713', '693', '683', '673', '663', '653', '643', '633', '623', '3', '613', '553', '543', '533', '513', '493', '483', '473', '463', '453', '443', '433', '423', '413', '383', '373', '353', '343', '333', '323', '313', '283', '273', '243', '223', '213', '193', '183', '173', '163', '153', '143', '133', '123', '113']],
         ]]));
        dump('ApierV2.SetTPDestination');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.SetTPDestination', 'params' => [
            ['TPid' => 'webdec', 'ID' => 'Dest_BR_Mobile', 'Prefixes' => ['999', '989', '979', '969', '959', '949', '939', '929', '919', '899', '889', '879', '869', '859', '849', '839', '829', '819', '799', '779', '759', '749', '739', '719', '699', '689', '679', '669', '659', '649', '639', '629', '619', '559', '549', '539', '519', '499', '489', '479', '469', '459', '449', '439', '429', '419', '389', '379', '359', '349', '339', '329', '319', '289', '279', '249', '229', '219', '199', '189', '179', '169', '159', '149', '139', '129', '119']],
         ]]));
        dump('ApierV2.GetTPDestinationIDs');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.GetTPDestinationIDs', 'params' => [['TPid' => 'webdec']]]));
        dump('ApierV2.SetTPRate');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.SetTPRate', 'params' => [['TPid' => 'webdec', 'ID' => 'Rate_BR_Mobile_Rate_1', 'RateSlots' => [['ConnectFee' => 0, 'Rate' => 0.07, 'RateUnit' => '30s', 'RateIncrement' => '1s', 'GroupIntervalStart' => '0s']]]], 'id' => 1]));
        dump($this->sendDataToCGRates(['method' => 'ApierV1.SetTPRate', 'params' => [['TPid' => 'webdec', 'ID' => 'Rate_BR_Fixed_Rate_1', 'RateSlots' => [['ConnectFee' => 0, 'Rate' => 0.02, 'RateUnit' => '30s', 'RateIncrement' => '1s', 'GroupIntervalStart' => '0s']]]], 'id' => 1]));
        dump('ApierV2.SetTPDestinationRate');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.SetTPDestinationRate', 'params' => [
            ['TPid' => 'webdec', 'ID' => 'DestinationRate_BR', 'DestinationRates' => [
                    ['DestinationId' => 'Dest_BR_Fixed', 'RateId' => 'Rate_BR_Fixed_Rate_1', 'Rate' => null, 'RoundingMethod' => '*up', 'RoundingDecimals' => 4, 'MaxCost' => 0, 'MaxCostStrategy' => ''],
                    ['DestinationId' => 'Dest_BR_Mobile', 'RateId' => 'Rate_BR_Mobile_Rate_1', 'Rate' => null, 'RoundingMethod' => '*up', 'RoundingDecimals' => 4, 'MaxCost' => 0, 'MaxCostStrategy' => ''],
                ],
            ],
        ], 'id' => 1]));
        dump('ApierV2.SetTPRatingPlan');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.SetTPRatingPlan', 'params' => [
            ['TPid' => 'webdec', 'ID' => 'RatingPlan_VoiceCalls', 'RatingPlanBindings' => [
                    ['DestinationRatesId' => 'DestinationRate_BR', 'TimingId' => '*any', 'weight' => 10],
                ],
            ],
        ], 'id' => 3]));
        dump('ApierV2.LoadTariffPlanFromStorDb');
        dump($this->sendDataToCGRates(['method' => 'APIerSv1.LoadTariffPlanFromStorDb', 'params' => [
                ['TPid' => 'webdec', 'DryRun' => false, 'Validate' => true, 'APIOpts' => null, 'Caching' => null],
        ]]));
        dump('ApierV2.SetRatingProfile');
        dump($this->sendDataToCGRates(['method' => 'APIerSv1.SetRatingProfile', 'params' => [
            ['TPid' => 'RatingProfile_VoiceCalls', 'Overwrite' => true, 'LoadId' => 'API', 'Tenant' => 'webdec', 'Category' => 'call', 'Subject' => '*any', 'RatingPlanActivations' => [
                    ['ActivationTime' => '2014-01-14T00:00:00Z', 'RatingPlanId' => 'RatingPlan_VoiceCalls', 'FallbackSubjects' => ''],
                ],
            ],
        ]]));
        dump('ApierV1.GetRatingProfileIDs');
        dump($this->sendDataToCGRates(['method' => 'ApierV1.GetRatingProfileIDs', 'params' => [
            ['TPid' => 'webdec'],
        ]]));
        dump('ApierV2.LoadTariffPlanFromStorDb');
        dump($this->sendDataToCGRates(['method' => 'APIerSv1.LoadTariffPlanFromStorDb', 'params' => [
                ['TPid' => 'webdec', 'DryRun' => false, 'Validate' => true, 'APIOpts' => null, 'Caching' => null],
        ]]));
        dump('ApierV2.SetChargerProfile');
        dump($this->sendDataToCGRates(['method' => 'APIerSv1.SetChargerProfile', 'params' => [
                ['Tenant' => 'webdec', 'ID' => 'DEFAULT', 'FilterIDs' => [], 'AttributeIDs' => ['*none'], 'Weight' => 0, 'ActivationInterval' => null, 'RunID' => ''],
        ]]));
        dump('ApierV1.GetChargerProfile');
        dump($this->sendDataToCGRates(['method' => 'APIerSv1.GetChargerProfile', 'params' => [
                ['TPid' => 'webdec', 'ID' => 'DEFAULT'],
        ]]));

        dump($this->sendDataToCGRates(['method' => 'APIerSv1.GetCost', 'params' => [[
                'Tenant' => 'webdec',
                'Category' => 'call',
                'Subject' => '1001',
                'AnswerTime' => '2022-08-17T23:59:17Z',
                'Destination' => '51999761456',
                'Usage' => '14s',
        ]], 'id' => 0]));

//        dump($this->sendDataToCGRates(['method' => 'CDRsV1.ProcessExternalCDR','params'=> [[
//                "Tenant" => "webdec",
//                "RequestType" => "*raw",
//                "ToR" => "*monetary",
//                "Account"=> "webdec",
//                "Category" => "call",
//                "Subject" => "1001",
//                "AnswerTime" => "2022-08-17T01:30:17Z",
//                "SetupTime" => "2022-08-17T01:30:10Z",
//                "Usage" => "17s",
//                "OriginID" => "API Function Example"
//            ]],"id" => 0]));
    }
}
