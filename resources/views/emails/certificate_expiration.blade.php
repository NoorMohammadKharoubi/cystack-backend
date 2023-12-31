<html lang="en">
<body>
    <p>Dear {{$notification->subscriber->email}}</p>
    <p>{{$notification->certificate->name_value}} certificate will be ended at {{$notification->certificate->not_after}}</p>
    <a href="https://crt.sh/?q={{$notification->certificate->id}}">Go to Certificate Details</a>
    <p>thanks</p>
</body>
</html>
