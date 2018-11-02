<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Imports\UsersImport;
use App\Role;
use App\UsersDetail;
use DB;
use Session;
use Input;
use File;
use Excel;
class UserController extends Controller
{
    public function index()
    {
        $users = User::with('detail')->whereRoleIs('user')->get();
        return $users;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validateWith([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|max:255',
            'npm' => 'required|max:255',
            'fakultas' => 'required|max:255',
            'prodi' => 'required|max:255',
            'universitas' => 'required|max:255',
          ]);
  
    
          $password = trim($request->password);
          
          $user = new User();
          $user->name = $request->name;
          $user->email = $request->email;
          $user->password = Hash::make($password);
          $user->save();

          $detailUser = new UsersDetail();
          $detailUser->npm = $request->npm;
          $detailUser->fakultas = $request->fakultas;
          $detailUser->prodi = $request->prodi;
          $detailUser->universitas = $request->universitas;
          $detailUser->save();

          if ($request->roles) {
            $user->syncRoles(explode(',', $request->roles));
          }
    
          return response()->json(['status' => 'success','msg'=>'User berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::with('detail')->where('id',$id)->get();
        return $users;
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
            'email' => 'required|unique:users,email,'.$id,
            'detail.npm' => 'required',
            'detail.fakultas' => 'required|max:255',
            'detail.prodi' => 'required|max:255',
            'detail.universitas' => 'required|max:255',
          ]);
  
         
        
          $user = User::findOrFail($id);
          $user->name = $request->name;
          $user->email = $request->email;
          if ($request->password_options == true) {
            $user->password = Hash::make('12345678');
            $json=['status' => 'success','msg'=>'data berhasil di update dan password berhasil di update menjadi 12345678'];
          }else{
            $json=['status' => 'success','msg'=>'data berhasil di update tanpa merubah password'];
          } 
          $user->save();

          if($idDetail = UsersDetail::where('user_id',$id)->first()){
            $detailUser = UsersDetail::findOrFail($idDetail->id);
            $detailUser->npm = $request->input('detail.npm');
            $detailUser->fakultas = $request->input('detail.fakultas');
            $detailUser->prodi = $request->input('detail.prodi');
            $detailUser->universitas = $request->input('detail.kelas');
            $detailUser->save();
          }else{
            $detailUser = new UsersDetail();
            $detailUser->npm = $request->input('detail.npm');
            $detailUser->fakultas = $request->input('detail.fakultas');
            $detailUser->prodi = $request->input('detail.prodi');
            $detailUser->universitas = $request->input('detail.universitas');
            $detailUser->user_id = $id;
            $detailUser->save();
          }
          
    
         
          return response()->json($json);
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validateWith([
            'password_lama' => 'required',
            'password_baru' => 'required',
          ]);
          $user = User::findOrFail($id);
          if(Hash::check($request->password_lama, $user->password)){
            $user->password = Hash::make($request->password_baru);    
            $json=['status' => 'success','msg'=>'Password berhasil diubah'];
          }else{
            $json=['status' => 'failed','msg'=>'Password yang anda masukkan salah, silahkan coba lagi'];
          }
          $user->save();
          
          return response()->json($json);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->count()>0){
            $user->delete();
            return response()->json(['status'=>'success','msg'=>'Data siswa berhasil dihapus']);
        } else {
            return response()->json(['status'=>'error','msg'=>'Gagal menghapus data Siswa']);
        }
    }

    public function getAuthenticatedUser()
    {
            try {

                    if (! $user = JWTAuth::parseToken()->authenticate()) {
                            return response()->json(['user_not_found'], 404);
                    }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                    return response()->json(['token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                    return response()->json(['token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    return response()->json(['token_absent'], $e->getStatusCode());

            }
            $userdata = User::with(['detail','roles'])->where('id',$user->id)->first();
            return response()->json(compact('userdata'));
    }

}
