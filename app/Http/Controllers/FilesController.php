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
        $files = File::where('user_id', $userId)->get();
        //$files = File::all();

        return view('files.index', ['files' => $files]);

    }

    // public function filelist()
    // {
    //     $userId = auth()->id();
    //     $files = File::where('user_id', $userId)->get();
    //     $filePath= File::url($files->path)->get();

    //     return view('files.filelist', ['files' => $files],['filePath' => $filePath]);

    // }

    public function filelist()
    {
        $userId = auth()->id();
        $files = File::where('user_id', $userId)->get();
        $filePath = [];

        // Loop through each file to get its path
        foreach ($files as $file) {
            $filePath[$file->id] = Storage::url($file->path);
        }
        
        foreach ($files as $file) {
            $file->path = $filePath[$file->id];
        }
    
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
        $uploadedFile->move(public_path('file'), $fileName);

        // Create a new File record in the database
        File::create([
            'user_id' => auth()->id(),
            'name' => $fileName,
            'type' => $type,
            'size' => $size,
            'path' => 'files/' . $fileName, // Adjust the path as needed
        ]);

        return redirect()->route('files.index')->withSuccess(__('File added successfully.'));
    }
}

    // public function store(StoreFileRequest $request)
    //*** ORIGINAL WORKING */
    // {
    // // Validate file
    // $request->validate([
    //     'file' => 'required|mimes:doc,docx,pdf|max:10240', // Adjust the max file size if needed
    // ]);

    // // Continue with file upload logic if validation passes
    // if ($request->hasFile('file')) {
    //     // File upload logic...

    //     // $uploadedFile = $request->file;
    //     // $fileName = $uploadedFile->getClientOriginalExtension();
    //     $fileName = $request->file->getClientOriginalName();
    //     $type = $request->file->getClientMimeType();
    //     $size = $request->file->getSize();
    //     $request->file->move(public_path('file'), $fileName);

    //     File::create([
    //         'user_id' => auth()->id(),
    //         'name' => $fileName,
    //         'type' => $type,
    //         'size' => $size,
    //     ]);

    //     return redirect()->route('files.index')->withSuccess(__('File added successfully.'));
    // }
    // }

//     public function store(StoreFileRequest $request)
//     //** TRYING this method to retrieve from database **
// {
//     // Validate file
//     $request->validate([
//         'file' => 'required|mimes:doc,docx,pdf|max:10240', // Adjust the max file size if needed
//     ]);

//     // Continue with file upload logic if validation passes
//     if ($request->hasFile('file')) {
//         // File upload logic...

//         $fileName = $request->file->getClientOriginalName();
//         $type = $request->file->getClientMimeType();
//         $size = $request->file->getSize();
//         $request->file->move(public_path('file'), $fileName);

//         File::create([
//             'user_id' => auth()->id(),
//             'name' => $fileName,
//             'type' => $type,
//             'size' => $size,
//         ]);

//         return response()->json([
//             'success' => true,
//             'message' => __('File added successfully.'),
//             'file_url' => asset('file/' . $fileName),
//         ]);
//     }
// }

    public function storeText(Request $request)
    {
        // $client = HttpClient::create();  //newly added
        $text = $request->input('text');

        if (!empty($text)) {
            $fileName = time() . '.txt';
            Storage::disk('public')->put($fileName, $text);

            return redirect()->back()->with('success', 'Text stored successfully.');
        }
        // try {
        //     $response = $client->request('POST', 'http://python-backend-api-url', [ //newly added
        //         'body' => [
        //             'file' => fopen($path, 'r')
        //         ]
        //     ]);
        // } catch (ClientExceptionInterface $e) {
            // Handle any exceptions or error responses from the API }
                

    }

       
    public function delete(Request $request, $id)
    {
        $files = File::findOrFail($id);
        $files->delete();
        return redirect()->back()->with('success', 'File deleted successfully');
    }

    public function show($id)
    {
        $file = File::find($id);

        if (!$file) {
            abort(404);
        }

        $path = public_path($file->path . '/file' . $file->filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function showFile($id)
    {
        // Fetch the file from the database
        $file = File::findOrFail($id);

        // Check if the file exists
        if ($file) {
            // Access the file path
            $filePath = Storage::url($file->path);

            // Now you can use $filePath to do whatever you need (e.g., display in an iframe)
            return view('files.filelist', ['filePath' => $filePath]);
        } else {
            // Handle the case where the file with the given ID doesn't exist
            return abort(404);
        }
    }
 }
 
