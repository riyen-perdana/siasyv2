<?php

namespace App\Http\Controllers\Apps;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\Permission\PermissionStoreRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserIndexRequest $request)
    {
        $permission = Permission::query();

        if($request->has('search')) {
            $permission->where('name','like','%'.$request->search.'%');
        }

        if($request->has('field','order')) {
            $permission->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Apps/Permission/Index', [
            'perPage' => intval($perPage),
            'permissions' => $permission->paginate($perPage),
            'filters' => $request->all(['search','field','order'])
        ]);

    }

    /**
     * TODO : Store Data Permission to Database
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        DB::beginTransaction();

        try {

            Permission::create([
                'name' => $request['nm_perizinan']
            ]);

            DB::commit();

            return redirect()->route('apps.permission.index');

        } catch (\Throwable $th) {

            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());

        }
    }
    
    /**
     * TODO : Delete Data Permission from Database
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Permission::destroy($id);

            DB::commit();
            return redirect()->route('apps.permission.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(PermissionUpdateRequest $request,$id)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::findOrFail($id);
            $permission->update([
                'name' => $request['nm_perizinan']
            ]);

            DB::commit();

            return redirect()->route('apps.permission.index');
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }   
}
