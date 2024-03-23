<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Running Letter</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        .running-letter {
            font-size: 48px;
            animation: run 5s infinite linear;
        }

        @keyframes run {
            0% {
                transform: translateX(0);
            }
            10% {
                transform: translateX(10vw);
            }
            20% {
                transform: translateY(10vh);
            }
            40% {
                transform: translateX(-10vw);
            }
            60% {
                transform: translateY(-10vh);
            }
            80% {
                transform: translateX(10vw);
            }
            100% {
                transform: translateY(-10vh);
            }
        }
    </style>
</head>
<body>
    <div class="running-letter" id="runningLetter" onclick="startRunning()"><a href="../index.php">Главная</a></div>

    <script>
        function startRunning() {
            document.getElementById("runningLetter").classList.add("running-letter");
        }
    </script>
</body>
</html>
