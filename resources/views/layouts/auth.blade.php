<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LabTrack</title>

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>

        body {
            font-family: 'Poppins', sans-serif;
        }

    </style>

</head>

<body>

    @yield('content')

</body>
</html>