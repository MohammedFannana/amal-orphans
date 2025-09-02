<?php

namespace App\Http\Controllers\Sponsor;

use Exception;
use Carbon\Carbon;
use App\Models\Orphan;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SponserController extends Controller
{
    
    public function waitingIndex(Request $request){
        $orphans = Orphan::where('role' , 'waiting')
        ->when($request->search, function ($builder, $value) { //from search input
            $builder->where('name', 'LIKE', "%{$value}%");
        })->paginate(6);


        return view('Sponsers.waiting-index' , compact('orphans'));
    }

    public function waitingView(Orphan $orphan){

        if ($orphan->role !== 'waiting') {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }

        return view('Sponsers.waiting-view' , compact('orphan'));

    }

    public function create(Orphan $orphan){

        if ($orphan->role !== 'waiting') {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }
        return view('Sponsers.create-sponsership' , compact('orphan'));

    }

    public function store(Request $request){
        // dd($request);


        $request->merge([
            'sponsor_id' => auth('sponsor')->id(),
            'status' => 'active',
        ]);
        // dd($request);

        $validated = $request->validate([
            'orphan_id' => ['required' , 'exists:orphans,id'],
            'sponsor_id' => ['required' , 'exists:sponsors,id'],
            'duration' => ['required' , 'numeric' ,'min:1'],
            'bail_amount' => ['required' , 'numeric' ,'min:1'],
            'payment_received' => ['required' , 'image' , 'dimensions:min_width=100,min_height=100','max:1048576'],
            // 'sponsorship_date' => now()->format('Y-m-d'),
            'status' => ['required' , 'in:active,finished'],
        ]);


        // $validated['sponsorship_date'] = now()->format('Y-m-d');
        $lastActiveSponsorship = Sponsorship::where('orphan_id', $validated['orphan_id'])
        ->where('status', 'active')
        ->orderByDesc('sponsorship_date')
        ->first();

        if ($lastActiveSponsorship) {
            $endDate = Carbon::parse($lastActiveSponsorship->sponsorship_date)
                ->addMonths($lastActiveSponsorship->duration);
            $validated['sponsorship_date'] = $endDate->format('Y-m-d');
        } else {
            $validated['sponsorship_date'] = now()->format('Y-m-d');
        }
        $validated['total'] = $validated['duration'] * $validated['bail_amount'];
        $validated['currency'] = "دولار";
        // dd($validated);


        // $orphan = Orphan::where('id' , $validated['orphan_id'])->first();
        $orphan = Orphan::find($validated['orphan_id']);



        if ($request->hasFile('payment_received')) {
            $file = $request->file('payment_received');
            $path = $file->store("images/orphans/{$orphan->name}", 'public');
                        // $path = $file->store("images/orphans", 'public');

            $validated['payment_received'] = $path;
        }

        // dd($validated);

        DB::beginTransaction();
        try {

            Sponsorship::create($validated);

            $orphan->update([
                'role' => 'sponsored',
            ]);

            DB::commit();

            return redirect()->route('sponsor.orphan.waiting.index')->with('success' , 'تم كفالة اليتيم بنجاح');

         }catch(Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('danger', __(' فشل في تسجيل كفالةاليتيم. يرجى المحاولة مرة أخرى. '));

        }

    }


    public function sponsorIndex(Request $request){

        $sponsorId = auth('sponsor')->id();

        $orphans = Orphan::where('role' , 'sponsored')
        ->whereHas('activeSponsorships', function ($query) use ($sponsorId) {
            $query->where('sponsor_id', $sponsorId);
        })
        ->when($request->search, function ($builder, $value) { //from search input
            $builder->where('name', 'LIKE', "%{$value}%");
        })
        ->with('activeSponsorships')
        ->paginate(6);


        return view('Sponsers.sponser-index' , compact('orphans'));
    }

    public function sponsorView(Orphan $orphan){

        $sponsor = auth('sponsor')->user();

        if (!$orphan->activeSponsorships || $orphan->activeSponsorships->sponsor_id !== $sponsor->id) {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }

        return view('Sponsers.sponsor-view' , compact('orphan'));

    }


    public function sponsorshipView(Orphan $orphan){

        $sponsor = auth('sponsor')->user();

        if (!$orphan->activeSponsorships || $orphan->activeSponsorships->sponsor_id !== $sponsor->id) {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }

        $sponsorships = $orphan->sponsorships()->latest()->paginate(8);
        return view('Sponsers.sponsorship-view' ,compact('sponsorships'));

    }

    public function orphanPayments(Orphan $orphan){

        $sponsor = auth('sponsor')->user();

        if (!$orphan->activeSponsorships || $orphan->activeSponsorships->sponsor_id !== $sponsor->id) {
            abort(403, 'غير مسموح لك بالوصول لهذا اليتيم');
        }

        $expenses = $orphan->expenses()->where('status' , 'active')->latest()->paginate(8);
        // $expenseAmount = $orphan->expenses()->sum('bail_amount');

        $allExpenses = $orphan->expenses()->where('status', 'active')->get();

        $expenseAmount = $allExpenses->sum(function ($expense) {
            return $expense->duration * $expense->bail_amount;
        });


        return view('Sponsers.orphan-payments-view' ,compact('expenses'  , 'expenseAmount'));

    }

}
