<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use JWTAuth;
use App\listChat;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = JWTAuth::parseToken()->authenticate()->id;
        $pesan = Chat::where('id_user1',$id)->orwhere('id_user2',$id)->with(['user1','user2'])->get();
        return $pesan;
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
            'id_penerima' => 'required',
          ]);

          $id =JWTAuth::parseToken()->authenticate()->id;
          if($chat = Chat::where([['id_user1',$id],['id_user2',$request->id_penerima]])->orwhere([['id_user1',$request->id_penerima],['id_user2',$id]])->first()){
              return $chat->token;
          }else{
            $chat = new Chat();
            $chat->id_user1 = JWTAuth::parseToken()->authenticate()->id;
            $chat->id_user2 = $request->id_penerima;
            $chat->token = bin2hex(random_bytes(64));
            $chat->save();  
            return $chat->token;
          }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $idUser =JWTAuth::parseToken()->authenticate()->id;
        if($chat->count()>0){
            if($chat->id_user1 != $chat->id_user2){
                if($chat->id_user1 == $idUser){
                    $chat->id_user1 = $chat->id_user2;
                }else if($chat->id_user2 == $idUser){
                    $chat->id_user2 = $chat->id_user1;
                }
                $chat->save();
            }else{
                $chat->delete();
            }
            return response()->json(['status'=>'success','msg'=>'Data berhasil dihapus']);
        } else {
            return response()->json(['status'=>'error','msg'=>'Gagal menghapus data']);
        }
    }
}
