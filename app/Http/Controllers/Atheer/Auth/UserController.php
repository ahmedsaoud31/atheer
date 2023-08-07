<?php

namespace App\Http\Controllers\Atheer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\Atheer\Auth\RoleRepository;

use App\Http\Requests\Atheer\Auth\User\StoreRequest;
use App\Http\Requests\Atheer\Auth\User\UpdateRequest;
use App\Http\Requests\Atheer\Auth\User\UpdateRoleRequest;

use Atheer;

class UserController extends Controller
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
     */
    public function index()
    {
        // $this->authorize('view', $this->model);
        $this->data['records'] = $this->model->query()->orderBy('id', 'desc')->paginate(10);
        return view("{$this->view}.index", $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('view', $this->model);
        if(request()->ajax()){
            $body = view("{$this->view}.forms.form", $this->data)->render();
            return response()->json(['body' => $body], 200);
        }else{
            return view("{$this->view}.forms.create", $this->data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // $this->authorize('create', $this->model);
        $this->data['record'] = $this->model = $this->repository->create($request->validated());
        if(request()->ajax()){
            $body = view("{$this->view}.tables.row", $this->data)->render();
            return response()->json(['message' => __("Data created successfully"), 'body' => $body, 'id' => $this->model->id], 200);
        }else{
            request()->session()->flash('alert-success', __("Data created successfully"));
            return redirect()->route("{$this->route}.index");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $this->authorize('view', $this->model);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['model'] = $this->model = $this->repository->firstOrFail($id);
        $this->data['atheer']->form = 'edit';
        // $this->authorize('view', $this->model);
        if(request()->ajax()){
            $body = view("{$this->view}.forms.form", $this->data)->render();
            return response()->json(['body' => $body], 200);
        }else{
            return view("{$this->view}.forms.edit", $this->data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $this->model = $this->repository->firstOrFail($id);
        // $this->authorize('update', $this->model);
        $this->repository->update($this->model, $request->validated());
        if(request()->ajax()){
            $this->data['record'] = $this->repository->first($id);
            $body = view("{$this->view}.tables.row", $this->data)->render();
            return response()->json(['message' => __("Data updated successfully"), 'body' => $body], 200);
        }else{
            request()->session()->flash('alert-success', __("Data updated successfully"));
            return redirect()->route("{$this->route}.edit", $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->model = $this->repository->firstOrFail($id);
        // $this->authorize('delete', $this->model);
        $this->model->delete();
        if(request()->ajax()){
            return response()->json(['message' => __("Data deleted successfully"), 'body' => ''], 200);
        }else{
            request()->session()->flash('alert-success', __("Data deleted successfully"));
            return redirect()->route("{$this->route}.index");
        }
    }

    public function roles()
    {
        $this->data['model'] = $this->model = $this->repository->firstOrFail(request()->id);
        $this->data['roles'] = Atheer::optionsFormat((new RoleRepository)->query()->get());
        $this->data['selections'] = $this->model->roles()->pluck('id')->toArray();
        if(request()->ajax()){
            $body = view("{$this->view}.forms.roles-form", $this->data)->render();
            return response()->json(['body' => $body], 200);
        }else{
            return view("{$this->view}.forms.roles", $this->data);
        }
    }

    public function updateRoles(UpdateRoleRequest $request)
    {
        $this->data['model'] = $this->model = $this->repository->firstOrFail(request()->id);
        $validated = (object)$request->validated();
        if(!isset($validated->roles)){
            $validated->roles = [];
        }
        $this->model->syncRoles($validated->roles);
        if(request()->ajax()){
            $this->data['record'] = $this->model;
            $body = view("{$this->view}.tables.row", $this->data)->render();
            return response()->json(['message' => __("Data updated successfully"), 'body' => $body], 200);
        }else{
            request()->session()->flash('alert-success', __("Data updated successfully"));
            return redirect()->route("{$this->route}.index");
        }
    }
}