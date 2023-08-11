<?php

namespace App\Http\Controllers\Atheer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Atheer\Auth\ForgotPasswordRequest;
use App\Http\Requests\Atheer\Auth\ResetPasswordRequest;
use App\Repositories\UserRepository;

class ForgotPasswordController extends Controller
{
    protected $data = [];
    protected $model;

    public function __construct()
    {
        $this->view = 'atheer::groups.auth.users';
        $this->route = 'atheer.auth.users';
        $this->repository = new UserRepository;
        $this->model = $this->repository->model();
        $this->data['model'] = $this->model;

        $toBlade =  (object)[];
        $toBlade->view = $this->view;
        $toBlade->route = $this->route;
        $toBlade->group = 'auth';
        $toBlade->item = 'users';
        $toBlade->name = 'user';
        $this->data['atheer'] = $toBlade;
    }

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
            return view("atheer::groups.auth.forgot-password");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForgotPasswordRequest $request)
    {
        $user = $this->repository->byEmail($request->email);
        $this->repository->sendRestPasswordEmail($user);
        request()->session()->flash('alert-success', __("Reset email send to your email, Please check your email"));
        return redirect()->route("atheer.forgot-password.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->byId($id);
        if(!request()->hasValidSignature()){
            request()->session()->flash('alert-danger', __("Signature expired, Please resend it again"));
            return redirect()->route("atheer.forgot-password.index");
        }
        return view("atheer::groups.auth.reset-password", $this->data);
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
    public function update(ResetPasswordRequest $request, $id)
    {
        $this->model = $this->repository->firstOrFail($id);
        // $this->authorize('update', $this->model);
        $this->repository->update($this->model, $request->validated());
        auth()->login($this->model);
        request()->session()->flash('alert-success', __("Password updated successfully"));
        return redirect()->route('atheer.index'); 
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
}
