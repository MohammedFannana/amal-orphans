<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::paginate(8);
        return view('admins.questions.index' , compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'question' => ['required' , 'string'],
            'answer' => ['required' , 'string'],
        ]);

        Question::create($validated);

        return redirect()->route('admin.question.index')->with('success' , 'تم إضافة السؤال بنجاح');
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
    public function edit(Question $question)
    {
        return view('admins.questions.edit' , compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
         $validated = $request->validate([
            'question' => ['sometimes' , 'string'],
            'answer' => ['sometimes' , 'string'],
        ]);

       $question->update($validated);

        return redirect()->route('admin.question.index')->with('success' , 'تم تعديل السؤال بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.question.index')->with('success' , 'تم حذف السؤال بنجاح');
    }
}
