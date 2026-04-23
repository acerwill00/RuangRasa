<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|max:100',
            'category_label' => 'required|string|max:100',
            'photo'          => 'nullable|image|max:4096',
            'image'          => 'nullable|url|max:500',
            'excerpt'        => 'required|string',
            'content'        => 'required|string',
            'author'         => 'required|string|max:100',
            'date'           => 'required|string|max:20',
        ]);

        // File upload takes priority over URL
        if ($request->hasFile('photo')) {
            $data['image'] = Storage::url($request->file('photo')->store('articles', 'public'));
        }

        // Auto-generate unique slug from title
        $slug = Str::slug($data['title']);
        $original = $slug;
        $i = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }
        $data['slug'] = $slug;

        $data['content'] = $this->convertToHtml($data['content']);
        Article::create($data);

        return redirect('/admin/articles')->with('success', 'Article published successfully.');
    }

    public function edit(Article $article)
    {
        // Strip HTML back to plain text so the admin sees clean readable text
        $plainContent = $this->htmlToPlain($article->content);
        return view('admin.articles.edit', compact('article', 'plainContent'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|max:100',
            'category_label' => 'required|string|max:100',
            'photo'          => 'nullable|image|max:4096',
            'image'          => 'nullable|url|max:500',
            'excerpt'        => 'required|string',
            'content'        => 'required|string',
            'author'         => 'required|string|max:100',
            'date'           => 'required|string|max:20',
        ]);

        // File upload takes priority over URL
        if ($request->hasFile('photo')) {
            $data['image'] = Storage::url($request->file('photo')->store('articles', 'public'));
        }

        $data['content'] = $this->convertToHtml($data['content']);
        $article->update($data);

        return redirect('/admin/articles')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect('/admin/articles')->with('success', 'Article deleted.');
    }

    /**
     * Convert plain text written by psychologists into styled HTML.
     * Rules:
     *   - Blank line between blocks = new paragraph
     *   - Line starting with ## = <h3> section heading
     *   - Everything else = <p class="mb-6">
     */
    private function convertToHtml(string $text): string
    {
        // Normalise line endings
        $text = str_replace("\r\n", "\n", trim($text));

        // Split into blocks by one or more blank lines
        $blocks = preg_split('/\n{2,}/', $text);

        $html = '';
        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') continue;

            if (str_starts_with($block, '## ')) {
                $heading = htmlspecialchars(substr($block, 3));
                $html .= "<h3 class=\"text-2xl font-bold mb-4 mt-8\">{$heading}</h3>\n";
            } else {
                $para = nl2br(htmlspecialchars($block));
                $html .= "<p class=\"mb-6\">{$para}</p>\n";
            }
        }

        return $html;
    }

    /**
     * Convert stored HTML back to plain text for the edit textarea.
     */
    private function htmlToPlain(string $html): string
    {
        // h3 → ## heading
        $text = preg_replace('/<h3[^>]*>(.*?)<\/h3>/si', '## $1', $html);
        // </p> → double newline
        $text = preg_replace('/<\/p>/i', "\n\n", $text);
        // <br> → single newline
        $text = preg_replace('/<br\s*\/?>/i', "\n", $text);
        // Strip remaining tags and decode entities
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return trim($text);
    }
}