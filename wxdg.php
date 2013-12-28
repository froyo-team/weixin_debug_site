<?php
require_once 'WxDebug.class.php';
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $wxDebug = new WxDebug();
    echo $wxDebug->jsonReturnSendMsg(
                                $_POST['ToUserName'],
                                $_POST['FromUserName'],
                                $_POST['MsgType'],
                                $_POST['Content'],
                                $_POST['Host'],
                                $_POST['Port'],
                                $_POST['event']
                                );
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>虚拟微信调用</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="papa">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>
        <script src="./public/js/action.js"></script>
        <link rel="stylesheet" href="./public/css/all.css" type="text/css" media="all">


    </head>
    <body>
        <div data-role="page" >
            <header class="bar" id="AllHead">
                
                <div data-role="header" data-theme="b">
                    <a href="#config" >三</a>
                        <h1>测试消息信息</h1>
                    <a href="#" id="add_contect">关注</a>
                </div>
            </header>

          <div data-role="content" class="content" id="home">
              <section>
                <nav id="chart_log">

                </nav>
             </section>
          </div><!-- /content -->

          <footer class="bar" id="allFoot">
              <div data-role="footer" data-theme="b">
                <div class="chartAction">
                <a href="#" id="send_mage">图片</a>
                <a href="#" id="send_video">视频</a>
                <input type="text" name="Content" id="content_msg">
                <a href="#" id="send">发送</a>

              </div>
          </footer>
        </div>

     
        <div data-role="page" id="config">
            <div data-role="header" data-theme="b">
            <a href="#" data-role="button" data-rel="back">返回</a>
                <h1>基本配置</h1>
            <a href="#" data-role="button" data-rel="save">保存</a>
            </div>
            <form name="wx_debug" id="wx_debug" method="POST">
            <div data-role="content">
                <ul data-role="listview">
                    <li>
                        <label>URL:<label>
                        <input name="Host" type="url" id="url" placeholder="http://" value="">
                    </li>
                    <li>
                        <label>PORT:<label>
                        <input name="Port" type="number" id="port" placeholder="80" value="80">
                    </li>
                    <li>
                        <label>FromeUser:<label>
                        <input name="FromUserName" type="text" id="fromeuser" value="tisa007" placeholder="fromeuser-openid">
                    </li>
                    <li>
                        <label>ToUser:<label>
                        <input name="ToUserName" type="text" id="touser" value="alan" placeholder="touser-openid">
                    </li>
                </ul>
            </div>
  
            <input name="MsgType" type="hidden" value="text" id="msg_type">
            <input name="Event" type="hidden" value="subscribe" id="event">
            <input name="Content" type="hidden" value="" id="send_content">
            </form>

        </div>

    </body>

   
</html>
