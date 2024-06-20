<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body.email {
            background-color: black;
            text-align: center;
            color: white;
        }

        .email h4 {
            display: inline-block;
            font-size: 28px;
            font-family: "Roboto", sans-serif;
            font-weight: bold;
            margin:0 auto 5%;
            background: linear-gradient(90deg, #58c6ff 0%, #076ad9 40%, #ff3bef 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .kredo {
            text-align: end;
        }

        .start {
            text-decoration: none;
            color: #ff3bef;
        }

        </style>
</head>

<body class="email">
    {{-- <p>Hello {{ $name }}!</p> --}}
    <h4>Welcome {{ $name }} to Kredo Instagram!</h4>
    <p>Thank you for registering. Ready for a new adventure? <a href="{{ $app_url }}" class="start">Start it NOW!</a> <br>
    We hope you enjoy our service!</p>
    <p class="kredo">&copy;Kredo Instagram</p>
</body>
</html>
