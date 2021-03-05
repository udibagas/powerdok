<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentExamsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('document_exams')->delete();

        \DB::table('document_exams')->insert(array (
            0 =>
            array (
                'id' => 1,
                'task_id' => 1,
                'user_id' => 3,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]}]',
                'exam_minimum_score' => 60,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            1 =>
            array (
                'id' => 2,
                'task_id' => 2,
                'user_id' => 2,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]}]',
                'exam_minimum_score' => 60,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            2 =>
            array (
                'id' => 3,
                'task_id' => 3,
                'user_id' => 4,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]}]',
                'exam_minimum_score' => 60,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            3 =>
            array (
                'id' => 4,
                'task_id' => 4,
                'user_id' => 5,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]}]',
                'exam_minimum_score' => 60,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            4 =>
            array (
                'id' => 5,
                'task_id' => 5,
                'user_id' => 6,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]}]',
                'exam_minimum_score' => 60,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            5 =>
            array (
                'id' => 6,
                'task_id' => 6,
                'user_id' => 7,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]}]',
                'exam_minimum_score' => 60,
                'created_at' => '2021-03-03 11:24:17',
                'updated_at' => '2021-03-03 11:24:17',
            ),
            6 =>
            array (
                'id' => 7,
                'task_id' => 7,
                'user_id' => 3,
                'document_id' => 12,
                'quizzes' => '[{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["ada","edfad","aedad","adefqda"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/03\\/11\\/XUfmOxl93V3LJkAbcm88FZ8fyD9FjLhI93nQwhgC.png"]},{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["dsdsd","fefe","sffe","effeef"],"correct_answer":0,"user_answer":null,"attachments":[]},{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["dsdsd","fefe","sffe","effeef"],"correct_answer":0,"user_answer":null,"attachments":[]},{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["dsdsd","fefe","sffe","effeef"],"correct_answer":0,"user_answer":null,"attachments":[]},{"question":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","choices":["dsdsd","fefe","sffe","effeef"],"correct_answer":0,"user_answer":null,"attachments":["http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/04\\/16\\/1FY11GkdprYOD9OEetnLULPXKGmVJ3gT60g18zQ6.png","http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/04\\/16\\/acNomYjLrQOuO00sU7XWHQKaee9xT87AO8zr4zby.png","http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/04\\/16\\/tWSLlPG7tIPuZWdXTjpaH3jjSblsYT5UV8D84oEZ.png","http:\\/\\/localhost:8000\\/storage\\/uploads\\/2021\\/03\\/04\\/16\\/tRpPzmBO0ANPszMJHiBUHwJp4Ojkuq5pj2l9V9KP.png"]}]',
                'exam_minimum_score' => 70,
                'created_at' => '2021-03-04 16:21:53',
                'updated_at' => '2021-03-04 16:21:53',
            ),
        ));


    }
}
