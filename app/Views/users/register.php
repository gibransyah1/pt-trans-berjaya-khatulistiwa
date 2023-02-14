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
            <h1>Register</h1>
        </div>
        <div class="wadah-isi-login">
            <form action="/users/registered" method="post">
                <ul class="ul-login">
                    <li>
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username">
                        <?php if (session()->getFlashdata('username')) : ?>
                            <p style="color: red; font-style: italic;"><?= session()->getFlashdata('username') ?></p>
                        <?php endif; ?>
                    </li>
                    <li>
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password">
                        <?php if (session()->getFlashdata('password')) : ?>
                            <p style="color: red; font-style: italic;"><?= session()->getFlashdata('password') ?></p>
                        <?php endif; ?>
                    </li>
                    <li>
                        <label for="password1">Ulangi Password: </label>
                        <input type="password" name="password1" id="password1">
                        <?php if (session()->getFlashdata('password1')) : ?>
                            <p style="color: red; font-style: italic;"><?= session()->getFlashdata('password1') ?></p>
                        <?php endif; ?>
                    </li>
                    <li>
                        <button type="submit" class="btn-login">Register</button>
                    </li>
                </ul>
            </form>
            <a href="/users/login">Login</a>
        </div>

    </div>
</body>

</html>