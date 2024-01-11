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
                    <a href="" onclick="OpenAdminModal(); return false;" class="BtnAddUser">Добавить пользователя</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

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
        let ban;
        if(document.getElementById("myModal") != null){
            document.getElementById("myModal").remove();
        }
        if(posts.Type == 1){
            types = 'Пассажир';
        }
        if(posts.Type == 2){
            types = 'Водитель';
        }
        if(posts.Ban == 1){
            ban = '- Заблокирован';
        }
        else {
            ban = '';
        }
        document.body.innerHTML += `
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="m-header">
                    <div class="m-header-left">
                        <span class="close"><i class="fa-solid fa-arrow-left fa-xs"></i></span>
                        <p>${posts.Login} ${ban}</p>
                    </div>
                    <div class="m-header-right">
                        <a href="" style="margin-right: 10px; width: 190px;">Предупреждение</a>
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
                                    <td><p>${posts.Name} ${posts.Family}</p></td>
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

    async function OpenAdminModal(){
        if(document.getElementById("myAdminModal") != null){
            document.getElementById("myAdminModal").remove();
        }
        document.body.innerHTML += `
        <div id="myAdminModal" class="modal-admin" style="display: block;">
        <div class="modal-admin-content">
            <div class="m-header" style="width:480px;">
                <div class="m-header-left" >
                    <span class="close"><i class="fa-solid fa-arrow-left fa-xs"></i></span>
                    <p>Добавление пользователя</p>
                </div>
            </div>
            <div class="m-cont" style="width:480px;">
                <div class="m-cont-info">
                    <div class="m-client-detail">
                        <p class="title-client-detail">Детали клиента</p>
                        <table class="m-tables">
                            <tr>
                                <td class="m-a-t-name"><p>Имя</p></td>
                                <td class="m-a-t-input"><input type="text" id="Name"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Фамилия</p></td>
                                <td class="m-a-t-input"><input type="text" id="Family"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Логин</p></td>
                                <td class="m-a-t-input"><input type="text" id="Login"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Пароль</p></td>
                                <td class="m-a-t-input"><input type="password" id="Pass"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Повтор пароля</p></td>
                                <td class="m-a-t-input"><input type="password" id="TwoPass"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Город</p></td>
                                <td class="m-a-t-input"><input type="text" id="City"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Почта</p></td>
                                <td class="m-a-t-input"><input type="text" id="email"></td>
                            </tr>
                            <tr>
                                <td class="m-a-t-name"><p>Телефон</p></td>
                                <td class="m-a-t-input"><input type="text" id="phone"></td>
                            </tr>
                        </table>
                        <p class="m-a-warn" id="warn-text"></p>
                    </div>
                </div>
            </div>
            <div class="m-footer" style="width:480px;">
                <a href="" onclick="AddUser(); return false;"style="width: 150px;">Добавить</a>
            </div>
            </div>
        </div>
        `
        var modal = document.getElementById('myAdminModal');
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
    }
    async function AddUser(){
        const formData = new FormData();
        var Name = document.getElementById('Name').value;
        var Family = document.getElementById('Family').value; 
        var Login = document.getElementById('Login').value; 
        var Pass = document.getElementById('Pass').value; 
        var TwoPass = document.getElementById('TwoPass').value; 
        var City = document.getElementById('City').value; 
        var email = document.getElementById('email').value; 
        var phone = document.getElementById('phone').value; 
        formData.append("name", Name);
        formData.append("family", Family);
        formData.append("password", Pass);
        formData.append("twopass", TwoPass);
        formData.append("login", Login);
        formData.append("city", City);
        formData.append("email", email);
        formData.append("phone", phone);

        let response = await fetch('/api/3295c76acbf4caaed33c36b1b5fc2cb1/RegisterUser', {
            method: 'POST',
            body: formData
        });
        let posts = await response.json();

        if(posts.code != "0013"){
            document.getElementById('warn-text').innerHTML = posts.result;
        }
        else {
            var modal = document.getElementById('myAdminModal');
            modal.style.display = "none";
            GetUser();
        }
    }
    /* ОБНОВЛЕНИЕ КОНТЕНТА
    $(document).ready(function(){
        GetUser();
        setInterval('GetUser()',5000);   //обращение к php-скрипту каждые 5 секунд
    });

    ОБНОВЛЕНИЕ КОНТЕНТА */


</script>
