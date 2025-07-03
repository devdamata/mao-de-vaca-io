<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Mão de Vaca</title>
</head>
<body>
<div class="min-h-screen">
    @include('landingpage.header')
    @include('landingpage.hero')
    @include('landingpage.features')
    @include('landingpage.testimonials')
    @include('landingpage.princing')
    @include('landingpage.footer')
</div>
</body>
</html>
