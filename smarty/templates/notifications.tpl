<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="html-header.tpl"}

        <style>
            input[type="text"]:focus,
            input[type="password"]:focus,
            .question_bottom_reply_textarea:focus {
                border-color: {$colorAccent} !important;
                box-shadow: {$colorAccent} 0 0 3px -1px;
            }

            .question_bottom_reply_send {
                background-color: {$colorAccent};
            }

            .question_header_action:hover {
                transform: scale(1.1);
                box-shadow: {$colorAccent} 0 0 3px;
            }

        </style>

        <script async src="js/general.js.php"></script>
        <script async src="js/notifications.js"></script>
    </head>
    <body>
        {include file='header.tpl'}
        <div id="content">
            <div class="content_panel float_left" id="notifications_filters_panel">
                <div class="content_panel_section">
                    <span class="content_panel_title">Filtros</span>
                        <label class="notifications_filters_row" for="all"><input type="radio" name="filter" id="all" checked/><span>Todo</span></label>
                        <label class="notifications_filters_row" for="questions"><input type="radio" name="filter" id="questions" /><span>Preguntas</span></label>
                        <label class="notifications_filters_row" for="reposts"><input type="radio" name="filter" id="reposts" /><span>Reposts</span></label>
                        <label class="notifications_filters_row" for="likes"><input type="radio" name="filter" id="likes" /><span>Me gusta</span></label>
                </div>
            </div>

            <div class="content_panel autosize" id="notifications_panel">
                <div class="content_panel_header">
                    <span class="content_panel_header_title">Notificaciones</span>
                </div>
                {if isset($twitter_account)}
                    <div style="
                    background-color: #fff8c6;
                    box-sizing: border-box;
                    padding: 10px 20px;
                    position: relative;
                    font-size: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between">
                        <span class="" style="vertical-align: middle;">
                            Tip: Comparte tu perfil en Twitter para tener más preguntas.</span>
                        <span id="btn_twitter_share_profile" class="button icon" style=" background-image: url(../img/ic_twitter_24.png) !important; border-color: #2A9EB2 !important; background-color: #37CBE5 !important;">
                            Compartir
                        </span>
                    </div>
                {else}
                    <div style="
                    background-color: #fff8c6;
                    box-sizing: border-box;
                    padding: 10px 20px;
                    position: relative;
                    font-size: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between">
                        <span class="" style="vertical-align: middle;">
                            Tip: Enlaza tu cuenta de Twitter para compartir tu perfil.</span>
                        <a href="http://ask.brianvalente.tk/social/ConnectToTwitter.php" class="button icon" style="text-decoration: none; background-image: url(../img/ic_twitter_24.png) !important; border-color: #2A9EB2 !important; background-color: #37CBE5 !important;">
                            Enlazar
                        </a>
                    </div>
                {/if}

                {if $loggedUser->getGroup() === 1}
                    <div style="background-color: #c6d9ff; box-sizing: border-box; padding: 10px 20px; position: relative; font-size: 12px; display: flex; align-items: center; justify-content: space-between; min-height: 56px; color: black; line-height: 16px;">
                        <span class="" style="vertical-align: middle;">¡Ahora sos administrador! "Un gran poder conlleva una gran responsabilidad". En otras palabras, no hagas pelotudeces.</span>
                    </div>
                {/if}
                {* if $loggedUser->getId() === 3}
                    <div style="background-color: #303030; box-sizing: border-box; padding: 10px 20px; position: relative; font-size: 12px; display: flex; align-items: center; justify-content: space-between; min-height: 56px; color: black; line-height: 16px;">
                        <span class="" style="vertical-align: middle;">👉🏻👌🏻</span>
                    </div>
                {/if *}
                {if count($unansweredQuestions) != 0}
                    {include file='notifications_question_row.tpl' questions=$unansweredQuestions}
                {else}
                    <span style="display:block; padding:50px 0; color:#ccc; font-size:48px; text-align: center;">No hay preguntas 🙁</span>
                {/if}
            </div>
        </div>
    </body>
</html>