<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\InviteUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserController extends Controller
{
    public function manageAdmins()
    {

        // Fetch records
        $admins = array();
        $admins = User::withTrashed()->where('role', 0)->get();
        $data = [
            'current_nav_tab' => 'users',
            'admins' => $admins,
        ];
        return view('admin/manageAdmins', $data);
    }

    public function manageJournalists()
    {

        // Fetch records
        $journalists = array();
        $journalists = User::withTrashed()->where('role', 1)->get();
        $data = [
            'current_nav_tab' => 'users',
            'journalists' => $journalists,
        ];
        return view('admin/manageJournalists', $data);
    }

    public function manageUsers()
    {

        // Fetch records
        $users = array();
        $users = User::withTrashed()->where('role', 2)->get();
        $data = [
            'current_nav_tab' => 'users',
            'users' => $users,
        ];
        return view('admin/manageUsers', $data);
    }

    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        do {
            //generate a random string using Laravel's str_random helper
            $token = Str::random(20);
        } //check if the token already exists and if it does, try again
        while (User::where('invite_token', $token)->first());

        $invited_user = User::create([
            'name' => '',
            'email' => $request->get('email'),
            'password' => '',
            'role' => 0,
            'profile_avatar_url' => '',
            'status' => 2,
            'invite_token' => $token,
            'invited_at' => Carbon::now()->toDateTimeString()
        ]);

        //generate a URL and send invitation email

        Mail::to($request->get('email'))->send(new InviteUser($token));

        notify()->success("You've added a new administrator successfully.");
        return response()->json(["success"=> "You've added a new administrator successfully."]);
    }

    public function createJournalist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        do {
            //generate a random string using Laravel's str_random helper
            $token = Str::random(20);
        } //check if the token already exists and if it does, try again
        while (User::where('invite_token', $token)->first());

        $invited_user = User::create([
            'name' => '',
            'email' => $request->get('email'),
            'password' => '',
            'role' => 1,
            'profile_avatar_url' => '',
            'status' => 2,
            'invite_token' => $token,
            'invited_at' => Carbon::now()->toDateTimeString()
        ]);

        //generate a URL and send invitation email

        Mail::to($request->get('email'))->send(new InviteUser($token));

        notify()->success("You've added a new journalist successfully.");
        return response()->json(["success"=> "You've added a new journalist successfully."]);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        do {
            //generate a random string using Laravel's str_random helper
            $token = Str::random(20);
        } //check if the token already exists and if it does, try again
        while (User::where('invite_token', $token)->first());

        $invited_user = User::create([
            'name' => '',
            'email' => $request->get('email'),
            'password' => '',
            'role' => 2,
            'profile_avatar_url' => '',
            'status' => 2,
            'invite_token' => $token,
            'invited_at' => Carbon::now()->toDateTimeString()
        ]);

        //generate a URL and send invitation email

        Mail::to($request->get('email'))->send(new InviteUser($token));

        notify()->success("You've added a new user successfully.");
        return response()->json(["success"=> "You've added a new user successfully."]);
    }

    public function lockUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $user_id = $request->get('user_id');
        $user = User::where('id', $user_id)->first();
        if($user) {
            $locked_user = User::where('id', $user_id)->delete();
            notify()->success("You've locked the user successfully.");
            return response()->json(['success' => "You've locked the user successfully."]);
        } else {
            notify()->error('Unable to find a user.');
            return response()->json(['error' => 'Unable to find a user.']);
        }
    }

    public function unlockUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $user_id = $request->get('user_id');
        $user = User::onlyTrashed()->where('id', $user_id)->first();
        if($user) {
            $unlocked_user = User::onlyTrashed()->where('id', $user_id)->restore();
            notify()->success("You've unlocked the user successfully.");
            return response()->json(['success' => "You've unlocked the user successfully."]);
        } else {
            notify()->error('Unable to find a user.');
            return response()->json(['error' => 'Unable to find a user.']);
        }
    }
}
