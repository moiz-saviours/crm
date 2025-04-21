<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AssignTeamMember;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams()->with(['users' => function($query) {
            $query->where('status', 1);
        }])->get();
        return view('user.team-members.index', compact('teams'));
    }
}
