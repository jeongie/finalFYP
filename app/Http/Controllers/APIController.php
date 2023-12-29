<?php

namespace App\Http\Controllers;
use App\Models\Extraction;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Excel;

class APIController extends Controller
{
    public function getapi(Request $request)
{
    try {
        echo $request;
        // Send a POST request to the Python server
        $response = Http::post('http://127.0.0.1:5000', [
            'data' => $request->input('data'),
        ]);

        // Get the response from the Python server
        $responseData = $response->json();

        // Handle the response as needed
        return view('api.extract', ['apidata' => $responseData]);
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

    public function storeDataInDatabase()
{
    $response = Http::get('http://127.0.0.1:5000'); // Update the URL with your Flask API endpoint

    if ($response->successful()) {
        $data = $response->json();

        foreach ($data as $item) {
            Extraction::create([
                'PID' => $item['PID'],
                'Date' => $item['Date'],
                'BMI' => $item['BMI'],
                'Resting_BP' => $item['Blood Pressure - Resting BP'],
                'Peak_BP' => $item['Blood Pressure - Peak BP'],
            ]);
        }
        return redirect()->route('export')->withSuccess(__('File added successfully.'));
    } else {
        return view('api.database_error', ['error' => 'Failed to connect to database']);
    }
}

    // public function export_contacts()
    // {
    //     return Excel::download(new ContactsExport, 'Contacts.xlsx');
    // }
    // //https://github.com/tauseedzaman/contact-management-system/blob/main/app/Exports/ContactsExport.php


}
