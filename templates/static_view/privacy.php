<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .content {
            background-color: rgb(78, 123, 192);
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
        }
        
    </style>
    <title>Document</title>
</head>

<body>
<div class="content shadow-lg p-3 my-5 text-white rounded w-25 text-center mx-auto"></div>
    
        <script>
            let apiKey = 'Ub0G16ItbVaRZYU4kwicYcpSrrebVT9A';
            let cityKey = '31868';
            function weather(cityKey, apiKey, cityName) {
                let builtUrl = `http://dataservice.accuweather.com/currentconditions/v1/${cityKey}?apikey=${apiKey}&language=en-us&details=true`;
                const xml = new XMLHttpRequest();
                xml.open("GET", builtUrl);
                xml.onload = function () {
                    const weatherArray = JSON.parse(xml.responseText);
                    console.log(weatherArray[0].ApparentTemperature.Metric.Value);
                    let content = document.getElementsByClassName('content')[0];
                    content.innerHTML = `                
                    <h1 class="cityName">${cityName}</h1>  
                    <img src="https://developer.accuweather.com/sites/default/files/${('0' + weatherArray[0].WeatherIcon).slice(-2)}-s.png" alt="" width="100%">
                    <p class="temp fs-1"><span class="fw-bold">${weatherArray[0].Temperature.Metric.Value}</span>°C</p>
                    <p class="status fs-2">${weatherArray[0].WeatherText}</p>                
                    <p class="temp fs-3">RealFeel: ${weatherArray[0].RealFeelTemperature.Metric.Value}°C</p>
                    `;
                }
                xml.send();
            }
            weather(cityKey, apiKey, 'Vienna');
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
