<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();

        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'photo' => 'required|image|max:5000',
        ]);
        $image = $request->photo;
        $image->storeAs('public/article-images', $image->hashName());
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $image->hashName(),
            'created_by' => auth()->id
        ]);
        return redirect()->route('article.index')->withSuccess('Berhasil Menambahkan Artikel');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validation = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'photo' => 'image'
        ]);
        Article::where('id', $article->id)->update($validation);
        return redirect()->route('article.index')->withSuccess('Artikel Berhasil Dihapus');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('article.index')->withSuccess('Artikel Berhasil Dihapus');
    }

    public function userIndex(Request $request)
    {
        // $articles = Article::with('user')->latest()->get();
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $articles = $query->paginate(12);

        foreach ($articles as $article) {
            $content = json_decode($article->content, true);
            $article->image = null; // Default image
            $firstParagraph = null;

            if ($content && isset($content['blocks'])) {
                foreach ($content['blocks'] as $block) {
                    // Ambil paragraf pertama
                    if ($block['type'] == 'paragraph' && !$firstParagraph) {
                        $firstParagraph = Str::limit(strip_tags(html_entity_decode($block['data']['text'])), 120, '...');
                    }
                    // Ambil gambar pertama
                    if ($block['type'] == 'image' && !$article->image) {
                        $article->image = $block['data']['file']['url'];
                    }

                    // Hentikan loop jika paragraf dan gambar sudah ditemukan
                    if ($firstParagraph && $article->image) {
                        break;
                    }
                }
            }

            // Simpan paragraf pertama ke dalam properti artikel
            $article->content = [
                'paragraph' => $firstParagraph,
                'image' => $article->image,
            ];
        }

        $latestArticles = Article::latest()->take(5)->get();
        $latestArticlesData = [];
        foreach ($latestArticles as $article) {
            $content = json_decode($article->content, true);
            $article->image = null; // Default image

            if ($content && isset($content['blocks'])) {
                foreach ($content['blocks'] as &$block) {
                    if ($block['type'] == 'image' && !$article->image) {
                        $article->image = $block['data']['file']['url'];
                        break; // Hanya ambil satu gambar
                    }
                }
            }

            $latestArticlesData[] = [
                'id' => $article->id,
                'title' => $article->title,
                'image' => $article->image ?? asset('assets/images/album_1.svg')
            ];
        }


        $slideArticles = Article::inRandomOrder()->take(3)->get();
        $slides = [];
        foreach ($slideArticles as $article) {
            $content = json_decode($article->content, true);
            $article->image = null; // Default image

            if ($content && isset($content['blocks'])) {
                foreach ($content['blocks'] as &$block) {
                    if ($block['type'] == 'paragraph') {
                        $block['data']['text'] = strip_tags(html_entity_decode($block['data']['text']));
                    }
                    if ($block['type'] == 'image' && !$article->image) {
                        $article->image = $block['data']['file']['url'];
                    }
                }
            }
            $article->content = $content;

            // Menambahkan artikel ke slides
            $slides[] = [
                'id' => $article->id,
                'image' => $article->image ?? asset('assets/images/album_1.svg'),
                'title' => Str::limit($article->title, 40),
                'description' => Str::limit($article->content['blocks'][0]['data']['text'] ?? '', 120, '...'),
                'profileImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                'author' => $article->user->name,
                'date' => $article->created_at->format('M d, Y')
            ];
        }

        return view('articles.userIndex', compact('articles', 'slides', 'latestArticlesData'));
    }

    public function userShow($id)
    {
        $article = Article::findOrFail($id); // Cari data berdasarkan ID, jika tidak ada maka 404
        $content = json_decode($article->content); // Decode JSON ke dalam objek
        // dd($content);

        $moreArticles = Article::where('id', '!=', $id)->inRandomOrder()->take(3)->get();
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

        return view('articles.articledetail', compact('article','content', 'moreArticlesData')); // Kirim data ke view
    }
}
