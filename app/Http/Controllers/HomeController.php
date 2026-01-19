<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Review;
use App\Models\Sparing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // sparing
        $sparings = Sparing::where('status_sparing', '!=', 'done')->latest()->get();

        //article
        $moreArticles = Article::latest()->take(3)->get();
        $moreArticlesData = [];
        foreach ($moreArticles as $moreArticle) {
            $moreArticleContent = json_decode($moreArticle->content, true);
            $moreArticle->image = null; // Default image
            $firstParagraph = null;

            if ($moreArticleContent && isset($moreArticleContent['blocks'])) {
                foreach ($moreArticleContent['blocks'] as $block) {
                    // Ambil paragraf pertama
                    if ($block['type'] == 'paragraph' && !$firstParagraph) {
                        $firstParagraph = Str::limit(strip_tags(html_entity_decode($block['data']['text'])), 120, '...');
                    }
                    // Ambil gambar pertama
                    if ($block['type'] == 'image' && !$moreArticle->image) {
                        $moreArticle->image = $block['data']['file']['url'];
                    }

                    // Hentikan loop jika paragraf dan gambar sudah ditemukan
                    if ($firstParagraph && $moreArticle->image) {
                        break;
                    }
                }
            }

            $moreArticlesData[] = [
                'id' => $moreArticle->id,
                'title' => Str::limit($moreArticle->title, 40),
                'created_by' => $moreArticle->user->name,
                'created_at' => $moreArticle->created_at->diffForHumans(),
                'paragraph' => $firstParagraph,
                'image' => $moreArticle->image ?? asset('assets/images/album_1.svg')
            ];
        }

        //rating
        $reviews = Review::with(['user:id,name,team,profile_photo'])->latest()->get();
        // dd($reviews->toJson());
        return view('index', compact(['sparings', 'reviews', 'moreArticlesData']));
    }
}
