<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentor;
use Validator;

class MentorController extends Controller
{
    public function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'industry' => 'required|string',
            'profession' => 'required|string',
            'interest' => 'required|string',
            'available' => 'required|string',
            'time_available' => 'required|string',
        ]);

        $user_id = auth()->user()->id;
        
        if (!$validator->fails()){

            $data=$request->all();

            $category = Mentor::create([
                'user_id' => $user_id,
                'industry' => $data['industry'],
                'profession' => $data['profession'],
                'interest' => $data['interest'],
                'available' => $data['available'],
                'time_available' => $data['time_available'],
            ]);

            if($category) {
                return response("Match successfully made", 201);
            } else {
                return response("Could not match", 201);
            }

        }else{

            $error = $validator->errors();
            return response($error, 311);

        }
    }
}
