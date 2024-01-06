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
        $files = File::where('user_id', $userId)->get();
        $filePath = [];
        // dd($files);

        //Loop through each file to get its path
        foreach ($files as $file) {
            // Generate the URL for the file using Laravel's Storage facade
            $filePath[] = Storage::disk('public')->path($file->path);
        }

        $selectedData = $request->input('data');

            // Send a POST request to the Python server
            $response = Http::post('http://127.0.0.1:5000/', [
                'data' => $selectedData,
                'filePath'=> $filePath,
            ]);

            // Get the response from the Python server
            $responseData = $response->json();

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
        $sessionId = $request->query('sessionId');
        $apidata = session()->get('apidata');
        // dd($apidata);
        // dd($sessionId);
        // echo($sessionId);
        \Log::info('$sessionId'. $sessionId);
        // need to create a new API? Or can pass the variable from prev page to this page?
        // dd($response->json());
        // TODO: Check if this is a successful request
        // \Log::info($response->json());

        // echo 'error1';

        foreach ($apidata as $item) {
            Extraction::create([
                'PID' => $item['PID'],
                'cabg' => $item['cabg'],
                'hb1ac' => $item['hb1ac'],
                'Rest HR' => $item['Rest HR'],
                'hypertension' => $item['hypertension'],
                'cholestrol' => $item['cholestrol'],
                'smoking' => $item['smoking'],
                'alcohol' => $item['alcohol'],
                'bmi' => $item['bmi'],
                'Rest BP' => $item['Rest BP'],
                'Peak BP' => $item['Peak BP'],
                'METS' => $item['METS'],
            ]);

        }
        return redirect()->route('export')->withSuccess(__('File added successfully.'));
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
