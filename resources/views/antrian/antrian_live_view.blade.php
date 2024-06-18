@php
    $videoDir = public_path('../../public_html/video');
    $videoFiles = scandir($videoDir);
    $videoSources = [];

    foreach ($videoFiles as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
            $videoSources[] = [
                'src' => asset('video/' . $file),
                'name' => pathinfo($file, PATHINFO_FILENAME),
            ];
        }
    }
@endphp
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Add padding to the top of the main content area */
        .main-content {
            padding-top: 100px;
            /* Adjust this value as needed */
        }

        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            /* Change the background color as needed */
            color: white;
            /* Text color */
            text-align: center;
            padding: 10px;
            /* Padding around the text */
            z-index: 1000;
            /* Ensure it's above other content */
        }

        .marquee {
            /* Styles for the marquee text */
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
            animation: marquee 20s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .blink {
            animation: blink 1s infinite;
        }
    </style>
    <title>Live Antrian Puskesmas Brebes</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/logo.png') }}" type="image/png">
</head>

<body>
    <nav v class="navbar fixed-top navbar-light bg-success">
        <div class="container-fluid" style="padding: 0 50px;">
            <!-- Logo on the left -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="" width="100"
                    class="me-2">
            </a>

            <!-- Center-aligned text and additional text at the bottom -->
            <div class="d-flex flex-column justify-content-center align-items-center text-white text-center">
                <h1 class="m-0" style="font-size: 3rem">Puskesmas Brebes</h1>
                <div class="d-none d-lg-block mt-2">
                    <p class="m-0">No. Telp: 123-456-7890</p>
                    <p class="m-0">Alamat: Jl. Contoh No. 123, Brebes</p>
                </div>
            </div>

            <!-- Logo on the right -->
            <a class="navbar-brand d-flex align-items-center justify-content-end" href="#">
                <img src="{{ asset('vendor/adminlte/dist/img/bakti.png') }}" alt="" width="100"
                    class="me-2">
            </a>
        </div>
    </nav>
    <div class="m-5  main-content">
        <div class="row">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>AGENDA</h5>
                    </div>
                    <div class="card-body " style="min-height: 30%;">
                        <video id="videoPlayer" width="100%" controls controlsList="nodownload" autoplay>
                            <source src="<?php echo $videoSources[0]['src']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>ANTRIAN</h5>
                    </div>
                    <div class="card-body text-center" style="min-height: 30%; font-weight: bold; font-size: 6em">
                        <div id="no_antrian">{{ $nextNoAntrian->no_antrian ?? "-" }}</div>
                        <table style="border-collapse: collapse;" class="mt-3">
                            <tr>
                                <td style="border: none; font-size: 25px; text-align: left; vertical-align: top;"
                                    width="20%">Nama</td>
                                <td style="border: none; font-size: 25px; text-align: left; vertical-align: top;"
                                    width="5%">:</td>
                                <td style="border: none; font-size: 25px; text-align: left; vertical-align: top;"
                                    width="75%" id="nama">{{ $nextNoAntrian->nama ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td style="border: none; font-size: 25px; text-align: left; vertical-align: top;">Alamat
                                </td>
                                <td style="border: none; font-size: 25px; text-align: left; vertical-align: top;">:</td>
                                <td style="border: none; font-size: 25px; text-align: left; vertical-align: top;"
                                    id="alamat">
                                    {{ $nextNoAntrian->alamat ?? "-" }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-success text-white text-center">
        <div class="marquee">
            <strong>Himbauan:</strong> Untuk kesehatan dan keselamatan bersama, mohon tetap menjaga jarak, mencuci
            tangan, dan memakai masker saat berada di Puskesmas. Terima kasih atas kerjasama Anda.
        </div>
    </footer>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        const videoSources = <?php echo json_encode($videoSources); ?>;
        const videoPlayer = document.getElementById('videoPlayer');
        let currentVideoIndex = 0;

        videoPlayer.addEventListener('ended', () => {
            currentVideoIndex = (currentVideoIndex + 1) % videoSources.length;
            videoPlayer.src = videoSources[currentVideoIndex].src;
            videoPlayer.play();
        });



        // Set the initial video source and name
        videoPlayer.src = videoSources[currentVideoIndex].src;
        videoPlayer.play();


        function fetchData() {
            var initialNoAntrian = $('#no_antrian').text();

            $.ajax({
                url: '/live/1', // Replace 'your-route' and '{id}' with your actual route and ID
                method: 'GET',
                success: function(response) {
                    if (response.no_antrian != initialNoAntrian) {
                        // Update the DOM with the new data
                        $('#no_antrian').text(response.no_antrian);
                        $('#nama').text(response.nama);
                        $('#alamat').text(response.alamat);

                        // Add a class to make the elements blink
                        $('#no_antrian, #nama, #alamat').addClass('blink');

                        // Remove the class after a short delay (e.g., 1 second)
                        setTimeout(function() {
                            $('#no_antrian, #nama, #alamat').removeClass('blink');
                        }, 1000);
                    }

                    // Call the function again after a delay (e.g., 5 seconds) for long polling
                    setTimeout(fetchData, 1000);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                    // Retry fetching data after a delay (e.g., 5 seconds)
                    setTimeout(fetchData, 1000);
                }
            });
        }
        $(document).ready(function() {
            fetchData(); // Initial call to start fetching data
        });
    </script>
</body>

</html>
