<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     RoleSeeder::class,
        // ]);

        $this->command->info('creating Authers....');

        $user = User::factory()->count(10)->create([
            'is_author' => 1,
        ]);

        $this->command->info('10 Authers added...');

        $this->command->info('creating users with articles');
        $user = User::factory()
            ->count(10)
            ->has(Article::factory()
                ->count(10)
                ->hasComments(3, function (array $attributes, Article $article) {
                    return ['comment_by' => $article->created_by];
                }))
            ->create();


        $this->command->info('10 admin editor added...');
    }
}
