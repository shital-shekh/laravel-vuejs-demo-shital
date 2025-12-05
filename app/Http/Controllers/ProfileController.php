<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;

class ProfileController extends Controller
{
    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'email'       => 'required|email',
            'gender'      => 'nullable',
            'country'     => 'nullable',
            'hobbies'     => 'nullable',
            'avatar'      => 'nullable'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(422, $validator->errors()->first());
        }



        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->hobbies = $request->hobbies; // JSON string

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Create uploads folder if missing
            $path = public_path('uploads/avatar');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $user->avatar = $filename;
        }
        else
        {
            $user->avatar = "Vijay";


            
        }

        $user->save();

        return ApiResponse::success(200, 'Profile updated successfully!', $user);
    }
}
