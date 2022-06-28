<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cut links</title>

    <!-- CUSTOM STYLES -->
    <link rel="stylesheet" href="/css/main.css">

    <!-- BOOTSTRAP STYLES/ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <!-- JQUERY SCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">

    <h1>Cut your link</h1>


    @if(isset($url) && $url)
        <div class="alert alert-success" role="alert">
            Link cutted successfully! <a href="{{$url}}">{{$url}}</a>
        </div>
    @elseif(!empty($error_messages))
        <div class="alert alert-warning" role="alert">
            @foreach ($error_messages as $error)
                {{$error}}<br>
            @endforeach
        </div>
    @endif


    <form action="{{route('create.link')}}" method="POST" class="row shadow-sm border rounded p-3 bg-light">
        @csrf

        <div class="form-group col-12 mb-3">
            <label for="original_address" class="form-label">Link <span class="text-danger">*</span>: </label>
            <div class="input-group">
                <textarea name="original_address" class="form-control" id="original_address"
                          placeholder="https://www.google.com" rows="3"></textarea>
            </div>
        </div>

        <div class="col-6">
            <label for="transitions_count" class="form-label">Max count of transitions (0 - unlimited)<span
                    class="text-danger">*</span>: </label>
            <div class="input-group">
                <input value="0" onkeypress='validate(event)' placeholder="1000" type="number" min="0"
                       class="form-control" id="transitions_count" name="transitions_count">
            </div>
        </div>

        <div class="col-6">
            <label for="expiration_date" class="form-label">Expiration date of link, max 24h (
                max {{date("Y-m-d H:i", strtotime('+24 hours'))}} )<span class="text-danger">*</span>: </label>
            <div class="input-group">
                <input min="{{date('Y-m-d H:i')}}" max="{{date("Y-m-d H:i", strtotime('+2 days'))}}"
                       id="expiration_date" type="datetime-local" class="form-control" value="{{date('Y-m-d H:i')}}"
                       name="expiration_date">

            </div>
        </div>


        <div class="col-auto mt-2">
            <button type="submit" class="btn btn-primary mb-3">Cut link</button>
        </div>
    </form>

</div>

<!-- BOOTSTRAP SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy"
        crossorigin="anonymous"></script>
<!-- PERSONAL SCRIPT -->
<script>
    //For only numbers in input
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
</body>
</html>
