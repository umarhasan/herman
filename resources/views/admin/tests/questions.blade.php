@extends('admin.layouts.app')

@section('title', 'Create Questions For Test')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Questions Management</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create Test/Exams</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="usermanagesec">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.tests.questions.store', $test->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div id="question-container"></div>

                                    <button type="button" onclick="addQuestion()" class="btn btn-success btn-sm">Add Question</button>
                                    <button id="saveBtn" type="submit" style="display: none;" class="btn btn-primary btn-sm">Save Questions</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        let count = 0;

        function addQuestion() {
            const container = document.getElementById('question-container');
            const html = `
            <div class="question-block mb-4 p-3 border rounded bg-gray-50">
                <div class="form-group mb-3">
                    <label>Question Input Mode:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="questions[${count}][mode]" value="text" checked onchange="toggleInputMode(${count}, this.value)">
                        <label class="form-check-label">Input</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="questions[${count}][mode]" value="audio" onchange="toggleInputMode(${count}, this.value)">
                        <label class="form-check-label">Audio</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="questions[${count}][mode]" value="video" onchange="toggleInputMode(${count}, this.value)">
                        <label class="form-check-label">Video</label>
                    </div>
                </div>

                <div class="form-group mb-3 question-input" id="text-question-${count}">
                    <label>Question:</label>
                    <input type="text" name="questions[${count}][question_text]" class="form-control" placeholder="Enter question">
                </div>

                <div class="form-group mb-3 question-input" id="audio-question-${count}" style="display:none;">
                    <label>Upload Audio:</label>
                    <input type="file" name="questions[${count}][question_audio]" accept="audio/*" class="form-control">
                </div>

                <div class="form-group mb-3 question-input" id="video-question-${count}" style="display:none;">
                    <label>Upload Video:</label>
                    <input type="file" name="questions[${count}][question_video]" accept="video/*" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Type:</label>
                    <select name="questions[${count}][type]" onchange="toggleOptions(this, ${count})" class="form-control">
                        <option value="mcq">MCQ</option>
                        <option value="short">Short Answer</option>
                    </select>
                </div>

                <div id="options-${count}" class="form-group mb-3">
                    <label>Options:</label>
                    <div id="option-set-${count}">
                        <div class="option-group mb-2">
                            <input type="text" name="questions[${count}][options][]" placeholder="Option 1" class="form-control mb-1 option-text">
                            <input type="file" name="questions[${count}][options_audio][]" accept="audio/*" class="form-control mb-1 option-audio" style="display:none;">
                            <input type="file" name="questions[${count}][options_video][]" accept="video/*" class="form-control option-video" style="display:none;">
                        </div>
                        <div class="option-group mb-2">
                            <input type="text" name="questions[${count}][options][]" placeholder="Option 2" class="form-control mb-1 option-text">
                            <input type="file" name="questions[${count}][options_audio][]" accept="audio/*" class="form-control mb-1 option-audio" style="display:none;">
                            <input type="file" name="questions[${count}][options_video][]" accept="video/*" class="form-control option-video" style="display:none;">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Correct Answer (Optional):</label>
                    <input type="text" name="questions[${count}][correct_answer]" placeholder="Correct answer" class="form-control">
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            count++;
            document.getElementById('saveBtn').style.display = 'inline-block';
        }

        function toggleInputMode(index, mode) {
            const types = ['text', 'audio', 'video'];
            types.forEach(type => {
                document.getElementById(`${type}-question-${index}`).style.display = (type === mode) ? 'block' : 'none';
            });

            const optionGroups = document.querySelectorAll(`#option-set-${index} .option-group`);
            optionGroups.forEach(group => {
                group.querySelector('.option-text').style.display = (mode === 'text') ? 'block' : 'none';
                group.querySelector('.option-audio').style.display = (mode === 'audio') ? 'block' : 'none';
                group.querySelector('.option-video').style.display = (mode === 'video') ? 'block' : 'none';
            });
        }

        function toggleOptions(select, index) {
            const optionsDiv = document.getElementById(`options-${index}`);
            optionsDiv.style.display = select.value === 'mcq' ? 'block' : 'none';
        }
    </script>
@endsection
