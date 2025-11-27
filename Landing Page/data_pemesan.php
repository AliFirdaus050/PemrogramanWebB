<?php
include 'koneksi.php'; 

$sql = "SELECT * FROM pemesanan_tiket ORDER BY waktu_pemesanan DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemesan Tiket - Museum Siola</title>
    <style>
        body { font-family: 'Poppins', sans-serif; padding: 20px; background-color: #f4f4f4; }
        h1 { text-align: center; color: #333; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #0077cc; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .btn-back { display: inline-block; padding: 10px 20px; background: #333; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .btn-back:hover { background: #555; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="btn-back">← Kembali ke Form</a>
    <h1>Daftar Pemesan Tiket</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Tanggal Kunjungan</th>
                <th>Jumlah</th>
                <th>Waktu Pesan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . date('d-m-Y', strtotime($row['tanggal_kunjungan'])) . "</td>
                            <td>" . $row['jumlah_tiket'] . " Tiket</td>
                            <td>" . $row['waktu_pemesanan'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center'>Belum ada data pemesan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>