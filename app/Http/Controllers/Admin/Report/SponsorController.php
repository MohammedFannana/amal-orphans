<?php

namespace App\Http\Controllers\Admin\Report;

use Carbon\Carbon;
use App\Models\Orphan;
use App\Models\Report;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Exports\OrphanReportExport;
use App\Exports\SponsorReportExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\SponsorshipReportExport;
use App\Models\Association;
use niklasravnsborg\LaravelPdf\Facades\Pdf;




class SponsorController extends Controller
{

    public function index(Request $request){

        $reports = Report::where('type' , 'sponsor')
        ->when($request->filled('search'), function ($query) use ($request) {
            $date = Carbon::parse($request->search);

            $query->whereYear('date', $date->year)
                ->whereMonth('date', $date->month);
        })->paginate(10);
        return view('admins.reports.sponsor' , compact('reports'));

    }

    public function indexSponsorship(Request $request){

        $reports = Report::where('type' , 'sponsorship')
        ->when($request->filled('search'), function ($query) use ($request) {
            $date = Carbon::parse($request->search);

            $query->whereYear('date', $date->year)
                ->whereMonth('date', $date->month);
        })->paginate(10);
        return view('admins.reports.sponsorship' , compact('reports'));

    }

    public function indexOrphan(Request $request){

        $assoc  = Association::get(['id' , 'name']);
        $reports = Report::where('type' , 'orphan')
        ->when($request->filled('search'), function ($query) use ($request) {
            $date = Carbon::parse($request->search);

            $query->whereYear('date', $date->year)
                ->whereMonth('date', $date->month);
        })->paginate(10);
        return view('admins.reports.orphan' , compact('reports' , 'assoc'));

    }

    public function ExcelReport(Request $request){

        $date = Carbon::parse($request->date);
        $folder = $date->format('m-Y');

        if($request->type == "sponsor"){

            $fileName = 'sponsor_report_' . $folder . '.xlsx';
            $filePath = 'reports/sponsors' . $fileName;

            // خزّن التقرير داخل storage/app/public/reports
            Excel::store(new SponsorReportExport, $filePath, 'public');

            // خزّن في الداتابيز
            Report::create([
                'type' => 'sponsor',
                'report' => $filePath,
                'date' => Carbon::createFromFormat('Y-m', $request->date)->startOfMonth(),
                'date_to' => Carbon::createFromFormat('Y-m', $request->date_to)->startOfMonth(),

            ]);

            return redirect()->back()->with('success' , 'تم إنشاء التقرير بنجاح');

        }elseif($request->type == "sponsorship"){

            $fileName = 'sponsorship_report_' . $folder . '.xlsx';
            $filePath = 'reports/sponsorships' . $fileName;

            // خزّن التقرير داخل storage/app/public/reports
            Excel::store(new SponsorshipReportExport($request->status), $filePath, 'public');

            // خزّن في الداتابيز
            Report::create([
                'type' => 'sponsorship',
                'report' => $filePath,
                'date' => Carbon::createFromFormat('Y-m', $request->date)->startOfMonth(),
                'date_to' => Carbon::createFromFormat('Y-m', $request->date_to)->startOfMonth(),

            ]);

            return redirect()->back()->with('success' , 'تم إنشاء التقرير بنجاح');
        }elseif ($request->type == "orphan") {

            $query = Orphan::query();

            $searchBys = $request->input('search_by', []);
            $conditions = $request->input('condition', []);
            $values = $request->input('search_value', []);
            $isSearch = collect($values)->filter(function ($value) {
                return $value !== null && $value !== '';
            })->isNotEmpty();

            if ($isSearch) {

                foreach ($searchBys as $index => $field) {
                    $condition = $conditions[$index] ?? '==';
                    $value = $values[$index] ?? null;

                    if ($value !== null && $value !== '') {
                        if ($condition == '==') {
                            $query->where($field, $value);
                        }
                        // يمكن إضافة شروط أخرى هنا لاحقًا
                    }
                }
            }



            $orphans = $query->get(); // استخدم get بدلاً من paginate لتصدير البيانات كاملة
            $folder = Carbon::parse($request->date)->format('m-Y');
            $fileName = 'orphan_report_' . $folder . '.xlsx';
            $filePath = 'reports/orphans/' . $fileName;

            // خزّن التقرير داخل storage/app/public/reports
            Excel::store(new OrphanReportExport($orphans), $filePath, 'public');

            // خزّن في الداتابيز
            Report::create([
                'type' => 'orphan',
                'report' => $filePath,
                'date' => Carbon::createFromFormat('Y-m', $request->date)->startOfMonth(),
                'date_to' => Carbon::createFromFormat('Y-m', $request->date_to)->startOfMonth(),
            ]);

            return redirect()->back()->with('success', 'تم إنشاء التقرير بنجاح');
        }

    }

