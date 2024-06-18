@extends('adminlte::page')

@section('title', 'Daftar Kartu')
@section('css')
    <style>
        /* The switch - adapted from https://www.w3schools.com/howto/howto_css_switch.asp */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider (rounded) */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /* Additional styling for the status text */
        #toggleStatus {
            margin-left: 10px;
        }
    </style>
@endsection
@section('content_header')
    <h1>
        Daftar Kartu</h1>
@stop

@section('content')
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">

                    <div class="row my-3">
                        <div class="col-md-12">
                            Scan Kartu
                            <label class="switch">
                                <input id="toggleButton" type="checkbox" onclick="toggleButton()" <?php echo $scan->status == 1 ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                            <span id="toggleStatus"><?php echo $scan->status == 1 ? 'ON' : 'OFF'; ?></span>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table id="table_pasien" class="table table-bordered table-striped"
                                    style="width: 100%; overflow-x: auto">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Kartu</th>
                                            <th>Status</th>
                                            <th>Pasien</th>
                                            {{-- <th>Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($kartu as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->no_kartu }}</td>
                                                <td>
                                                    @if ($data->status == 1)
                                                        <span class="badge badge-success">Terpakai</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Terpakai</span>
                                                    @endif
                                                </td>
                                                <td class="nama">
                                                    @if (!empty($data->nik))
                                                        {{ $data->nik }} - {{ $data->nama }} -
                                                        {{ $data->alamat }}
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <a class="btn btn-danger btn-delete m-2"
                                                        data-id="{{ $data->id }}">Hapus</a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>

                </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            @stop
            @section('footer')
                <div id="mycredit" class="small"><strong> Copyright &copy;
                        <?php echo date('Y'); ?> Sistem Informasi Pelayanan Puskesmas </div>
            @stop

            @section('plugins.Datatables', true)
            @section('plugins.DatatablesPlugin', true)
            @section('plugins.Sweetalert2', true)

            @section('js')
                <script type="text/javascript">
                    function add() {
                        window.location = "{{ route('pasien.create') }}";
                    }
                    $(function() {
                        $("#table_pasien").DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "columnDefs": [{
                                    "width": "2%",
                                    "targets": 0
                                },
                                {
                                    "width": "20%",
                                    "targets": 1
                                },
                                {
                                    "width": "10%",
                                    "targets": 2
                                },
                                {
                                    "width": "58%",
                                    "targets": 3
                                },

                            ]
                        })

                    });

                    $(document).on('click', '.btn-delete', function(e) {
                        e.preventDefault();
                        var id = $(this).data('id');
                        var name = $(this).closest('tr').find('.nama').text();
                        // Fetch CSRF token from the meta tag
                        var token = $('meta[name="csrf-token"]').attr('content');
                        let url = "/pasien/" + id;


                        Swal.fire({
                            title: `Hapus Data Pasien ${name}?`,
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {

                            if (result.value) {

                                $.ajax({
                                    type: "DELETE",
                                    url: url,
                                    data: {
                                        '_token': token
                                    },
                                    success: function(data) {
                                        Swal.fire({
                                            title: 'Berhasil Dihapus!',
                                            type: "success"
                                        });
                                        window.location.reload();
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oops...',
                                            text: error
                                        });
                                    }
                                });
                            }
                        });
                    });


                    function toggleButton() {
                        var toggleStatus = document.getElementById("toggleStatus");
                        var newStatus = toggleStatus.textContent === "OFF" ? "ON" : "OFF";

                        // Make an AJAX request to update the status
                        $.ajax({
                            type: "GET",
                            url: "/scan",
                            data: {
                                status: newStatus
                            },
                            success: function(response) {
                                if (response.status === 1) {
                                    toggleStatus.textContent = "ON";
                                    toggleStatus.setAttribute("checked", "checked");
                                } else {
                                    toggleStatus.textContent = "OFF";
                                    toggleStatus.removeAttribute("checked");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                </script>


            @stop
