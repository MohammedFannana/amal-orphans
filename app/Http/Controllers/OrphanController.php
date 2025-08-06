<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreOrphanRequest;

use Exception;
use App\Models\Orphan;
use App\Models\Association;
use Illuminate\Support\Arr;
use App\Models\ExternalLink;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class OrphanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // $orphan = Auth::guard('orphan')->user()->load('profile');
        $orphan = Auth::guard('orphan')->user();
        if (!$orphan) {
            return redirect()->route('login')->with('error', 'الرجاء تسجيل الدخول أولاً');
        }

        if (Gate::allows('complete-orphan-data', $orphan)) {
            // return view('orphans.index' ,compact('orphan'));
            return redirect()->route('complete.profile' , $orphan->id);
        }

        $orphan = $orphan->load(['siblings', 'profile']);
        return view('orphans.index' ,compact('orphan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if (Auth::guard('association')->check()) {
            $association = Auth::guard('association')->user();
        }
        else {
            abort(403, 'غير مصرح بالدخول لهذه الصفحة');
        }

        return view('orphans.create', compact('association'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth_association = Auth::guard('association');


        if($auth_association->check()){

            $request->merge([
                'association_id' =>$auth_association->user()->id,
                'role' => 'certified'
            ]);

        }elseif(Auth::guard('researcher')->check()){
            $association= Auth::guard('researcher')->user()->association_id;

            $request->merge([
                'association_id' =>$association,
                'role' => 'auditor'
            ]);

            // dd($request);

        }elseif (Auth::guard('web')->check()) {

            $request->merge(['role' => 'certified']);

        }else{
            abort(403, 'غير مصرح بالدخول لهذه الصفحة');
        }

        // dd($request);

        $validated = $request->validate([
            'image' => ['required' , 'image' , 'dimensions:min_width=100,min_height=100','max:1048576'],
            'name' => ['required' , 'string'],
            'role' => ['required' , 'in:candidate,auditor,rejected,certified,waiting,sponsored'],
            'association_id' => ['required' , 'exists:associations,id'],
            'birth_date' => ['required' , 'date'],
            'birth_place' => ['required' , 'string'],
            'country' => ['required' ,'string'],
            'city' => ['required' ,'string'],
            'landmark' => ['required' ,'string'],
            'id_number' => ['required' , 'numeric' , 'unique:orphans,id_number','digits:9'],
            'orphan_status' => ['required' , 'in:يتيم الأم,يتيم الأب,يتيم الأبوين'],
            'gender' => ['required' , 'in:ذكر,أنثى'],


            'mother_name' => ['required' ,'string'],
            'death_mother_date' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأبوين,يتيم الأم'],

            'cause_mother_death' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأبوين,يتيم الأم'],

            'father_name' => ['required' ,'string'],

            'death_father_date' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأبوين,يتيم الأب'],

            'cause_father_death' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأبوين,يتيم الأب'],

            'mother_id_number' => ['nullable' ,'numeric' ,'required_if:orphan_status,يتيم الأب'],

            'mother_marital_status' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأب'],

            'mother_phone' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأب'],

            'father_id_number' => ['nullable' ,'numeric' ,'required_if:orphan_status,يتيم الأم'],

            'father_marital_status' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأم'],

            'father_phone' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأم'],

            'income' => ['required' ,'string','in:دخل ثايت,بدون دخل'],
            'income_value' => ['nullable' ,'string' ,'required_if:income,دخل ثابت'],

            'income_source' => ['nullable' ,'string' , 'required_if:income,دخل ثابت'],

            'father_death_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576', 'required_without:not_available_father_death'],
            'not_available_father_death' => ['nullable', 'string', 'required_without:father_death_certificate'],

            'mother_death_certificate' => ['nullable' ,'image' , 'dimensions:min_width=100,min_height=100','max:1048576' ,'required_without:not_available_mother_death'],
            'not_available_mother_death' => ['nullable' ,'string' ,'required_without:mother_death_certificate'],


            //     // //store in profiles table
            //     // // 'orphan_id' => ['required' , 'exists:profiles,id'],
            'guardian_name' => ['required' , 'string'],
            'guardian_relation' => ['required' , 'string'],
            'guardian_jop' => ['required' , 'string'],


            'guardian_id_number' => ['required' , 'numeric'],
            'guardian_housing' => ['required' , 'string'],
            'guardian_whats_phone' => ['required' , 'string'],
            'guardian_first_phone' => ['required' , 'string'],
            'guardian_secound_phone' => ['required' , 'string'],
            'guardian_email' => ['required' , 'email'],
            'health_status' => ['required' , 'in:جيد,مريض'],
            'disease_type' => ['nullable' , 'in:مرض عادي,مرض مزمن,مرض عضال' ,
                                'required_if:health_status,مريض'],

           'medical_report' => [
                'nullable','image','dimensions:min_width=100,min_height=100',
                'max:1048576','required_without:not_available_medical_report'
            ],

            'not_available_medical_report' => [
                'nullable','string','required_without:medical_report'
            ],

            'educational_status' => ['required' , 'in:دون سن الدراسة,يدرس,لا يدرس'],

            'academic_stage' => ['nullable' , 'string', 'required_if:educational_status,يدرس'],
            'average' => ['nullable' , 'string', 'required_if:educational_status,يدرس'],

            'educational_certificate' => ['nullable' , 'image' , 'dimensions:min_width=100,min_height=100','max:1048576',
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->educational_status === 'يدرس') {
                        // إذا كانت الشهادة  فارغة وكان سبب عدم التوفر غير مملوء
                        if (empty($value) && empty($request->not_available_educational_certificate)) {
                            $fail('يجب تقديم الشهادة الدراسية  أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

            'not_available_educational_certificate' => ['nullable' , 'string' ,
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->educational_status === 'يدرس') {
                        // إذا كان سبب عدم التوفر فارغًا وكان صورة الشهادة غير مملوءة
                        if (empty($value) && empty($request->educational_certificate)) {
                            $fail('يجب تقديم صورة الشهادة الدراسية أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

            'brother_name' => ['required', 'array'],
            'brother_name.*' => ['string', 'required'],

            'brother_gender' => ['required', 'array'],
            'brother_gender.*' => ['string', 'required', 'in:ذكر,أنثى'],

            'brother_age' => ['required', 'array'],
            'brother_age.*' => ['string', 'required'],

            'brother_marital_status' => ['required', 'array'],
            'brother_marital_status.*' => ['required'  , 'in:أعزب,متزوج,أرمل,مطلق,مهجورة'],

            'brother_jop' => ['required', 'array'],
            'brother_jop.*' => ['string', 'required'],

            'brother_id_number' => ['required', 'array'],
            'brother_id_number.*' => ['numeric', 'required', Rule::unique('siblings', 'brother_id_number'),'digits:9'],


            // 'brother_name' => ['string' , 'required'],

            // 'brother_gender' => ['string' , 'required' ,'in:ذكر,أنثى,انثى'],

            // 'brother_age' => ['string' , 'required'],

            // 'brother_marital_status' => ['string' , 'required'],

            // 'brother_jop' => ['string' , 'required'],

            // 'brother_id_number' => ['numeric' , 'required' , Rule::unique('siblings', 'brother_id_number')],

            'receive_guarantee' => ['required' , 'in:bank,wallet'],

            'account_number' => ['nullable' , 'string' , 'required_if:receive_guarantee,bank'],

            'bank' => ['nullable' , 'string' , 'required_if:receive_guarantee,bank' ],

            'phone_number_linked_account' => ['nullable' , 'string' , 'required_if:receive_guarantee,bank'],

            'wallet_number' => ['nullable' , 'string' , 'required_if:receive_guarantee,wallet'],

            'wallet_owner' => ['nullable' , 'string' , 'required_if:receive_guarantee,wallet'],

            'wallet_owner_id_number' => ['nullable' , 'string' , 'required_if:receive_guarantee,wallet'],

            'wallet_owner_id_number_image' => [
                'nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576',
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->receive_guarantee === 'wallet') {
                        // إذا كانت صورة الهوية فارغة وكان سبب عدم التوفر غير مملوء
                        if (empty($value) && empty($request->not_available_wallet_owner_id_number_image)) {
                            $fail('يجب تقديم صورة الهوية أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

            //     // تحقق من سبب عدم توفر صورة الهوية
            'not_available_wallet_owner_id_number_image' => [
                'nullable', 'string',
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->receive_guarantee === 'wallet') {
                        // إذا كان سبب عدم التوفر فارغًا وكان صورة الهوية غير مملوءة
                        if (empty($value) && empty($request->wallet_owner_id_number_image)) {
                            $fail('يجب تقديم صورة الهوية أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

        ]);



        // dd(intval($validated['id_number']));

        $validated['password'] = Hash::make(intval($validated['id_number']));
        // dd($validated);
        // $validated = $request->validate();

        $fields = [
            'image',
            'father_death_certificate',
            'mother_death_certificate',
            'medical_report',
            'educational_certificate',
            'wallet_owner_id_number_image',
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store("images/orphans/{$request->name}", 'public');
                $validated[$field] = $path;
            }
        }


        // dd($validated);
        DB::beginTransaction();

        try {

            // start store in orphans table
            $validatedData = Arr::only($validated , ['image' , 'role' ,'name' , 'association_id' , 'birth_date' , 'birth_place' , 'country',
                                                        'city' , 'landmark' , 'id_number' ,'orphan_status' , 'gender' ,
                                                        'mother_name' , 'death_mother_date' , 'cause_mother_death', 'father_name', 'death_father_date', 'cause_father_death', 'mother_id_number', 'mother_marital_status',
                                                        'mother_phone', 'father_id_number', 'father_marital_status', 'father_phone', 'income', 'income_value', 'income_source'
                                                        , 'father_death_certificate', 'not_available_father_death', 'mother_death_certificate', 'not_available_mother_death' , 'guardian_name' ,'guardian_relation',
                                                        'guardian_jop' , 'password'
                                                    ]);


            // dd($validatedData);
            $orphan = Orphan::create($validatedData);


            // store in profiles table
            $profileData = Arr::only($validated ,[
                'guardian_id_number' , 'guardian_housing' , 'guardian_whats_phone' , 'guardian_first_phone' ,
                'guardian_secound_phone' , 'guardian_email' , 'health_status' ,'disease_type' ,'medical_report' ,'not_available_medical_report' ,
                'educational_status' , 'average' ,'academic_stage' ,'educational_certificate' ,'not_available_educational_certificate',
                'receive_guarantee' , 'account_number' ,'bank' , 'phone_number_linked_account' ,'wallet_number' , 'wallet_owner'
                ,'wallet_owner_id_number' ,'wallet_owner_id_number_image' , 'not_available_wallet_owner_id_number_image'

            ]);

            // dd($profileData);

            $orphan->profile()->create($profileData);



            // store in sbiling table
            // $siblingsData = Arr::only($validated ,[
            //     'brother_name' , 'brother_gender' ,'brother_age' , 'brother_marital_status' , 'brother_jop' , 'brother_id_number'
            // ]);

            // dd(count($request->brother_name));

            for ($i = 0; $i < count($request->brother_name); $i++) {
                $orphan->siblings()->create([
                    'brother_name' => $request->brother_name[$i],
                    'brother_gender' => $request->brother_gender[$i],
                    'brother_age' => $request->brother_age[$i],
                    'brother_marital_status' => $request->brother_marital_status[$i],
                    'brother_jop' => $request->brother_jop[$i],
                    'brother_id_number' => $request->brother_id_number[$i],
                ]);
            }


            // dd($siblingsData);

            // $orphan->siblings()->create($siblingsData);


            DB::commit();
            return redirect()->back()->with('success', __('تمت اضافة اليتيم بنجاح'));


        }catch(Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('danger', __(' فشل في تسجيل اليتيم. يرجى المحاولة مرة أخرى. '));

        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orphan $orphan)
    {
        $orphan = $orphan->load('profile' , 'siblings');
        return view('orphans.edit' , compact('orphan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orphan $orphan)
    {

        $validated = $request->validate([
            'image' => ['sometimes', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'name' => ['sometimes', 'string'],
            // 'role' => ['sometimes', 'in:candidate,auditor,rejected,certified,waiting,sponsored'],
            // 'association_id' => ['sometimes', 'exists:associations,id'],
            'birth_date' => ['sometimes', 'date'],
            'birth_place' => ['sometimes', 'string'],
            'country' => ['sometimes', 'string'],
            'city' => ['sometimes', 'string'],
            'landmark' => ['sometimes', 'string'],
            'id_number' => ['sometimes', 'numeric', Rule::unique('orphans', 'id_number')->ignore($orphan->id)],
            'orphan_status' => ['sometimes', 'in:يتيم الأم,يتيم الأب,يتيم الأبوين'],
            'gender' => ['sometimes', 'in:ذكر,أنثى'],

            'mother_name' => ['sometimes', 'string'],
            'death_mother_date' => ['nullable', 'string'],
            'cause_mother_death' => ['nullable', 'string'],
            'father_name' => ['sometimes', 'string'],
            'death_father_date' => ['nullable', 'string'],
            'cause_father_death' => ['nullable', 'string'],
            'mother_id_number' => ['nullable', 'numeric'],
            'mother_marital_status' => ['nullable', 'string'],
            'mother_phone' => ['nullable', 'string'],
            'father_id_number' => ['nullable', 'numeric'],
            'father_marital_status' => ['nullable', 'string'],
            'father_phone' => ['nullable', 'string'],
            'income' => ['sometimes', 'string', 'in:دخل ثايت,بدون دخل'],
            'income_value' => ['nullable', 'string'],
            'income_source' => ['nullable', 'string'],

            'father_death_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_father_death' => ['nullable', 'string'],
            'mother_death_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_mother_death' => ['nullable', 'string'],

            'guardian_name' => ['sometimes', 'string'],
            'guardian_relation' => ['sometimes', 'string'],
            'guardian_jop' => ['sometimes', 'string'],
            'guardian_id_number' => ['sometimes', 'numeric'],
            'guardian_housing' => ['sometimes', 'string'],
            'guardian_whats_phone' => ['sometimes', 'string'],
            'guardian_first_phone' => ['sometimes', 'string'],
            'guardian_secound_phone' => ['sometimes', 'string'],
            'guardian_email' => ['sometimes', 'email'],
            'health_status' => ['sometimes', 'in:جيد,مريض'],
            'disease_type' => ['nullable', 'in:مرض عادي,مرض مزمن,مرض عضال'],
            'medical_report' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_medical_report' => ['nullable', 'string'],

            'educational_status' => ['sometimes', 'in:دون سن الدراسة,يدرس,لا يدرس'],
            'academic_stage' => ['nullable', 'string'],
            'average' => ['nullable', 'string'],
            'educational_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_educational_certificate' => ['nullable', 'string'],

            'brother_name' => ['sometimes', 'array'],
            'brother_name.*' => ['string', 'required'],
            'brother_gender' => ['sometimes', 'array'],
            'brother_gender.*' => ['string', 'in:ذكر,أنثى'],
            'brother_age' => ['sometimes', 'array'],
            'brother_age.*' => ['string'],
            'brother_marital_status' => ['sometimes', 'array'],
            'brother_marital_status.*' => ['string'],
            'brother_jop' => ['sometimes', 'array'],
            'brother_jop.*' => ['string'],
            'brother_id_number' => ['sometimes', 'array'],
            'brother_id_number.*' => ['numeric', Rule::unique('siblings', 'brother_id_number')->ignore($orphan->id, 'orphan_id')],

            'receive_guarantee' => ['sometimes', 'in:bank,wallet'],
            'account_number' => ['nullable', 'string'],
            'bank' => ['nullable', 'string'],
            'phone_number_linked_account' => ['nullable', 'string'],
            'wallet_number' => ['nullable', 'string'],
            'wallet_owner' => ['nullable', 'string'],
            'wallet_owner_id_number' => ['nullable', 'string'],
            'wallet_owner_id_number_image' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_wallet_owner_id_number_image' => ['nullable', 'string'],
        ]);

        $fields = [
            'image',
            'father_death_certificate',
            'mother_death_certificate',
            'medical_report',
            'educational_certificate',
            'wallet_owner_id_number_image',
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store("images/orphans/{$orphan->name}", 'public');
                $validated[$field] = $path;

                // حذف الصورة القديمة بعد الرفع
                $oldPath = $orphan->$field ?? $orphan->profile->$field ?? null;
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        DB::beginTransaction();
        try {
            // تحديث orphan
             $validatedData = Arr::only($validated , ['image' , 'birth_place' , 'country',
                                                        'city' , 'landmark' ,'orphan_status' , 'gender' ,
                                                        'mother_name' , 'death_mother_date' , 'cause_mother_death', 'father_name', 'death_father_date', 'cause_father_death', 'mother_id_number', 'mother_marital_status',
                                                        'mother_phone', 'father_id_number', 'father_marital_status', 'father_phone', 'income', 'income_value', 'income_source'
                                                        , 'father_death_certificate', 'not_available_father_death', 'mother_death_certificate', 'not_available_mother_death' , 'guardian_name' ,'guardian_relation',
                                                        'guardian_jop' , 'password'
                                                    ]);


            // dd($validatedData);
            $orphan->update($validatedData);


            // store in profiles table
            $profileData = Arr::only($validated ,[
                'guardian_id_number' , 'guardian_housing' , 'guardian_whats_phone' , 'guardian_first_phone' ,
                'guardian_secound_phone' , 'guardian_email' , 'health_status' ,'disease_type' ,'medical_report' ,'not_available_medical_report' ,
                'educational_status' , 'average' ,'academic_stage' ,'educational_certificate' ,'not_available_educational_certificate',
                'receive_guarantee' , 'account_number' ,'bank' , 'phone_number_linked_account' ,'wallet_number' , 'wallet_owner'
                ,'wallet_owner_id_number' ,'wallet_owner_id_number_image' , 'not_available_wallet_owner_id_number_image'

            ]);

            // dd($profileData);

            $orphan->profile()->update($profileData);

            // تحديث الإخوة
            if ($request->has('brother_name')) {
                $orphan->siblings()->delete(); // حذف الإخوة القدامى
                foreach ($request->brother_name as $i => $name) {
                    $orphan->siblings()->create([
                        'brother_name' => $name,
                        'brother_gender' => $request->brother_gender[$i],
                        'brother_age' => $request->brother_age[$i],
                        'brother_marital_status' => $request->brother_marital_status[$i],
                        'brother_jop' => $request->brother_jop[$i],
                        'brother_id_number' => $request->brother_id_number[$i],
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', __('تم تحديث بيانات اليتيم بنجاح'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', __('فشل في تحديث بيانات اليتيم.'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function completeProfile(string $id){

        $authOrphan = auth('orphan')->user();

        // 2. إذا البيانات مكتملة → امنع الدخول
        if (Gate::denies('complete-orphan-data', $authOrphan)) {
            abort(403, 'تم إكمال البيانات، لا يمكنك الوصول إلى صفحة الإكمال.');
        }

        if (!$authOrphan || $authOrphan->id != $id) {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }

        $orphan = Orphan::findOrFail($id);
        return view('orphans.complete-profile' , compact('orphan'));

    }

    public function storeProfile(Request $request , String $id){


        $authOrphan = auth('orphan')->user();

        // 2. إذا البيانات مكتملة → امنع الدخول
        if (Gate::denies('complete-orphan-data', $authOrphan)) {
            abort(403, 'تم إكمال البيانات، لا يمكنك الوصول إلى صفحة الإكمال.');
        }

        if (!$authOrphan || $authOrphan->id != $id) {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }

        $orphan = Orphan::findOrFail($id);

        if($orphan->id_number != $authOrphan->id_number){
            abort(403, 'غير مسموح لك بتعديل هذا اليتيم');
        }

        // $request->merge([
        //     'name' => $authOrphan->name,
        //     'birth_date' => $authOrphan->birth_date,
        //     'id_number' => $authOrphan->id_number,
        // ]);

        $validated = $request->validate([
            'image' => ['required', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            // 'role' => ['sometimes', 'in:candidate,auditor,rejected,certified,waiting,sponsored'],
            // 'association_id' => ['sometimes', 'exists:associations,id'],
            // 'birth_date' => ['sometimes', 'date'],
            // 'name' => ['sometimes', 'string'],
            'birth_place' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'landmark' => ['required', 'string'],
            // 'id_number' => ['sometimes', 'numeric', Rule::unique('orphans', 'id_number')->ignore($orphan->id)],
            'orphan_status' => ['required', 'in:يتيم الأم,يتيم الأب,يتيم الأبوين'],
            'gender' => ['required', 'in:ذكر,أنثى'],

            'mother_name' => ['required', 'string'],
            'death_mother_date' => ['nullable', 'string'],
            'cause_mother_death' => ['nullable', 'string'],
            'father_name' => ['required', 'string'],
            'death_father_date' => ['nullable', 'string'],
            'cause_father_death' => ['nullable', 'string'],
            'mother_id_number' => ['nullable', 'numeric'],
            'mother_marital_status' => ['nullable', 'string'],
            'mother_phone' => ['nullable', 'string'],
            'father_id_number' => ['nullable', 'numeric'],
            'father_marital_status' => ['nullable', 'string'],
            'father_phone' => ['nullable', 'string'],
            'income' => ['required', 'string', 'in:دخل ثايت,بدون دخل'],
            'income_value' => ['nullable', 'string'],
            'income_source' => ['nullable', 'string'],

            'father_death_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_father_death' => ['nullable', 'string'],
            'mother_death_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_mother_death' => ['nullable', 'string'],

            'guardian_name' => ['required', 'string'],
            'guardian_relation' => ['required', 'string'],
            'guardian_jop' => ['required', 'string'],
            'guardian_id_number' => ['required', 'numeric'],
            'guardian_housing' => ['required', 'string'],
            'guardian_whats_phone' => ['required', 'string'],
            'guardian_first_phone' => ['required', 'string'],
            'guardian_secound_phone' => ['required', 'string'],
            'guardian_email' => ['required', 'email'],
            'health_status' => ['required', 'in:جيد,مريض'],
            'disease_type' => ['nullable', 'in:مرض عادي,مرض مزمن,مرض عضال'],
            'medical_report' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_medical_report' => ['nullable', 'string'],

            'educational_status' => ['required', 'in:دون سن الدراسة,يدرس,لا يدرس'],
            'academic_stage' => ['nullable', 'string'],
            'average' => ['nullable', 'string'],
            'educational_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_educational_certificate' => ['nullable', 'string'],

            'brother_name' => ['required', 'array'],
            'brother_name.*' => ['string', 'required'],
            'brother_gender' => ['required', 'array'],
            'brother_gender.*' => ['string', 'in:ذكر,أنثى'],
            'brother_age' => ['required', 'array'],
            'brother_age.*' => ['string'],
            'brother_marital_status' => ['required', 'array'],
            'brother_marital_status.*' => ['string'],
            'brother_jop' => ['required', 'array'],
            'brother_jop.*' => ['string'],
            'brother_id_number' => ['required', 'array'],
            'brother_id_number.*' => ['numeric', 'digits:9'],
            'receive_guarantee' => ['required', 'in:bank,wallet'],
            'account_number' => ['nullable', 'string'],
            'bank' => ['nullable', 'string'],
            'phone_number_linked_account' => ['nullable', 'string'],
            'wallet_number' => ['nullable', 'string'],
            'wallet_owner' => ['nullable', 'string'],
            'wallet_owner_id_number' => ['nullable', 'string'],
            'wallet_owner_id_number_image' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576'],
            'not_available_wallet_owner_id_number_image' => ['nullable', 'string'],
        ]);


        $fields = [
            'image',
            'father_death_certificate',
            'mother_death_certificate',
            'medical_report',
            'educational_certificate',
            'wallet_owner_id_number_image',
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store("images/orphans/{$orphan->name}", 'public');
                $validated[$field] = $path;

            }
        }

        DB::beginTransaction();
        try {
            // تحديث orphan
            $orphan->update(Arr::only($validated, [
                'image',  'birth_place', 'country', 'city', 'landmark',
                 'orphan_status', 'gender', 'mother_name', 'death_mother_date', 'cause_mother_death',
                'father_name', 'death_father_date', 'cause_father_death', 'mother_id_number', 'mother_marital_status',
                'mother_phone', 'father_id_number', 'father_marital_status', 'father_phone', 'income', 'income_value',
                'income_source', 'father_death_certificate', 'not_available_father_death', 'mother_death_certificate',
                'not_available_mother_death', 'guardian_name', 'guardian_relation', 'guardian_jop'
            ]));

            // تحديث profile
            // if ($orphan->profile) {
            $orphan->profile()->create(Arr::only($validated, [
                'guardian_id_number', 'guardian_housing', 'guardian_whats_phone', 'guardian_first_phone',
                'guardian_secound_phone', 'guardian_email', 'health_status', 'disease_type', 'medical_report',
                'not_available_medical_report', 'educational_status', 'average', 'academic_stage',
                'educational_certificate', 'not_available_educational_certificate', 'receive_guarantee',
                'account_number', 'bank', 'phone_number_linked_account', 'wallet_number', 'wallet_owner',
                'wallet_owner_id_number', 'wallet_owner_id_number_image', 'not_available_wallet_owner_id_number_image'
            ]));
            // }

            // تحديث الإخوة
            foreach ($request->brother_name as $i => $name) {
                $orphan->siblings()->create([
                    'brother_name' => $name,
                    'brother_gender' => $request->brother_gender[$i],
                    'brother_age' => $request->brother_age[$i],
                    'brother_marital_status' => $request->brother_marital_status[$i],
                    'brother_jop' => $request->brother_jop[$i],
                    'brother_id_number' => $request->brother_id_number[$i],
                ]);
            }

            DB::commit();
            return redirect()->route('orphan.primary.index')->with('success', __('تم تحديث بيانات اليتيم بنجاح'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('danger', __('فشل في تسجيل اليتيم. يرجى المحاولة مرة أخرى.'));
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showImage(Request $request){
         try {
            $filePath = Crypt::decrypt($request->file);
            return view('orphans.show_image' , compact('filePath'));

        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showVideo(Request $request){
        try {
            $filePath = Crypt::decrypt($request->file);
            return view('orphans.show_video' , compact('filePath'));

        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showAudio(Request $request){
        try {
            $filePath = Crypt::decrypt($request->file);
            return view('orphans.show_audio' , compact('filePath'));

        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function balance(){

        $orphanUser = Auth::guard('orphan')->user();
        $sponsor =  $orphanUser->activeSponsorships->sponsor;
        $expenses = $orphanUser->expenses()->orderBy('created_at', 'desc')->paginate(8);
        // $expenseAmount = $orphanUser->expenses()->sum('bail_amount');
         $expenseAmount = $orphanUser->expenses->sum(function ($expense) {
            return $expense->duration * $expense->bail_amount;
        });

        // dd($balances);

        return view('orphans.balance-view' , compact('expenses' , 'expenseAmount','sponsor'));
    }
}
