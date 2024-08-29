<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaderboard = Leaderboard::orderBy('score', 'asc')
            ->orderBy('remaining_time', 'asc')
            ->with('user')
            ->get();

        return $this->success(['leaderboard' => $leaderboard], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'score' => 'required|integer',
            'remaining_time' => 'required|integer',
            'user_id' => 'required',
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        Leaderboard::create($request->all());

        return $this->success(['message' => 'Score has been saved'], 201);
    }
}
