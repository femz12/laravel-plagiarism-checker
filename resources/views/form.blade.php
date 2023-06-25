<!DOCTYPE html>
<html>
<head>
    <title>Plagiarism Checker</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-container textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            resize: vertical;
        }

        .form-container button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Plagiarism Checker</h2>

        <form method="POST" action="{{ route("plagiarism.submit") }}">
            @csrf

            <div class="form-group">
                <label for="text">Enter Text:</label>
                <textarea id="text" name="text" rows="10" placeholder="Enter your text here" required>{{ old('text') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Check Plagiarism</button>
        </form>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
