<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta charset="UTF-8">
    <title>InterCityXpress</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('icons/favicon.png') }}">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
        /*body { background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);}*/
        .error-template {padding: 10px 15px;text-align: center;}
        .error-actions {margin-top:15px;margin-bottom:15px;}
        .error-actions .btn { margin-right:10px; }

        .home-btn{
            background: #F1831F;
            border: none;
        }
        .img-div{
            padding-top: 2rem;
            text-align: center;
        }
        .img-logo{
            width: 15%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="img-div">
                <img src="{{ asset('icons/logo.jpg') }}" alt="logo" class="img-logo">
            </div>
            <div class="error-template">
                <h1 style="color: #F1831F">Email Verification Success!</h1>
                <div class="error-details text-black" style=" font-weight: bold; font-size: 16px;">
                    <p>
                        Your email has been successfully verified. <br>
                        We shall use the new email ID for any communication with you. 
                    </p>
                </div>
                <div class="error-actions">
                    <a href="https://www.interpay.sa" class="btn btn-primary home-btn">
                        <span class="glyphicon glyphicon-home"></span>
                        Take Me Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>