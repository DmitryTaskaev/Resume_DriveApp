<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
    <link rel="stylesheet" href="files/style/style.css">
    <script src="https://kit.fontawesome.com/08e5fde617.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>
<body>
    <div class="main-cont">
        <?include('Modules/left-menu.php');?>
        <div class="content-cont">
            <div class="content" id="content" style="flex-direction: column;">
                <div class="cont-users">
                    <h1 style="margin-left: 20px; margin-top: 20px;">Пользователи</h1>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!--a
<div id="myModal" class="modal" style="display: block;">
    <div class="modal-content">
        <div class="m-header">
            <div class="m-header-left">
                <span class="close"><i class="fa-solid fa-arrow-left fa-xs"></i></span>
                <p>DEFITZ</p>
            </div>
            <div class="m-header-right">
                <a href="">Заблокировать</a>
            </div>
        </div>
        <div class="m-cont">
            <div class="m-cont-top">
                <div class="m-cont-top-left">
                    <p class="title-client-detail">Тип пользователя</p>
                    <h1 class="m-c-t-l-t">Водитель</h1>
                </div>
            </div>
            <div class="m-cont-info">
                <div class="m-client-detail">
                    <p class="title-client-detail">Детали клиента</p>
                    <table class="m-tables">
                        <tr>
                            <td class="m-t-name"><p>Имя</p></td>
                            <td><p>Таскаев Дмитрий</p></td>
                        </tr>
                        <tr>
                            <td class="m-t-name"><p>Почта</p></td>
                            <td><p>dimataskaev@bk.ru</p></td>
                        </tr>
                        <tr>
                            <td class="m-t-name"><p>Телефон</p></td>
                            <td><p>89226171353</p></td>
                        </tr>
                        <tr>
                            <td class="m-t-name"><p>Поездки</p></td>
                            <td><p>5</p></td>
                        </tr>
                    </table>
                </div>
                <div class="m-client-detail">
                    <p class="title-client-detail">Детали безопасности</p>
                    <table class="m-tables">
                        <tr>
                            <td class="m-t-name"><p>Reg-ip</p></td>
                            <td><p>Last-ip</p></td>
                        </tr>
                        <tr>
                            <td class="m-t-name"><p>Last-ip</p></td>
                            <td><p>dimataskaev@bk.ru</p></td>
                        </tr>
                        <tr>
                            <td class="m-t-name"><p>Наказаний</p></td>
                            <td><p>0</p></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="m-footer">
            <a href="">Посмотреть действия</a>
        </div>
    </div>
</div>
-->

<script type="text/javascript">
    async function GetUser() {
        if(document.getElementById("u-table") != null){
            document.getElementById("u-table").remove();
        }
        document.querySelector('.cont-users').innerHTML +=`
        <table class="user-table" id="u-table">
        </table>
        `
        document.querySelector('.user-table').innerHTML +=`
        <tr class="header-user-table">
            <td><p>Имя пользователя</p></td>
            <td><p>Поездок</p></td>
            <td><p>Тип пользователя</p></td>
            <td><p>Действие</p></td>
        </tr>
        `
        let res = await fetch('/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetAllUser');
        let posts = await res.json();
        console.log(posts);

        posts.forEach((post) => {
            if(post.Type == 1){
                document.querySelector('.user-table').innerHTML +=`
                <td><p>${post.Name}</p></td>
                <td><p>${post.CountDrive}</p></td>
                <td><p>Пассажир</p></td>
                <td>
                    <a href="" onclick="OpenModal('${post.Login}'); return false;"><i class="fa-solid fa-circle-info fa-lg"></i></a>
                </td>
                `
            }
            if(post.Type == 2){
                document.querySelector('.user-table').innerHTML +=`
                <td><p>${post.Name}</p></td>
                <td><p>${post.CountDrive}</p></td>
                <td><p>Водитель</p></td>
                <td>
                    <a href="" onclick="OpenModal('${post.Login}'); return false;"><i class="fa-solid fa-circle-info fa-lg"></i></a>
                </td>
                `
            }
            

        });

    }
    async function OpenModal(user){
        let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetOnUserInfoByLogin/' + user;
        let res = await fetch(url);
        let posts = await res.json();
        let types;
        if(document.getElementById("myModal") != null){
            document.getElementById("myModal").remove();
        }
        if(posts.Type == 1){
            types = 'Пассажир';
        }
        if(posts.Type == 2){
            types = 'Водитель';
        }
        document.body.innerHTML += `
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="m-header">
                    <div class="m-header-left">
                        <span class="close"><i class="fa-solid fa-arrow-left fa-xs"></i></span>
                        <p>${posts.Login}</p>
                    </div>
                    <div class="m-header-right">
                        <a href="">Заблокировать</a>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="m-cont-top">
                    <div class="m-cont-top-left">
                        <p class="title-client-detail">Тип пользователя</p>
                        <h1 class="m-c-t-l-t">${types}</h1>
                    </div>
                </div>
                    <div class="m-cont-info">
                        <div class="m-client-detail">
                            <p class="title-client-detail">Детали клиента</p>
                            <table class="m-tables">
                                <tr>
                                    <td class="m-t-name"><p>Имя</p></td>
                                    <td><p>${posts.Name} ${posts.Famile}</p></td>
                                </tr>
                                <tr>
                                    <td class="m-t-name"><p>Почта</p></td>
                                    <td><p>${posts.Email}</p></td>
                                </tr>
                                <tr>
                                    <td class="m-t-name"><p>Телефон</p></td>
                                    <td><p>${posts.Phone}</p></td>
                                </tr>
                                <tr>
                                    <td class="m-t-name"><p>Поездки</p></td>
                                    <td><p>${posts.CountDrive}</p></td>
                                </tr>
                            </table>
                        </div>
                        <div class="m-client-detail">
                            <p class="title-client-detail">Детали безопасности</p>
                            <table class="m-tables">
                                <tr>
                                    <td class="m-t-name"><p>Reg-ip</p></td>
                                    <td><p>${posts. RegIP}</p></td>
                                </tr>
                                <tr>
                                    <td class="m-t-name"><p>Last-ip</p></td>
                                    <td><p>${posts.LastIP}</p></td>
                                </tr>
                                <tr>
                                    <td class="m-t-name"><p>Наказаний</p></td>
                                    <td><p>${posts.Warn}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="m-footer">
                    <a href="">Посмотреть действия</a>
                </div>
            </div>
        </div>
        `
        var modal = document.getElementById('myModal');
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];
        modal.style.display = "block";

        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        posts = null;
    }
    GetUser();

    /* ОБНОВЛЕНИЕ КОНТЕНТА
    $(document).ready(function(){
        GetUser();
        setInterval('GetUser()',5000);   //обращение к php-скрипту каждые 5 секунд
    });

    ОБНОВЛЕНИЕ КОНТЕНТА */


</script>
