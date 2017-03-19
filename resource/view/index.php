<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php asset('css/style.css'); ?>">
</head>
<body>
    <form action="/post" method="post">
        <?php foreach ( message('errors') as $error) :?>
            <ul>
                <li>
                    <?php echo $error; ?>
                </li>
            </ul>
        <?php endforeach; ?>
        <input type="text" name="login" value="<?php echo old('login'); ?>"> <br>
        <input type="text" name="password" value="<?php echo old('password'); ?>"> <br>
        <input type="submit" value="send">
    </form>
</body>
</html>

