<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Storage;
//use Symfony\Component\HttpClient\HttpClient;
//use Symfony\Component\HttpClient\Exception\ClientExceptionInterface;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;

class FilesController extends Controller
{

    public function index()
    {
        $files = File::all();

        return view('files.index', ['files' => $files]);

    }

    public function filelist()
    {
        $files = File::all();

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
        // File upload logic...

        $uploadedFile = $request->file;
        $fileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
        $type = $uploadedFile->getClientMimeType();
        $size = $uploadedFile->getSize();

        $uploadedFile->move(public_path('file'), $fileName);

        $file = File::create([
            'name' => $uploadedFile->getClientOriginalName(),
            'type' => $type,
            'size' => $size,
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

    public function download(Request $request)
    {
        $selectedFileIds = $request->input('selectedFiles');
        $selectedFiles = File::whereIn('id', $selectedFileIds)->get();

    if (!empty($selectedFiles)) {
        // Download selected files
        foreach ($selectedFiles as $file) {
            return response()->download(storage_path('app/' . $file->path));
        }
    } else {
        // No files selected
        return back()->withError('Please select at least one file to download.');
    }
    }

 }
 
