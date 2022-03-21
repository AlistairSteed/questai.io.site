<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Sale;
use App\Models\User;
use App\Models\Audit;
use App\Models\Basket;
use App\Models\Client;
use App\Models\Country;
use App\Models\Jobtype;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Industry;
use App\Models\Infotext;
use App\Models\Candidate;
use App\Models\Functions;
use App\Models\Basketline;
use App\Models\Experience;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Models\EmployementType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createCampaign($client_id)
    {
        $client = Client::findOrFailByEncryptedId($client_id);
        $client_id = $client->clid;
        $countries = Country::all();
        $industries = Industry::all();
        $job_types = Jobtype::all();
        $functions = Functions::all();
        $experiences = Experience::all();
        $employment_types = EmployementType::all();
        $client = Client::find($client_id);
        $infotext = Infotext::where('enterprise_id',enterpriseId())->whereNotIn('group', [0]) ->get();
        return view('campaign_form', compact('countries', 'industries', 'job_types', 'functions', 'employment_types', 'experiences', 'client_id','client','infotext'));
    }

    public function ajaxCajobTypeIdSearch(Request $request){
        return Jobtype::where('jtsearch','LIKE','%'.$request->term."%")->get()->map(function(Jobtype $jobType) {
            return [
                'id' => $jobType->jtid,
                'text' => $jobType->jtdesc,
            ];
        });
    }

    public function editCampaign($client_id, $id){

        $client = Client::findOrFailByEncryptedId($client_id);
        $client_id = $client->clid;        
        $campaign = Campaign::findOrFailByEncryptedId($id);
        $id = $campaign->caid;

        $countries = Country::all();
        $industries = Industry::all();
        $job_types = Jobtype::all();
        $functions = Functions::all();
        $experiences = Experience::all();
        $employment_types = EmployementType::all();

        $campaign = Campaign::find($id);
        return view('campaign_form', compact('campaign', 'countries', 'industries', 'job_types', 'functions', 'employment_types', 'experiences', 'client_id', 'client'));
    }

    public function storeCampaign(Request $request, $client_id)
    {
        try {            
            $client = Client::findOrFailByEncryptedId($client_id);
            $client_id = $client->clid;

            $type = 'store';
            $inputs = $request->all();
            $job = Jobtype::findOrFail(intval($inputs['cajobtypeid']));
            $inputs['caenterpriseid'] = enterpriseId();
            $inputs['caclientid'] = $client_id;
            $inputs['casalaryfrom'] = str_replace(',', '', $request->casalaryfrom);
            $inputs['casalaryto'] = str_replace(',', '', $request->casalaryto);
            $inputs['caote'] = str_replace(',', '', $request->caote);
            $inputs['castatus'] = 0;
            $inputs['calink'] = 0;
            $inputs['capostcode'] = $request->capostcode;
            $inputs['cadate'] = Carbon::now()->format('Y-m-d H:i:s');
            $inputs['cacreatedby'] = Auth::user()->usemail;
            $inputs['cajobvideo1'] = $job->jtvideo;
            $inputs['cacreatedon'] = Carbon::now()->format('Y-m-d H:i:s');
            $campaign = Campaign::create($inputs);

            // Add to Basket and Basketline
            $getBasketData = Basket::where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            if($getBasketData){
                $basketData = $getBasketData;
            }else{
                $basket = [
                    'baenterpriseid' => enterpriseId(),
                    'baclientid' => $client_id,
                    'bauserid' => Auth::user()->usid,
                    'badatestart' => Carbon::now()->format('Y-m-d H:i:s'),
                    'bacomplete' => 0,
                ];
                
                $basketData = Basket::create($basket);
            }
            if($getBasketData){

                $getBasketline = Basketline::where('blbasketid',$getBasketData->baid)->where('blproductid',1)->first();
            }else{
                $getBasketline = Basketline::where('blbasketid',$basketData->baid)->where('blproductid',1)->first();
            }
            $product = Product::find(1);
            if(empty($getBasketline)){
                $basketline = [
                    'blbasketid' => $basketData->baid,
                    'blcampaignid' => $campaign->caid,
                    'blcandidateid' => 0,
                    'blproductid' => $product->prid,
                    'blprice' => $product->prprice,
                    'blprocessed' => 0,
                ];

                $basketlineData = Basketline::create($basketline);
            }
        } catch (\Exception $e){
            Log::info('Campaign store error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

        return response()->json(['status' => 'success', 'data' => $campaign, 'type' => $type], 200);
    }


    public function updateCampaign(Request $request, $client_id, $id)
    {
        try {
            $client = Client::findOrFailByEncryptedId($client_id);
            $client_id = $client->clid;        
            $campaign = Campaign::findOrFailByEncryptedId($id);
            $id = $campaign->caid;

            $type = 'update';
            $inputs = $request->all();
            $campaign = Campaign::findOrFail($id);
            $job = Jobtype::findOrFail(intval($inputs['cajobtypeid']));
            $inputs['casalaryfrom'] = str_replace(',', '', $request->casalaryfrom);
            $inputs['casalaryto'] = str_replace(',', '', $request->casalaryto);
            $inputs['caote'] = str_replace(',', '', $request->caote);
            $inputs['caremote'] = (int)$inputs['caremote'];
            $inputs['cajobvideo1'] = $job->jtvideo;
            $inputs['caprivate'] = (int)$inputs['caprivate'];
            $inputs['capostcode'] = $request->capostcode;
            $inputs['caupdatedby'] = Auth::user()->usemail;
            $inputs['caupdatedon'] = Carbon::now()->format('Y-m-d H:i:s');
            $campaign->update($inputs);

        } catch (\Exception $e){
            Log::info('Campaign update error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

        return response()->json(['status' => 'success', 'data' => $campaign, 'type' => $type], 200);
    }

    public function getCampaignGrantAccess($client_id, $id){
        try {
            $users = User::where('usclientid', $client_id)->get();
            $user_accesses = UserAccess::where('uaclientid', $client_id)->where('uacampaignid', $id)->where('uausid','!=', Auth::user()->usid)->get();

        } catch (\Exception $e){
            Log::info('Campaign grant access error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

        return response()->json(['status' => 'success', 'data' => $user_accesses, 'users' => $users], 200);
    }

    public function campaignGrantAccessStore(Request $request){
        try {
            $inputs = $request->all();
            
            $userData = User::find($inputs['user']);

            if (isset($inputs['id']) && $inputs['id']){
                $userExist = UserAccess::where('uausid',$inputs['user'])->where('uaclientid',$inputs['client_id'])->where('uacampaignid',$inputs['camping_id'])->first();
                if($userExist->uaid != $inputs['uaid']){
                    return response()->json(['status' => 'error', 'data' => [], 'message' => 'User already exists for this campaign.'], 200);
                }else{                
                    $type = 'update';
                    $user_accesses_data = UserAccess::where('uausid',$inputs['user'])->where('uaclientid',$inputs['client_id'])->where('uacampaignid',$inputs['camping_id'])->first();

                    $user_accesses = [
                        'uausid' => $inputs['user'],
                        'uaenterpriseid' => $userData->usenterpriseid,
                        'uaclientid' => $inputs['client_id'],
                        'uacampaignid' => $inputs['camping_id'],
                        'uaaccess' => $inputs['user_access'],
                    ];
                    $user_accesses_data->update($user_accesses);
                }
            } else {
                $userExist = UserAccess::where('uausid',$inputs['user'])->where('uaclientid',$inputs['client_id'])->where('uacampaignid',$inputs['camping_id'])->first();
                $type = 'store';
                if($userExist){
                    return response()->json(['status' => 'error', 'data' => [], 'message' => 'User already exists for this campaign.'], 200);
                }else{
                    $user_accesses = [
                        'uausid' => $inputs['user'],
                        'uaenterpriseid' => $userData->usenterpriseid,
                        'uaclientid' => $inputs['client_id'],
                        'uacampaignid' => $inputs['camping_id'],
                        'uaaccess' => $inputs['user_access'],
                    ];

                    $user_accesses_data = UserAccess::create($user_accesses);
                }
            }
            
            $users = User::where('usclientid', $inputs['client_id'])->get();
            $user_accesses = UserAccess::where('uaclientid', $inputs['client_id'])->where('uacampaignid', $inputs['camping_id'])->where('uausid','!=', Auth::user()->usid)->get();

        } catch (\Exception $e) {
            Log::info('Campaign Grant Access Store error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

        return response()->json(['status' => 'success', 'data' => $user_accesses, 'users' => $users, 'type' => $type], 200);
    }

    public function grantAccessUserDelete(Request $request, $user_id){
        try {
            $user = UserAccess::where('uausid', $user_id)->where('uaclientid',$request->client_id)->where('uacampaignid',$request->campaign_id)->first();
            if ($user){
                $user->delete();
                
                $users = User::where('usclientid', $request->client_id)->get();
                $user_accesses = UserAccess::where('uaclientid', $request->client_id)->where('uacampaignid', $request->campaign_id)->where('uausid','!=', Auth::user()->usid)->get();
            }
        } catch (\Exception $e) {
            Log::info('Campaign Grant Access User delete error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }  
        return response()->json(['status' => 'success', 'data' => $user_accesses, 'users' => $users], 200);
    }

    public function fileResponse($filename){
        return Storage::disk('s3')->download($filename);
    }

}
