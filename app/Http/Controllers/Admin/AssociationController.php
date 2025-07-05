<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;


class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $associations = Association::
        when($request->search, function ($builder, $value) { //from search input
            $builder->where('name', 'LIKE', "%{$value}%");
        })->paginate(6);
        return view('admins.associations.index' ,compact('associations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $association = New Association();
        return view('admins.associations.create' ,compact('association'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'responsible_person' =>['required' , 'string'],
            'email' => ['required', 'email' , 'unique:associations,email'],
            'fax' => ['required', 'string' , 'unique:associations,fax'],
            'license_number' => ['nullable', 'integer' , 'unique:associations,license_number'],
            'phone'=> ['required', 'string' , 'unique:associations,phone'],
            'phone1' => ['required', 'string'],
            'phone2' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        Association::create($validated);
        return redirect()->route('admin.association.index')->with('success' , 'تم إضافة الجمعية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Association $association)
    {
        // dd($association);
        return view('admins.associations.view' , compact('association'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Association $association)
    {
        return view('admins.associations.edit' , compact('association'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Association $association)
    {

        $validated=$request->validate([
            'name' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'responsible_person' =>['sometimes' , 'string'],
            'email' => ['sometimes', 'email' , Rule::unique('associations', 'email')->ignore($association->id)],
            'fax' => ['sometimes', 'integer' , Rule::unique('associations', 'fax')->ignore($association->id)],
            'license_number' => ['nullable', 'integer' , Rule::unique('associations', 'license_number')->ignore($association->id)],
            'phone'=> ['sometimes', 'string' , Rule::unique('associations', 'phone')->ignore($association->id)],
            'phone1' => ['sometimes', 'string'],
            'phone2' => ['sometimes', 'string'],
        ]);

        $association->update($validated);
        return redirect()->route('admin.association.index')->with('success' , 'تم تعديل بيانات الجمعية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {

        $association->delete();
        return redirect()->route('admin.association.index')->with('success' , 'تم حذف الجمعية بنجاح');

    }
}
