<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Booking | {{ $judul }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        .welcome-text {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 800px;
            margin-bottom: 20px;
        }

        .btn-submit {
            margin-top: 20px;
        }
    </style>

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>

<body>

    <div class="welcome-text">Selamat Datang di Semesta Outdoor 🌍🌲</div>

    <div class="container">
        <h2 class="text-center">Form Booking</h2>
        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="barang_id" class="form-label">Pilih Barang</label>
                <select name="barang_id" id="barang_id" class="form-select" required>
                    <option selected disabled>--Pilih Barang--</option>
                    @foreach ($barang as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="customer" class="form-label">Nama Customer</label>
                    <input type="text" name="customer" id="customer" class="form-control"
                        placeholder="Masukkan nama customer" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="no_hp" class="form-label">No Hp</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="+628---"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tgl_sewa" class="form-label">Tanggal Sewa</label>
                    <input type="date" name="tgl_sewa" id="tgl_sewa" class="form-control"
                        value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control"
                        value="{{ \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jaminan_sewa" class="form-label">Jaminan Sewa (Upload File)</label>
                    <input type="file" name="jaminan_sewa" id="jaminan_sewa" class="form-control" required>
                    <small class="text-danger">*Format dalam bentuk jpg,png,jpeg</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="uang_dp" class="form-label">Uang DP (Opsional)</label>
                    <input type="text" name="uang_dp" id="uang_dp" class="form-control"
                        placeholder="Masukkan uang DP">
                    <small class="text-danger">*Isi jika anda DP booking</small>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat"
                    required>
            </div>

            <button type="submit" class="btn btn-success btn-submit">Submit Booking</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS (Optional for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            swal({
                                title: "Notifikasi",
                                text: "Pemesanan berhasil! Pesan WhatsApp telah terkirim.",
                                icon: "success",
                                button: false,
                                timer: 3000,
                                position: 'top-end',
                            });
                        } else {
                            swal({
                                title: "Kesalahan",
                                text: "Terjadi kesalahan. Silakan coba lagi.",
                                icon: "error",
                                button: false,
                                timer: 3000,
                                position: 'top-end',
                            });
                        }
                    })
                    .catch(error => {
                        swal({
                            title: "Kesalahan",
                            text: "Terjadi kesalahan. Silakan coba lagi.",
                            icon: "error",
                            button: false,
                            timer: 3000,
                            position: 'top-end',
                        });
                    });
            });
        });
    </script>
</body>

</html>
