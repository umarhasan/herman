<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::where('teacher_id', auth()->id())->with('questions.options')->latest()->get();
        return view('teacher.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('teacher.tests.create');
    }

    public function store(Request $request)
    {

        $request->validate(['title'=>'required|string|max:255']);
        $test = Test::create([
            'teacher_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description
        ]);
        return redirect()->route('teacher.tests.edit', $test)->with('success','Test created. Add questions now.');
    }

    public function edit(Test $test)
    {
        abort_if($test->teacher_id !== auth()->id(),403);
        $test->load('questions.options');
        return view('teacher.tests.edit', compact('test'));
    }

    // Add question
    public function storeQuestion(Request $request, Test $test)
    {
        abort_if($test->teacher_id !== auth()->id(),403);

        $request->validate([
            'question_text'=>'required|string',
            'image'=>'nullable|image|max:2048',
            'audio'=>'nullable|mimetypes:audio/mpeg,audio/wav,audio/mp3|max:51200',
            'video'=>'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:512000',
            'options'=>'required|array|min:2|max:6',
            'options.*.text'=>'nullable|string',
            'options.*.image'=>'nullable|image|max:2048',
            'options.*.audio'=>'nullable|mimetypes:audio/mpeg,audio/wav,audio/mp3|max:51200',
            'options.*.video'=>'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:512000',
            'correct'=>'required|array'
        ]);

        $questionData = [
            'question_text' => $request->question_text,
            'image_path' => $request->file('image') ? $request->file('image')->store('questions','public') : null,
            'audio_path' => $request->file('audio') ? $request->file('audio')->store('questions','public') : null,
            'video_path' => $request->file('video') ? $request->file('video')->store('questions','public') : null,
        ];

        $question = $test->questions()->create($questionData);

        foreach ($request->options as $index => $opt) {
            $optionData = [
                'option_text' => $opt['text'] ?? null,
                'image_path' => isset($opt['image']) && $opt['image'] ? $opt['image']->store('options','public') : null,
                'audio_path' => isset($opt['audio']) && $opt['audio'] ? $opt['audio']->store('options','public') : null,
                'video_path' => isset($opt['video']) && $opt['video'] ? $opt['video']->store('options','public') : null,
                'is_correct' => in_array($index, $request->correct)
            ];
            $question->options()->create($optionData);
        }

        return back()->with('success','Question added.');
    }

    // delete question and media
    public function destroyQuestion(Question $question)
    {
        $test = $question->test;
        abort_if($test->teacher_id !== auth()->id(),403);

        if ($question->image_path) Storage::disk('public')->delete($question->image_path);
        if ($question->audio_path) Storage::disk('public')->delete($question->audio_path);
        if ($question->video_path) Storage::disk('public')->delete($question->video_path);

        foreach ($question->options as $opt) {
            if ($opt->image_path) Storage::disk('public')->delete($opt->image_path);
            if ($opt->audio_path) Storage::disk('public')->delete($opt->audio_path);
            if ($opt->video_path) Storage::disk('public')->delete($opt->video_path);
            $opt->delete();
        }

        $question->delete();

        return back()->with('success','Question deleted.');
    }

    // delete entire test (optional)
    public function destroy(Test $test)
    {
        abort_if($test->teacher_id !== auth()->id(),403);

        foreach ($test->questions as $question) {
            if ($question->image_path) Storage::disk('public')->delete($question->image_path);
            if ($question->audio_path) Storage::disk('public')->delete($question->audio_path);
            if ($question->video_path) Storage::disk('public')->delete($question->video_path);
            foreach ($question->options as $opt) {
                if ($opt->image_path) Storage::disk('public')->delete($opt->image_path);
                if ($opt->audio_path) Storage::disk('public')->delete($opt->audio_path);
                if ($opt->video_path) Storage::disk('public')->delete($opt->video_path);
            }
        }

        $test->delete();
        return redirect()->route('teacher.tests.index')->with('success','Test deleted.');
    }
}
