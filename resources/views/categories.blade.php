<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="stylesheet" href='/css/app.css'>
</head>
<body>
    <div id='app'>
        @if (count($categories))
            <ul>
            @foreach ($categories as $category)
                <li>{{$category['title']}}</li>
            @endforeach
            </ul>
        @else
            <em>Категории отсутствуют</em>
        @endif

        <categories-component
            title='Список категорий'
           
        />
    </div>
    <script src='/js/app.js'></script>
</body>
</html>