<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        //vallidate the reqest
        $attributes = request()->validate([
            //'email' => 'required|exists:users,email' //exists checks whether the posted email exists in the column
            'email' => 'required|email',
            'password' => 'required'
        ]); //$errors variable that we look for in the view, is automatically set in the validate function if the validation fails


        //attempt to log in the user
        //based on the provided credentials
        if(!auth()->attempt($attributes)) //auth()->attempt() confirms you have provided correct password for the given account and it also signs you in if you do so
        {
            //authentication failed
            /* return back()
                ->withInput() //flash the input-data the user typed into the inputs
                ->withErrors(['email' => 'Your provided credentials could not be verified.']); //set the error message back
            */

            //                ^
            //                |
            //          equivalent to
            //                ^
            //                |
            
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified'
            ]);
        }

        
        
        session()->regenerate(); //provides protection against session fixation attack

        //redirect with a success flash message
        return redirect('/')->with('success', 'Welcome Back!');

    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye!');
    }
}
