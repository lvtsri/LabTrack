<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LabTrack</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#f3f3f7]">

    <div class="flex">

        @include('components.dosen.sidebar')

        <main class="flex-1 p-10">
            @yield('content')
        </main>

    </div>

    <script>

        const modal = document.getElementById('editModal');

        const openBtn = document.getElementById('openModal');

        const closeBtn = document.getElementById('closeModal');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

    </script>

</body>
</html>