<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/images/slider');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider = Slider::orderby('urutan','asc')->get();
        return $slider;
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
        $photos = $request->file('file');
 
        if (!is_array($photos)) {
            $photos = [$photos];
        }
 
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }
 
        $photo = $photos[0];
        $name = sha1(date('YmdHis') . str_random(30));
        $save_name = $name . '.' . $photo->getClientOriginalExtension();

        $photo->move($this->photos_path, $save_name);

        $slide = new Slider();
        $slide->urutan = $request->urutan;
        $slide->filename = $save_name;
        $slide->originalName = basename($photo->getClientOriginalName());
        $slide->save();

        return response()->json([
            'slider' => $slide
        ], 200);
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
        $uploaded_image = Slider::findOrFail($id);
 
        if (empty($uploaded_image)) {
            return response()->json(['message' => 'Sorry file does not exist'], 400);
        }
 
        $file_path = $this->photos_path . '/' . $uploaded_image->filename;
 
        if (file_exists($file_path)) {
            unlink($file_path);
        }
 
        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }
        
        return "Terhapus";
    }
}
