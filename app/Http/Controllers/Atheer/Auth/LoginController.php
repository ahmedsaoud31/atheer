<?php

namespace App\Http\Controllers\Atheer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Atheer\AtheerController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Atheer\Auth\LoginRequest;
use App\Repositories\UserRepository;

class LoginController extends AtheerController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            return redirect('atheer.index');
        }else{
            return view("atheer::groups.auth.login");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
 
        if (auth()->attempt($credentials, $request->remember ? true : false)) {
            return redirect()->route('atheer.index');
        }else{
            $this->addPublicError(__('Login faild'));
            return Redirect::route('atheer.login')->withErrors($this->validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        if(auth()->user()){
            auth()->logout(auth()->user());
        }
        return redirect()->route('atheer.login');
    }
}
