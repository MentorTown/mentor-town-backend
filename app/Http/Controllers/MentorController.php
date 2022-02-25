<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Mentee;
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

            /*$mentee = Mentee::where('profession', $data['profession'])->inRandomOrder()
            ->limit(1)->first();*/

            $mentor_exist = Mentor::where('id', $user_id)->exists();

            if(!$mentor_exist) {
                /*if($mentee) {*/
                    
                    /*$mentee_id = $mentee->id;*/

                    $category = Mentor::create([
                        'user_id' => $user_id,
                        'industry' => $data['industry'],
                        'profession' => $data['profession'],
                        'interest' => $data['interest'],
                        'available' => $data['available'],
                        'time_available' => $data['time_available'],
                    ]);

                    User::where('id', $user_id)->update(['status' => 1]);

                    if($category) {
                        return response("Match successfully made", 201);
                    } else {
                        return response("Could not match", 311);
                    }

                /*} else {
                    return response("No mentee available", 311);
                }*/
            } else {
                return response("You are already a mentor", 311);
            }

        }else{

            $error = $validator->errors();
            return response($error, 311);

        }
    }

    public function getMentee() {
        $user_id = auth()->user()->id;

        $mentee = DB::table('mentees')
        ->join('users', 'mentees.user_id', '=', 'users.id')->get();
        
        return response($mentee, 201);
    }
}
