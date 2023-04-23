<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $website_id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
        ]);

        $user = User::find($validatedData['user_id']);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $website = Website::find($website_id);
        if (!$website) {
            return response()->json(['error' => 'Website not found.'], 404);
        }

        $subscription = Subscription::where('user_id', $validatedData['user_id'])
            ->where('website_id', $website_id)
            ->first();

        if ($subscription) {
            return response()->json(['error' => 'Subscription already exists.'], 400);
        }

        $subscription = Subscription::create([
            'user_id' => $validatedData['user_id'],
            'website_id' => $website_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully.',
            'data' => $subscription,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
