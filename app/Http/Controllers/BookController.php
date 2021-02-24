<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;
use App\DetailLibrary;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        return view('book',compact('categories'));
    }

    public function getAllBook(Request $request)
    {
        $books = Book::with('category')->get();

        if ($request->ajax()) {
            return datatables()->of($books)
                ->addColumn('action', function ($data) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit badge-success btn-sm edit-book"><i class="fa fa-edit">
                    </i>Edit</a>
                    <button class=" delete btn-sm btn-danger" data-id="' . $data->id . '" onclick="hapus(this)"><i class="la la-trash"></i>Hapus</button>';
                })
                ->addColumn('category_name', function ($data) {
                    return $data->category->name;
                })
                ->rawColumns(['action','category_name'])
                ->addIndexColumn()
                ->make(true);
            # code...
        }
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
   
        $book_id = $request->book_id;

        $details = [
        'name' => $request->name,
        'category_id' => $request->category,
        'author' => $request->author,
        ];

        $book = Book::updateOrCreate(['id' => $book_id], $details);

        return response()->json($book);
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
        
        $where = array('id' => $id);
        // $book  = Book::where($where)->first();
        $books = Book::with('category')
        ->where($where)
        ->first();

        $cat = Category::get();
        $lists = "<option value='" . $books->category->id . "'>" . $books->category->name . "</option>"; 
        foreach ($cat as $data) {
            $lists .= "<option value='" . $data->id . "'>" . $data->name . "</option>"; 
        }

        $callback = array('list_cat' => $lists, 'books' => $books); 

        return response()->json($callback);
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
        $book = Book::where('id', $id)->delete();
        $book = DetailLibrary::where('book_id', $id)->delete();
        return back()->with('success','Book deleted successfully');
    }
}
