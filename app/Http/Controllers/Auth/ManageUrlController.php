<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ManageUrl;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageUrlController extends Controller
{
    public function index()
    {
        $urls = ManageUrl::all();
        
        return view('guest', ['urls' => $urls]);
    }
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $rowCoun = ManageUrl::select('id')->limit(1)->orderBy('id', 'DESC')->get();
        //dd($rowCoun);
        $originalUrl = $request->url;
        $shorternUrl = rtrim(strtr(base64_encode(pack('i', $rowCoun[0]->id + 1)), '+/', '-_'), '=');
        $expirationTime = $request->expiration_time;

        $res = ManageUrl::create([
            'user_id' => $userId,
            'original_url' => $originalUrl,
            'unique_shortern_url' => $shorternUrl,
            'expiration_time' => $expirationTime,
            'is_active' => true,
            'url_type' => $request->linkType
        ]);

        if($user->is_admin){
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

        /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function urlPortal()
    {
        $urls = ManageUrl::all();
        
        return view('layouts.admin.urlPortal', ['urls' => $urls]);
    }

    public function accessLink(Request $request){

        $url = ManageUrl::select('original_url')
            ->where([
                ['unique_shortern_url', '=', $request->shorternUrl],
                ['expiration_time', '>', now()]
            ])
            ->get();
        return $url;
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLink(Request $request){
        $user = Auth::user();
        $userId = $user->id;
        $update = ManageUrl::where('id', '=', $request->urlId)
                    ->update(['user_id' => $userId, 'original_url' => $request->originalUrl, 'expiration_time' => $request->expiraationTime, 'url_type' => $request->linkType]);
        return $update;
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $url=ManageUrl::find($request->urlId);
        $url->delete();
        
        if($url){
            return true;
        }
        else{
            return false;
        }
       
    }
}
