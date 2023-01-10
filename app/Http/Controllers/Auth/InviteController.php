<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InviteController extends Controller
{
    public function inviteView($invite_token)
    {
        if(Auth::check()) {
            return redirect('/dashboard');
        } else {
            $invite_token = base64_decode($invite_token);
            $time = Carbon::now()->subMinutes(120);

            //check if invitation link is still valid
            $invited_user = User::where('invite_token', $invite_token)->where('status', 2)->where('invited_at','>=',$time)->first();
            if(!$invited_user) {
                abort(404);
            } else {
                return view('auth/invitation', ['invited_user' => $invited_user]);
            }
        }

    }

    public function acceptInvitation(Request $request) {
        $invite_token = $request->input('invite_token');
        $time = Carbon::now()->subMinutes(120);

        //check if invitation link is still valid
        $invited_user = User::where('invite_token', $invite_token)->where('status', 2)->where('invited_at','>=',$time)->first();
        if(!$invited_user) {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = DB::table('users')->where('invite_token', $invite_token)
                    ->update(['name' => $request->input('name'), 'password' => Hash::make($request->input('password')), 'status' => 1, 'invite_token' => NULL, 'updated_at' => Carbon::now()]);

        if($user) {
            return redirect('/login');
        } else {
            abort(404);
        }
    }
}
