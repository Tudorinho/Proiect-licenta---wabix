<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina HTML cu layout asemănător PDF</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff; /* Fundal alb */
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px; /* Lățime maximă a conținutului */
            margin: 0 auto; /* Centrare orizontală */
            padding: 20px; /* Spațiu interior */
            background-color: #ffffff; /* Fundal alb */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Umbră pentru efect de adâncime */
        }

        /* Stiluri pentru antet */
        header {
            text-align: center;
            padding: 20px 0;
            background-color: #f0f0f0; /* Fundal gri pentru antet */
        }

        /* Stiluri pentru conținut */
        .content {
            padding: 20px 0;
        }

        /* Stiluri pentru subsol */
        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #f0f0f0; /* Fundal gri pentru subsol */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Titlu Pagină</h1>
        </header>
        <div class="content">
            <p>Aici este conținutul paginii. Puteți adăuga text, imagini și alte elemente HTML aici.</p>
        </div>
        <footer>
            <p>Drepturile de autor © 2024 - Numele dumneavoastră</p>
        </footer>
    </div>
</body>
</html>
