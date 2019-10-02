<?php

namespace App\Http\Controllers;

use App\File;
use App\Filters\FileFilters;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['main', 'index', 'show']);
    }

    public function main()
    {
        return view('files.main');
    }

    /**
     * Display a listing of the resource.
     *
     * @param FileFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(FileFilters $filters)
    {
        $files = File::latest()
            ->filter($filters)
            ->paginate(10);
        return view('files.index', ['files' => $files]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'file' => 'required'
            ]);
        if (($info = $this->getFileInfo($request->file)) !== false) {
            $file = File::create([
                'user_id' => $info['user_id'],
                'name' => $info['name'],
                'path' => $info['path'],
                'size' => $info['size'],
                'mime' => $info['mime'],
                'extension' => $info['extension']
            ]);
            return redirect($file->path())->with('flash', 'File uploaded.');
        };
        return redirect('/main');
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
     * Show the form for editing the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
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

        if(\request()->wantsJson()){
        return response([], 204);}

        return redirect()->route('list')->with('flash', 'File has been deleted.');
    }


    /**
     * @param $file
     * @return array|bool
     */
    protected function getFileInfo(UploadedFile $file)
    {
        if ($file->isValid()) {
            $userId = auth()->id();
            $mime = $file->getClientMimeType();
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $extension = $file->extension();
            $file->store("uploads/{$userId}", 'public');
            $path = "uploads/{$userId}/{$file->hashName()}";
            return [
                'user_id' => $userId,
                'name' => $name,
                'path' => $path,
                'size' => $size,
                'mime' => $mime,
                'extension' => $extension
            ];
        }
        return [
            'error' => $file->getError()
        ];
    }
}


