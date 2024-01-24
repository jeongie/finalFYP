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

        $userId = auth()->id();
        $files = File::where('user_id', $userId)->where('is_new', true)->where('tb_extract', true)->get();
        $filePath = [];

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
        $userId = auth()->id();
        $apidata = session()->get('apidata');
        $selectedData = json_decode($request->input('selectedData'), true);


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
        File::where('user_id', $userId)->update(['tb_extract' => false]);

        return redirect()->route('export')->withSuccess(__('Extracted data is saved.'));
    } catch (\Exception $e) {
        // Log the exception message
        \Log::error('Exception: ' . $e->getMessage());
        
        // Display the exception message
        return view('api.database_error', ['error' => 'An error occurred while connecting to the database.']);
    }
}



}