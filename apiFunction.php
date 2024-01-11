<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Функции PHP</title>
    <link rel="stylesheet" href="files/style/style.css">
    <script src="https://kit.fontawesome.com/08e5fde617.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>
<body>
<div class="main-cont">
        <?include('Modules/left-menu.php');?>
        <div class="content-cont">
            <div class="sup-content" style="flex-direction: column;">
                <h1 style="margin-top: 20px;">Функции API</h1>
                <div class="func-cont">
                    <div class="func-cont-table">
                        <table class="func-table" id="u-table">
                            <tr class="header-func-table">
                                <td><p>Функция</p></td>
                                <td><p>Уровень</p></td>
                                <td><p>Статус</p></td>
                                <td><p>Действие</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    async function GetFunction() {
        $(".func-table").html("");
        document.querySelector('.func-table').innerHTML +=`
        <tr class="header-func-table">
            <td><p>Функция</p></td>
            <td><p>Уровень</p></td>
            <td><p>Статус</p></td>
            <td><p>Действие</p></td>
        </tr>
        `
        let res = await fetch('/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetAllApiFunction');
        let posts = await res.json();
        console.log(posts);

        posts.forEach((post) => {
            if(post.Status == 0){
                document.querySelector('.func-table').innerHTML +=`
                <tr>
                    <td><p>${post.FuncName}</p></td>
                    <td><p>${post.NeedLevel}</p></td>
                    <td><p style="color: #E23839;">Выключена</p></td>
                    <td>
                        <a href="" onclick="OpenModal(${post.id}); return false;"><i class="fa-solid fa-pen fa-lg"></i></a>
                        <a href="" onclick="OnOfFunction(${post.id}); return false;"><i class="fa-solid fa-power-off fa-lg" style="color: #4CC122;"></i></a>
                    </td>
                </tr>
                `
            }
            if(post.Status == 1){
                document.querySelector('.func-table').innerHTML +=`
                <tr>
                    <td><p>${post.FuncName}</p></td>
                    <td><p>${post.NeedLevel}</p></td>
                    <td><p style="color: #4CC122;">Включена</p></td>
                    <td>
                        <a href="" onclick="OpenModal(${post.id}); return false;"><i class="fa-solid fa-pen fa-lg"></i></a>
                        <a href="" onclick="OnOfFunction(${post.id}); return false;"><i class="fa-solid fa-power-off fa-lg" style="color: #E23839;"></i></a>
                    </td>
                </tr>
                `
            }
            

        });
    }
    async function OnOfFunction(fid) {
        let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/OnOffApiFunction/' + fid;
        let res = await fetch(url);
        GetFunction();
    }
    async function UpdateLevel(fid) {
        const formData = new FormData();
        var text1 = document.getElementById('levels').value; 
        formData.append("id", fid);
        formData.append("level", text1);

        let response = await fetch('/api/3295c76acbf4caaed33c36b1b5fc2cb1/UpdateLevelApiFunction', {
            method: 'POST',
            body: formData
        });
    }
    async function OpenModal(id){
        if(document.getElementById("myModalFunc") != null){
            document.getElementById("myModalFunc").remove();
        }
        document.body.innerHTML += `
        <div id="myModalFunc" class="func-modal" style="display: block;">
            <div class="func-modal-content">
                <div class="m-f-header-left">
                    <span class="close"><i class="fa-solid fa-arrow-left fa-xs"></i></span>
                    <p>Обновление уровня</p>
                </div>
                <div class="m-f-body">
                    <input type="text" id="levels">
                    <a href="" id="f-m-acc">Применить</a>
                </div>
            </div>
        </div>
        `
        var modal = document.getElementById('myModalFunc');
        var btn = document.getElementById("f-m-acc");
        var span = document.getElementsByClassName("close")[0];
        modal.style.display = "block";

        span.onclick = function() {
            modal.style.display = "none";
        }
        btn.onclick = function() {
            modal.style.display = "none";
            UpdateLevel(id);
            GetFunction();
            return false;
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
    GetFunction();
</script>