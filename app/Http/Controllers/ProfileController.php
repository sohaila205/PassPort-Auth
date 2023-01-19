<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //
    public function show()
    {
        $id = Auth::user()->id;
        $user = User::select('name', 'email')->find($id);
        if (isset($user)) {

            return response()->json([
                'user' => $user,
                'code' => 200
            ], 200);
        }
        return response()->json([
            'message' => __('trans.user_not_exist'),
            'code' => 201
        ], 201);
    }
    
    public function updateName(Request $request)
    {
        $id = Auth::user()->id;

        $user = User::find($id);

        $user->update([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => __('trans.update_name'),
            'code' => 200
        ], 200);
    }
}
