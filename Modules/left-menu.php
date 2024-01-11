<?
if(isset($_GET['key'])) {
    if(isset($_GET['levelApi'])) {
        session_start();
        $_SESSION['UserKey'] = $_GET['key'];
        $_SESSION['lvl'] = $_GET['levelApi'];
    }
}
if(!isset($_SESSION['UserKey']) && !isset($_SESSION['lvl'])){

}
?>

<script>
    async function LoadInfoOnUser(key){
        
    }
    LoadInfoOnUser('<?print_r($_SESSION['UserKey']);?>');
</script>

<div class="menu-cont">
            <div class="menu-header">
                <div class="profile">
                    <img src="" alt="">
                    <p>Дмитрий</p>
                </div>
            </div>
            <div class="menu-item">
                <a href="index.php" class="item" id="btn1">
                    <div class=""><br></div>
                    <i class="fa-solid fa-circle-info fa-lg"></i>
                    Информация
                </a>
                <a href="settings.php" class="item" id="btn2">
                    <div class=""><br></div>
                    <i class="fa-solid fa-sliders fa-lg"></i>
                    Настройки
                </a>
                <a href="users.php" class="item">
                    <div class=""><br></div>
                    <i class="fa-solid fa-user fa-lg"></i>
                    Пользователи
                </a>
                <a href="support.php" class="item">
                    <div class=""><br></div>
                    <i class="fa-solid fa-headset fa-lg"></i>
                    Поддержка
                </a>
                <p class="adm-menu-txt">АДМИНИСТИРОВАНИЕ</p>
                <a href="apiFunction.php" class="item">
                    <div class=""><br></div>
                    <i class="fa-solid fa-circle-info fa-lg"></i>
                    Функции API
                </a>
                <a href="UsersAdmin.php" class="item">
                    <div class=""><br></div>
                    <i class="fa-solid fa-circle-info fa-lg"></i>
                    Пользователи
                </a>
                <a href="logs.php" class="item">
                    <div class=""><br></div>
                    <i class="fa-solid fa-circle-info fa-lg"></i>
                    Логи пользователей
                </a>

            </div>
            <div class="menu-footer">
                <a href="sdfasdf.php" class="logaut">
                    Выйти
                </a>
            </div>
        </div>

<script>
    jQuery(() => {
    $(".menu-item [href]").each(function () {
        if (this.href == window.location.href) {
            $(this).addClass("active");
        }
    });
});
</script>