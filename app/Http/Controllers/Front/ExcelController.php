<?php

namespace App\Http\Controllers\Front;

use App\Imports\OrphansImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;



class ExcelController extends Controller
{



        public function importFromStorageByName()
        {
           $filePath = storage_path('app/orphans3.xlsx'); // تأكد أن الملف موجود هنا

            try {
                Excel::import(new OrphansImport, $filePath);
                return response()->json(['message' => 'تم الاستيراد بنجاح'], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'حدث خطأ أثناء الاستيراد',
                    'error' => $e->getMessage()
                ], 500);
            }
        }



}
