<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library;
use App\Book;
use App\Category;
use App\DetailLibrary;

class DetailLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DetailLibrary::with(['library','book'])->get();
        $library = Library::get();
        return view('contentLibraries',compact('library'));
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
        $id = $request->id;
        
        foreach($request->book as $book){
            $details = [
                'book_id' => $book,
                'library_id' => $request->library_id,
            ];
            $detail = DetailLibrary::updateOrCreate(['id' => $id], $details);
        }

        return response()->json($detail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $library = Library::find($id)->get();
        $data=[];
        foreach($library as $library){
            $data['library_name'] = $library->name;
        }
        $data['library_id'] = $id;
      
        $books = Book::with('category')->get();
        return view('addDetailLibrary',compact('data','books'));
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
        //
    }
}
