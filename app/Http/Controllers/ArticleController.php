<?php

namespace App\Http\Controllers;

use App\Models\Front\BlogArticle;
use App\Models\Front\BlogArticleElement;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public function list(Request $request)
    {
        $months = ['1' => 'JAN', '2' => 'FEV', '3' => 'MAR', '4' => 'AVR', '5' => 'MAI', '6' => 'JUI',
                   '7' => 'JUI', '8' => 'AOU', '9' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DEC'];

        ($request->page) ? $currentPage = $request->page : $currentPage = 1;
        // nb item by page
        $itemPerPage = 6;

        if($currentPage > 1) {
            // nb skiping elements
            $skipingElement = ($currentPage-1) * $itemPerPage - 1;
            // latest elements page before
            $latestArticle = BlogA::where('status', 'online')->orderBy('publicated_at', 'desc')->skip($skipingElement)->take(1)->first();
            $dateBefore = $latestArticle->publicated_at;
        } else {
            $dateBefore = date('Y-m-d H:i:s');
        }

        // total page
        $totalArticles = BlogArticle::where('status', 'online')->where('publicated_at', '<', date('Y-m-d H:i:s'))->orderBy('publicated_at', 'desc')->count();

        // $total page
        $totalPages = ceil($totalArticles / $itemPerPage);

        ($currentPage == $totalPages) ? $nextPage = null : $nextPage = $currentPage+1;
        ($currentPage == 1)           ? $prevPage = null : $prevPage = $currentPage-1;

        // get all articles after date
        $articles = BlogArticle::where('status', 'online')->where('publicated_at', '<', $dateBefore)->orderBy('publicated_at', 'desc')->take($itemPerPage)->get();

        $pagination = ['totalPages' => $totalPages, 'currentPage' => $currentPage, 'prevPage' => $prevPage, 'nextPage' => $nextPage];

        return view('article.list', ['articles' => $articles, 'months' => $months, 'pagination' => $pagination]);
    }

    public function show(Request $request)
    {
        $article = BlogArticle::where('slug', $request->slug)->first();
        $elements = BlogArticleElement::where('article_id', $article->id)->with('type')->orderBy('element_order', 'asc')->get();
        return view('article.show', ['article' => $article, 'elements' => $elements]);
    }

}
