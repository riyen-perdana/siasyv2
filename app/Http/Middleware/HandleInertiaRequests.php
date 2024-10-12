<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'session' => [
                'status' 	=> fn () => $request->session()->get('status'),
                'success'   => fn () => $request->session()->get('success'),
                'error'    	=> fn () => $request->session()->get('error'),
            ],
            'auth' => [
                'user' => $request->user(),
                'permissions' => $request->user() ? $request->user()->getPermissionArray() : [],
                'roles' => $request->user() ? $request->user()->roles()->first()->name : [],
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
