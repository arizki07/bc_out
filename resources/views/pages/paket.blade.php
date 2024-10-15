@extends('layouts.app')
@section('content')
    <style>
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <div style="background-color: #3b5d50; padding: 50px 0;">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-lg-7 d-flex flex-column align-items-center">
                    <div class="hero-img-wrap mb-4"
                        style="position: relative; width: 280px; height: 280px; border-radius: 50%; 
                        background: linear-gradient(135deg, #fe0606, #071de5, #f6f7f6); 
                        background-size: 300% 300%; 
                        animation: gradientMove 5s ease infinite; 
                        display: flex; justify-content: center; align-items: center;">
                        <img src="{{ asset('assets/images/bg.jpg') }}" class="img-fluid"
                            style="border-radius: 50%; object-fit: cover; width: 240px; height: 240px;">
                    </div>
                    <div class="intro-excerpt text-white">
                        <h1>SEMESTAA OUTDOOR</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Pricing Section -->
    <div class="container my-5">
        <div class="row justify-content-center">
            @foreach ($paketBarang as $paket => $barangs)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body text-center d-flex flex-column">

                            <!-- Gambar paket -->
                            <img src="{{ asset('assets/images/bg.jpg') }}" class="img-fluid mx-auto mb-3"
                                style="border-radius: 50%; object-fit: cover; width: 150px; height: 150px;"
                                alt="Image for {{ $paket }}">

                            <!-- Nama Paket -->
                            <h4 class="card-title">{{ $paket }}</h4>

                            <!-- Harga Paket -->
                            <p class="card-text display-6 mb-3">
                                <span class="text-dark">{{ $hargaPaket[$paket] }}</span>
                            </p>

                            <!-- Tampilkan barang untuk paket ini -->
                            <ul class="list-unstyled mb-4">
                                @foreach ($barangs as $barang)
                                    <li>{{ $barang->nama_barang }}</li>
                                @endforeach
                            </ul>

                            <!-- Tombol Pesan -->
                            <button type="button" class="btn btn-primary open-modal" data-paket="{{ $paket }}"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('paket.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Nama Customer dan No HP -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="customer" class="form-label">Nama Customer</label>
                                    <input type="text" class="form-control" id="customer" name="customer" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                </div>
                            </div>
                        </div>

                        <!-- Jaminan Sewa -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="jaminan_sewa" class="form-label">Upload Jaminan Sewa</label>
                                <input type="file" class="form-control" id="jaminan_sewa" name="jaminan_sewa" required>
                            </div>
                        </div>


                        <div class="row">
                            <!-- Tanggal Sewa dan Tanggal Kembali -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="tgl_sewa" class="form-label">Tanggal Sewa</label>
                                    <input type="date" class="form-control" id="tgl_sewa" name="tgl_sewa" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                                    <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Paket dan Total Bayar -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="paket" class="form-label">Paket</label>
                                    <input type="text" class="form-control" id="paket" name="paket" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="text" class="form-control" id="total_bayar" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <!-- Alamat -->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('exampleModal');

            modal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = event.relatedTarget;

                // Extract info from data-paket attribute
                var paket = button.getAttribute('data-paket');

                // Find the package price
                var hargaPaket = {
                    "Paket A": 80000,
                    "Paket B": 60000,
                    "Paket C": 90000,
                    "Paket D": 55000,
                    "Paket E": 40000,
                    "Paket F": 40000
                };

                // Update the modal's content with the selected package
                var inputPaket = document.getElementById('paket');
                var inputTotalBayar = document.getElementById('total_bayar');

                // Set form inputs based on the selected package
                inputPaket.value = paket;
                inputTotalBayar.value = hargaPaket[paket];
            });
        });
    </script>
@endsection
