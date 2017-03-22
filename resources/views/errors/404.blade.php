<!DOCTYPE html>
<html>
    <head>
        <title>URL Not Found!</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #fff;
                display: table;
                font-weight: 100;
                background: #C0392B;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                margin-top: 8em;
                display: inline-block;
            }

            .title {
                font-size: 120px;
                margin-bottom: 0;
                font-weight: 700;
                margin-top: 0;
            }
            a{
                font-weight: 700;
            }
            .message{
                font-size: 50px;
            }
            .center-align{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content row">
                <p class="center-align title col s12 m4"><i class="material-icons fa-3x">adb</i></p>
                <div class="message left-align col s12 m7 offset-m1">You seem to have upset the delicate 
                    internal balance of my own housekeeper. If you don't mind, can get back <a class="link pointer white-text" href="{{url('/')}}"<b>here.</b></a></div>
            </div>
        </div>
    </body>
</html>