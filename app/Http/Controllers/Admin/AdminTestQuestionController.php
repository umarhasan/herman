<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class AdminTestQuestionController extends Controller
{
    public function create(Test $test)
    {
        $test->load('questions');
        return view('admin.tests.questions', compact('test'));
    }

    public function store(Request $request, Test $test)
    {
        foreach ($request->questions as $index => $q) {
            $data = [
                'test_id' => $test->id,
                'input_mode' => $q['input_mode'] ?? 'text',
                'question_text' => $q['question_text'] ?? null,
                'correct_answer' => $q['correct_answer'] ?? null,
            ];

            // Question media
            if (isset($q['question_audio'])) {
                $data['question_audio'] = $q['question_audio']->store('questions/audio', 'public');
            }

            if (isset($q['question_video'])) {
                $data['question_video'] = $q['question_video']->store('questions/video', 'public');
            }

            // Option A-D text/audio/video
            foreach (['a', 'b', 'c', 'd'] as $opt) {
                $data["option_$opt"] = $q["option_$opt"] ?? null;

                if (isset($q["option_{$opt}_audio"])) {
                    $data["option_{$opt}_audio"] = $q["option_{$opt}_audio"]->store('questions/audio', 'public');
                }

                if (isset($q["option_{$opt}_video"])) {
                    $data["option_{$opt}_video"] = $q["option_{$opt}_video"]->store('questions/video', 'public');
                }
            }

            if (isset($q['id'])) {
                $question = Question::find($q['id']);
                if ($question) {
                    $question->update($data);
                }
            } else {
                Question::create($data);
            }
        }

        return redirect()->route('admin.tests.index')->with('success', 'Questions saved successfully.');
    }

    public function edit($id)
    {
        $test = Test::with('questions')->findOrFail($id);
        return view('admin.tests.editquestions', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $test->load('questions');
        return $this->store($request, $test);
    }
}