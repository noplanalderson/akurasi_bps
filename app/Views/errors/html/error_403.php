<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url('_/img/favicon.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo site_url('_/img/favicon.png'); ?>">
    <title>403 - Forbidden</title>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Share+Tech+Mono|Montserrat:700");

        * {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
            box-sizing: border-box;
            color: inherit;
        }

        body {
            background-image: linear-gradient(120deg, #4f0088 0%, #000000 100%);
            height: 100vh;
        }

        h1 {
            font-size: 45vw;
            text-align: center;
            position: fixed;
            width: 100vw;
            z-index: 1;
            color: #ffffff26;
            text-shadow: 0 0 50px rgba(0, 0, 0, 0.07);
            top: 50%;
            transform: translateY(-50%);
            font-family: "Montserrat", monospace;
        }

        div {
            background: rgba(0, 0, 0, 0);
            width: 70vw;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 auto;
            padding: 30px 30px 10px;
            box-shadow: 0 0 150px -20px rgba(0, 0, 0, 0.5);
            z-index: 3;
        }

        P {
            font-family: "Share Tech Mono", monospace;
            color: #f5f5f5;
            margin: 0 0 20px;
            font-size: 17px;
            line-height: 1.2;
        }

        span {
            color: #f0c674;
        }

        i {
            color: #8abeb7;
        }

        div a {
            text-decoration: none;
        }

        b {
            color: #81a2be;
        }

        a.avatar {
            position: fixed;
            bottom: 15px;
            right: -100px;
            animation: slide 0.5s 4.5s forwards;
            display: block;
            z-index: 4
        }

        a.avatar img {
            border-radius: 100%;
            width: 44px;
            border: 2px solid white;
        }

        @keyframes slide {
            from {
                right: -100px;
                transform: rotate(360deg);
                opacity: 0;
            }
            to {
                right: 15px;
                transform: rotate(0deg);
                opacity: 1;
            }
        }

    </style>
</head>
<body>
<h1>403</h1>
<div><p>> <span>ERROR CODE</span>: "<i>HTTP 403 Forbidden</i>"</p>
<p>> <span>ERROR DESCRIPTION</span>: "<i>Access Denied. You Do Not Have The Permission To Access This Page On This Server</i>"</p>
<p>> <span>ERROR POSSIBLY CAUSED BY</span>: [<b>execute access forbidden, read access forbidden, write access forbidden, source access denied</b>...]</p>
</div>

<script>
    var str = document.getElementsByTagName('div')[0].innerHTML.toString();
    var i = 0;
    document.getElementsByTagName('div')[0].innerHTML = "";

    setTimeout(function() {
        var se = setInterval(function() {
            i++;
            document.getElementsByTagName('div')[0].innerHTML = str.slice(0, i) + "|";
            if (i == str.length) {
                clearInterval(se);
                document.getElementsByTagName('div')[0].innerHTML = str;
            }
        }, 10);
    },0);

</script>
</body>
</html>
