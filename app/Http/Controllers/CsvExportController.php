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

    public function exportExcel()
    {
        $name = 'extractedReport.csv';
        $headers = [
            'Content-Disposition' => 'attachment; filename='. $name,
        ];
        $colom = \Illuminate\Support\Facades\Schema::getColumnListing("extraction");
        $temp_colom = array_flip($colom);
        unset($temp_colom['id']);
        $colom = array_flip($temp_colom);
        return response()->stream(function() use($colom){
            $file = fopen('php://output', 'w+');
            fputcsv($file, $colom);
            $data = Extraction::cursor();
            
            foreach ($data as $key => $value) {
                $data = $value->toArray();
                
                unset($data['id']);

                fputcsv($file, $data);
            }
            $blanks = array("\t","\t","\t","\t");
            fputcsv($file, $blanks);
            $blanks = array("\t","\t","\t","\t");
            fputcsv($file, $blanks);
            $blanks = array("\t","\t","\t","\t");
            fputcsv($file, $blanks);

            fclose($file);
        }, 200, $headers);        
    }
}