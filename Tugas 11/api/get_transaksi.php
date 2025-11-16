<?php

include_once '../koneksi.php';

try {
    $query = "SELECT id, masuk, keluar, nama_konsumen, berat, kategori, status, harga_total 
              FROM transaksi 
              ORDER BY masuk DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $transaksi_arr = array();
        $transaksi_arr["data"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $transaksi_item = array(
                "id" => $id,
                "masuk" => $masuk,
                "keluar" => $keluar,
                "nama_konsumen" => $nama_konsumen,
                "berat" => $berat,
                "kategori" => $kategori,
                "status" => $status,
                "harga_total" => $harga_total
            );

            array_push($transaksi_arr["data"], $transaksi_item);
        }

        http_response_code(200);
        echo json_encode($transaksi_arr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "Data transaksi tidak ditemukan.")
        );
    }

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(
        array("message" => "Gagal mengambil data: " . $e->getMessage())
    );
}
?>