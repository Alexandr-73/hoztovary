<!DOCTYPE html>
<html>

<head>
    <title>Заявка с сайта</title>
</head>

<body>
    <h1>Новая заявка на разработку / доработку сайта</h1>
    <p><strong>Имя:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Сообщение:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>

</html>
