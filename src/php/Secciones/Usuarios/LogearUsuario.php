<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../../../css/Styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<?php include "../Header.php"?>
<div class="container">
    <h1 class="mt-4">Iniciar sesión</h1>
    <form id="loginForm">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
    </form>
    <div id="message" class="mt-3"></div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            let email = $('#email').val();
            let password = $('#password').val();


            if (email === '' || password ===''){
                $('#message').html('<div class="alert alert-danger">Debes de llenar todos los campos.</div>');
                return;
            }
            $.ajax({
                url: '../../Funciones/LogUsuarios.php',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    let resp = JSON.parse(response);
                    if(resp.respuesta === 'correcto'){
                        $('#message').html('<div class="alert alert-success">Registrado correctamente.</div>');
                        window.location.href = '../../../../../index.php'

                    }else{
                        $('#message').html('<div class="alert alert-danger">Usuario o contraseñas incorrectas.</div>');
                    }
                    $('#loginForm')[0].reset();
                }
            });
        });
    });
</script>
</body>
</html>
