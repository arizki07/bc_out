<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Booking |</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 900px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h1 {
            margin-top: 0;
            color: #4facfe;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .row .column {
            flex-basis: calc(50% - 20px);
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .text-danger {
            color: red;
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }

            .row .column {
                flex-basis: 100%;
            }
        }
    </style>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>

<body>

    <div class="container">
        <h1>Selamat Datang di Halaman Booking</h1>
        <h2>Form Booking</h2>
        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="column">
                <label for="barang_id">Pilih Barang</label>
                <select name="barang_id" id="barang_id" required>
                    <option selected disabled>--Pilih Barang--</option>
                    @foreach ($barang as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Row 1: Barang dan Customer -->
            <div class="row">
                <div class="column">
                    <label for="customer">Nama Customer</label>
                    <input type="text" name="customer" id="customer" placeholder="Masukkan nama customer" required>
                </div>
                <div class="column">
                    <label for="no_hp">No Hp</label>
                    <input type="text" name="no_hp" id="no_hp" placeholder="+628---" required>
                </div>
            </div>

            <!-- Row 2: Alamat dan Tanggal Sewa -->
            <div class="row">
                <div class="column">
                    <label for="tgl_sewa">Tanggal Sewa</label>
                    <input type="date" name="tgl_sewa" id="tgl_sewa" required>
                </div>
                <div class="column">
                    <label for="tgl_kembali">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" required>
                </div>
            </div>

            <!-- Row 3: Jaminan Sewa (File Upload) -->
            <div class="row">
                <div class="column">
                    <label for="jaminan_sewa">Jaminan Sewa (Upload File)</label>
                    <input type="file" name="jaminan_sewa" id="jaminan_sewa" required>
                </div>
                <div class="column">
                    <label for="uang_dp">Uang DP (opsional)</label>
                    <input type="text" name="uang_dp" id="uang_dp" placeholder="Masukkan uang DP">
                    <small class="text-danger">*Isi jika anda Dp</small>
                </div>
            </div>

            <!-- Row 4: Alamat -->
            <div class="column">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Submit Booking</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman formulir default

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tampilkan notifikasi menggunakan SweetAlert
                            showNotification('Pemesanan berhasil! Pesan WhatsApp telah terkirim.');
                        } else {
                            showNotification('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    })
                    .catch(error => {
                        showNotification('Terjadi kesalahan. Silakan coba lagi.');
                        console.error('Error:', error);
                    });
            });

            function showNotification(message) {
                // Menggunakan SweetAlert untuk menampilkan notifikasi
                swal({
                    title: "Notifikasi",
                    text: message,
                    icon: "success",
                    button: false,
                    timer: 3000, // Notifikasi akan hilang setelah 3 detik
                    position: 'top-end', // Posisi di pojok kanan atas
                    className: "sweet-alert-custom" // Kelas kustom untuk styling
                });

                // Refresh halaman setelah notifikasi menghilang
                setTimeout(() => {
                    location.reload();
                }, 3100); // Waktu tunggu untuk refresh (3 detik + 100 ms untuk memberi waktu notifikasi menghilang)
            }
        });
    </script>

    <style>
        .sweet-alert-custom {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>

</body>

</html>
