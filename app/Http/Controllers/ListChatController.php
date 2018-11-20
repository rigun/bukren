<?php

namespace App\Http\Controllers;

use App\listChat;
use Illuminate\Http\Request;
use JWTAuth;
class ListChatController extends Controller
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
    public function store(Request $request)
    {
        $this->validateWith([
            'pesan' => 'required',
            'token' => 'required',
          ]);

          $id =JWTAuth::parseToken()->authenticate()->id;
   
          $listChat = new listChat();
          $listChat->pesan = $request->pesan;
          $listChat->token = $request->token;
          $listChat->id_pemilik = $id;
          $listChat->save();

          return $listChat;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\listChat  $listChat
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $listChat = listChat::where('token',$token)->get();
        return $listChat;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\listChat  $listChat
     * @return \Illuminate\Http\Response
     */
    public function edit(listChat $listChat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\listChat  $listChat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, listChat $listChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\listChat  $listChat
     * @return \Illuminate\Http\Response
     */
    public function destroy(listChat $listChat)
    {
        //
    }
}
