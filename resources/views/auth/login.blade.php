<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VIRTULIST</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
 * {
    box-sizing: border-box; /* Mencegah ukuran elemen jadi tidak seimbang */
}

body {
    font-family: "Lora", serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    padding: 10px;
}

.wrapper {
    display: flex;
    background: rgba(255, 255, 255, 0.6);
    padding: 50px;
    border-radius: 15px;
    backdrop-filter: blur(5px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 1000px; /* Agar tidak terlalu lebar di layar besar */
    height: auto;
    flex-wrap: wrap; /* Supaya bisa menyesuaikan di layar kecil */
}

.image-container {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

.image-container img {
    width: 90%;
    max-width: 400px; /* Batas maksimal ukuran gambar */
    border-radius: 10px;
}

.container {
    flex: 1;
    padding: 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: auto;
    width: 100%;
}

.app-name {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 2px solid #000;
    border-radius: 5px;
    font-size: 16px;
}

/* Tombol tetap proporsional */
.btn-primary,
.btn-google {
    width: 100%;
    padding: 14px;
    border-radius: 30px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-primary {
    background-color: white;
    color: black;
    border: 2px solid black;
}

.btn-primary:hover {
    background-color: lightgray;
}

.btn-google {
    margin-top: 15px;
    background-color: white;
    border: 2px solid black;
}

.btn-google:hover {
    background-color: lightgray;
}

.btn-google img {
    width: 22px;
    margin-right: 10px;
}

.btn-google span {
    color: black;
    font-weight: bold;
    font-size: 16px;
}

a {
    color: blue;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.password-container {
    position: relative;
}

.eye-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    .wrapper {
        flex-direction: column;
        text-align: center;
        padding: 30px;
    }

    .image-container {
        order: -1; /* Gambar pindah ke atas */
        margin-bottom: 20px;
    }

    .image-container img {
        width: 70%;
        max-width: 300px;
    }

    .container {
        width: 100%;
        padding: 10px;
    }

    .form-control,
    .btn-primary,
    .btn-google {
        font-size: 16px;
        padding: 12px;
    }
}

@media (max-width: 480px) {
    .wrapper {
        padding: 20px;
    }

    .app-name {
        font-size: 24px;
    }

    .form-control,
    .btn-primary,
    .btn-google {
        font-size: 14px;
        padding: 10px;
    }

    .btn-google img {
        width: 18px;
    }
}

    </style>
</head>
<body style="background: url('{{ asset('assets/image/background-to-do.jpg') }}') no-repeat center center/cover;">
    <div class="wrapper">
        <div class="image-container">
            <img src="{{ asset('assets/image/to-do-image.jpg') }}" alt="To Do List">
        </div>
        <div class="container">
            <div class="app-name">VIRTULIST</div>
            @if (session('error'))
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <div style="color: red; font-size: 14px;">{{ $message }}</div>
                @enderror
                
                <div class="password-container">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <i class="eye-icon" id="eye-icon" onclick="togglePassword()">👁️</i>
                </div>
                <p style="text-align: left; margin-top: 5px;">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </p>                
                @error('password')
                    <div style="color: red; font-size: 14px;">{{ $message }}</div>
                @enderror
                
                <button type="submit" class="btn-primary">Login</button>
            </form>
            <div class="text-center">
                <p>Or Login with Google</p>
                <a href="{{ route('auth.google') }}" class="btn-google">
                    <img src="{{ asset('assets/image/google-logo.png') }}" alt="Google Logo">
                    <span>Google</span>
                </a>
            </div>
            <p>Don't have an account? <a href="{{ route('register') }}">Register here!</a></p>
        </div>
    </div>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (email === "" || password === "") {
                alert("Email dan Password harus diisi!");
                return false;
            }
            return true;
        }
        
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.textContent = "🙈";
            } else {
                passwordInput.type = "password";
                eyeIcon.textContent = "👁️";
            }
        }
    </script>
</body>
</html>
