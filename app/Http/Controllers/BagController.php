<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bag;
use JWTAuth;
class BagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bag = Bag::where('pemilik_id', JWTAuth::parseToken()->authenticate()->id)->with('barang')->get();
        return $bag;
    }
    public function count()
    {
        $bag = Bag::where('pemilik_id', JWTAuth::parseToken()->authenticate()->id)->count();
        return $bag;
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
            'barang_id' => 'required|max:255',
          ]);

          $bag = new Bag();
          $bag->barang_id = $request->barang_id;
          $bag->pemilik_id = JWTAuth::parseToken()->authenticate()->id;
          $bag->status = 0;
          $bag->save();

          return $bag;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $bag = Bag::where('pemilik_id', $id)->get();
        return $bag;
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
        $item = Bag::findOrFail($id);
        if($item->count()>0){
            $item->delete();
            return response()->json(['status'=>'success','msg'=>'Data berhasil dihapus']);
        } else {
            return response()->json(['status'=>'error','msg'=>'Gagal menghapus data']);
        }
    }
}
