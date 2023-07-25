<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Front\BlogArticle;
use App\Models\Front\BlogArticleElement;
use App\Models\Front\BlogCategory;
use App\Models\Front\BlogElementType;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BlogController extends Controller
{
    public function index()
    {
        $articles = BlogArticle::where('suppressed', 0)->with('category')->orderBy('publicated_at', 'asc')->get();
        return view('admin.blog.index', ['articles' => $articles]);
    }


    public function create(Request $request) {

        if($request->article_id) {
            $article = BlogArticle::with('category')->get()->find($request->article_id);
            $elements = BlogArticleElement::where('article_id', $article->id)->with('type')->orderBy('element_order', 'asc')->get();

        } else {
            $article = new BlogArticle();
            $elements = null;
        }

        $elementTypes = BlogElementType::where('is_active', 1)->get();
        return view('admin.blog.edit', ['elementTypes' => $elementTypes, 'article' => $article, 'elements' => $elements]);
    }

    public function deleteElement(Request $request) {
        $element = BlogArticleElement::find($request->element_id);
        $element->delete();

        return response()->json(['BlogArticleElement deleted']);
    }

    public function categoryList(Request $request) {
        $string = $request->string;

        $arr = [];
        if($results = BlogCategory::where('name', 'LIKE', "%".$string."%")->orderBy('name', 'asc')->get()) {
            foreach($results as $result) {
                $arr[] = ['id' => $result->id, 'name' => $result->name];
            }
        }

        return response()->json([$arr]);
    }

    public function update(Request $request) {

        $new = true;

        if($request->article_id) {
            $article = BlogArticle::find($request->article_id);
            $new = false;
        } else {
            $article = new BlogArticle();
        }

        // if an image url exist
        if($request->cover_img_url && $request->cover_img_url != "") {
            $article->cover_img = $request->cover_img_url;
        } else if($request->cover_img_64 && $request->cover_img_64 != "") {

            // create image if exist
            $base64string = $request->cover_img_64;
            $uploadpath   = 'blog/images/';
            $parts        = explode(";base64,", $base64string);
            $imageparts   = explode("image/", @$parts[0]);
            $imagetype    = $imageparts[1];
            $imagebase64  = base64_decode($parts[1]);
            $file         = $uploadpath . uniqid() . '.png';
            file_put_contents($file, $imagebase64);

            // compress img
            ImageService::compressImg($file);

            $article->cover_img = $file;

        } else {
            $article->cover_img = null;
        }

        $article->slug = $request->slug;
        $article->title = $request->title;
        $article->resume = $request->resume;
        $article->status = $request->status;
        $article->publicated_at = $request->publicated_at;


        // change with category_name
        if($request->category_id) {
            $article->category_id = $request->category_id;
        } else {
            $newCategory = new BlogCategory();
            $newCategory->name = $request->category_name;
            $newCategory->save();
            $article->category_id = $newCategory->id;
        }

        if($new) {
            $article->created_by = Auth::id();
        }
        $article->updated_by = Auth::id();
        $article->author_id = Auth::id();
        $article->save();

        return response()->json($article);
    }

    public function updateElement(Request $request) {

        $new = true;

        if($request->element_id) {
            $element = BlogArticleElement::find($request->element_id);
            $new = false;
        } else {
            $element = new BlogArticleElement();
        }

        // check if file exist
        if($request->cover_img_url && $request->cover_img_url != "") {
            $element->img1 = $request->cover_img_url;
        } else if($request->cover_img_64 && $request->cover_img_64 != "") {

            // create image if exist
            $base64string = $request->cover_img_64;
            $uploadpath   = 'blog/images/';
            $parts        = explode(";base64,", $base64string);
            $imageparts   = explode("image/", @$parts[0]);
            $imagebase64  = base64_decode($parts[1]);
            $file         = $uploadpath . uniqid() . '.png';
            file_put_contents($file, $imagebase64);

            // compress img
            ImageService::compressImg($file);

            $element->img1 = $file;

        } else {
            $element->img1 = null;
        }


        // set only if data exists
        if($request->type_id && $request->type_id != "")             $element->type_id = $request->type_id;
        if($request->element_order && $request->element_order != "") $element->element_order = $request->element_order;
        if($request->content_text && $request->content_text != "")   $element->content_text = $request->content_text;
        if($request->article_id && $request->article_id != "")       $element->article_id = $request->article_id;

        if($new) {
            $element->created_by = Auth::id();
        }
        $element->updated_by = Auth::id();
        $element->save();

        return response()->json($element);
    }


}
