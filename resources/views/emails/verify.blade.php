<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emailni tasdiqlash</title>
</head>
<body>
    <h1>Salom, {{ $user->name }}</h1>
    <p>Quyidagi linkni bosing, email manzilingizni tasdiqlash uchun:</p>
    <a href="{{ $verificationUrl }}">Emailni tasdiqlash</a>
</body>
</html>
