<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0 auto;
            text-align: center;
        }

    </style>
</head>
<body>
@foreach($lists as $list)
    <h2>传智学员信息登记表</h2>
    <p><span>用户登录名：</span>{{$list->username}}</p>
    <p><span>真实姓名：</span>{{$list->real_name}}</p>
    <p><span>真实年龄：</span>{{$list->real_age}}</p>
    <p><span>电子邮箱：</span>{{$list->myemail}}
    </p>
    <p><span>身份证号：</span>{{$list->card}}</p>
    <p><span>手机号码：</span>{{$list->telphone}}</p>
    <p><span>个人主页：</span>{{$list->myurl}}</p>
    <p class="lucky"><span>幸运颜色：</span>
        <input readonly disabled type="color" value="{{$list->lovecolor}}"></p>
    <p><span>学习感言：</span>{{$list->content}}</p>
    <hr>
@endforeach
</body>
</html>
