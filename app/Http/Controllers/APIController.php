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

        // Handle the response as needed
        return view('api.extract', ['apidata' => $responseData, 'selectedData' => $selectedData]);
    } catch (\Exception $e) {
        return view('api.api_error', ['error' => $e->getMessage()]);
    }
}
// class APIController extends Controller
// {
//     public function getapi()
//     {
//         // Fetch data from the API
//         $client= new Client();
//         $apiUrl="http://127.0.0.1:5000";

//         try {
//             // Make a GET request to the OpenWeather API
//             $response = $client->get($apiUrl);

//             // Get the response body as an array
//             $data = json_decode($response->getBody(), true);

//             // Handle the retrieved weather data as needed (e.g., pass it to a view)
//             return view('api.extract', ['apidata' => $data]);
//         } catch (\Exception $e) {
//             // Handle any errors that occur during the API request
//             return view('api.api_error', ['error' => $e->getMessage()]);
//         }
//     }

public function storeDataInDatabase(Request $request)
{
    try {
        $response = Http::get('http://127.0.0.1:5000/'); // Update the URL with your Flask API endpoint
        // dd($response->json());

        if ($response->successful()) {
            $data = $response->json();
            // dd($response);

            foreach ($data as $item) {
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
        } else {
            // Log the API response error message
            \Log::error('API Error: ' . $response->status());
            
            // Display a generic error message
            return view('api.database_error', ['error' => 'Failed to connect to the API.']);
        }
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
