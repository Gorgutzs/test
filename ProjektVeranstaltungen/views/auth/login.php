<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body >

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow p-4" style="width: 400px;">

        <h2 class="text-center mb-4">Login zum Dashboard</h2>

        <form method="POST" action="/ProjektVeranstaltungen/auth/login">

            <div class="mb-3">
                <label for="username" class="form-label">Benutzername</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="username" 
                    name="Username"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Passwort</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="Password"
                    required
                >
            </div>
                
            <button type="submit" class="btn btn-primary w-100">
                Anmelden
            </button>

        </form>

    </div>

</div>
</body>
</html>



        