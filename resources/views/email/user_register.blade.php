<!DOCTYPE html>
<html>
<head>
    <title>Welcome To Monarch Personnel</title>
</head>

<body>
    
<h2>Welcome To Monarch Personnel</h2>
<br/>
<h2>Hello, {{$user_name}}</h2>
<br/>
Your registered email id is: {{$email_id}}
<br/>
Your Password is: {{$password}}

<br/>
<br/>
<a href="{{ url('/login?ent='.$enterpriseId) }}" class="btn btn-primary">Go To Website</a>
</body>

</html>