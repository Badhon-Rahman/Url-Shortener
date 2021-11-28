<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
     * @param  \App\Http\Requests\Auth\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       
        
    }

        /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUser(Request $request)
    {
        $update = User::where('id', '=', $request->userId)
                    ->update(['name' => $request->userName, 'email' => $request->email]);
        return $update;
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request)
    {
        //dd($request);
        $user=User::find($request->userId);
        $user->delete();
        
        if($user){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

    }
}
