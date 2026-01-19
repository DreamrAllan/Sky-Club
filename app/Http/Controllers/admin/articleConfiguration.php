<?php

namespace App\Http\Controllers\admin;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class articleConfiguration extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $articles = Article::all();
        return view('admin.article.article', compact('articles'));
    }

    public function show($id)
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

        return view('articles.articledetail', compact('article','content', 'moreArticlesData'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $articles = new Article();
        $articles->title = $request->title;
        $articles->content = json_encode($request->content);
        $articles->created_by = Auth::user()->id;
        $articles->save();

        $res = ['msg' => 'Post created successfully'];

        return redirect()->route('admin.article')->with('success', 'Article saved successfully');
    }

    public function edit(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->content = json_encode($request->content);
        $article->created_by = Auth::user()->id;
        $article->save();

        return redirect()->route('admin.article')->with('success', 'Article saved successfully');
    }

    public function update($id)
    {
        $article = Article::findOrFail($id);

        return view('admin.article.update-article', ['article' => $article]);
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.article.create-article');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);

        if ($article) {
            $article->delete();
            return redirect()->back()->with('success', 'Voucher Deleted Successfully');
        }

        return redirect()->back()->withErrors(['code' => 'Voucher Not Found']);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Simpan gambar ke storage/public/images/articles
            $path = $file->store('images/articles', 'public');

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset('storage/' . $path), // Kembalikan URL gambar
                ]
            ]);
        }

        return response()->json(['success' => 0, 'message' => 'Upload failed']);
    }
    public function fetch(Request $request)
    {
        $url = $request->input('url');

        // Lakukan validasi atau pengambilan gambar dari URL, jika perlu

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => $url // Kembalikan URL gambar
            ]
        ]);
    }
}
