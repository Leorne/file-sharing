<?php

namespace App\Http\Controllers;

use App\File;
use App\Filters\FileFilters;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['main', 'index', 'show', 'getList']);
    }


    /**
     * Display a listing of the resource.
     *
     * @param FileFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('files.index');
    }


    /**
     * return list for json request
     * @param FileFilters $filters
     * @return mixed
     */
    public function getList(FileFilters $filters){
        $files = File::latest()
            ->filter($filters)
            ->paginate(20);
        return $files;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'file' => 'required'
            ]);

        $helper = new FileHelper($request->file);
        $data = $helper->getData();
        if (!isset($data['error'])) {
            $file = File::create($data);
            //OK
            if (\request()->json()) {
                $request->session()->flash('flash', 'File has been uploaded.');
                return $file->path();
            }

            return redirect($file->path())->with('flash', 'File uploaded.');
        };
        return redirect('/', 422);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return view('files.show', compact('file'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        $file->delete();

        \Storage::delete($file->getFilePath());

        if (\request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('list')->with('flash', 'File has been deleted.');
    }

}


