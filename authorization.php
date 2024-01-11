<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="files/style/style.css">
    <script src="https://kit.fontawesome.com/08e5fde617.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <title>Авторизация</title>
</head>
<body>
    <div class="main-block">
        <div class="auth-block">
            <h1 style="margin-top: 10px;">Авторизация</h1>
            <input type="text" id="login">
            <input type="password" id="password">
            <p class="m-a-warn" id="warn-text" style="margin-top: 10px; margin-bottom: 0px; margin-left: 0px;"></p>
            <a href="" onclick="Auth(); return false;">Авторизоваться</a>
        </div>
    </div>
</body>
</html>
<script>
    async function Auth() {
        const formData = new FormData();
        var login = document.getElementById('login').value; 
        var pass = document.getElementById('password').value; 
        formData.append("login", login);
        formData.append("password", pass);

        let response = await fetch('/api/778c0e8726f21d41b86ca19f07165f67/LoginUser', {
            method: 'POST',
            body: formData
        });
        let posts = await response.json();
        console.log(posts);

        if(posts.code != '0016'){
            document.getElementById('warn-text').innerHTML = posts.result;
        }
        else {
            document.getElementById('warn-text').innerHTML = ' ';
            location.href = "index.php?key=" + posts.apiKey + "&levelApi=" + posts.Level;
        }
    }
</script>