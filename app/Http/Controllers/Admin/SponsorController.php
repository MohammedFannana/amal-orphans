<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;



class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sponsors = Sponsor::
        when($request->search, function ($builder, $value) { //from search input
            $builder->where('name', 'LIKE', "%{$value}%");
        })->paginate(6);
        return view('admins.sponsors.index' ,compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sponsor = new Sponsor();
        return view('admins.sponsors.create' , compact('sponsor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required' , 'string'],
            'phone' => ['required' , 'string'],
            'email' => ['required' , 'email' ,'unique:sponsors,email'],
            'country' => ['required' , 'string'],
            'address' => ['required' , 'string'],
            'password' => ['required' , 'confirmed', Rules\Password::defaults()],
            'receive_report' => ['required' , 'in:yes,no'],
            'payment_reminder' => ['required' , 'in:yes,no'],
            'payment_mechanism' => ['required' , 'in:bank,credit_card,debit_card,PALPAY,benefit_pay'],

        ]);

        $validated['password'] = Hash::make($validated['password']);

        Sponsor::create($validated);
        return redirect()->route('admin.sponsor.index')->with('sucess' , 'تم إضافة الكافل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        return view('admins.sponsors.view' , compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('admins.sponsors.edit' ,compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => ['sometimes' , 'string'],
            'phone' => ['sometimes' , 'string'],
            'email' => ['sometimes' , 'email' ,Rule::unique('sponsors', 'email')->ignore($sponsor->id)],
            'country' => ['sometimes' , 'string'],
            'address' => ['sometimes' , 'string'],
            'receive_report' => ['sometimes' , 'in:yes,no'],
            'payment_reminder' => ['sometimes' , 'in:yes,no'],
            'payment_mechanism' => ['sometimes' , 'in:bank,credit_card,debit_card,PALPAY,benefit_pay'],

        ]);

        $sponsor->update($validated);
        return redirect()->route('admin.sponsor.edit' , $sponsor->id)->with('success' ,'تم تعديل بيانات الكافل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return redirect()->route('admin.sponsor.index')->with('success' , 'تم حذف الكافل بنجاح');
    }
}
