<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Поддержка</title>
    <link rel="stylesheet" href="files/style/style.css">
    <script src="https://kit.fontawesome.com/08e5fde617.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>
<body>
    <div class="main-cont">
        <?include('Modules/left-menu.php');?>
        <div class="content-cont">
            <div class="sup-content" style="flex-direction: column;">
                <h1 style="margin-top: 20px;">Поддержка</h1>
                <div class="support-cont">
                    <div class="sup-left-cont">
                        <p class="sup-title">Активные</p>
                        <div class="sup-list">
                            
                        </div>
                    </div>
                    <div class="sup-right-cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    async function LoadReports(){
        if(document.getElementById(".sup-item") != null){
            document.querySelector('.sup-list').innerHTML =``
        }
        $(".sup-list").html("");
        let res = await fetch('/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetActiveReport');
        let posts = await res.json();

        posts.forEach((post) => {
            if(post.Status == 0){
                document.querySelector('.sup-list').innerHTML +=`
                <div class="sup-item" id="sup-tm" style="background-color: #EDF4FC;" onclick="LoadChat(${post.id});">
                    <div class="sup-item-txt">
                        <h1 style="color: #4786D6;">${post.Login}</h1>
                        <p style="color: #4786D6;">${post.Title}</p>
                    </div>
                    <div class="sup-item-arrow">
                        <i class="fa-solid fa-arrow-right fa-xl" style="color: #4786D6;"></i>
                    </div>
                </div>
                `
            }
            else {
                document.querySelector('.sup-list').innerHTML +=`
                <div class="sup-item" id="sup-tm" style="background-color: #FAFAFC;" onclick="LoadChat(${post.id});">
                    <div class="sup-item-txt">
                        <h1>${post.Login}</h1>
                        <p>${post.Title}</p>
                    </div>
                    <div class="sup-item-arrow">
                        <i class="fa-solid fa-arrow-right fa-xl" style="color: black;"></i>
                    </div>
                </div>
                `
            }
            

        });
    }
    LoadReports();
    async function LoadChat(reportId){
        if(document.getElementById("chat-report-top") != null){
            document.querySelector('.sup-right-cont').innerHTML =``
            
        }
        let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/GetInfoOnReport/' + reportId;
        let res = await fetch(url);
        let posts = await res.json();
        CheckReport(reportId);
        if(posts.Answer == ""){
            document.querySelector('.sup-right-cont').innerHTML =`
            <div class="chat-report-top">
                <div class="chat-report-top-txt">
                    <a href=""><i class="fa-solid fa-arrow-left fa-xl"></i></a>
                    <div class="chat-report-top-txts">
                        <h1>${posts.Login}</h1>
                        <p>${posts.StartDate}</p>
                    </div>
                </div>
                <div class="chat-report-top-action">
                    <a href="" onclick="CloseReport(${reportId})"><i class="fa-solid fa-lock fa-xl"></i></a>
                </div>
            </div>
            <div class="chat-report-body">
                <div class="chat-report-message">
                    <p>${posts.Message}</p>
                </div>
            </div>
            <div class="chat-report-footer">
                <textarea name="" id="AnswTxtx"></textarea>
                <a href="" onclick="AddAnswer(${reportId}); return false;"><i class="fa-solid fa-paper-plane fa-xl"></i></a>
            </div>
            `
        }
        else {
            document.querySelector('.sup-right-cont').innerHTML =`
            <div class="chat-report-top">
                <div class="chat-report-top-txt">
                    <a href=""><i class="fa-solid fa-arrow-left fa-xl"></i></a>
                    <div class="chat-report-top-txts">
                        <h1>${posts.Login}</h1>
                        <p>${posts.StartDate}</p>
                    </div>
                </div>
                <div class="chat-report-top-action">
                    <a href="" onclick="CloseReport(${reportId})"><i class="fa-solid fa-lock fa-xl"></i></a>
                </div>
            </div>
            <div class="chat-report-body">
                <div class="chat-report-message">
                    <p>${posts.Message}</p>
                </div>
                <div class="chat-report-answ">
                    <p>${posts.Answer}</p>
                </div>
            </div>
            <div class="chat-report-footer">
                <textarea name="" id="AnswTxtx"></textarea>
                <a href="" onclick="AddAnswer(${reportId}); return false;"><i class="fa-solid fa-paper-plane fa-xl"></i></a>
            </div>
            `
        }
    }
    async function CloseReport(id){
        let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/CloseReport/' + id;
        let res = await fetch(url);

    }
    async function CheckReport(id){
        let url = '/api/3295c76acbf4caaed33c36b1b5fc2cb1/CheckReport/' + id;
        let res = await fetch(url);
        LoadReports();
    }
    async function AddAnswer(repId) {
        const formData = new FormData();
        var text1 = document.getElementById('AnswTxtx').value; 
        formData.append("repid", repId);
        formData.append("answ", text1);

        let response = await fetch('/api/3295c76acbf4caaed33c36b1b5fc2cb1/AddAnswer', {
            method: 'POST',
            body: formData
        });
        LoadChat(repId);
    }
</script>
