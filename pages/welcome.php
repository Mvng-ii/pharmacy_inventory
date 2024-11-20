<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">
  <title>WELCOME PAGE</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      background: url('../images/Medical.jpeg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .topnav {
      width: 100%;
      position: fixed;
      top: 0;
      z-index: 9999;
      background-color: rgba(0, 0, 0, 0.6);
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      color: white;
      font-size: 40px;
    }

    nav ul {
      margin: 0;
      padding: 0;
      display: flex;
      list-style-type: none;
    }

    nav ul li {
      padding: 10px 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    nav ul li a:hover {
      color: #ea1538;
      transition: 0.3s;
    }

    button {
      border: none;
      background: red;
      padding: 12px 30px;
      border-radius: 30px;
      color: white;
      font-weight: bold;
      font-size: 15px;
      transition: 0.4s;
    }

    button:hover {
      background-color: green;
      cursor: pointer;
    }

    .main-content {
      flex: 1;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin-top: 100px;
      padding: 20px;
    }

    .main-content h1 {
      color: white;
      font-size: 2.7rem;
      font-family: 'Libre Baskerville', serif;
    }

    .main-content p {
      color: white;
      font-size: 1rem;
      margin: 20px 0;
    }

    .social-media {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px 0;
    }

    .social-media img {
      width: 55px;
      height: 55px;
      margin: 0 10px;
    }

    .footer {
      background-color: #001C30;
      padding: 20px;
      text-align: center;
      color: white;
    }

    .footer h2 {
      font-size: 2rem;
      margin: 0;
    }

    .footer p {
      margin: 10px 0 0 0;
    }
  </style>
</head>
<body>

<div class="topnav">
  <h2 class="logo">Neta Pharmacy</h2>

  <button onclick="redirectToLogin()">Login</button>
</div>

<div class="main-content">
  <h1>Welcome to Neta Pharmacy</h1>
  <p>Your all-in-one solution for pharmacy and medical care.</p>
  <button onclick="redirectToRegister()">Sign Up for Free</button>

  <div class="social-media">
    <a href="https://www.instagram.com/accounts/login/" target="_blank">
      <img src="../images/instagram.png" alt="Instagram">
    </a>
    <a href="https://www.tiktok.com/login" target="_blank">
      <img src="../images/tiktok.png" alt="TikTok">
    </a>
    <a href="https://www.facebook.com/login/" target="_blank">
      <img src="../images/facebook.png" alt="Facebook">
    </a>
    <a href="https://twitter.com/i/flow/login" target="_blank">
      <img src="../images/x.png" alt="Twitter">
    </a>
  </div>
</div>

<div class="footer">
  <h2>Neta Pharmacy</h2>
  <p>All you need in one pharmacy. © 2023 Neta Pharmacy</p>
</div>

<script>
  function redirectToLogin() {
    window.location.href = "login.php";
  }

  function redirectToRegister() {
    window.location.href = "register.php";
  }
</script>

</body>
</html>
