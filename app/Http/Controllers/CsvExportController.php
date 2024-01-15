<?php

namespace App\Http\Controllers;

use App\Models\Extraction;
use Illuminate\Http\Request;
use App\Models\User;

class CsvExportController extends Controller
{
    public function exportExcelView()
    {
        return view('files.exportExcel');
    }

    public function exportExcel(Request $request)
    {
        $name = 'extractedReport.csv';
        $headers = [
            'Content-Disposition' => 'attachment; filename='. $name,
        ];
        
        $column = \Illuminate\Support\Facades\Schema::getColumnListing("extraction");
        $temp_column = array_flip($column);
        unset($temp_column['id']);
        $column = array_flip($temp_column);
        
        return response()->stream(function () use ($column, $request) {
            $userId = auth()->id();
            
            $file = fopen('php://output', 'w+');
            fputcsv($file, $column);

            $data = $request->has('export_new_files')
                ? Extraction::join('files', 'extraction.PID', '=', 'files.PID')
                    ->where('files.user_id', $userId)
                    ->where('files.is_new', true)
                    ->select('extraction.*')
                    ->distinct()
                    ->cursor()
                : Extraction::where('user_id', $userId)->cursor();

            foreach ($data as $key => $value) {
                $record = $value->toArray();
                unset($record['id']);

                fputcsv($file, $record);
            }

            $blanks = array("\t", "\t", "\t", "\t");
            fputcsv($file, $blanks);
            $blanks = array("\t", "\t", "\t", "\t");
            fputcsv($file, $blanks);
            $blanks = array("\t", "\t", "\t", "\t");
            fputcsv($file, $blanks);

            fclose($file);
        }, 200, $headers);
    }
}