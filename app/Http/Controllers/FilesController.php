<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
//use Symfony\Component\HttpClient\HttpClient;
//use Symfony\Component\HttpClient\Exception\ClientExceptionInterface;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;

class FilesController extends Controller
{

    public function index()
    {
        $userId = auth()->id();
        $files = File::where('user_id', $userId)->where('is_new', true)->get();
        //$files = File::all();

        return view('files.index', ['files' => $files]);

    }

    public function filelist()
    {
        
        // dd(Storage::disk('public')->path('/files/student entry.docx'));
        // Storage::disk('public')->path('/file/filename.docx'));

        $userId = auth()->id();
        $files = File::where('user_id', $userId)->where('is_new', true)->get();
        // $files = File::where('user_id', $userId)->get();
        $filePath = [];
        // dd($files);

        //Loop through each file to get its path
        foreach ($files as $file) {
            // Generate the URL for the file using Laravel's Storage facade
            $filePath[$file->id] = Storage::url($file->path);
        }
        // dd($filePath);

        // Update the path property of each file with the generated URL
        foreach ($files as $file) {
            $file->path = $filePath[$file->id];
        }
        // File::where('user_id', $userId)->update(['is_new' => false]);
        return view('files.filelist', ['files' => $files]);

    }

    public function create()
    {
        return view('files.create');
    }


    public function store(StoreFileRequest $request)
{
    // Validate file
    $request->validate([
        'file' => 'required|mimes:doc,docx,pdf|max:10240', // Adjust the max file size if needed
    ]);

    // Continue with file upload logic if validation passes
    if ($request->hasFile('file')) {
        $uploadedFile = $request->file('file');
        $fileName = $uploadedFile->getClientOriginalName();
        $type = $uploadedFile->getClientMimeType();
        $size = $uploadedFile->getSize();

        // Move the uploaded file to the public/file directory
        // $uploadedFile->move(public_path('file'), $fileName);
        $filePath= Storage::disk('public')->putFileAs('files', $uploadedFile, $fileName);

        // Create a new File record in the database
        File::create([
            'user_id' => auth()->id(),
            'name' => $fileName,
            'type' => $type,
            'size' => $size,
            'path' => $filePath,// Adjust the path as needed
            'is_new'=> true, // Mark the file as newly uploaded
        ]);

        return redirect()->route('files.index')->withSuccess(__('File added successfully.'));
    }
}


    public function storeText(Request $request)
    {
        // $client = HttpClient::create();  //newly added
        $text = $request->input('text');

        if (!empty($text)) {
            $fileName = time() . '.txt';
            Storage::disk('public')->put($fileName, $text);

            return redirect()->back()->with('success', 'Text stored successfully.');
        }
    }

       
    public function delete(Request $request, $id)
    {
        $files = File::findOrFail($id);
        $files->delete();
        return redirect()->back()->with('success', 'File deleted successfully');
    }

    // public function show($id)
    // {
    //     $file = File::find($id);

    //     if (!$file) {
    //         abort(404);
    //     }

    //     $path = public_path($file->path . '/file' . $file->filename);

    //     if (!File::exists($path)) {
    //         abort(404);
    //     }

    //     $file = File::get($path);
    //     $type = File::mimeType($path);

    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //     return $response;
    // }

    // public function showFile($id)
    // {
    //     // Fetch the file from the database
    //     $file = File::findOrFail($id);

    //     // Check if the file exists
    //     if ($file) {
    //         // Access the file path
    //         $filePath = Storage::url($file->path);

    //         // Now you can use $filePath to do whatever you need (e.g., display in an iframe)
    //         return view('files.filelist', ['filePath' => $filePath]);
    //     } else {
    //         // Handle the case where the file with the given ID doesn't exist
    //         return abort(404);
    //     }
    // }
 }
 
