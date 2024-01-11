<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="files/style/style.css">
    <script src="https://kit.fontawesome.com/08e5fde617.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <title>Главная страница</title>
</head>
<body>
    <div class="main-cont">
        <?require('Modules/left-menu.php');?>
        <div class="content-cont">
            <div class="content" id="content"><div class="cont-block">
                    <div class="block-top">
                        <p class="block-name">Пользователи</p>
                        <div class="top-icon">
                            <i class="fa-solid fa-user fa-2xl"></i>
                        </div>
                    </div>
                    <h1 id="CountUser">152</h1>
                    <div class="block-info">
                        <i class="fa-solid fa-arrow-up fa-1x" style="color: #4CC122;"></i>
                        <p style="color: #4CC122; margin-left: 7px; margin-right: 15px;">40%</p>
                        <p style="color: #BCC3CB; font-size: 18px;">С прошлого месяца</p>
                    </div>
                </div>
                <div class="cont-block">
                    <div class="block-top">
                        <p class="block-name">Успешных вопросов</p>
                        <div class="top-icon" style="background-color: #FEF6EB;">
                            <i class="fa-solid fa-headset fa-2xl" style="color: #F1BB35;"></i>
                        </div>
                    </div>
                    <h1 id="CountGoodReport">152</h1>
                    <div class="block-info">
                        <i class="fa-solid fa-arrow-down fa-1x" style="color: #E23839;"></i>
                        <p style="color: #E23839; margin-left: 7px; margin-right: 15px;">40%</p>
                        <p style="color: #BCC3CB; font-size: 18px;">С прошлого месяца</p>
                    </div>
                </div>
                <div class="cont-block">
                    <div class="block-top">
                        <p class="block-name">Нерешенных вопросов</p>
                        <div class="top-icon" style="background-color: #FBE1E2;">
                            <i class="fa-solid fa-headset fa-2xl" style="color: #E23839;"></i>
                        </div>
                    </div>
                    <h1 id="CountBadReport">152</h1>
                    <div class="block-info">
                        <i class="fa-solid fa-arrow-up fa-1x" style="color: #4CC122;"></i>
                        <p style="color: #4CC122; margin-left: 7px; margin-right: 15px;">40%</p>
                        <p style="color: #BCC3CB; font-size: 18px;">С прошлого месяца</p>
                    </div>
                </div>
                <div class="cont-block">
                    <div class="block-top">
                        <p class="block-name">Поездок</p>
                        <div class="top-icon" style="background-color: #E4F6DE;">
                            <i class="fa-solid fa-car fa-2xl" style="color: #4CC122;"></i>
                        </div>
                    </div>
                    <h1 id="CountDrives">152</h1>
                    <div class="block-info">
                        <i class="fa-solid fa-arrow-up fa-1x" style="color: #4CC122;"></i>
                        <p style="color: #4CC122; margin-left: 7px; margin-right: 15px;">40%</p>
                        <p style="color: #BCC3CB; font-size: 18px;">С прошлого месяца</p>
                    </div>
                </div></div>
        </div>
        <script>
    window.onload = async function() {
        async function LoadUsers(){
            let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetCountUser';
            let res = await fetch(url);
            let posts = await res.json();
            if(posts != null){
                document.getElementById('CountUser').innerHTML = posts.UserCount;
            }
        }
        LoadUsers();
        async function LoadGoodReport(){
            let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetCountGoodReports';
            let res = await fetch(url);
            let posts = await res.json();
            if(posts != null){
                document.getElementById('CountGoodReport').innerHTML = posts.GoodReportCount;
            }
        }
        LoadGoodReport();
        async function LoadBadReport(){
            let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetCountBadReports';
            let res = await fetch(url);
            let posts = await res.json();
            if(posts != null){
                document.getElementById('CountBadReport').innerHTML = posts.BadReport;
            }
        }
        LoadBadReport();
        async function LoadDrives(){
            let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetCountDrives';
            let res = await fetch(url);
            let posts = await res.json();
            if(posts != null){
                document.getElementById('CountDrives').innerHTML = posts.drivesCount;
            }
        }
        LoadDrives();
    }
    
</script>

</body>
</html>
