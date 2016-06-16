<html>
    <head>
        <title>使用者登入</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./css/star23ter-template.css" rel="stylesheet">
    </head>
  <body background="pic2.jpg" >

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-inverse">
          <ul class="nav navbar-nav">
            <li><a href="./index.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 使用者登入</a></li>
            <!--<li><a href="./map.php"><span class="glyphicon glyphicon-move" aria-hidden="true"></span> 使用者地圖導覽</a></li>
            <li><a href="./Introduction.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 系統介紹</a></li>-->
            <li class="active"><a class="btn btn-secondary btn-sm" disabled><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span> 註冊帳號</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Username</p>
          </ul>
        </div><!--/.nav-collapse -->
        <div id="navbar" class=""></div>
      </div>
    </nav>

    <!--上列表單201605260249-->


    <br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <div class="container">

        <form action="signup.php" method="POST" class="form-signin" role="form">
            <table align=center style="background-color=#FAFAFA">
            <tbody>
                <tr>
                    <td>
                        <span style="color:orange;">
                            <h2 class="form-signin-heading">加入會員</h2>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>

                            <label for="inputText" class="sr-only">輸入使用者名稱</label>
                        <input type="text" id="username" class="form-control" placeholder="輸入使用者名稱。" size="60%" required="" autofocus=""
                        data-toggle="tooltip" data-placement="right" title="請輸入使用者名稱或真實姓名" name="username">
                            <br/>
                        <label for="inputEmail" class="sr-only" >請輸入E-mail</label>
                        <input type="email" id="userEmail" class="form-control" placeholder="請輸入E-mail" size="60%" required="" autofocus=""
                        data-toggle="tooltip" data-placement="right" title="勿使用他人或無效E-mail，以免帳號遭人使用或更改。" name="userEmail">
                            <br/>
                        <label for="inputPassword" class="sr-only">設定密碼</label>
                        <input type="password" id="Password" class="form-control" placeholder="設定密碼。" size="60%" required="" autofocus=""
                        data-toggle="tooltip" data-placement="right" title="請輸入8~20個英數字的密碼" name="Password">
                            <br/>
                        <label for="inputPassword" class="sr-only">再次設定密碼</label>
                        <input type="password" id="againPassword" class="form-control" placeholder="再次設定密碼。" size="60%" required="" autofocus=""
                        data-toggle="tooltip" data-placement="right" title="再次確認輸入密碼" name="againPassword">
                            <br/>
                    </td>
                </tr>
                <tr>
                    <td align=center>
                      <input type="submit" class="btn btn-success" value="確認送出">
                    </td>
                <tr>

<script src="./js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/tooltip.js"></script>
<script type="text/javascript" src="./js/register.js"></script>
<!--register.js 為引用於javascript -->

                    <!--
                        <div class="input-group" >
                          <div class="input-group-addon">使用者名稱</div>
                            <input type="text" class="form-control" id="inputText" placeholder="Amount" size="60%" required="" autofocus=""
                            data-toggle="tooltip" data-placement="right" title="請輸入常用通訊電話">
                        </div>
                        <br/>
                    -->

</body>