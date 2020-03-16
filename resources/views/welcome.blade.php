<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>

                <div>
                    <input id="word" type="text">
                    <button onclick="getReply();">送信</button>
                </div>
            </div>
        </div>
        <script>
            function getReply(){
                let comment = document.getElementById('word').value

                // XMLHttpRequestオブジェクトの作成
                let request = new XMLHttpRequest();
                const url = 'https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk';
                const apikey = encodeURIComponent("{{ env('TALK_API_KEY', null)  }}");
                const query = encodeURIComponent(comment);

                // URLを開く
                request.open('POST', url, true);

                // サーバに対して解析方法を指定する
                request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );

                // レスポンスが返ってきた時の処理を記述
                request.onload = function () {
                    const data = JSON.parse(this.response);
                    alert(data.results[0].reply)
                }

                // リクエストをURLに送信
                request.send("apikey=" + apikey + "&query=" + query);
            }

        </script>
    </body>
</html>
