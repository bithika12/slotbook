<!DOCTYPE html>
<html>
<head>
    <title>OHhh!!  Something went wrong.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }
        a{
            text-decoration: none;
            color: orange;
            font-weight: bold;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #555555;
            background: #fff;
            display: table;
            font-weight: 600;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }
        p.image{
            margin-bottom: 0;
            margin-top: 0;
        }
        .center-align{
            text-align: center;
        }
        .title {
            font-size: 150%;
            color: grey;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <p class="center-align image">
                <img src="{{ URL::asset('images/technical-error.gif') }}">
            </p>
            <div class="title">If you are coming here several times, don't forget to submit a ticket 
                <a href="{{URL('support')}}">
                here </a>.
            </div>
        </div>
    </div>
</body>
</html>