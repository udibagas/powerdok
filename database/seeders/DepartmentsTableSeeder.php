<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'aspernatur',
                'description' => 'Dignissimos tempore qui fugit.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'quis',
                'description' => 'Earum omnis porro recusandae ratione cum.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'fuga',
                'description' => 'Dicta tempora culpa blanditiis.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'maxime',
                'description' => 'Et vel et rerum a mollitia.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'a',
                'description' => 'Expedita eos deleniti aut sed nesciunt debitis totam.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'quo',
                'description' => 'Rerum deleniti exercitationem quia provident exercitationem non vel.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'id',
                'description' => 'Iure velit voluptas illo quos beatae.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'porro',
                'description' => 'Voluptatem quasi ut facilis non excepturi et dolor.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'facilis',
                'description' => 'Quasi nobis reprehenderit omnis iusto rerum quia qui.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'est',
                'description' => 'Aspernatur possimus ad tempora minus autem repudiandae esse.',
                'parent_id' => NULL,
                'head_id' => NULL,
                'created_at' => '2021-03-03 10:22:40',
                'updated_at' => '2021-03-03 10:22:40',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}