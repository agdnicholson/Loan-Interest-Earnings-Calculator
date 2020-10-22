<html>
    <head>
        <title>Loan Interest Earnings Calculator</title>
        <!-- CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1>Loan Interest Earnings Calculator</h1>
                <h3 class="mb-5">Earnings for {{$monthStr}} {{$year}}</h3>
                @foreach ($interestAmounts as $name => $amount) 
                    <p>{{ $name }} earns &pound;{{ $amount }}</p>
                @endforeach
            </div>
        </div>
    </body>
</html>