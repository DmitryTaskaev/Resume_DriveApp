<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Логирование</title>
    <link rel="stylesheet" href="files/style/style.css">
    <script src="https://kit.fontawesome.com/08e5fde617.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>
<body>
    <div class="main-cont">
        <?include('Modules/left-menu.php');?>
        <div class="content-cont">
            <div class="logs-content" style="flex-direction: column;">
                <h1 style="margin-top: 20px;">Логирование</h1>
                <div class="logs-cont">
                    <div class="input-logs">
                        <input type="text" id="logs-name">
                        <a href="" onclick="Search(); return false;"><i class="fa-solid fa-magnifying-glass fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    async function GetLogsOnUser(UserName){
        if(document.getElementById("l-table") != null){
            document.getElementById("l-table").remove();
        }

        document.querySelector('.logs-cont').innerHTML +=`
        <table class="logs-table" id="l-table">
        <tbody>
        `
        
        document.querySelector('.logs-table').innerHTML +=`
        <tr class="header-logs-table">
            <td><p>Пользователь</p></td>
            <td><p>Действие</p></td>
            <td><p>Дата</p></td>
            <td><p>RegIP</p></td>
            <td><p>LogIP</p></td>
        </tr>
        `

        let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetLogsByUser/' + UserName;
        console.log(url);
        let res = await fetch(url);
        let posts = await res.json();
        console.log(posts);

        posts.forEach((post) => {
            document.querySelector('.logs-table').innerHTML +=`
            <td><p>${post.LoginUser}</p></td>
            <td><p>${post.Action}</p></td>
            <td><p>${post.DateAction}</p></td>
            <td><p>${post.RegIp}</p></td>
            <td><p>${post.IP}</p></td>
            `
        });
    }

    async function Search(){
        var text1 = document.getElementById('logs-name').value;
        GetLogsOnUser(text1);
    }
</script>