<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library;

class LibraryController extends Controller
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
        return view('library');
    }

    public function getAllLibrary(Request $request)
    {
        $libraries = Library::get();

        if ($request->ajax()) {
            return datatables()->of($libraries)
                ->addColumn('action', function ($data) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit badge-success btn-sm edit-library"><i class="fa fa-edit">
                    </i>Edit</a>
                    <button class=" delete btn-sm btn-danger" data-id="' . $data->id . '" onclick="hapus(this)"><i class="la la-trash"></i>Hapus</button>
                        <a href="/library/'.$data->id.'/add_book" data-toggle="tooltip"   class="edit badge-info btn-sm add-book">Add book</a>';
                })
                ->rawColumns(['action'])
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
        $library_id = $request->library_id;

        $details = [
            'name' => $request->name,
            'address' => $request->address,
        ];

        $library = Library::updateOrCreate(['id' => $library_id], $details);

        return response()->json($library);
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
        $library  = Library::where($where)->first();

        return response()->json($library);
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
        
        $library = Library::where('id', $id)->delete();

        return back()->with('success','Library deleted successfully');
    }
}
