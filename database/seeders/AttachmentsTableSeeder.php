<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttachmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attachments')->delete();
        
        \DB::table('attachments')->insert(array (
            0 => 
            array (
                'id' => 12,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 7,
                'user_id' => 3,
                'name' => 'Powerdok1.png',
                'path' => 'uploads/2021/03/04/16/XbLZDp2YEwqQ6abhAAuBoGsc1o3ayEccOScMjFbB.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:21:53',
            ),
            1 => 
            array (
                'id' => 13,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 7,
                'user_id' => 3,
                'name' => 'Powerdok4.png',
                'path' => 'uploads/2021/03/04/16/f6n2XDOJYwYhGsUlZH55pm5NS4PuRPCavyrsIr8h.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:21:53',
            ),
            2 => 
            array (
                'id' => 14,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 7,
                'user_id' => 3,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/04/16/VDsJ5Vrdd6FaEoVwrgquI09FdyP1rPjj4NbG8SJb.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:21:53',
            ),
            3 => 
            array (
                'id' => 15,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 7,
                'user_id' => 3,
                'name' => 'Remind SOP Review v1.0.docx',
                'path' => 'uploads/2021/03/04/16/GVMhRFVoGa7TERPotn4Pxg9TzR2yUwh3qEzQl9eq.docx',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:21:53',
            ),
            4 => 
            array (
                'id' => 16,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 7,
                'user_id' => 3,
                'name' => 'Policy & SOP Management Software - User Journey.docx',
                'path' => 'uploads/2021/03/04/16/OYlgz4fx5evyGYZ2sBesVfKuv1QgH66wgpUA4Qdv.docx',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:21:53',
            ),
            5 => 
            array (
                'id' => 1,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 1,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/OVnhC2M7lTZk10MsYFq8WCJrZWRGkk17QZnX7RqA.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            6 => 
            array (
                'id' => 2,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 2,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/OVnhC2M7lTZk10MsYFq8WCJrZWRGkk17QZnX7RqA.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            7 => 
            array (
                'id' => 3,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 3,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/OVnhC2M7lTZk10MsYFq8WCJrZWRGkk17QZnX7RqA.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            8 => 
            array (
                'id' => 4,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 4,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/OVnhC2M7lTZk10MsYFq8WCJrZWRGkk17QZnX7RqA.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            9 => 
            array (
                'id' => 5,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 5,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/OVnhC2M7lTZk10MsYFq8WCJrZWRGkk17QZnX7RqA.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            10 => 
            array (
                'id' => 6,
                'attachable_type' => 'App\\Models\\Task',
                'attachable_id' => 6,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/OVnhC2M7lTZk10MsYFq8WCJrZWRGkk17QZnX7RqA.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            11 => 
            array (
                'id' => 7,
                'attachable_type' => 'App\\Models\\DocumentQuiz',
                'attachable_id' => 1,
                'user_id' => 1,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/03/11/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:19:45',
                'updated_at' => '2021-03-04 16:19:45',
            ),
            12 => 
            array (
                'id' => 8,
                'attachable_type' => 'App\\Models\\DocumentQuiz',
                'attachable_id' => 5,
                'user_id' => 3,
                'name' => 'dashboard.png',
                'path' => 'uploads/2021/03/04/16/1FY11GkdprYOD9OEetnLULPXKGmVJ3gT60g18zQ6.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:19:45',
                'updated_at' => '2021-03-04 16:19:45',
            ),
            13 => 
            array (
                'id' => 9,
                'attachable_type' => 'App\\Models\\DocumentQuiz',
                'attachable_id' => 5,
                'user_id' => 3,
                'name' => 'Powerdok1.png',
                'path' => 'uploads/2021/03/04/16/acNomYjLrQOuO00sU7XWHQKaee9xT87AO8zr4zby.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:19:45',
                'updated_at' => '2021-03-04 16:19:45',
            ),
            14 => 
            array (
                'id' => 10,
                'attachable_type' => 'App\\Models\\DocumentQuiz',
                'attachable_id' => 5,
                'user_id' => 3,
                'name' => 'Powerdok4.png',
                'path' => 'uploads/2021/03/04/16/tWSLlPG7tIPuZWdXTjpaH3jjSblsYT5UV8D84oEZ.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:19:45',
                'updated_at' => '2021-03-04 16:19:45',
            ),
            15 => 
            array (
                'id' => 11,
                'attachable_type' => 'App\\Models\\DocumentQuiz',
                'attachable_id' => 5,
                'user_id' => 3,
                'name' => 'Powerdok1.png',
                'path' => 'uploads/2021/03/04/16/tRpPzmBO0ANPszMJHiBUHwJp4Ojkuq5pj2l9V9KP.png',
                'deleted_at' => NULL,
                'created_at' => '2021-03-04 16:19:45',
                'updated_at' => '2021-03-04 16:19:45',
            ),
        ));
        
        
    }
}