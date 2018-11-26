<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
class KategoriController extends Controller
{
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/images/kategori');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all();
        return $kategori;
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
            'name' => 'required|max:255|unique:kategoris',
          ]);

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
  
          $kategori = new Kategori();
          $kategori->name = $request->name;
          $kategori->filename = $save_name;
          $kategori->originalName = basename($photo->getClientOriginalName());
          $kategori->save();

          return response()->json(['status' => 'success','msg'=>'Kategori berhasil dibuat']);
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
        $this->validateWith([
            'name' => 'required|max:255|unique:kategoris',
          ]);
          $item = Kategori::find($id);
              if (empty($item)) {
            return response()->json(['message' => 'Sorry file does not exist'], 400);
            }else{
                $photos = $request->file('file');

                if($photos){
                    $file_path = $this->photos_path . '/' . $item->filename;
    
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
    
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
    
                    $item->filename = $save_name;
                    $item->originalName = basename($photo->getClientOriginalName());
                }
              $kategori->name = $request->name;
              $item->save();
    
              return $item;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $uploaded_image = Kategori::findOrFail($id);
 
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