    public function PdfReport(Request $request){

        $date = Carbon::parse($request->date);
        $date_to = Carbon::parse($request->date_to);
        $folder = $date->format('m-Y');

        ini_set('pcre.backtrack_limit', '5000000'); // 5 million
        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes



        if($request->type == "sponsor"){


            $fileName = 'sponsor_report_' . $folder . '.pdf';
            $filePath = 'reports/sponsors' . $fileName;

            // جهّز البيانات

            $sponsors = Sponsor::get();


            // أنشئ الـ PDF
            $pdf = Pdf::loadView('admins.reports.pdf.sponsor', compact(['sponsors' , 'date']));

            // خزّن الملف داخل storage/app/public/reports
            Storage::disk('public')->put($filePath, $pdf->output());

            // خزّن في الداتابيز
            Report::create([
                'type' => 'sponsor',
                'report' => $filePath,
                'date' => $date->startOfMonth(),
                'date_to'=> $date_to->startOfMonth()
            ]);

            return redirect()->back()->with('success', 'تم إنشاء التقرير بنجاح');


        }elseif($request->type == "sponsorship"){

            $fileName = 'sponsorship_report_' . $folder . '.pdf';
            $filePath = 'reports/sponsorships' . $fileName;

            // جهّز البيانات

            $sponsorships = Sponsorship::where('status' , $request->status)
            ->with('orphan' , 'sponsor')
            ->get();


            // أنشئ الـ PDF
            $pdf = Pdf::loadView('admins.reports.pdf.sponsorship', compact(['sponsorships' , 'date']));

            // خزّن الملف داخل storage/app/public/reports
            Storage::disk('public')->put($filePath, $pdf->output());

            // خزّن في الداتابيز
            Report::create([
                'type' => 'sponsorship',
                'report' => $filePath,
                'date' => $date->startOfMonth(),
                'date_to'=> $date_to->startOfMonth()
            ]);

            return redirect()->back()->with('success', 'تم إنشاء التقرير بنجاح');

        }elseif ($request->type == "orphan") {

            $query = Orphan::query();

            $searchBys = $request->input('search_by', []);
            $conditions = $request->input('condition', []);
            $values = $request->input('search_value', []);
            $isSearch = collect($values)->filter(function ($value) {
                return $value !== null && $value !== '';
            })->isNotEmpty();

            if ($isSearch) {

                foreach ($searchBys as $index => $field) {
                    $condition = $conditions[$index] ?? '==';
                    $value = $values[$index] ?? null;

                    if ($value !== null && $value !== '') {
                        if ($condition == '==') {
                            $query->where($field, $value);
                        }
                        // يمكن إضافة شروط أخرى هنا لاحقًا
                    }
                }
            }



            $orphans = $query->with('profile' , 'association')->get(); // استخدم get بدلاً من paginate لتصدير البيانات كاملة
            $folder = Carbon::parse($request->date)->format('m-Y');
            $fileName = 'orphan_report_' . $folder . '.pdf';
            $filePath = 'reports/orphans/' . $fileName;

            // خزّن التقرير داخل storage/app/public/reports
            $pdf = Pdf::loadView('admins.reports.pdf.orphan', compact(['orphans' , 'date']));

            // خزّن الملف داخل storage/app/public/reports
            Storage::disk('public')->put($filePath, $pdf->output());

            // خزّن في الداتابيز
            Report::create([
                'type' => 'orphan',
                'report' => $filePath,
                'date' => Carbon::createFromFormat('Y-m', $request->date)->startOfMonth(),
                'date_to' => Carbon::createFromFormat('Y-m', $request->date_to)->startOfMonth(),
            ]);

            return redirect()->back()->with('success', 'تم إنشاء التقرير بنجاح');
        }

    }

    public function download(string $id){

        $report = Report::findOrFail($id);

        $dateFormatted = Carbon::parse($report->date)->format('m-Y');
        $extension = pathinfo($report->report, PATHINFO_EXTENSION);


        $fileName = "report_{$report->id}_{$dateFormatted}." .  $extension;


        return Storage::disk('public')->download($report->report, $fileName);


    }

    public function destroy(string $id){
        $report = Report::findOrFail($id);

        $report->delete();

        if ($report->report && Storage::disk('public')->exists($report->report)) {
            Storage::disk('public')->delete($report->report);
        }

        return redirect()->back()->with('success', 'تم حذف التقرير بنجاح');


    }
}
