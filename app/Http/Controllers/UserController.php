<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');

        if ($search) {
            $users = User::with('todo') -> where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orderBy('name')
                ->where('id', '!=', 1)
                ->paginate(20)
                ->withQueryString();
        } else {
            $users = User::with('todo')->where('id', '!=', 1)
                ->orderBy('name')
                ->paginate(20);
        }

        return view('user.index', compact('users'));
    }
    public function makeadmin(User $data)
    {
        $data->timestamps = false;
        $data->is_admin = true;
        $data->update();

        return back()->with('success', 'Make admin successfully!');
    }

    public function removeadmin(User $data)
    {
        if ($data->id != 1) {
            $data->timestamps = false;
            $data->is_admin = false;
            $data->update();

            return back()->with('success', 'Remove admin successfully!');
        } else {
            return redirect()->route('user.index');
        }
    }
    public function destroy(User $data)
    {
        if ($data->id != 1) {
            $data->delete();
            return back()->with('success', 'Delete user successfully!');
        } else {
            return redirect()->route('user.index')->with('danger', 'Delete user failed!');
        }
    }
}
