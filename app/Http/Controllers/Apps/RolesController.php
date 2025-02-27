<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::with('permissions')->get();
        // $permission = Permission::all();
        $data = Permission::orderBy('name')->pluck('name', 'id');
        $collection = collect($data);
        $permissions = $collection->groupBy(function ($item, $key) {
            // Memecah string menjadi array kata-kata
            $words = explode('.', $item);

            // Mengambil kata pertama
            return $words[0];
        });

        return Inertia::render('Apps/Roles/Index', [
            'roles' => $role,
            'permissions' => $permissions
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get permissions
        // $permissions = Permission::all();
        $data = Permission::orderBy('name')->pluck('name', 'id');
        $collection = collect($data);
        $permissions = $collection->groupBy(function ($item, $key) {
            // Memecah string menjadi array kata-kata
            $words = explode('.', $item);

            // Mengambil kata pertama
            return $words[0];
        });
        return $permissions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
