<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query()->with('roles');
        $roles = Role::all();

        if($request->has('search')) {
            $user->where('name','like','%'.$request->search.'%');
            $user->orWhere('email','like','%'.$request->search.'%');
            $user->orWhere('nip','like','%'.$request->search.'%');
        }

        if($request->has('field','order')) {
            $user->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;


        return Inertia::render('Apps/Users/Index', [
            'perPage' => intval($perPage),
            'users' => $user->paginate($perPage),
            'roles' => $roles,
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
