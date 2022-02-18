<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Sale;
use App\Models\User;
use App\Models\Audit;
use App\Models\Basket;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Candidate;
use App\Models\Attachment;
use App\Models\Basketline;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        $user = Auth::user();
        $user_id = \Auth::id();
        // $role = Role::create(['name' => 'super']);
        // $role = Role::create(['name' => 'admin']);
        // $role = Role::create(['name' => 'enterprise']);
        // $role = Role::create(['name' => 'client']);
        // $user->assignRole('super');
        // $user->assignRole('admin');
        $clients = Client::where('clenterpriseid', enterpriseId())->get();
        $news_data = News::where('neenterpriseid', enterpriseId())->get();
        return view('dashboard', compact('clients', 'news_data', 'user','user_id'));
    }

    public function saconsole()
    {
        $user = auth()->user();
        if ($user->hasRole(['super'])) {
            return view('super_console', compact('user'));
        }
    }
    public function topadmin()
    {
        $user = Auth::user();
        $user_id = \Auth::id();
        if ($user_id == 40 || ($user_id >= 46 && $user_id <=49)) {
            return view('top_admin', compact('user','user_id'));
        }
    }
    

    public function updateProfile(Request $request)
    {
        try {
            $inputs = $request->all();
            $user = auth()->user();
            $data = [
                'usfirstname' => $inputs['usfirstname'],
                'uslastname' => $inputs['uslastname'],
            ];
            if (isset($inputs['password']) && $inputs['password']){
                $data['ushashpw'] = bcrypt($inputs['password']);
            }
            $user->update($data);
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Profile update failed');
        }
    }
    public function updateClient($id)
    {
        try {            
            $client = Client::findOrFailByEncryptedId($id);
            $id = $client->clid; 
            $enterprise = Enterprise::find(enterpriseId());
            
            if($client){
                return view('client_update', compact('client','enterprise'));
            }
        } catch (\Exception $e){
            return redirect()->route('client-overview', $id)->with('error', 'Client not found!');
        }
    }

    public function postUpdateClient(Request $request, $id){
        try {                                    
            $client = Client::findOrFailByEncryptedId($id);
            $id = $client->clid; 
            $inputs = $request->all();

            if ($client){
                $inputs['clupdatedby'] = auth()->user()->usemail;
                $inputs['clupdatedon'] = Carbon::now()->format('Y-m-d H:i:s');
                $client->update($inputs);
            }
            return redirect()->route('client-overview', $client->encrypted_id)->with('success', 'Client updated successfully!');
        } catch (\Exception $e){
            return redirect()->route('client-overview', $client->encrypted_id)->with('error', 'Client update failed!');
        }
    }

    public function getClientOverview($id){

        try {
            $client = Client::findOrFailByEncryptedId($id);
            $activities = Audit::with('Campaign:caid,cajobtitle')->where('auclientid', $client->clid)->get();
            $campaigns = Campaign::where('caclientid', $client->clid)->orderBy('cacreatedon','desc')->get();

            $campaigns = $campaigns->map(function ($item) {
                $item->total_candidates = Candidate::where('cacaid', $item->caid)->count();
                $item->waiting_candidates = Candidate::where('cafinalstatus', 00)->where('cacaid', $item->caid)->count();
                return $item;
            });
            $client_id = $client->clid;
            return view('client_overview', compact('client', 'activities', 'campaigns', 'id','client_id'));
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Client not found');
        }

    }

    public function getCampaignOverview($client_id,$id){
        try {            
            $client = Client::findOrFailByEncryptedId($client_id);
            $client_id = $client->clid;

            $clientData = Client::find($client_id);

            $usrId = Auth::user()->usid;
            $campaign = Campaign::findOrFailByEncryptedId($id);
            $id = $campaign->caid;
            $activities = Audit::where('aucampaignid', $id)->get();
            // $userInfo = User::findOrFail($client_id);
            $campaignStatus = $campaign->castatus;
            return view('campaign_overview', compact('campaign', 'activities', 'id', 'client_id','client','usrId','campaignStatus','clientData'));
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Client not found');
        }

    }

    public function approveCampaignStatus(Request $request){

        try {
            $inputs = $request->all();
            $campaign = Campaign::findOrFail($inputs['cam_id']);

            if ($campaign){
                if ($inputs['string'] == 'approve'){

                    $campaign->update([
                        'castatus' => $inputs['status'],
                        'caapprovedby' => auth()->user()->usfirstname.' '.auth()->user()->uslastname,
                        'caapprovedon' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                } elseif ($inputs['string'] == 'end'){

                    $campaign->update([
                        'castatus' => $inputs['status'],
                        'caapprovedby' => auth()->user()->usfirstname.' '.auth()->user()->uslastname,
                        'caenddate' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                }

            }
            return response()->json(['status' => 'success', 'data' => $campaign], 200);
        } catch (\Exception $e){
            Log::info('Ajax campaign status approve error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function ajaxGetCandidates(Request $request){

        try {
        $inputs = $request->all();

        $candidates = Candidate::where('cacaid', $inputs['campaign_id']);

            if (isset($inputs['app_status']) && ($inputs['app_status'] || $inputs['app_status'] == 0)) {
                $candidates = $candidates->where('caapplicationstatus', $inputs['app_status']);
            }

            if (isset($inputs['search']) && $inputs['search']){
                $candidates = $candidates->where(function ($q) use($inputs) {
                    $q->where('calastname', 'like', '%' . $inputs['search'] . '%')
                        ->orWhere('cafirstnames', 'like', '%' . $inputs['search'] . '%')
                        ->orWhere('casource', 'like', '%' . $inputs['search'] . '%')
                        ->orWhere('caappdate', 'like', '%' . $inputs['search'] . '%');
                });
            }

            $candidates = $candidates->get();

            $candidates = $candidates->map(function ($item) {
                $item->date = Carbon::parse($item->caappdate)->format('Y-m-d');
                $item->time = Carbon::parse($item->caappdate)->format('H:i');
                $item->atscore = isset($item->attachmentProfile) ? $item->attachmentProfile->atscore : '';
                return $item;
            });

            if ($inputs['sort_by'] == 'app_date_asc') {
                $candidates = $candidates->sortBy('caappdate');
            } elseif ($inputs['sort_by'] == 'app_date_desc'){
                $candidates = $candidates->sortByDesc('caappdate');
            } elseif ($inputs['sort_by'] == 'name_asc'){
                $candidates = $candidates->sortBy(function($item) {
                    return "{$item->calastname} {$item->cafirstnames}";
                });
            } elseif ($inputs['sort_by'] == 'name_desc'){
                $candidates = $candidates->sortByDesc(function($item) {
                    return "{$item->calastname} {$item->cafirstnames}";
                });
            } elseif ($inputs['sort_by'] == 'profile_score_asc'){
                $candidates = $candidates->sortBy('atscore');
            } elseif ($inputs['sort_by'] == 'profile_score_desc'){
                $candidates = $candidates->sortByDesc('atscore');
            } else {
                // $candidates = $candidates->sortBy('caid');
                $candidates = $candidates->sortByDesc('caappdate');
            }
            $candidates = $candidates->values()->all();

            $comments = Comment::with('user')->where('coclientid', $inputs['client_id'])->where('cocampaignid',$inputs['campaign_id'])->get();

            return response()->json(['status' => 'success', 'data' => $candidates, 'comments' => $comments], 200);
        } catch (\Exception $e){
            Log::info('Ajax get candidates error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function changeCandidateStatus(Request $request){

        try {
            $inputs = $request->all();
            $candidate = Candidate::findOrFail($inputs['can_id']);

            if ($candidate){
                $candidate->update([
                    'cafinalstatus' => $inputs['status']
                ]);
            }
            return response()->json(['status' => 'success', 'data' => $candidate], 200);
        } catch (\Exception $e){
            Log::info('Ajax candidate status change error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function getSales()
    {
        $sales = Sale::with('Client:clid,clname')->get();
        return view('sales', compact('sales'));
    }

    public function ajaxGetSales(Request $request){

        try {
            $inputs = $request->all();

            $sales = Sale::with('Client:clid,clname');

            if (isset($inputs['search']) && $inputs['search']){
                $sales = $sales->where(function ($q) use($inputs) {
                    $q->where('sadatetime', 'like', '%' . $inputs['search'] . '%')
                        ->orWhereHas('Client', function ($q1) use ($inputs){
                            $q1->where('clname', 'like', '%' . $inputs['search'] . '%');
                        });
                });
            }

            $sales = $sales->get();

            $sales = $sales->map(function ($item) {
                $item->date = Carbon::parse($item->sadatetime)->format('Y-m-d');
                $item->time = Carbon::parse($item->sadatetime)->format('H:i');
                $item->ap_date = Carbon::parse($item->saapproveddate)->format('Y-m-d');
                $item->ap_time = Carbon::parse($item->saapproveddate)->format('H:i');
                $item->name = $item->Client->clname;
                $item->payment_type = Sale::getSalesPaymentType($item->sapaymenttype);
                return $item;
            });

            return response()->json(['status' => 'success', 'data' => $sales], 200);
        } catch (\Exception $e){
            Log::info('Ajax get sale error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function ajaxGetCandidateName(Request $request){

        try {
            $inputs = $request->all();

            $candidateData = Candidate::with('attachments')->where('caid', $inputs['candidate_id'])->first();
            
            return response()->json(['status' => 'success', 'data' => $candidateData], 200);
        } catch (\Exception $e){
            Log::info('Ajax get candidates error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function ajaxGetCandidateComment(Request $request, $id){
        try {

            $comments = Comment::with('user')->where('coclientid', $request->client_id)->where('cocampaignid',$request->camping_id)->where('cocandidateid', $id)->get();
            
            return response()->json(['status' => 'success', 'data' => $comments], 200);
        } catch (\Exception $e){
            Log::info('Ajax get candidates error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function addCandidateComment(Request $request){
        try {
            $type = 'store';
            $inputs = $request->all();

            $comments = [
                'coenterpriseid' => enterpriseId(),
                'coclientid' => $inputs['client_id'],
                'cocampaignid' => $inputs['camping_id'],
                'cocandidateid' => $inputs['candidate_id'],
                'codate' => Carbon::now()->format('Y-m-d H:i:s'),
                'couser' => Auth::user()->usid,
                'cocomment' => $inputs['candidate_comment'],
            ];


            $comments = Comment::create($comments);
            $insertedId = $comments->coid;
            $getcomments = Comment::with('user')->where('coclientid', $comments->coclientid)->where('cocampaignid',$comments->cocampaignid)->where('cocandidateid', $comments->cocandidateid)->get();

        } catch (\Exception $e){
            Log::info('Comment store error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

        return response()->json(['status' => 'success', 'data' => $getcomments, 'type' => $type], 200);

    }

    public function ajaxGetComment($comment_id){
        try {

            $comment = Comment::with('user')->where('coid', $comment_id)->first();
            
            return response()->json(['status' => 'success', 'data' => $comment], 200);
        } catch (\Exception $e){
            Log::info('Ajax get candidates error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function editCandidateComment(Request $request){
        try {
            $type = 'update';
            
            $inputs = $request->all();

            $comment = Comment::findOrFail($request->comments_id);
            $inputs['cocomment'] = $request->candidate_comment;
            $comment->update($inputs);

            $getcomments = Comment::with('user')->where('coclientid', $comment->coclientid)->where('cocampaignid',$comment->cocampaignid)->where('cocandidateid', $comment->cocandidateid)->get();

        } catch (\Exception $e){
            Log::info('Comment update error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

        return response()->json(['status' => 'success', 'data' => $getcomments, 'type' => $type], 200);

    }

    public function ajaxGetCandidateBuyAssessments(Request $request){

        try {
            $productData = Product::where('prgroup', Product::PRGROUPTWO)->where('practive', 1)->get();
            
            $categoryData = Product::where('prgroup', Product::PRGROUPTWO)->where('practive', 1)->pluck('prcategory')->unique();  
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'purchasedBasketData' => $purchasedBasketData, 'categoryData' => $categoryData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Candidate Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function getCandidateCategoryNameWiseData(Request $request){

        try {
            $productData = Product::where('prgroup', Product::PRGROUPTWO)->where('prcategory', $request->categoryName)->where('practive', 1)->get();
            
            $categoryData = Product::where('prgroup', Product::PRGROUPTWO)->where('practive', 1)->pluck('prcategory')->unique();  
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'purchasedBasketData' => $purchasedBasketData, 'categoryData' => $categoryData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Candidate Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function candidateAssessmentAdditionalAddtocart(Request $request){

        try {
            $inputs = $request->all();
            $product = Product::findOrFail($inputs['product_id']);

            $getBasketData = Basket::where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            // dd($getBasketlineData);
            if($getBasketData){
                $basketData = $getBasketData;
            }else{
                $basket = [
                    'baenterpriseid' => enterpriseId(),
                    'baclientid' => $inputs['client_id'],
                    'bauserid' => Auth::user()->usid,
                    'badatestart' => Carbon::now()->format('Y-m-d H:i:s'),
                    'bacomplete' => 0,
                ];
                
                $basketData = Basket::create($basket);
            }
            if($getBasketData){

                $getBasketline = Basketline::where('blbasketid',$getBasketData->baid)->where('blproductid',$inputs['product_id'])->where('blcandidateid',$request->candidate_id)->first();
            }else{
                $getBasketline = Basketline::where('blbasketid',$basketData->baid)->where('blproductid',$inputs['product_id'])->where('blcandidateid',$request->candidate_id)->first();
            }

            if(empty($getBasketline)){
                
                $type = 'add';
                $basketline = [
                    'blbasketid' => $basketData->baid,
                    'blcampaignid' => $inputs['campaign_id'],
                    'blcandidateid' => $inputs['candidate_id'],
                    'blproductid' => $inputs['product_id'],
                    'blprice' => $product->prprice,
                    'blprocessed' => 0,
                ];

                $basketlineData = Basketline::create($basketline);
            }else{
                $type = 'remove';
                $getBasketline->delete();
            }

            $productData = Product::where('prgroup', Product::PRGROUPTWO)->where('practive', 1)->get();
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'purchasedBasketData' => $purchasedBasketData, 'type' => $type], 200);
        } catch (\Exception $e){
            Log::info('Ajax Candidate Assessment Additional Addtocart error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function candidateAssessmentAdditionalRemovetocart(Request $request){

        try {
            $type = 'remove';
            $getBasketline = Basketline::find($request->basketLine_id);
            $getBasketline->delete();

            $productData = Product::where('prgroup', Product::PRGROUPTWO)->where('practive', 1)->get();
            
            $categoryData = Product::where('prgroup', Product::PRGROUPTWO)->where('practive', 1)->pluck('prcategory')->unique();  
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'purchasedBasketData' => $purchasedBasketData, 'type' => $type, 'categoryData' => $categoryData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Candidate Assessment Additional Addtocart error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function ajaxCandidateAssessmentAdditionalSearch(Request $request){

        try {
            $productData = Product::where('prgroup', Product::PRGROUPTWO)->where('prdesc','LIKE','%'.$request->search."%")->where('practive', 1)->get();
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'purchasedBasketData' => $purchasedBasketData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Candidate Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function ajaxGetCartProduct(){

        try {
            $productData = Product::where('practive', 1)->get();
            
            $basketData = Basket::with('user')->with(['basketLines' => function ($query) {
                $query->select('blif','blbasketid','blcampaignid','blcandidateid','blproductid','blprice','blprocessed')
                    ->with(['candidate' => function ($query1) {
                        $query1->select('caid','cafirstnames','calastname');
                    }]);
            }])->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Candidate Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function productRemoveCart(Request $request){
        try {
            $type = 'remove';
            $getBasketline = Basketline::find($request->basketLine_id);
            $getBasketline->delete();
        
            $productData = Product::where('practive', 1)->get();
            
            $basketData = Basket::with('user')->with(['basketLines' => function ($query) {
                $query->select('blif','blbasketid','blcampaignid','blcandidateid','blproductid','blprice','blprocessed')
                    ->with(['candidate' => function ($query1) {
                        $query1->select('caid','cafirstnames','calastname');
                    }]);
            }])->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'type' => $type], 200);
        } catch (\Exception $e){
            Log::info('Ajax Candidate Assessment Additional Addtocart error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function ajaxGetCampaignBuyAssessments(Request $request){

        try {
            $productData = Product::where('prgroup', Product::PRGROUPONE)->where('practive', 1)->get();    
            $categoryData = Product::where('prgroup', Product::PRGROUPONE)->where('practive', 1)->pluck('prcategory')->unique();          
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();  
            
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();

            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'categoryData' => $categoryData, 'purchasedBasketData' => $purchasedBasketData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Campaign Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function getCampaignCategoryNameWiseData(Request $request){

        try {
            $productData = Product::where('prgroup', Product::PRGROUPONE)->where('prcategory', $request->categoryName)->where('practive', 1)->get();
            
            $categoryData = Product::where('prgroup', Product::PRGROUPONE)->where('practive', 1)->pluck('prcategory')->unique();  
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'categoryData' => $categoryData, 'purchasedBasketData' => $purchasedBasketData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Campaign Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function ajaxCampaignAssessmentAdditionalSearch(Request $request){

        try {
            $productData = Product::where('prgroup', Product::PRGROUPONE)->where('prdesc','LIKE','%'.$request->search."%")->where('practive', 1)->get();
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'purchasedBasketData' => $purchasedBasketData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Campaign Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    public function campaignAssessmentAdditionalAddtocart(Request $request){

        try {
            $inputs = $request->all();
            $product = Product::findOrFail($inputs['product_id']);

            $getBasketData = Basket::where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            // dd($getBasketlineData);
            if($getBasketData){
                $basketData = $getBasketData;
            }else{
                $basket = [
                    'baenterpriseid' => enterpriseId(),
                    'baclientid' => $inputs['client_id'],
                    'bauserid' => Auth::user()->usid,
                    'badatestart' => Carbon::now()->format('Y-m-d H:i:s'),
                    'bacomplete' => 0,
                ];
                
                $basketData = Basket::create($basket);
            }
            if($getBasketData){

                $getBasketline = Basketline::where('blbasketid',$getBasketData->baid)->where('blproductid',$inputs['product_id'])->first();
            }else{
                $getBasketline = Basketline::where('blbasketid',$basketData->baid)->where('blproductid',$inputs['product_id'])->first();
            }

            if(empty($getBasketline)){
                
                $type = 'add';
                $basketline = [
                    'blbasketid' => $basketData->baid,
                    'blcampaignid' => $inputs['campaign_id'],
                    'blcandidateid' => 0,
                    'blproductid' => $inputs['product_id'],
                    'blprice' => $product->prprice,
                    'blprocessed' => 0,
                ];

                $basketlineData = Basketline::create($basketline);
            }else{
                $type = 'remove';
                $getBasketline->delete();
            }

            $productData = Product::where('prgroup', Product::PRGROUPONE)->where('practive', 1)->get();
            
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();
            
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();
            
            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'type' => $type, 'purchasedBasketData' => $purchasedBasketData], 200);
        } catch (\Exception $e){
            Log::info('Ajax Candidate Assessment Additional Addtocart error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }
    
    public function campaignAssessmentAdditionalRemovetocart(Request $request){

        try {
            $type = 'remove';
            $getBasketline = Basketline::find($request->basketLine_id);
            $getBasketline->delete();

            $productData = Product::where('prgroup', Product::PRGROUPONE)->where('practive', 1)->get();    
            $categoryData = Product::where('prgroup', Product::PRGROUPONE)->where('practive', 1)->pluck('prcategory')->unique();          
            $basketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',0)->first();  
            
            $purchasedBasketData = Basket::with('basketLines')->where('bauserid',Auth::user()->usid)->where('bacomplete',1)->get();

            return response()->json(['status' => 'success', 'productData' => $productData, 'basketData' => $basketData, 'categoryData' => $categoryData, 'purchasedBasketData' => $purchasedBasketData, 'type' => $type], 200);
        } catch (\Exception $e){
            Log::info('Ajax Candidate Assessment Additional Addtocart error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function checkCouponCode(Request $request){
        try {            
            $today_date = date('Y-m-d');
            $user = auth()->user();
            $coupon = Coupon::where('cocode',$request->coupon)->where('coclientid',$user->usclientid)->first();
            if($coupon){
                if($coupon->coexpire > $today_date){
                    $type = 'valid';
                }else{
                    $type = 'expire';
                }
            }else{
                $type = 'invalid';
            }
            return response()->json(['status' => 'success', 'data' => $coupon, 'type' => $type], 200);
        } catch (\Exception $e){
            Log::info('Ajax Check coupon code error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
    }

    public function myBasket()
    {
        $basketData = Basket::where('bauserid',Auth::user()->usid)->where('bacomplete',1)->orderBy('baid','DESC')->get();
        return view('basket_history', compact('basketData'));
    }

    public function myOrderHistory($id)
    {
        $basket = Basket::findOrFailByEncryptedId($id);
        $id = $basket->baid;    

        $productData = Product::where('practive', 1)->get();
        $basketData = Basket::with('user')->with(['basketLines' => function ($query) {
            $query->select('blif','blbasketid','blcampaignid','blcandidateid','blproductid','blprice','blprocessed')
                ->with(['candidate' => function ($query1) {
                    $query1->select('caid','cafirstnames','calastname');
                }]);
        }])->where('bauserid',Auth::user()->usid)->where('baid',$id)->get();
        return view('order_history', compact('basketData','productData'));
    }

    

    public function ajaxGetProductName(Request $request){

        try {
            $basketLine = Basketline::find($request->basketLine_id);
            $productData = Product::find($basketLine->blproductid);
            $productName = $productData->prdesc;
            
            return response()->json(['status' => 'success', 'productName' => $productName], 200);
        } catch (\Exception $e){
            Log::info('Ajax Get Candidate Buy Assessments error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }

    }

    
}
