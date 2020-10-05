<?php

use Illuminate\Database\Seeder;
use App\HomeBanner;

class HomeBannersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(HomeBanner::where("id", 1)->count() == 0){
            $homeBanner = new HomeBanner;
            $homeBanner->id = 1;
            $homeBanner->status = 0;
            $homeBanner->save();
        }
        if(HomeBanner::where("id", 2)->count() == 0){
            $homeBanner = new HomeBanner;
            $homeBanner->id = 2;
            $homeBanner->status = 0;
            $homeBanner->save();
        }
        if(HomeBanner::where("id", 3)->count() == 0){
            $homeBanner = new HomeBanner;
            $homeBanner->id = 3;
            $homeBanner->status = 0;
            $homeBanner->save();
        }
        if(HomeBanner::where("id", 4)->count() == 0){
            $homeBanner = new HomeBanner;
            $homeBanner->id = 4;
            $homeBanner->status = 0;
            $homeBanner->save();
        }

    }
}
