<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('articles', []) as $slug => $data) {
            // Skip if already seeded (idempotent)
            if (Article::where('slug', $slug)->exists()) {
                continue;
            }

            Article::create([
                'title'          => $data['title'],
                'slug'           => $slug,
                'category'       => $data['category'],
                'category_label' => $data['category_label'],
                'image'          => $data['image'] ?? null,
                'excerpt'        => $data['excerpt'],
                'content'        => $data['content'],
                'author'         => $data['author'],
                'date'           => $data['date'],
            ]);
        }
    }
}
