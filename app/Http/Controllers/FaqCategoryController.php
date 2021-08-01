<?php

namespace App\Http\Controllers;

use App\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq_categories = FaqCategory::orderBy('created_at', 'DESC')->get();
        return view('faq_categories.index', compact('faq_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faq_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $faq_category = new FaqCategory();
        $request->validate([
            'faq_category_name' => 'required',
        ]);
        $faq_category->faq_category_name = $request->faq_category_name;
        if($faq_category->save()){
                flash(__('Faq category has been inserted successfully'))->success();
                return redirect()->route('faqCategory.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FaqCategory $faqCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq_category = FaqCategory::findOrFail(decrypt($id));
        return view('faq_categories.edit', compact('faq_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faq_category = FaqCategory::findOrFail($id);
        $request->validate([
            'faq_category_name' => 'required',
        ]);
        $faq_category->faq_category_name =$request->input('faq_category_name');
        try {
            $faq_category->save();
            flash(__('Faq category has been update successfully'))->success();
            return redirect()->route('faqCategory.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $faq_category = FaqCategory::findOrFail($id);
        try {
            $faq_category->destroy($faq_category->id);
            flash(__('Faq category has been deleted successfully'))->success();
            return redirect()->route('faqCategory.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
    }

}
