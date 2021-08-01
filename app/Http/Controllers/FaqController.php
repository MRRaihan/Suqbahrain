<?php

namespace App\Http\Controllers;

use App\Faq;
use App\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::orderBy('created_at', 'DESC')->get();
        return view('faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faq_categories = FaqCategory::orderBy('faq_category_name')->get();
        return view('faq.create', compact('faq_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $faq = new Faq();
        $request->validate([
            'faq_category_id' => 'required',
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);

        $faq->faq_category_id = $request->faq_category_id;
        $faq->faq_question = $request->faq_question;
        $faq->faq_answer = $request->faq_answer;
        if($faq->save()){
            flash(__('Faq has been inserted successfully'))->success();
            return redirect()->route('faq.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq_categories = FaqCategory::orderBy('faq_category_name')->get();
        $faq = Faq::findOrFail(decrypt($id));
        return view('faq.edit', compact('faq_categories', 'faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $request->validate([
            'faq_category_id' => 'required',
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);
        $faq->faq_category_id =$request->input('faq_category_id');
        $faq->faq_question =$request->input('faq_question');
        $faq->faq_answer =$request->input('faq_answer');
        try {
            $faq->save();
            flash(__('Faq has been update successfully'))->success();
            return redirect()->route('faq.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        try {
            $faq->destroy($faq->id);
            flash(__('Faq has been deleted successfully'))->success();
            return redirect()->route('faq.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
    }
}
