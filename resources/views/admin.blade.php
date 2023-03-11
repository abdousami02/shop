<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  <div class="container mt-5">
    <div class="panel">
      <form action="/login" method="POST" class="login">
        <h3 class="head">Login</h3>
        <div class="name">
          <i class="far fa-user fa-lg icon"></i>
          <input type="text" name="username" placeholder="username" />
        </div>
        <div class="pass">
          <i class="far fa-lock-alt fa-lg icon"></i>
          <input type="password" name="username" placeholder="password" />
        </div>
        <a to="/signUp" href="#" class="forget">Forget Password?</a>
        <button @click.prevent type="botton" class="btn-sub">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
