<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mentee;
use App\Models\Mentor;
use Validator;
use DB;

class MenteeController extends Controller
{
    public function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'industry' => 'required|string',
            'profession' => 'required|string',
            'experience' => 'required|string',
            'available' => 'required|string',
            'time_available' => 'required|string',
        ]);

        $user_id = auth()->user()->id;
        
        if (!$validator->fails()){
            
            $data=$request->all();

            $mentor = Mentor::where('profession', $data['profession'])->inRandomOrder()
            ->limit(1)->first();

            $mentee_exist = Mentee::where('id', $user_id)->exists();

            if(!$mentee_exist) {
                if($mentor) {  

                    $mentor_id = $mentor->id;

                    $category = Mentee::create([
                        'user_id' => $user_id,
                        'industry' => $data['industry'],
                        'profession' => $data['profession'],
                        'experience' => $data['experience'],
                        'available' => $data['available'],
                        'time_available' => $data['time_available'],
                        'mentor' => $mentor_id
                    ]);

                    $affected = User::where('id', $user_id)->update(['status' => 2]);

                    if($category) {
                        return response("Match successfully made", 201);
                    } else {
                        return response("Could not match", 311);
                    }
                } else {
                    return response("No mentor available", 311);
                }
            } else {
                return response("You are already a mentee", 311);
            }

        }else{

            $error = $validator->errors();
            return response($error, 311);

        }
    }

    public function getMentor() {
        $user_id = auth()->user()->id;

        $mentee = Mentee::where('user_id', $user_id)->first();
        $mentor_id = $mentee->mentor;

        $mentor = User::where('id', $mentor_id)->first();
        $mentor_name = $mentor->name;

        $mentor = DB::table('mentors')
        ->join('users', 'mentors.user_id', '=', 'users.id')->first();

        $mentor = json_encode($mentor);
        
        return response($mentor, 201);
    }
}
