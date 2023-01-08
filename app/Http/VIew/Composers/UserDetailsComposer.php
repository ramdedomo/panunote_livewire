<?php
 
namespace App\Http\View\Composers;
 
use Illuminate\View\View;
use Session;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
            
            if(Auth::user()){
                //get user info
                $userInfo = PanunoteUsers::where('user_id', Auth::user()->user_id)->first();
            }
            // else{
            //     return "No session";
            // }
    
            $view->with('name', $userInfo);
      
       
        
    }
}