<?php

namespace App\Http\Controllers\Association;

use Exception;
use App\Models\Orphan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{


    public function create($orphanId){
        $orphan = Orphan::where('id' , $orphanId)->first(['id' , 'name']);


        if (Gate::allows('complete-orphan-data', $orphan)){

            abort(404);

        }


        return view('review' , compact('orphan'));

    }


    public function researcherReview(Request $request){

        $orphan = Orphan::findOrFail($request->orphan_id);

        if (Gate::allows('complete-orphan-data', $orphan)){

            abort(404);

        }


        if($orphan->role == 'auditor'){
            abort(404);
        }


        $request->merge([
            'review_number' => 'first',
            'review_date' =>now()->format('Y-m-d'),
        ]);

        $validated = $request->validate([
            'review_number'  => ['required' , 'string' , 'in:first,final'],
            'review_date' => ['required' , 'date'],
            'orphan_id' => ['required' , 'exists:orphans,id'],
            'status' => ['required' , 'in:approved,rejected'],
            'report' => ['required' , 'string'],
            'name' => ['required' , 'string']
        ]);



        DB::beginTransaction();

        try {


            Review::create($validated);

            // event(new OrphanReviewed($review));


            if ($request->status == 'approved') {

                $orphan->update(['role' => 'auditor']);

            } else {
                $orphan->update(['role' => 'rejected']);
            }


            DB::commit();

            return redirect()->route('researcher.orphan.index')->with('success', __('تمت مراجعة اليتيم مراجعة أولية بنجاح'));


        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('danger', __(' فشل في تسجيل بيانات مراجعة اليتيم. يرجى المحاولة مرة أخرى. '));

        }

    }

    public function associationReview(Request $request){

        $request->merge([
            'review_number' => 'final',
            'review_date' =>now()->format('Y-m-d'),
        ]);

        $validated = $request->validate([
            'review_number'  => ['required' , 'string' , 'in:first,final'],
            'review_date' => ['required' , 'date'],
            'orphan_id' => ['required' , 'exists:orphans,id'],
            'status' => ['required' , 'in:approved,rejected'],
            'report' => ['required' , 'string'],
            'name' => ['required' , 'string']
        ]);


        DB::beginTransaction();

        try {

            $orphan = Orphan::findOrFail($validated['orphan_id']);

            Review::create($validated);

            // event(new OrphanReviewed($review));


            if ($request->status == 'approved') {

                if($orphan->activeSponsorships){
                    $orphan->update(['role' => 'sponsored']);
                }else{
                    $orphan->update(['role' => 'certified']);
                }

            } else {
                $orphan->update(['role' => 'rejected']);
            }


            DB::commit();
            return redirect()->route('association.orphan.candidate')->with('success', __('تمت اعتماد اليتيم بنجاح'));


        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('danger', __(' فشل في تسجيل بيانات مراجعة اليتيم. يرجى المحاولة مرة أخرى. '));

        }

    }
}
