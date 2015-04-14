<?php

class TypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('types')->delete();
        
        DB::table('types')->insert(
            array(
                    array(
                        'title' => 'Фізичний', 
                        'created_at' => date('Y-m-d H:i:s'), 
                        'updated_at' => date('Y-m-d H:i:s')
                    ),
                
                    array(
                        'title' => 'Віртуальний', 
                        'created_at' => date('Y-m-d H:i:s'), 
                        'updated_at' => date('Y-m-d H:i:s')
                    ),                            
            )
        );
    }
}