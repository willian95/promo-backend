<?php

use Illuminate\Database\Seeder;
use App\HomeNote;

class HomeNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(HomeNote::count() == 0){
            $homeNote = new HomeNote;
            $homeNote->status = 0;
            $homeNote->save();
        }
        
        

    }
}
