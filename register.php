<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background: url("gedung.png") no-repeat center center fixed;
      background-size: cover;
      font-family: "Poppins", sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(255, 255, 255, 0.45);
      backdrop-filter: blur(6px);
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(40px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .register-container {
      position: relative;
      z-index: 5;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 45px 50px;
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.25);
      width: 100%;
      max-width: 450px;
      text-align: center;
      animation: fadeInUp 1s ease both;
    }

    .logo {
      width: 100px;
      height: auto;
      margin-bottom: 8px;
      animation: fadeInUp 1.2s ease both;
    }

    h2 {
      margin-bottom: 25px;
      color: #1c1c1c;
      font-size: 28px;
      font-weight: 700;
      letter-spacing: 1px;
      margin-top: 5px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      align-items: center;
    }

    input {
      width: 100%;
      padding: 14px 17px;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.9);
      font-size: 16px;
      transition: 0.3s;
    }

    input:focus {
      outline: none;
      box-shadow: 0 0 0 2px #00c46a;
      background: white;
    }

    button {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #28a745, #00d084);
      color: white;
      font-size: 17px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
    }

    button:hover {
      background: linear-gradient(135deg, #218838, #00b36b);
      transform: translateY(-1px);
    }

    .note {
      margin-top: 18px;
      font-size: 14px;
      color: #333;
      opacity: 0;
      animation: fadeInUp 1s ease 0.4s forwards;
    }

    a {
      color: #007bff;
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .register-container {
        padding: 35px 30px;
        max-width: 90%;
      }
      .logo {
        width: 80px;
        margin-bottom: 6px;
      }
      h2 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Register</h2>

  <form id="registerForm">
  <input type="text" name="username" placeholder="Username" required />
  <input type="email" name="email" placeholder="Email Address" required />
  <input type="password" name="password" placeholder="Password" required />
  <button type="submit">Daftar</button>
 </form>

    <p class="note">Sudah punya akun? <a href="login.php">Login</a></p>
  </div>

<script>
document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Mencegah reload halaman

    let formData = new FormData(this);

    fetch("proses_register.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            alert("Akun berhasil dibuat!");
            window.location.href = "login.php";
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        alert("Terjadi kesalahan koneksi!");
    });
});
</script>

</body>
</html>
