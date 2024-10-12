<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(Request $request)
    {
        $permission = Permission::query();

        if($request->has('search')) {
            $permission->where('name','like','%'.$request->search.'%');
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Apps/Permission/Index', [
            'perPage' => intval($perPage),
            'permissions' => $permission->paginate($perPage),
            'filters' => $request->all(['search'])
        ]);
        //dd($request);
    }
}
