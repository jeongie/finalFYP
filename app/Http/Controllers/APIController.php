<?php

namespace App\Http\Controllers;
use App\Models\File;
use App\Models\Extraction;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;

class APIController extends Controller
{
    public function getapi(Request $request)
{
    try {
        // \Log::info("testing in getapi");
        // // Send a POST request to the Python server
        // $response = Http::post('http://127.0.0.1:5000/', [
        //     'data' => $request->input('data'),
        // ]);

        // // Get the response from the Python server
        // $responseData = $response->json();
        // echo '<pre>';
        // print_r($responseData);
        // echo '</pre>';
        $userId = auth()->id();
        // $files = File::where('user_id', $userId)->get();
        $files = File::where('user_id', $userId)->where('is_new', true)->get();
        $filePath = [];
        // dd($files);

        //Loop through each file to get its path
        foreach ($files as $file) {
            // Generate the URL for the file using Laravel's Storage facade
            $filePath[] = Storage::disk('public')->path($file->path);
        }

        $selectedData = $request->input('data');
        // dd($selectedData);

            // Send a POST request to the Python server
            // https://fyp-flask-3gborstie-jeongies-projects.vercel.app/
            $response = Http::post('http://127.0.0.1:5000/', [
                'data' => $selectedData,
                'filePath'=> $filePath,
            ]);

            // Get the response from the Python server
            $responseData = $response->json();
            // dd($responseData);
           

            session(['apidata' => $responseData]);
        // Handle the response as needed
        return view('api.extract', ['apidata' => $responseData, 'selectedData' => $selectedData]);
    } catch (\Exception $e) {
        return view('api.api_error', ['error' => $e->getMessage()]);
    }
}

// Save the data inputted by the user to the database
public function storeDataInDatabase(Request $request)
{
    try {
        $userId = auth()->id();
        // \Log::info("selectedData is below");
        // \Log::info($request->input('selectedData'));
        // $sessionId = $request->query('sessionId');
        $apidata = session()->get('apidata');
        // dd($apidata);
        $selectedData = json_decode($request->input('selectedData'), true);
        // dd($request);


        foreach ($apidata as $item) {
            Extraction::create([
                'user_id' => auth()->id(),
                'PID' => $item['PID'],

                'gender'=>$item['gender']??null,
                'age'=>$item['age']??null,
                'hb1ac' => $item['hb1ac'] ?? null,
                'hypertension' => $item['hypertension'] ?? null,
                'cholestrol' => $item['cholestrol'] ?? null,
                'smoking' => $item['smoking'] ?? null,
                'alcohol' => $item['alcohol'] ?? null,
                'diet'=>$item['diet'] ?? null,
                'bmi' => $item['bmi'] ?? null,
                'ef' => $item['ef'] ?? null,

                'METS' => $item['METS'] ?? null,
                'Rest HR' => $item['Rest HR'] ?? null,
                'Peak HR' => $item['Peak HR'] ?? null,
                'HR reserve' => $item['HR reserve'] ?? null,
                'HR recovery' => $item['HR recovery'] ?? null,

                'Rest BP' => $item['Rest BP'] ?? null,
                'Peak BP' => $item['Peak BP'] ?? null,
            ]);
        }
        // File::where('user_id', $userId)->update(['is_new' => false]);

        return redirect()->route('export')->withSuccess(__('Extracted data is saved.'));
    } catch (\Exception $e) {
        // Log the exception message
        \Log::error('Exception: ' . $e->getMessage());
        
        // Display the exception message
        return view('api.database_error', ['error' => 'An error occurred while connecting to the database.']);
    }
}




    // public function export_contacts()
    // {
    //     return Excel::download(new ContactsExport, 'Contacts.xlsx');
    // }
    // //https://github.com/tauseedzaman/contact-management-system/blob/main/app/Exports/ContactsExport.php


}