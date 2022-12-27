<?php
 
namespace App\Http\View\Composers;
 
use Illuminate\View\View;
use Session;
use App\Models\PanunoteUsers;

class UserDetailsComposer
{

 
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */

    public function compose(View $view)
    {
        if(Session::has('USER_ID')){
            //get user info
            $userInfo = PanunoteUsers::where('user_id', session('USER_ID'))->first();
        }
        // else{
        //     return "No session";
        // }

        $view->with('name', $userInfo);
        
    }
}