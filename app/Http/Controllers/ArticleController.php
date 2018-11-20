<?php

namespace App\Http\Controllers;

use App\article;
use App\User;
use Purifier;
use JWTAuth;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = article::with('user')->get();
        return $data;
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
            'slug' => 'required',
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
          ]);
          
        $post = new article;
        $post->slug =  $request->slug;
        $post->title = $request->title;
        $post->content = Purifier::clean($request->content);
        $post->author_id = JWTAuth::parseToken()->authenticate()->id;
        $post->type = $request->type;
        $post->save();

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = article::find($id)->with('user')->first();
        return $data;
    }

    public function showBySlug($slug)
    {
        $data = article::where('slug',$slug)->with('user')->first();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
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
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
          ]);
          
        $post = article::findOrFail($id);
        $post->title = $request->title;
        $post->content = Purifier::clean($request->content);
        $post->type = $request->type;
        $post->status = 1;
        $post->save();

        return $post;
    }
    public function updateStatus(Request $request, $id)
    {

        $this->validateWith([
            'status' => 'required',
          ]);
          
        $post = article::findOrFail($id);
        $post->status = $request->status;
        $post->save();

        return $post;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = article::findOrFail($id);
        if($post->count()>0){
            $post->delete();
            return response()->json(['statur'=>'success','msg'=>'Data siswa berhasil dihapus']);
        } else {
            return response()->json(['statur'=>'error','msg'=>'Gagal menghapus data Siswa']);
        }
    }
    public function apiCheckUnique(Request $request)
    {
        return json_encode(!article::where('slug', '=', $request->slug)->exists());
    }

    public function blog($slug)
    {
        if(article::where('slug', '=', $slug)->exists()){
            $post = article::where('slug', '=', $slug)->first();
        }else{
            $post = 'not found';
        }
        return $post;
    }
}
