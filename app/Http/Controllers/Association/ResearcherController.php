<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use App\Models\Researcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class ResearcherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $association = Auth::guard('association')->user()->id;
        $researchers = Researcher::where('association_id' , $association)
        ->when($request->search, function ($builder, $value) { //from search input
            $builder->where('name', 'LIKE', "%{$value}%");
        })->paginate(6);
        return view('associations.researchers.index' ,compact('researchers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $researcher = new Researcher();
        return view('associations.researchers.create' ,compact('researcher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'association_id' => auth('association')->user()->id,
        ]);

        $validated = $request->validate([
            'association_id' => ['required' , 'exists:associations,id'],
            'name' => ['required' , 'string'],
            'email' => ['required' , 'email' ,'unique:researchers,email'],
            'id_number' => ['required' , 'numeric' , 'unique:researchers,id_number'],
            'phone' => ['required' , 'string'],
            'phone_whats' => ['required' , 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

        ]);

        $validated['password'] = Hash::make($validated['password']);

        Researcher::create($validated);
        return redirect()->route('association.researcher.index')->with('success' , ' تم إضافة الباحث بنجاح ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Researcher $researcher)
    {
        $associationId = auth('association')->id();

        if ($researcher->association_id !== $associationId) {
            abort(403, 'غير مسموح لك بتعديل هذا الباحث.');
        }
        return view('associations.researchers.view' ,compact('researcher'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Researcher $researcher)
    {
        $associationId = auth('association')->id();

        if ($researcher->association_id !== $associationId) {
            abort(403, 'غير مسموح لك بتعديل هذا الباحث.');
        }
        return view('associations.researchers.edit' , compact('researcher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Researcher $researcher)
    {
        $associationId = auth('association')->id();

        if ($researcher->association_id !== $associationId) {
            abort(403, 'غير مسموح لك بتعديل هذا الباحث.');
        }

        $validated = $request->validate([
            'name' => ['sometimes' , 'string'],
            'email' => ['sometimes' , 'email' ,Rule::unique('researchers', 'email')->ignore($researcher->id)],
            'id_number' => ['sometimes' , 'numeric' , Rule::unique('researchers', 'id_number')->ignore($researcher->id)],
            'phone' => ['sometimes' , 'string'],
            'phone_whats' => ['sometimes' , 'string'],
        ]);

        $researcher->update($validated);
        return redirect()->back()->with('success' , 'تم تحديث بيانات الباحث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Researcher $researcher)
    {
        $associationId = auth('association')->id();

        if ($researcher->association_id !== $associationId) {
            abort(403, 'غير مسموح لك بتعديل هذا الباحث.');
        }
        
        $researcher->delete();
        return redirect()->route('association.researcher.index')->with('success' , 'تم حذف الباحث بنجاح');
    }
}
