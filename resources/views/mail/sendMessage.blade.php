<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerte de Panique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container text-center">
        <div class="card shadow-lg p-4 border-danger">
            <div class="card-body">
                <h2 class="text-danger">
                    ⚠️ An error has occurred
                </h2>
                <div class="lead text-danger">{{ $messageContent }}</div>
                <p class="text-muted">📅 Date : {{ now() }}</p>
            </div>
        </div>
    </div>
</body>
</html>
