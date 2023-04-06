<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CSV reading and validation

        $abUserFile = fopen(base_path("data/user.csv"), "r");
        $abArticleFile = fopen(base_path("data/articles.csv"), "r");
        $abArticlecategoryFile = fopen(base_path("data/articlecategory.csv"), "r");

        $firstline = true;

        if ($abUserFile !== false){
            while (($data = fgetcsv($abUserFile, 1000, ";")) !== false) {
                if (!$firstline) {
                    DB::table('ab_user')->insert([
                        //id;ab_name;ab_password;ab_mail
                        'id' => intval($data[0]),
                        'ab_name' => $data[1],
                        'ab_password' => bcrypt($data[2]),
                        'ab_mail' => $data[3],
                    ]);
                }
                $firstline = false;
            }
            fclose($abUserFile);
        }

        $firstline = true;
        if ($abArticleFile !== false){
            while (($data = fgetcsv($abArticleFile, 1000, ";")) !== false) {
                if (!$firstline) {
                    DB::table('ab_article')->insert([
                        'id'=>intval($data[0]),
                        'ab_name' => $data[1],
                        'ab_price' => intval($data[2]*100), //Preis als cent 1 euro = 100 cent
                        'ab_description' => $data[3],
                        'ab_creator_id' => intval($data[4]),
                        'ab_createdate' => Carbon::createFromFormat("d.m.y H:i",$data[5])
                    ]);
                }
                $firstline = false;
            }
            fclose($abArticleFile);
        }

        $firstline = true;
        if ($abArticlecategoryFile !== false){
            while (($data = fgetcsv($abArticlecategoryFile, 1000, ";")) !== false) {
                if (!$firstline) {
                    if ($data[2] == 'NULL') {
                        $data[2] = NULL;
                    }
                    DB::table('ab_articlecategory')->insert([
                        'id'=>intval($data[0]),
                        'ab_name' => $data[1],
                        'ab_parent' => $data[2],
                    ]);
                }
                $firstline = false;
            }
            fclose($abArticlecategoryFile);
        }
    }
}
