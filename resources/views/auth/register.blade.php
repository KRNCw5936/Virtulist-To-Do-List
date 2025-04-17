<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    background: url('{{ asset('assets/image/background-to-do.jpg') }}') no-repeat center center/cover;
}

.wrapper {
    display: flex;
    background: rgba(255, 255, 255, 0.6);
    padding: 40px;
    border-radius: 15px;
    backdrop-filter: blur(5px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 900px;
    max-width: 90%;
    height: auto;
}

.image-container {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-container img {
    width: 100%;
    max-width: 350px;
    height: auto;
    border-radius: 10px;
    object-fit: cover;
}

.container {
    flex: 1.2;
    padding: 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

.app-name {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 2px solid #000;
    border-radius: 5px;
    font-size: 16px;
}

.btn-primary {
    background-color: white;
    color: black;
    padding: 12px 25px;
    border: 2px solid black;
    border-radius: 30px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    width: 100%;
}

.btn-primary:hover {
    background-color: lightgray;
}

a {
    color: blue;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* RESPONSIVE DESIGN */
@media (max-width: 992px) {
    .wrapper {
        flex-direction: column;
        text-align: center;
        width: 95%;
        padding: 30px;
    }
    .image-container {
        order: -1;
        margin-bottom: 20px;
    }
    .image-container img {
        max-width: 280px;
    }
    .container {
        width: 100%;
    }
}
    </style>    
</head>
<body>
    <div class="wrapper">
        <div class="image-container">
            <img src="{{ asset('assets/image/to-do-image.jpg') }}" alt="Register Image">
        </div>
        <div class="container">
            <div class="app-name">VIRTULIST</div>
            <h2>Pendaftaran Akun</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Kata Sandi" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
                <div class="text-center">
                    <p>Sudah punya akun?  <a href="{{ route('login') }}">Masuk di sini!</a></p>
                </div>
            </form>
        </div>
    </div>    
</body>
</html>