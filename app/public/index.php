<style>
    html {
        height: 100%;
        width: 100%;
    }

    body {
        background: url("https://beedle.club/uploads/posts/2023-03/1679617264_beedle-club-p-fentezi-art-priroda-fentezi-vkontakte-4.jpg")
        no-repeat center center fixed;
        background-size: cover;
        font-family: "Droid Serif", serif;
    }

    #container {
        background: rgba(230, 230, 250, 0.5);
        width: 18.75rem;
        height: 25rem;
        margin: auto;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    header {
        text-align: center;
        vertical-align: middle;
        line-height: 3rem;
        height: 3rem;
        background: rgba(216, 191, 216, 0.7);
        font-size: 1.4rem;
        color: black;
    }

    fieldset {
        border: 0;
        text-align: center;
    }

    input[type="submit"] {
        background: rgba(0, 0, 0, 1);
        border: 0;
        display: block;
        width: 70%;
        margin: 0 auto;
        color: white;
        padding: 0.7rem;
        cursor: pointer;
    }

    input {
        background: transparent;
        border: 0;
        border-left: 4px solid;
        border-color: black;
        padding: 10px;
        color: black;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        outline: 0;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 1.2rem;
        border-color: transparent;
    }

    ::placeholder {
        color: black;
    }

    /*Media queries */

    @media all and (min-width: 481px) and (max-width: 568px) {
        #container {
            margin-top: 10%;
            margin-bottom: 10%;
        }
    }
    @media all and (min-width: 569px) and (max-width: 768px) {
        #container {
            margin-top: 5%;
            margin-bottom: 5%;
        }
    }
</style>
<body>
      <div id="container">
         <header>Register new account</header>
         <form method="post">
            <fieldset>
               <br/>
               <input type="text" name="name" id="name" placeholder="Username" >
               <br/><br/>
               <input type="text" name="email" id="email" placeholder="E-mail" >
               <br/><br/>
               <input type="password" name="password" id="password" placeholder="Password" >
               <br/><br/>
               <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" >
               <br/> <br/> <br/>
               <label for="submit"></label>
               <input type="submit" name="submit" id="submit" value="REGISTER">
            </fieldset>
         </form>
      </div>
</body>


<?php

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if (empty($name)) {
            echo 'Поле Username не может быть пустым';
        }
        if (strlen($name) <2 ) {
            echo 'Поле Username должно быть не менее двух символов';
        }

    } else {
        echo 'Поле Username не заполнено';
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (empty($email)) {
            echo 'Поле E-mail не может быть пустым';
        }
    } else {
        echo 'Поле E-mail не заполнено';
    }


    if (isset($_POST['password'])) {
        $password = $_POST["password"];
        if (empty($password)) {
            echo 'Поле Password не может быть пустым';
        }
        if (strlen($password) < 3  or strlen($password) > 15) {
            echo ("Пароль должен состоять не менее чем из 3 символов и не более чем из 15.");
        }
        } else {
        echo 'Поле Password не заполнено';
    }
    if ($_POST['name'] !== $_POST['confirm-password']) {
        echo 'Пароли не совпадают';
    }


    $pdo = new PDO("pgsql:host=db;dbname=dbname", "dbuser", "dbpwd");

    //$pdo->exec( "insert into users(name, email, password) values ('$name', '$email', '$password')");

    $password = password_hash($password, PASSWORD_DEFAULT);

    $statement = $pdo->prepare("insert into users(name, email, password) values (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
}

