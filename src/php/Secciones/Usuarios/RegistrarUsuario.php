<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../../css/Styles.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include "../Header.php"?>
<div class="container">
    <h1 class="text-center my-4">Registro de Usuario</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="registrationForm" method="POST">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="name">Apellidos:</label>
                    <input type="text" class="form-control" id="apeliidos" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
            <div id="message" class="mt-3"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        $('#registrationForm').on('submit', function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let apellidos = $('#apeliidos').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let confirmPassword = $('#confirmPassword').val();

            // Validar que las contraseñas coincidan
            if (password !== confirmPassword) {
                $('#message').html('<div class="alert alert-danger">Las contraseñas no coinciden.</div>');
                return;
            }

            if (name === '' || apellidos==='' || email === '' || password === '' || confirmPassword === '' ){
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Debes de llenar todos los campos!',
                });
                return;
            }
            $.ajax({
                url: '../../Funciones/RegistrarUsuario.php',
                type: 'POST',
                data: {
                    name: name,
                    apellidos: apellidos,
                    email: email,
                    password: password
                },
                success: function(response) {
                    let resp = JSON.parse(response);
                    if(resp.respuesta === 'registrado'){
                        $('#message').html('<div class="alert alert-danger">Ya existe este correo registrado.</div>');
                    }

                    if(resp.respuesta === 'correcto'){
                        $('#message').html('<div class="alert alert-success">Registrado correctamente.</div>');
                        window.location.href = '../../../../../index.php'

                    }
                    $('#registrationForm')[0].reset();
                }
            });
        });
    });
</script>
</body>
</html>
