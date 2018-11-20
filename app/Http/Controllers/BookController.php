<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Kategori;
use JWTAuth;

class BookController extends Controller
{
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/images/book');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::where('id_pemilik',JWTAuth::parseToken()->authenticate()->id)->with(['kategori'])->get();
        return $book;
    }
    public function search($search){
        $book = Book::where('nama', 'LIKE', '%'.$search.'%')->with(['kategori','user'])->get();
        return $book;
    }
    public function showAll(){
        $book = Book::with(['kategori','user'])->get();
        return $book;
    }
    public function newItem()
    {
        $book = Book::orderby('created_at','desc')->with('kategori')->get();
        return $book;
    }
    public function freeItem()
    {
        $book = Book::orderby('created_at','desc')->where('type','Gratis')->with('kategori')->get();
        return $book;
    }
    public function paidItem()
    {
        $book = Book::orderby('created_at','desc')->where('type','!=','Gratis')->with('kategori')->get();
        return $book;
    }
    public function detailBarang($slug)
    {
        $book = Book::where('slug',$slug)->with(['kategori'])->first();
        return $book;
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
            'nama' => 'required',
            'deskripsi' => 'required',
            'pengarang' => 'required',
            'type' => 'required',
            'tahun' => 'required',
            'slug' => 'required',
            'stok' => 'required',
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
        $book = new Book();
        $book->nama = $request->nama;
        $book->slug = $request->slug;
        $book->filename = $save_name;
        $book->originalName = basename($photo->getClientOriginalName());
        $book->deskripsi = $request->deskripsi;
        $book->pengarang = $request->pengarang;
        $book->tahun = $request->tahun;
        if($request->harga != null){
            $book->harga = $request->harga;
        }
        $book->type = $request->type;
        $book->stok = $request->stok;
        $book->id_kategori = $request->kat_id;
        $book->id_pemilik = $user = JWTAuth::parseToken()->authenticate()->id;
        $book->save();
      

          return response()->json(['status' => 'success','msg'=>'Kategori berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kategori)
    {
        $kategori = Kategori::where('name', $kategori)->first();
        $book = $kategori->book;
        return $book;
    }
    public function showByType($type)
    {
        if($type == 'Gratis'){
            $book = Book::where('type', $type)->with('kategori')->get();
        }else{
            $book = Book::where('type','!=', $type)->with('kategori')->get();
        }
        return $book;
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
            'nama' => 'required',
            'deskripsi' => 'required',
            'pengarang' => 'required',
            'type' => 'required',
            'tahun' => 'required',
            'stok' => 'required',
          ]);

          $book = Book::findOrFail($id);
          if (empty($book)) {
                return response()->json(['message' => 'Sorry file does not exist'], 400);
            }
          $photos = $request->file('file');

          if($photos){
            $file_path = $this->photos_path . '/' . $book->filename;
 
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

            $book->filename = $save_name;
            $book->originalName = basename($photo->getClientOriginalName());
          }
        

        $book->nama = $request->nama;
        $book->deskripsi = $request->deskripsi;
        $book->pengarang = $request->pengarang;
        $book->tahun = $request->tahun;
        if($request->harga != null){
            $book->harga = $request->harga;
        }
        $book->type = $request->type;
        $book->stok = $request->stok;
        $book->id_kategori = $request->kat_id;
        $book->save();
      

          return response()->json(['status' => 'success','msg'=>'Kategori berhasil dibuat']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $uploaded_image = Book::findOrFail($id);
 
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

    public function apiCheckUnique(Request $request)
    {
        return json_encode(!Book::where('slug', '=', $request->slug)->exists());
    }
}
