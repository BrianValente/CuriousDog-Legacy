<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="html-header.tpl"}

        <script async src="js/general.js.php"></script>
        <script async src="js/register_twitter.js"></script>
    </head>
    <body>
        {include file='header.tpl'}
        <div id="register_content" style="width: 800px; background-color: white; margin: 10px auto 0 auto; box-sizing: border-box; padding: 20px;">
            ¡Bienvenido, {$twitter_user['name']}! Necesitamos una contraseña para poder terminar el registro.
            <br>
            <input class="input" placeholder="Contraseña" id="register_password" autocomplete="off" type="password">
            <span class="button" id="send">Enviar</span>
        </div>
    </body>
</html>