<?php

namespace App\Http\Controllers\Atheer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Atheer\Auth\PermissionRepository;

use App\Http\Requests\Atheer\Auth\Permission\StoreRequest;
use App\Http\Requests\Atheer\Auth\Permission\UpdateRequest;
use App\Http\Requests\Atheer\Auth\Permission\DestroyRequest;

class PermissionController extends Controller
{
    protected $data = [];
    protected $model;

    public function __construct()
    {
        $this->view = 'atheer::groups.auth.permissions';
        $this->route = 'atheer.auth.permissions';
        $this->repository = new PermissionRepository;
        $this->model = $this->repository->model();
        $this->data['model'] = $this->model;

        $toBlade =  (object)[];
        $toBlade->view = $this->view;
        $toBlade->route = $this->route;
        $toBlade->group = 'auth';
        $toBlade->item = 'permissions';
        $toBlade->name = 'permission';
        $this->data['atheer'] = $toBlade;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('view', $this->model);
        $this->data['records'] = $this->model->query()->orderBy('name')->paginate(10);
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
    public function destroy(string $id, DestroyRequest $request)
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
}