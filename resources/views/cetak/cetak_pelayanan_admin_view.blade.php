@extends('adminlte::page')

@section('title','Pelayanan Pasien')
@section('content_header')
<h1>Pelayanan Pasien</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table id="table_pelayanan" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Tujuan</th>
                                        <th>Keluhan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach ($pelayanan as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') }}</td>
                                        <td>{{ $data->nik }}</td>
                                        <td class="nama">{{ $data->nama }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>{{ $data->tujuan }}</td>
                                        <td>{{ $data->keluhan }}</td>
                                        <td>
                                            {{-- <button class="btn btn-success btn-panggil m-2"
                                                data-id_show="{{ $data->id }}">Panggil</button> --}}
                                            <button class="btn btn-info btn-show m-2"
                                                data-id_show="{{ $data->antrian_id }}">Show</button>
                                            {{-- <button class="btn btn-warning btn-pelayanan m-2"
                                                data-id_pelayanan="{{ $data->pasien_id }}">Pelayanan</button> --}}
                                            {{-- <a class="btn btn-danger btn-delete m-2" data-id="{{$data->id}}">Hapus</a> --}}
                                        </td>
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
                    <?php echo date('Y');?> Sistem Informasi Pelayanan Puskesmas </div>
            @stop

            @section('plugins.Datatables', true)
            @section('plugins.DatatablesPlugin', true)
            @section('plugins.Sweetalert2', true)

            @section('js')
            <script type="text/javascript">
                
                 $(function () {
                    $("#table_pelayanan").DataTable({
                      "paging": true,
                      "lengthChange": false,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false,
                      "responsive": true,  
                      "columnDefs": [
                                        { "width": "2%", "targets": 0 }, 
                                        { "width": "10%", "targets": 1 }, 
                                        { "width": "10%", "targets": 2 }, 
                                        { "width": "20%", "targets": 3 },   
                                        { "width": "20%", "targets": 4 },   
                                        { "width": "10%", "targets": 5 },   
                                        { "width": "10%", "targets": 6 },   
                                    
                                    ],
                      "buttons": [
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3,4,5,6 ]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3,4,5,6 ]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3,4,5,6 ]
                                }
                            }
                        ]
                    }).buttons().container().appendTo('#table_pelayanan_wrapper .col-md-6:eq(0)');
                   
                  });
                

                
            </script>
            <script>
                $(document).on('click', '.btn-show', function (e) {
                     e.preventDefault();
                     var id = $(this).data('id_show');
                     // Fetch CSRF token from the meta tag
                     var token = $('meta[name="csrf-token"]').attr('content');
                     let url = "/pelayanan/" + id;
 
                 
                             $.ajax({
                                 type: "GET",
                                 url: url,
     
                                 success: function (data) {
                                     var pelayanan = data.pelayanan;
                                     Swal.fire({
                                         title: 'Pelayanan Details',
                                         width: '65%',
                                         html: `
                                         <table style="width:100%;text-align:left;">
                                             <tr>
                                                 <th>NIK</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].nik}</td>
                                             </tr>
                                             <tr>
                                                 <th>BPJS</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].bpjs}</td>
                                             </tr>
                                             <tr>
                                                 <th>Nama</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].nama}</td>
                                             </tr>
                                              <tr>
                                                 <th>Jenis Kelamin</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].jen_kel}</td>
                                             </tr>
                                             <tr>
                                                 <th>Tanggal Lahir</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].tgl_lahir}</td>
                                             </tr>
                                              <tr>
                                                 <th>Umur</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].umur}</td>
                                             </tr>
                                             <tr>
                                                 <th>Alamat</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].alamat}</td>
                                             </tr>
                                             <tr>
                                                 <th>Tujuan</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].tujuan}</td>
                                             </tr>
                                             <tr>
                                                 <th>Keluhan</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].keluhan}</td>
                                             </tr>
                                             <tr>
                                                 <th>Catatan</th>
                                                 <td>:</td>
                                                 <td>${pelayanan[0].catatan}</td>
                                             </tr>
                                          
                                            
                                             
                                         </table>
                                         `,
                                         showCloseButton: true,
                                         showConfirmButton: false
                                         // You can customize the modal further as needed
                                     });
                                 },
                                 error: function (xhr, status, error) {
                                     Swal.fire({
                                         type: 'error',
                                         title: 'Oops...',
                                         text: error
                                     });
                                 }
                             });
                 });
             </script>
            @stop