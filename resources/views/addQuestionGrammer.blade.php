@extends('voyager::master')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form method="POST" action="{{ route('submit_form') }}">
    @csrf

    <div class="form-group">
        <label for="grammer">Grammar:</label>
        <input type="text" class="form-control" name="grammer" id="grammer">
    </div>

    <hr>

    <div id="questions_container">
        <div class="question-form">
            <div class="form-group">
                <label for="question_text">Question Text:</label>
                <input type="text" class="form-control" name="question_text[]" required>
            </div>

            <div class="form-group">
                <label>Answers:</label>
                <div class="answer-group">
                    <input type="text" class="form-control" name="answer_text[0][]" required>
                    <label><input type="radio" name="status[0][0]" value="false" onchange="handleRadioChange(this)"> Correct Answer</label>
                </div>
                <div class="answer-group">
                    <input type="text" class="form-control" name="answer_text[0][]" required>
                    <label><input type="radio" name="status[0][0]" value="false" onchange="handleRadioChange(this)"> Correct Answer</label>
                </div>
                <div class="answer-group">
                    <input type="text" class="form-control" name="answer_text[0][]" required>
                    <label><input type="radio" name="status[0][0]" value="false" onchange="handleRadioChange(this)"> Correct Answer</label>
                </div>
                <div class="answer-group">
                    <input type="text" class="form-control" name="answer_text[0][]" required>
                    <label><input type="radio" name="status[0][0]" value="false" onchange="handleRadioChange(this)"> Correct Answer</label>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary" id="add_question">Add Question</button>
    <button type="submit" class="btn btn-success">Submit</button>
</form>


<script>
     function handleRadioChange(radio) {
        var radios = document.getElementsByName(radio.name);
        for (var i = 0; i < radios.length; i++) {
            radios[i].value = "false";
        }
        radio.value = "true";
    }
document.getElementById('add_question').addEventListener('click', function () {
  var questionsContainer = document.getElementById('questions_container');
  var questionForm = document.querySelector('.question-form').cloneNode(true);

  // Generate unique IDs for the new question form elements
  var timestamp = Date.now();
  var questionText = questionForm.querySelector('input[name="question_text[]"]');
  questionText.name = 'question_text[' + timestamp + ']';

  var answerGroups = questionForm.querySelectorAll('.answer-group');
  answerGroups.forEach(function (answerGroup, index) {
    var answerText = answerGroup.querySelector('input[name^="answer_text"]');
    answerText.name = 'answer_text[' + timestamp + '][' + index + ']';

    var radio = answerGroup.querySelector('input[type="radio"]');
    radio.name = 'status[' + timestamp + ']';
    radio.value = index; // Assign a unique value to each radio button
    // radio.addEventListener('click', function () {
    //     radios.forEach(function (r, rIndex) {
    //       r.value = rIndex === 0 ? 'true' : 'false';
    //     });
    //   });
    // Add an event listener to each radio button to handle selection/deselection
    radio.addEventListener('click', function () {
        var answerGroupRadios = answerGroup.querySelectorAll('input[type="radio"]');
      answerGroupRadios.forEach(function (groupRadio) {
        if (groupRadio !== radio) {
          groupRadio.checked = false;
          groupRadio.value = 'false';
        } else {
          groupRadio.value = 'true';
        }
      });
      var answerGroupRadios = answerGroup.querySelectorAll('input[type="radio"]');
      answerGroupRadios.forEach(function (groupRadio) {
        if (groupRadio !== radio) {
          groupRadio.checked = false;
        }
      });
    });
  });

  questionsContainer.appendChild(questionForm);
});
</script>
@endsection
