<?php
include 'koneksi.php';

// Query untuk mengambil data terbaru terlebih dahulu
$sql = "SELECT * FROM dataudara ORDER BY time DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemantauan</title>
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
            gap: 10px;
            font-size: 1.5rem;
            color: white;
            justify-content: center;
            padding: 20px 0;
            margin-left: 40px;
        }

        .sukeku i {
            font-size: 2.5rem;
            color: #17a2b8;
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
            gap: 10px;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .sidebar ul li a:hover {
            color: #17a2b8;
        }

        .sidebar ul li i {
            font-size: 1.2rem;
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

        .card-header {
            font-size: 1.2rem;
        }

        .table th, .table td {
            vertical-align: middle;
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
        <div class="container mt-4">
            <h1 class="text-center mb-4">Pemantauan Suhu dan Kelembapan Udara Pada Kamar</h1>
            
            <div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>Data Temperature Sensor (TMP36) dan Gas Sensor</span>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari data...">
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Suhu (°C)</th>
                    <th>Kelembapan (%)</th>
                    <th>Kualitas Udara</th>
                    <th>Keterangan</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        $keterangan = $row['udara'] > 500 ? "Buruk" : "Baik";

                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['suhu'] . "</td>";
                        echo "<td>" . $row['kelembapan'] . "</td>";
                        echo "<td>" . $row['udara'] . "</td>";
                        echo "<td>" . $keterangan . "</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data tersedia</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
    <script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataTable tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

            if (rowText.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
