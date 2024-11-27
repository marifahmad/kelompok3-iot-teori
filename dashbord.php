<?php
// Sertakan koneksi ke database
session_start(); 
include 'koneksi.php';

// Query untuk mendapatkan data terakhir dari tabel dataudara
$sql = "SELECT * FROM dataudara ORDER BY time DESC LIMIT 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Udara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #9face6);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .sukeku {
    display: flex;
    align-items: center;
    gap: 10px; /* Jarak antara ikon dan teks */
    font-size: 1.5rem; /* Ukuran judul */
    color: white;
    justify-content: center;
    padding: 20px 0;
    margin-left: 40px;
}

.sukeku i {
    font-size: 2.5rem; /* Ukuran ikon */
    color: #17a2b8; /* Warna ikon */
}



        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
        }

        .sidebar.hidden {
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        .sidebar h3 {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #495057;
        }

        .sidebar ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar ul li {
            padding: 15px 20px;
        }

        .sidebar ul li a {
    display: flex;
    align-items: center;
    gap: 10px; /* Jarak antara ikon dan teks */
    font-size: 1rem;
    color: white;
    text-decoration: none;
    transition: color 0.2s ease;
}
.sidebar ul li a:hover {
    color: #17a2b8; /* Warna saat hover */
}
.sidebar ul li i {
    font-size: 1.2rem; /* Ukuran ikon */
}


        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .display-4 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    
    <div class="sidebar" id="sidebar">
    <h3 class="sukeku">
    SUKEKU <i class="fas fa-wind"></i> 
</h3>

    <ul>
        <li>
            <a href="dashbord.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="index.php">
                <i class="fas fa-database"></i> Detail Data
            </a>
        </li>
        <li>
            <a href="login.php">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </li>
        <li>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>


    <div class="main-content" id="main-content">
        <div class="container text-center">
            <h1 class="mb-4 text-primary">Monitoring Suhu, Kelembapan, dan Kualitas Udara Pada Kamar</h1>
            
            <div class="row justify-content-center">
                <!-- Kartu untuk Suhu -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-thermometer-half fa-3x text-danger mb-3"></i>
                            <h3 class="card-title text-danger">Suhu</h3>
                            <p class="display-4">
                                <?= isset($data['suhu']) ? $data['suhu'] . " °C" : "N/A"; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Kartu untuk Kelembapan -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-tint fa-3x text-success mb-3"></i>
                            <h3 class="card-title text-success">Kelembapan</h3>
                            <p class="display-4">
                                <?= isset($data['kelembapan']) ? $data['kelembapan'] . " %" : "N/A"; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Kartu untuk Kualitas Udara -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-smog fa-3x text-info mb-3"></i>
                            <h3 class="card-title text-info">Kualitas Udara</h3>
                            <p class="display-4">
                                <?= isset($data['udara']) ? $data['udara'] : "N/A"; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-muted mt-3">Data terakhir diperbarui: 
                <?= isset($data['time']) ? $data['time'] : "Tidak ada data"; ?>
            </p>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('full-width');
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
