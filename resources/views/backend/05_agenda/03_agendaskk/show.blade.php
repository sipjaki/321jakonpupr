@include('backend.00_administrator.00_baganterpisah.01_header')

<!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
{{-- ---------------------------------------------------------------------- --}}

@include('backend.00_administrator.00_baganterpisah.04_navbar')
{{-- ---------------------------------------------------------------------- --}}

      @include('backend.00_administrator.00_baganterpisah.03_sidebar')

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">

              <div class="col-sm-12"><h3 class="mb-0">Selamat datang ! <span style="color: black; font-weight:800;" > {{ Auth::user()->name }}</span> di Dashboard <span style="color: black; font-weight:800;"> {{ Auth::user()->statusadmin->statusadmin }} </span>  Sistem Informasi Pembina Jasa Konstruksi Kab Blora</h3></div>

            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>

        <br>
        <!-- Menampilkan pesan sukses -->

        {{-- ======================================================= --}}
        {{-- ALERT --}}

        @include('backend.00_administrator.00_baganterpisah.06_alert')

        {{-- ======================================================= --}}

            <!-- Menyertakan FontAwesome untuk ikon -->

        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row" style="margin-right: 10px; margin-left:10px;">
                <!-- /.card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="card-title" style="color: black;">
                            Data Details :
                            <button class="btn btn-success"
                                    style="background-color: #1d643b; border-color: #1d643b; font-weight: bold; padding: 10px 20px;
                                           border-radius: 5px; font-size: 16px; margin-right: 10px;"
                                    onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#000000'; this.style.borderColor='#1d643b';"
                                    onmouseout="this.style.backgroundColor='#1d643b'; this.style.color='#ffffff'; this.style.borderColor='#1d643b';">
                                {{ $data->namakegiatan }}
                            </button>
                        </h2>
                        <button id="status-{{ $data->id }}" class="btn btn-sm"></button>

                        <script>
                            function updateStatus() {
                                let now = new Date().getTime();
                                let tanggalHabis = new Date("{{ \Carbon\Carbon::parse($data->penutupan)->format('Y-m-d H:i:s') }}").getTime();
                                let statusButton = document.getElementById("status-{{ $data->id }}");

                                // CSS yang digunakan pada tombol
                                let buttonStyle = "font-weight: bold; padding: 10px 20px; border-radius: 5px; font-size: 16px; margin-right: 10px;";

                                if (now > tanggalHabis) {
                                    statusButton.innerText = "DITUTUP";
                                    statusButton.setAttribute("style", buttonStyle + " background-color: red; border-color: red; color: white;"); // Set to red for "TIDAK BERLAKU"
                                    statusButton.className = "btn btn-danger btn-sm"; // Update class for 'danger' status

                                    // Hover effect: keep background white on hover
                                    statusButton.onmouseover = function() {
                                        statusButton.style.backgroundColor = '#ffffff';
                                        statusButton.style.color = '#000000'; // Color becomes black when hovered
                                        statusButton.style.borderColor = 'red'; // Keep red border
                                    };
                                    statusButton.onmouseout = function() {
                                        statusButton.style.backgroundColor = 'red';
                                        statusButton.style.color = 'white'; // Keep white text when mouse out
                                        statusButton.style.borderColor = 'red'; // Keep red border
                                    };
                                } else {
                                    statusButton.innerText = "DIBUKA";
                                    statusButton.setAttribute("style", buttonStyle + " background-color: #1d643b; border-color: #1d643b; color: white;");
                                    statusButton.className = "btn btn-success btn-sm"; // Update class for 'success' status

                                    // Hover effect: keep background white on hover
                                    statusButton.onmouseover = function() {
                                        statusButton.style.backgroundColor = '#ffffff';
                                        statusButton.style.color = '#000000'; // Color becomes black when hovered
                                        statusButton.style.borderColor = '#1d643b'; // Keep original border color
                                    };
                                    statusButton.onmouseout = function() {
                                        statusButton.style.backgroundColor = '#1d643b';
                                        statusButton.style.color = 'white'; // Keep white text when mouse out
                                        statusButton.style.borderColor = '#1d643b'; // Keep original border color
                                    };
                                }
                            }

                            // Jalankan pertama kali saat halaman dimuat
                            updateStatus();

                            // Update setiap 1 detik untuk realtime
                            setInterval(updateStatus, 1000);
                        </script>

                    </div>

                    <div class="col-md-12">
                        <!--begin::Quick Example-->
                        <div class="card card-primary card-outline mb-6">
                            <!--begin::Header-->
                            {{-- <div class="card-header"><div class="card-title">Quick Example</div></div> --}}
                            <!--end::Header-->
                            <!--begin::Form-->

                            <form>
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Left Column (6/12) -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-calendar-event" style="margin-right: 8px; color: navy;"></i> Nama Kegiatan
                                                </label>
                                                <input class="form-control" value="{{$data->namakegiatan}}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-tags-fill" style="margin-right: 8px; color: navy;"></i> Kategori Pelatihan
                                                </label>
                                                <input class="form-control" value="{{$data->kategoripelatihan->kategoripelatihan}}" readonly />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-building" style="margin-right: 8px; color: navy;"></i> Penyelenggara
                                                </label>
                                                <input class="form-control" value="{{$data->penyelenggara}}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-calendar-x-fill" style="margin-right: 8px; color: navy;"></i> Penutupan
                                                </label>
                                                <input class="form-control" value="{{ \Carbon\Carbon::parse($data->penutupan)->translatedFormat('d F Y') }}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-clock-fill" style="margin-right: 8px; color: navy;"></i> Waktu Pelaksanaan
                                                </label>
                                                <input class="form-control" value="{{ \Carbon\Carbon::parse($data->waktupelaksanaan)->translatedFormat('d F Y') }}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-people-fill" style="margin-right: 8px; color: navy;"></i> Jumlah Peserta
                                                </label>
                                                <input class="form-control" value="{{$data->jumlahpeserta}}" readonly/>
                                            </div>
                                        </div>
                                          <!-- End Left Column -->
                                        <!-- Right Column (6/12) -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-geo-alt-fill" style="margin-right: 8px; color: navy;"></i> Lokasi
                                                </label>
                                                <input class="form-control" value="{{$data->lokasi}}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-info-circle-fill" style="margin-right: 8px; color: navy;"></i> Keterangan
                                                </label>
                                                <input class="form-control" value="{{$data->keterangan}}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-journal-text" style="margin-right: 8px; color: navy;"></i> Isi Agenda
                                                </label>
                                                <input class="form-control" value="{{$data->isiagenda}}" readonly/>
                                            </div>

                                            <div class="mb-3">
                                                <img src="{{ asset('storage/' . $data->foto) }}" class="img-fluid rounded" alt="Foto" width="250">
                                            </div>

                                            <div class="mb-3">
                                                <a href="{{ asset('storage/' . $data->materi) }}" class="btn btn-primary" target="_blank">
                                                    <i class="bi bi-file-earmark-text"></i> Lihat Materi
                                                </a>
                                            </div>
                                        </div>
                                                                            </div> <!-- end row -->
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Quick Example-->

                    </div>
                    <!-- /.card -->
                    <!-- Button Section -->
                    <br><br>
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                        <a href="/404">
                            <button
                            onmouseover="this.style.backgroundColor='white'; this.style.color='black';"
                            onmouseout="this.style.backgroundColor='#22C55E'; this.style.color='white';"
                            style="background-color: #22C55E; color: white; border: none; margin-right: 10px; padding: 10px 20px; border-radius: 15px; font-size: 16px; cursor: pointer; display: flex; align-items: center; transition: background-color 0.3s, color 0.3s; text-decoration: none;">
                            <!-- Ikon Kembali -->
                            <i class="fa fa-file" style="margin-right: 8px;"></i>
                            Update
                        </button>
                        </a>
                        <a href="/beagendapelatihan">
                            <button
                            onmouseover="this.style.backgroundColor='white'; this.style.color='black';"
                            onmouseout="this.style.backgroundColor='#374151'; this.style.color='white';"
                            style="background-color: #374151; color: white; border: none; margin-right: 10px; padding: 10px 20px; border-radius: 15px; font-size: 16px; cursor: pointer; display: flex; align-items: center; transition: background-color 0.3s, color 0.3s; text-decoration: none;">
                            <!-- Ikon Kembali -->
                            <i class="fa fa-arrow-left" style="margin-right: 8px;"></i>
                            Kembali
                        </button>
                    </a>
                </div>

                    </div>
                    <!--end::Row-->
                    </div>

        </div>
        <!--end::Row-->
        </div>
                  <!--end::Container-->
        <!--end::App Content Header-->
        <!--begin::App Content-->
          <!--end::App Content-->
      </main>
      <!--end::App Main-->
    </div>
    </div>


      @include('backend.00_administrator.00_baganterpisah.02_footer')
