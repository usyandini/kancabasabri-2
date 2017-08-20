<?php

use Illuminate\Database\Seeder;

class RejectReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reject_reasons')->truncate();
    	for ($i=1; $i < 6 ; $i++) { 
	    	DB::table('reject_reasons')->insert(
	            [
	            	'content'	=> 'Sample alasan '.$i,
	            	'type'		=> 1,
                    'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
	            ]
	        );	
    	}

    	for ($i=1; $i < 6 ; $i++) { 
	    	DB::table('reject_reasons')->insert(
	            [
	            	'content'	=> 'Sample alasan '.$i,
	            	'type'		=> 2,
                    'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
	            ]
	        );	
    	}
    }
}
