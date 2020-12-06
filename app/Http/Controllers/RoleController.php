<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create (Request $request)
    {
        $role = new Role();
        $role->fill($request->all());
        $role->save();

        return $role;
    }

    public function getAll (Request $request)
    {
        return Role::all();
    }

    public function get (Request$request)
    {
        $role = Role::where('id', $request->route('id'))->get();

        return $role;
    }

    public function update (Request $request)
    {
        $role = Role::where('id', $request->json('id'))
            ->update($request->all());

        return $request->all();
    }

    public function delete (Request $request)
    {
        $role = Role::where('id', $request->route('id'));

        $role->delete();

        return $role->get();
    }
}
