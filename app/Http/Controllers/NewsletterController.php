<?php

namespace App\Http\Controllers;

//use App\Services\Newsletter;

use App\Services\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{


    public function __invoke(Newsletter $newsletter)
    {
        
            request()->validate(['email' => 'required|email']);
            

            try {

        /*         $newsletter = new Newsletter();
                $newsletter->subscribe(request('email'));
                //we can also combine the previous two lines as (new Newsletter())->subscribe(request('email'));
        */
                $newsletter->subscribe(request('email'));

            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'email' => 'This email could not be added to our newsletter list'
                ]);
            }

            
            return redirect('/')->with('success', 'You are now signed up for our newsletter');

    }


}
