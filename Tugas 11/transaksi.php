<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi - LaundryCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Crud Laundry</h1>

        <div class="card mb-4">
            <div class="card-header">Tambah Transaksi Baru</div>
            <div class="card-body">
                <form id="formTransaksi">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_konsumen" class="form-label">Nama Konsumen</label>
                            <input type="text" class="form-control" id="nama_konsumen" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori (Cth: Normal, Expert)</label>
                            <input type="text" class="form-control" id="kategori" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="berat" class="form-label">Berat (kg)</label>
                            <input type="number" class="form-control" id="berat" step="0.1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan (per kg)</label>
                            <input type="number" class="form-control" id="harga_satuan" required>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="masuk" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keluar" class="form-label">Tanggal Keluar (Estimasi)</label>
                            <input type="date" class="form-control" id="keluar" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </form>
                <div id="pesan" class="mt-3"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Daftar Transaksi (data dari DB)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Masuk</th>
                                <th>Nama</th>
                                <th>Berat</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody id="tabelDataTransaksi">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchTransaksi();

            document.getElementById('formTransaksi').addEventListener('submit', function(e) {
                e.preventDefault(); 
                tambahTransaksi();
            });
        });

        function fetchTransaksi() {
            fetch('api/get_transaksi.php')
                .then(response => response.json())
                .then(data => {
                    let tabelBody = document.getElementById('tabelDataTransaksi');
                    tabelBody.innerHTML = ''; 

                    if (data.data && data.data.length > 0) {
                        data.data.forEach(trx => {
                            let row = `<tr>
                                <td>${trx.id}</td>
                                <td>${trx.masuk}</td>
                                <td>${trx.nama_konsumen}</td>
                                <td>${trx.berat} kg</td>
                                <td>${trx.kategori}</td>
                                <td>${trx.status}</td>
                                <td>Rp ${trx.harga_total}</td>
                            </tr>`;
                            tabelBody.innerHTML += row;
                        });
                    } else if (data.message) { 
                         tabelBody.innerHTML = `<tr><td colspan="7" class="text-center">${data.message}</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    tabelBody.innerHTML = '<tr><td colspan="7" class="text-center">Gagal memuat data. Periksa koneksi atau API.</td></tr>';
                });
        }

        function tambahTransaksi() {
            const dataKirim = {
                nama_konsumen: document.getElementById('nama_konsumen').value,
                kategori: document.getElementById('kategori').value,
                berat: document.getElementById('berat').value,
                harga_satuan: document.getElementById('harga_satuan').value,
                masuk: document.getElementById('masuk').value,
                keluar: document.getElementById('keluar').value
            };

            fetch('api/create_transaksi.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dataKirim) 
            })
            .then(response => response.json())
            .then(data => {
                let pesanDiv = document.getElementById('pesan');
                if(data.message.includes("berhasil")) {
                     pesanDiv.innerHTML = `<div class="alert alert-success">${data.message} Total: Rp ${data.total_harga_dihitung}</div>`;
                     document.getElementById('formTransaksi').reset(); 
                } else {
                     pesanDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }

                fetchTransaksi(); 

                setTimeout(() => { pesanDiv.innerHTML = ''; }, 3000);
            })
            .catch(error => {
                console.error('Error adding transaksi:', error);
                document.getElementById('pesan').innerHTML = `<div class="alert alert-danger">Gagal menambahkan transaksi. Periksa API.</div>`;
            });
        }
    </script>
</body>
</html>