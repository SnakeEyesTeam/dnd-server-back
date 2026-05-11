<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title>Восстановление пароля</title>
</head>

<body>
    <h2>Здравствуйте!</h2>
    <p>Вы запросили сброс пароля. Для этого перейдите по ссылке ниже:</p>
    <p>
        <a href="{{ "http://95.31.215.197:8080/change-password?token=" . explode("=" ,$resetUrl)[1] }}"
            style="display:inline-block;padding:10px 20px;margin-top:10px;background-color:#4CAF50;color:#fff;text-decoration:none;border-radius:5px;">Сбросить
            пароль</a>
    </p>
    <p>Если вы не запрашивали сброс пароля, проигнорируйте это письмо.</p>
</body>

</html>
