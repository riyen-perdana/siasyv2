<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = Role::query()->with('permissions');
        // $permission = Permission::all();
        $data = Permission::orderBy('name')->pluck('name', 'id');
        $collection = collect($data);
        $permissions = $collection->groupBy(function ($item, $key) {
            // Memecah string menjadi array kata-kata
            $words = explode('.', $item);

            // Mengambil kata pertama
            return $words[0];
        });

        if($request->has('search')) {
            $role->where('name','like','%'.$request->search.'%');
        }

        if($request->has('field','order')) {
            $role->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Apps/Roles/Index', [
            'perPage' => intval($perPage),
            'roles' => $role->paginate($perPage),
            'permissions' => $permissions,
            'filters' => $request->all(['search','field','order'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $request->nm_role]);
            $role->givePermissionTo($request->permission);
            DB::commit();
            return redirect()->route('apps.roles.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, string $id)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {

            $role = Role::findOrFail($id);
            
            $role->update(['name' => $request->nm_role]);
            $role->syncPermissions($request->permission);
            
            DB::commit();
            return redirect()->route('apps.roles.index');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
        // update role data
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            Role::destroy($id);

            DB::commit();
            return redirect()->route('apps.roles.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->ids as $id) {
                Role::destroy($id);
            }
            DB::commit();
            return redirect()->route('apps.roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
