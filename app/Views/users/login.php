<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            margin-top: 120px;
            /* background-color: #63aae0; */
        }
    </style>
</head>

<body>

    <?php if (session()->getFlashdata('flash')) : ?>
        <script>
            alert('<?= session()->getFlashdata('flash'); ?>');
        </script>
    <?php endif; ?>
    <div class="container-login">
        <div class="wadah-judul-login">
            <h1>LOGIN</h1>
        </div>
        <div class="wadah-isi-login">
            <form action="/users/logged" method="post">
                <ul class="ul-login">
                    <li>
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username">
                    </li>
                    <li>
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password">
                    </li>
                    <li>
                        <button type="submit" class="btn-login">Login</button>
                    </li>
                </ul>
            </form>
            <a href="/users/register">Register</a>
        </div>
    </div>
</body>

</html>