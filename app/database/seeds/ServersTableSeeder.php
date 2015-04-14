<?php

class ServersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('servers')->delete();
        
        DB::table('servers')->insert(
            array(
                array(
                    'name' => 'Фізичний Сервер 1',
                    'ip' => '10.0.0.1',
                    'start_date' => date('Y-m-d H:i:s', strtotime('14.02.2014')),
                    'type_id' => 1,
                    'physical_server_id' => NULL,
                    'doc_name' => 'Документ на Фізичний сервер 1',
                    'cpu' => '386SX',
                    'hdd' => 'Samsung 80Mb',
                    'ram' => '8Mb',
                    'inventory_number' => '100',
                    'serial_number' => '100',
                    'appointment' => 'Сервер для вірт. машин 1',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ),       
                
                array(
                    'name' => 'Віртуальний Сервер 1',
                    'ip' => '10.0.0.2',
                    'start_date' => date('Y-m-d H:i:s', strtotime('14.02.2014')),
                    'type_id' => 2,
                    'physical_server_id' => 1,
                    'doc_name' => 'Документ на Віртуальний сервер 1',
                    'cpu' => '386SX',
                    'hdd' => '20Mb',
                    'ram' => '2Mb',
                    'inventory_number' => '',
                    'serial_number' => '',
                    'appointment' => 'Призначення 1',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ), 
                
                array(
                    'name' => 'Віртуальний Сервер 2',
                    'ip' => '10.0.0.3',
                    'start_date' => date('Y-m-d H:i:s', strtotime('14.02.2014')),
                    'type_id' => 2,
                    'physical_server_id' => 1,
                    'doc_name' => 'Документ на Віртуальний сервер 2',
                    'cpu' => '386SX',
                    'hdd' => '20Mb',
                    'ram' => '2Mb',
                    'inventory_number' => '',
                    'serial_number' => '',
                    'appointment' => 'Призначення 2',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ), 
                
                array(
                    'name' => 'Фізичний Сервер 2',
                    'ip' => '10.0.0.4',
                    'start_date' => date('Y-m-d H:i:s', strtotime('23.04.2014')),
                    'type_id' => 1,
                    'physical_server_id' => NULL,
                    'doc_name' => 'Документ на Фізичний сервер 2',
                    'cpu' => 'AMD K6-2-350',
                    'hdd' => 'Seqagate 20Gb',
                    'ram' => '512Mb',
                    'inventory_number' => '101',
                    'serial_number' => '101',
                    'appointment' => 'Сервер для вірт. машин 2',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ),       
                
                array(
                    'name' => 'Віртуальний Сервер 3',
                    'ip' => '10.0.0.5',
                    'start_date' => date('Y-m-d H:i:s', strtotime('23.04.2014')),
                    'type_id' => 2,
                    'physical_server_id' => 4,
                    'doc_name' => 'Документ на Віртуальний сервер 3',
                    'cpu' => 'AMD K6-2-350',
                    'hdd' => '10Gb',
                    'ram' => '128Mb',
                    'inventory_number' => '',
                    'serial_number' => '',
                    'appointment' => 'Призначення 3',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ), 
                
                array(
                    'name' => 'Віртуальний Сервер 4',
                    'ip' => '10.0.0.6',
                    'start_date' => date('Y-m-d H:i:s', strtotime('23.04.2014')),
                    'type_id' => 2,
                    'physical_server_id' => 4,
                    'doc_name' => 'Документ на Віртуальний сервер 4',
                    'cpu' => 'AMD K6-2-350',
                    'hdd' => '5Gb',
                    'ram' => '64Mb',
                    'inventory_number' => '',
                    'serial_number' => '',
                    'appointment' => 'Призначення 4',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ), 
            )
        );        
    }
}