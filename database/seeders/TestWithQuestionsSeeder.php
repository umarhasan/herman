<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Test;
use App\Models\Question;
use App\Models\Option;

class TestWithQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ get only teachers using Spatie's roles
        $teachers = User::role('teacher')->get(); // works with spatie/laravel-permission

        foreach ($teachers as $teacher) {
            // create one demo test for this teacher
            $test = Test::create([
                'teacher_id'  => $teacher->id,
                'title'       => 'Demo Test for ' . $teacher->name,
                'description' => 'Automatically generated test with 20 sample questions.',
            ]);

            // create 20 sample questions for each teacher
            for ($i = 1; $i <= 20; $i++) {
                $question = Question::create([
                    'test_id'       => $test->id,
                    'question_text' => "Sample question $i for {$teacher->name}?",
                    // media optional
                    'image_path' => null,
                    'audio_path' => null,
                    'video_path' => null,
                ]);

                // create 4 options for each question
                $correctIndex = rand(1, 4);
                for ($j = 1; $j <= 4; $j++) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => "Option $j for question $i",
                        'is_correct'  => $j === $correctIndex,
                        'image_path'  => null,
                        'audio_path'  => null,
                        'video_path'  => null,
                    ]);
                }
            }
        }
    }
}
