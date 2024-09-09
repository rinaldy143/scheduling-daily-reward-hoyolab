<?php

namespace App\Http\Controllers;

use App\Models\Cookies;
use Illuminate\Http\Request;

class CookiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cookies = Cookies::where('user_id', auth()->id())->latest()->first();
        return view('cookies', compact('cookies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cookie' => 'required|string',
        ]);

        // Simpan data baru ke database
        $cookies = new Cookies();
        $cookies->user_id = auth()->id();
        $cookies->cookie = $request->cookie;
        $cookies->save();

        return response()->json(['success' => 'Cookie berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cookies $cookies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cookies $cookies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cookies $cookies)
    {
        $request->validate([
            'id' => 'required|exists:cookies,id',
            'cookie' => 'nullable|string',
        ]);

        $cookies = Cookies::find($request->id);
        $cookies->cookie = $request->cookie;
        $cookies->save();

        return response()->json(['success' => true, 'message' => 'Log updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cookies $cookies)
    {
        //
    }
}
