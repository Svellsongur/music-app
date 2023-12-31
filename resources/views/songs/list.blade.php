<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <span>Check file</span>
    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="">
    <form action="{{ route('test') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="">
        <button type="submit">Check</button>
    </form>
</body>

</html>
