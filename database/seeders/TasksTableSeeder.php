<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tasks')->delete();
        
        \DB::table('tasks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 3,
                'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-31',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-04 14:28:12',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 2,
                'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-31',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-04 16:22:43',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 4,
                'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-31',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 5,
                'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-31',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 6,
                'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-31',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 7,
                'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-31',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'type' => 3,
                'document_id' => 12,
                'assignee_id' => 3,
                'title' => 'Test',
                'description' => 'test',
                'custom_fields' => NULL,
                'priority' => 1,
                'due_date' => '2021-03-05',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:23:05',
            ),
        ));
        
        
    }
}