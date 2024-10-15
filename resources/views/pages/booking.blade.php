@extends('layouts.app')
@section('content')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Booking</h1>
                    </div>
                </div>
                <div class="col-lg-7"></div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Form Pemesanan</h5>

                            <!-- Button to add item in card header -->
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" id="add-item" class="btn btn-secondary">Tambah Barang</button>
                            </div>

                            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- Pastikan untuk menyertakan token CSRF -->
                                <div id="barang-container" class="mb-4">
                                    <div class="barang-item mb-3">
                                        <label for="barang" class="form-label">Pilih Barang</label>
                                        <select name="barang_ids[]" class="form-select" required>
                                            <option value="" disabled selected>Pilih Barang</option>
                                            @foreach ($barang as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-danger btn-sm remove-item mt-2"
                                            title="Hapus">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="customer" class="form-label">Nama Customer</label>
                                    <input type="text" id="customer" name="customer" class="form-control" required>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="no_hp" class="form-label">Nomor HP</label>
                                    <input type="text" id="no_hp" name="no_hp" class="form-control" required>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="tgl_sewa" class="form-label">Tanggal Sewa</label>
                                        <input type="date" id="tgl_sewa" name="tgl_sewa" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                                        <input type="date" id="tgl_kembali" name="tgl_kembali" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="jaminan_sewa" class="form-label">Jaminan Sewa</label>
                                        <input type="file" id="jaminan_sewa" name="jaminan_sewa" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="uang_dp" class="form-label">Uang DP (optional)</label>
                                        <input type="number" id="uang_dp" name="uang_dp" class="form-control"
                                            min="0">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sisa Bayar:</label>
                                    <span id="sisa_bayar">0</span> <!-- Menampilkan sisa bayar -->
                                </div>

                                <div class="mb-3">
                                    <label for="total_bayar" class="form-label">Total Bayar:</label>
                                    <input type="text" id="total_bayar" name="total_bayar" class="form-control" disabled>
                                </div>



                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery (optional, but makes DOM manipulation easier) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const harga = {!! json_encode($barang->pluck('harga', 'id')) !!}; // Pass harga to the view

            const calculateTotal = () => {
                let total = 0;
                $('select[name="barang_ids[]"]').each(function() {
                    const barangId = $(this).val();
                    if (barangId) {
                        total += parseFloat(harga[barangId]) || 0; // Menambahkan harga barang ke total
                    }
                });
                $('#total_bayar').val(total); // Set input total_bayar dengan nilai total
                updateSisaBayar(); // Update sisa bayar
            };

            const updateSisaBayar = () => {
                const totalBayar = parseFloat($('#total_bayar').val()) || 0; // Selalu gunakan total
                const uangDp = parseFloat($('#uang_dp').val()) || 0;
                const sisaBayar = totalBayar - uangDp; // Hitung sisa bayar
                $('#sisa_bayar').text(sisaBayar >= 0 ? sisaBayar : 0); // Update sisa bayar
            };

            $('#add-item').click(function() {
                $('#barang-container').append(`
                    <div class="barang-item mb-3">
                        <label for="barang" class="form-label">Pilih Barang</label>
                        <select name="barang_ids[]" class="form-select" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-danger btn-sm remove-item mt-2" title="Hapus">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                `);
                calculateTotal(); // Recalculate total when a new item is added
            });

            $(document).on('change', 'select[name="barang_ids[]"]', function() {
                calculateTotal(); // Recalculate total when an item selection changes
            });

            $(document).on('click', '.remove-item', function() {
                $(this).closest('.barang-item').remove();
                calculateTotal(); // Recalculate total when an item is removed
            });

            $('#uang_dp').on('input', function() {
                updateSisaBayar(); // Update remaining payment when DP changes
            });
        });
    </script>
@endsection
