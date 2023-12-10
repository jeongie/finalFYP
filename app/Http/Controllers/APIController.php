<?php

namespace App\Http\Controllers;
use App\Models\Extraction;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Excel;

// class APIController extends Controller
// {
//     public function extract(Request $request)
//     {
//         // Retrieve and process form data here
//         $selectedData = $request->input('data');

//         // Perform your processing logic (e.g., call the Flask API)
//         $client = new Client();
//         $response = $client->get('http://127.0.0.1:5000');

//         // Get the response body as a string
//         $body = $response->getBody()->getContents();

//         // You can now process the $body as needed
//         // For example, if the response is JSON, you might decode it
//         $data = json_decode($body, true);

//         // Handle the data as needed
//         // ...

//         // Return a response (this is just an example)
//         return response()->json(['message' => 'Data processed successfully']);
//     }
// }

class APIController extends Controller
{
    public function getapi()
    {
        // Fetch data from the API
        $client= new Client();
        $apiUrl="http://127.0.0.1:5000";

        try {
            // Make a GET request to the OpenWeather API
            $response = $client->get($apiUrl);

            // Get the response body as an array
            $data = json_decode($response->getBody(), true);

            // Handle the retrieved weather data as needed (e.g., pass it to a view)
            return view('api.extract', ['apidata' => $data]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api.api_error', ['error' => $e->getMessage()]);
        }
    }

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
        return view('error_view', ['error' => 'Failed to connect to database']);
    }
}

    // public function export_contacts()
    // {
    //     return Excel::download(new ContactsExport, 'Contacts.xlsx');
    // }
    // //https://github.com/tauseedzaman/contact-management-system/blob/main/app/Exports/ContactsExport.php


}
