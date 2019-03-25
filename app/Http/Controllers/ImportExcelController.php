<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Models\ZipCode;
use DB;
use Excel;
use Illuminate\Http\Request;
use ZipArchive;

class ImportExcelController extends Controller {

    public function importExport() {
        return view('importExport');
    }

    public function importExcel() {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $val) {
                    foreach ($val as $value) {
                        $insert[] = ['zip_code' => $value->zip_code, 'country_code' => $value->country_code, 'service_availability' => $value->service_availability];
                    }
                }
                if (!empty($insert)) {
                    try {
                        DB::table('zip_code')->insert($insert);
                        return back()->with(['success' => 'Data Inserted Successfully']);
                    } catch (\Exception $exp) {
                        dd($exp->getMessage());
                    }
                }
            }
        }
        return back();
    }

}
