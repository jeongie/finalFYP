<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class FilesController extends Controller
{

    public function index()
    {
        $userId = auth()->id();
        $files = File::where('user_id', $userId)->where('is_new', true)->get();
        //$files = File::all();

        return view('files.index', ['files' => $files]);

    }

    public function allFile()
    {
        $userId = auth()->id();
        $files = File::where('user_id', $userId)->get();

        return view('dashboard', ['files' => $files]);

    }

    public function filelist()
    {
        
        $userId = auth()->id();
        $files = File::where('user_id', $userId)->where('is_new', true)->get();
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
        'file' => 'required', // Adjust the max file size if needed
        'file.*' => 'required|mimes:doc,docx,pdf|max:10240', // Adjust the max file size if needed
    ]);
    
    if ($request->hasFile('file')) {
        foreach ($request->file as $uploadedFile) {

            $fileNameExt = $uploadedFile->getClientOriginalName();
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            $existingfileName = File::where('name',$fileName)->exists();

            if ($existingfileName) {
                // File with the same name exists, append a suffix
                $fileName = $this->generateUniquefileName($fileName);
            }
           
            if (substr_count($fileName, '_')) {
                $filenameParts = explode('_', $fileName);
                $pidn = $filenameParts[0] . '_' . end($filenameParts);
            } else {
                $pidn = $fileName;
            }

            $existingFiles = File::where('pid',$pidn)->exists();

            if ($existingFiles) {
                // File with the same name exists, append a suffix
                $pidn = $this->generateUniquePid($pidn);
            }


            $pid= $pidn;
            $type = $uploadedFile->getClientMimeType();
            $size = $uploadedFile->getSize();
            $filePath = Storage::disk('public')->putFileAs('files', $uploadedFile, $fileName);
    
            // Convert to PDF if the file is a Word document
            if ($uploadedFile->getClientOriginalExtension() === 'docx' || $uploadedFile->getClientOriginalExtension() === 'doc') {
                $pdfFilePath = $this->convertToPdf($uploadedFile);
                $filePath = $pdfFilePath; // Update the file path to the PDF path
            }
    
            // Create a new File record in the database
            File::create([
                'user_id' => auth()->id(),
                'PID'=> $pid,
                'name' => $fileName,
                'type' => $type,
                'size' => $size,
                'path' => $filePath,
                'is_new' => true,
            ]);
        }
    }

        return redirect()->route('files.index')->withSuccess(__('Files added successfully.'));
    
}

    public function generateUniquePid($basePid)
    {
        $counter = 1;

        // Append a suffix until a unique pid is found
        while (File::where('pid', $basePid . '_' . $counter)->exists()) {
            $counter++;
        }

        return $basePid . '_' . $counter;
    }

    public function generateUniquefileName($basefileName)
    {
        $counter = 1;

        // Append a suffix until a unique pid is found
        while (File::where('name', $basefileName . '('.$counter.')')->exists()) {
            $counter++;
        }

        return $basefileName . '('.$counter.')';
    }


    private function convertToPdf($uploadedFile)
    {
        $domPdfPath = base_path( 'vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        // Load the Word document
        $phpWord = IOFactory::load($uploadedFile->getRealPath());
        // $phpWord = IOFactory::load($uploadedFile->$filePath);

        // Set up PDF rendering
        $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');

        // Save the PDF to storage
        $pdfFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME) . '.pdf';
        // $pdfFilePath = Storage::disk('public')->path('files/' . $pdfFileName);
        $pdfFilePath = 'files/' . $pdfFileName;

        // $pdfWriter->save($pdfFilePath);
        $pdfWriter->save(Storage::disk('public')->path($pdfFilePath));

        return $pdfFilePath;
    }
       
    public function delete(Request $request, $id)
    {
        $files = File::findOrFail($id);
        $files->delete();
        return redirect()->back()->with('success', 'File deleted successfully');
    }

 }
 
