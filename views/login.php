<?php

function LoginPage(){
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Meta Description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link rel="stylesheet" href="">
    <?php CommonImport() ?>
</head>


<body un-cloak>
    <main class="container flex-row">
        <article class="grid">
            <div>
                <hgroup>
                    <h1>Log in or Register</h1>
                    <h2>Enter your username and password</h2>
                </hgroup>
                <div class="text-center">
                    <input type="text" name="username" placeholder="Username" aria-label="Username" required />
                    <input type="password" name="password" placeholder="Password" aria-label="Password" required />

                    <button type="submit" class="primary" hx-post="api.php?action=login"
                        hx-include="[name='username'],[name='password']" hx-target="#error">Login</button>

                    <button type="submit" class="contrast" hx-post="api.php?action=register"
                        hx-include="[name='username'],[name='password']" hx-target="#error">Register</button>

                    <ins id="error" hidden></ins>

                </div>
            </div>
        </article>

    </main>
</body>


</html>


    <?php
}
?>