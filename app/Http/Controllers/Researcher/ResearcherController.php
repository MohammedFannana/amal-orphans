<?php

namespace App\Http\Controllers\Researcher;

use App\Models\Orphan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResearcherController extends Controller
{
    public function index(){

        $researcher = auth('researcher')->user();

        $orphans = Orphan::where('association_id', $researcher->association_id)
        ->where(function ($query) {
            $query->where('role', 'candidate')
                  ->orWhere('role', 'auditor');
        })
        ->paginate(6);
        // $researcher = auth('researcher')->user();
        return view('researchers.index' , compact('orphans'));
    }

    public function view(Orphan $orphan){


        if(auth('researcher')->check()){
            $researcher = auth('researcher')->user();

            if ($orphan->association_id != $researcher->association_id) {
                abort(403, 'غير مسموح لك بالوصول لهذا اليتيم.');
            }
        }elseif(auth('association')->check()){
            $association = auth('association')->user();

            if ($orphan->association_id !== $association->id) {
                abort(403, 'غير مسموح لك بالوصول لهذا اليتيم.');
            }
        }

        $orphan = $orphan->load(['profile' , 'siblings']);
        return view('researchers.orphan-view' , compact('orphan'));
    }

    public function create(){
        return view('researchers.create');

    }

    public function store(Request $request){

        if(Auth::guard('researcher')->check()){

            $association_id = Auth::guard('researcher')->user()->association->id;

            $request->merge([
                'association_id' => $association_id,
            ]);

            $validated = $request->validate([

                'name' => ['required', 'string'],
                'birth_date' => ['required'],
                'id_number' => ['required' , 'numeric' , 'digits:9' , 'unique:orphans,id_number'],
                'association_id' => ['required' , 'exists:associations,id']

            ]);

            $validated['role'] = 'candidate';
            $validated['password'] =  Hash::make($validated['id_number']) ;


            Orphan::create($validated);
            return redirect()->back()->with('success' , 'تم إضافة البيانات بنجاح');

        }else{
            abort(403, 'غير مصرح بالدخول لهذه الصفحة');
        }

    }
}
