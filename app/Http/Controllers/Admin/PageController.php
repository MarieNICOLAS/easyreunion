<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function edit(Request $request, Page $page)
    {
        return view('admin.pages.edit')->with('page', $page);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'meta' => 'required|max:250',
            'meta_title' => 'required|max:250',
            'banner_title' => 'required',
            'content' => 'required',
        ]);

        $page->title = $request->input('title');
        $page->meta_title = $request->input('meta_title');
        $page->meta = $request->input('meta');
        $page->banner_title = $request->input('banner_title');
        $page->content = $request->input('content');
        $page->save();

        return redirect()->back()->with(['success' => 'Mise à jour réussie']);
    }
}
