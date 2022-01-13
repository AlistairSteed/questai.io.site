<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\News;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @description: Return news setup list
     */
    public function index(){
        return view('news');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @description: Return all data of news
     */
    public function indexAjax(){
        try {
            $news = News::where('neenterpriseid',enterpriseId())->get();
        } catch (\Exception $e) {
            Log::info('News setup index error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
        return response()->json(['status' => 'success', 'data' => $news], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @description: Store and update news data based on news id
     */
    public function store(Request $request){
        try {
            $inputs = $request->all();
            if (isset($inputs['id']) && $inputs['id']){
                $type = 'update';
                $news = News::findOrFail($inputs['id']);

                $news_data = [
                    'nedate' => Carbon::parse($inputs['news_date'])->format('Y-m-d'),
                    'netitle' => $inputs['news_title'],
                    'nearticlelink' => $inputs['news_link'],
                    'neenterpriseid' => enterpriseId(),
                ];

                if (isset($inputs['news_image']) && $inputs['news_image']){
                    $upload_response = $this->uploadFile('news_image', 'public/news-images');
                    //if status get true store it in database else store default image
                    if ($upload_response['status'] && $upload_response['path']) {
                        $news_data['neimagelink'] = $upload_response['path'];

                        if (Storage::disk('public')->exists($news->neimagelink)){
                            unlink(public_path('storage/' . $news->neimagelink));
                        }
                    }
                }

                $news->update($news_data);
            } else {
                $type = 'store';

                $news_data = [
                    'nedate' => Carbon::parse($inputs['news_date'])->format('Y-m-d'),
                    'netitle' => $inputs['news_title'],
                    'nearticlelink' => $inputs['news_link'],
                    'neenterpriseid' => enterpriseId(),
                ];

                $upload_response = $this->uploadFile('news_image', 'public/news-images');
                //if status get true store it in database else store default image
                if ($upload_response['status'] && $upload_response['path']) {
                    $news_data['neimagelink'] = $upload_response['path'];
                }

                $news = News::create($news_data);
            }

        } catch (\Exception $e) {
            Log::info('News setup store error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
        return response()->json(['status' => 'success', 'data' => $news, 'type' => $type], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @description: Delete news data from database
     */
    public function delete($id){
        try {
            $news = News::find($id);
            if ($news){
                if (Storage::disk('public')->exists($news->neimagelink)){
                    unlink(public_path('storage/' . $news->neimagelink));
                }
                $news->delete();
            }
        } catch (\Exception $e) {
            Log::info('News setup delete error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
        return response()->json(['status' => 'success', 'data' => []], 200);
    }
}
