<!-- resources/views/cv/generated.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>CV Generated</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
</head>
<body>
    <h1>Generated CV</h1>
    <div class="cv-content">
        {!! nl2br(e($cvContent)) !!}
    </div>
</body>
</html>
