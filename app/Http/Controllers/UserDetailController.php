<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UsersDetail;
use App\Book;
use App\Chat;
use JWTAuth;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $detail = User::where('id',$user->id)->with('detail')->first();
        return $detail;
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
            'name' => 'required|max:255',
            'detail.npm' => 'required',
            'detail.prodi' => 'required',
            'detail.tanggalLahir' => 'required',
            'detail.nomorHp' => 'required',
            'detail.jenisKelamin' => 'required',
          ]);
  
    
          $id = JWTAuth::parseToken()->authenticate()->id;

          $user = User::findOrFail($id);
          $user->name = $request->name;
          if($request->status == 0){ //Belum verfikasi email
                $user->status = 2; // email belum diverfikasi tetapi detail sudah lengkap
          }else if($request->status == 1){ //email sudah diverfikasi
              $user->status = 3; // email sudah diverfikasi dan data sudah lengkap.
          }
          $user->save();

          if($detailUser = UsersDetail::where('user_id',$id)->first()){
            $detailUser->tanggalLahir = $request->input('detail.tanggalLahir');
            $detailUser->nomorHp = $request->input('detail.nomorHp');
            $detailUser->npm = $request->input('detail.npm');
            $detailUser->prodi = $request->input('detail.prodi');
            $detailUser->jenisKelamin = $request->input('detail.jenisKelamin');
            $detailUser->save();
            $msg = 'Detail Berhasil Ditambahkan';

          }else{
            $detailUser = new UsersDetail();
            $detailUser->tanggalLahir = $request->input('detail.tanggalLahir');
            $detailUser->nomorHp = $request->input('detail.nomorHp');
            $detailUser->npm = $request->input('detail.npm');
            $detailUser->prodi = $request->input('detail.prodi');
            $detailUser->jenisKelamin = $request->input('detail.jenisKelamin');
            $detailUser->user_id = $id;
            $detailUser->save();

            $msg = 'Detail Berhasil Diperbaharui';

          }

    
          return response()->json(['status' => 'success','msg'=>'Detail user berhasil di perbaharui ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $userDetail = $user->detail;
        return $userDetail;
    }
    public function showByChatToken($token)
    {
        $chat = Chat::where('token',$token)->first();
        $id = JWTAuth::parseToken()->authenticate()->id;
        if($chat->id_user1 == $id){
            $detail = User::where('id',$chat->id_user2)->with('detail')->first();
        }else if($chat->id_user2 == $id){
            $detail = User::where('id',$chat->id_user1)->with('detail')->first();
        }else{
            $detail = "tidak ditemukan";
        }
        return $detail;
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
        $this->validateWith([
            'name' => 'required|max:255',
            'tanggalLahir' => 'required',
            'nomorHp' => 'required',
            'jenisKelamin' => 'required',
          ]);
  
    

          $user = User::findOrFail($request->userId);
          $user->name = $request->name;
          if($request->status == 0){ //Belum verfikasi email
                $user->status = 2; // email belum diverfikasi tetapi detail sudah lengkap
          }else if($request->status == 1){ //email sudah diverfikasi
              $user->status = 3; // email sudah diverfikasi dan data sudah lengkap.
          }
          $user->save();

          if($detailUser = UsersDetail::where('user_id',$id)->first()){
            $detailUser->tanggalLahir = $request->tanggalLahir;
            $detailUser->nomorHp = $request->nomorHp;
            $detailUser->jenisKelamin = $request->jenisKelamin;
            $detailUser->save();
            $msg = 'user berhasil di update';

          }else{
              $msg = 'user id tidak ditemukan';
          }
          
    
          return response()->json(['status' => 'success','msg'=>$msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->count()>0){
            $detailUser = UsersDetail::where('user_id',$id)->first();
            $detailUser->delete();
            $user->delete();
            return response()->json(['status'=>'success','msg'=>'Data berhasil dihapus']);
        } else {
            return response()->json(['status'=>'error','msg'=>'Gagal menghapus data']);
        }
    }
}
