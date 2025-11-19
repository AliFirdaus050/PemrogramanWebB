<?php

include_once '../koneksi.php';

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->nama_konsumen) &&
    !empty($data->berat) &&
    !empty($data->kategori) &&
    !empty($data->harga_satuan) &&
    !empty($data->masuk) &&
    !empty($data->keluar)
    ) {
    try {
        $harga_total = (int)$data->berat * (int)$data->harga_satuan;

        $query = "INSERT INTO transaksi 
                    (masuk, keluar, nama_konsumen, berat, kategori, status, harga_satuan, harga_total) 
                  VALUES 
                    (:masuk, :keluar, :nama_konsumen, :berat, :kategori, 'Belum Diambil', :harga_satuan, :harga_total)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":masuk", $data->masuk);
        $stmt->bindParam(":keluar", $data->keluar);
        $stmt->bindParam(":nama_konsumen", $data->nama_konsumen);
        $stmt->bindParam(":berat", $data->berat);
        $stmt->bindParam(":kategori", $data->kategori);
        $stmt->bindParam(":harga_satuan", $data->harga_satuan);
        $stmt->bindParam(":harga_total", $harga_total);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array(
                "message" => "Transaksi berhasil ditambahkan.",
                "total_harga_dihitung" => $harga_total
            ));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Gagal menambahkan transaksi."));
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Error: " . $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Data tidak lengkap. Semua field wajib diisi."));
}

?>
