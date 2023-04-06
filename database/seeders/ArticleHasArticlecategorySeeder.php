<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class ArticleHasArticlecategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //
        $abArticleHasArticlecategory = fopen(base_path("public/article_has_articlecategory.csv"), "r");
        $firstline = true;
        if ($abArticleHasArticlecategory !== false){
            $id = 1;
            while (($data = fgetcsv($abArticleHasArticlecategory, 1000, ";")) !== false) {
                if (!$firstline) {
                    DB::table('ab_article_has_articlecategory')->insert([
                        //ab_articlecategory_id;ab_article_id
                        'ab_articlecategory_id' => $data[0],
                        'ab_article_id' => $data[1]
                    ]);
                }
                $firstline = false;
                $id++;
            }
            fclose($abArticleHasArticlecategory);
        }
    }
}
