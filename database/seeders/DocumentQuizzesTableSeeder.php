<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentQuizzesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('document_quizzes')->delete();
        
        \DB::table('document_quizzes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'document_id' => 12,
                'question' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
                'choices' => '["ada","edfad","aedad","adefqda"]',
                'correct_answer' => 0,
                'created_at' => '2021-03-03 11:09:41',
                'updated_at' => '2021-03-03 11:09:41',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'document_id' => 12,
                'question' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
                'choices' => '["dsdsd","fefe","sffe","effeef"]',
                'correct_answer' => 0,
                'created_at' => '2021-03-03 14:24:36',
                'updated_at' => '2021-03-03 14:24:36',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'document_id' => 12,
                'question' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
                'choices' => '["dsdsd","fefe","sffe","effeef"]',
                'correct_answer' => 0,
                'created_at' => '2021-03-03 14:24:36',
                'updated_at' => '2021-03-03 14:24:36',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'document_id' => 12,
                'question' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
                'choices' => '["dsdsd","fefe","sffe","effeef"]',
                'correct_answer' => 0,
                'created_at' => '2021-03-03 14:24:36',
                'updated_at' => '2021-03-03 14:24:36',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'document_id' => 12,
                'question' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
                'choices' => '["dsdsd","fefe","sffe","effeef"]',
                'correct_answer' => 0,
                'created_at' => '2021-03-03 14:24:36',
                'updated_at' => '2021-03-03 14:24:36',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}