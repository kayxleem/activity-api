<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function users()
    {
        $users = User::all();
        if ($users->count() > 0) {
            return view('admin.users', compact('users'));

        } else {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'success', 'message' => 'No Users found']);
        }
    }
}
