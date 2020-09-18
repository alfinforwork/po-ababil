<?php
require_once('./connect.php');
$id_sopir = $_GET['id_sopir'];
$id_mobil = $_GET['id_mobil'];
$q = $con->query("SELECT * from lokasi join mobil on lokasi.id_mobil = mobil.id_mobil  where lokasi.id_sopir='$id_sopir' and lokasi.id_mobil='$id_mobil' limit 1 ");
$data = $q->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test map</title>
    <!--  -->

    <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
    <script src='system/js/axios.min.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />

    <!--  -->
</head>

<body>
    <h1 style="text-align: center;">Tracking map</h1>
    <p style="text-align: center;"><?= "$data->merk | $data->ket_mobil" ?></p>
    <div id='map' style='width: 80%; height: 80vh; margin: auto;'></div>
    <script>
        navigator.geolocation.getCurrentPosition(function(position) {
            mapboxgl.accessToken =
                'pk.eyJ1IjoiYWxmaW5mb3J3b3JrIiwiYSI6ImNrZjUzdWpvbzBhMzIzNHFmNzdxNWZtc28ifQ.pOrZhTiM6kMdOFhWp4kLrw';
            // 
            // var lat = -7.92532900972418;
            // var long = 110.38955489092359;
            var lat = <?= $data->latitude ?>;
            var long = <?= $data->longitude ?>;
            // 
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [long, lat],
                zoom: 13
            });
            var marker = new mapboxgl.Marker()
                .setLngLat([long, lat])
                .addTo(map);
            setInterval(async () => {
                var res = await axios.get('api-realtime.php?id_sopir=<?= $id_sopir ?>&id_mobil=<?= $id_mobil ?>');
                console.log(res.data);
                lat = res.data.latitude;
                long = res.data.longitude;
                // lat = lat + 0.001;
                // long = long + 0.001;
                map.flyTo({
                    center: [long, lat],
                });
                marker.setLngLat([long, lat])
                console.log(lat + " " + long);
            }, 2000);
        })
    </script>

</body>

</html>