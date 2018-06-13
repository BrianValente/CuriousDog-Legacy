{assign var='user_from'          value=$question->getUserFrom()}
{if $user_from !== null}
    {assign var='user_from_username' value=$question->getUserFrom()->getUsername()}
    {assign var='user_from_name'     value=$question->getUserFrom()->getName()}
{/if}

{assign var='id'                 value=$question->getId()}
{assign var='user_to'            value=$question->getUserTo()}
{assign var='user_to_picture'    value=$question->getUserTo()->getUserProfilePictureUrl()}
{assign var='user_to_username'   value=$question->getUserTo()->getUsername()}
{assign var='user_to_name'       value=$question->getUserTo()->getName()}
{assign var='question_html'      value=$question->getQuestionHtml()}
{assign var='answer_html'        value=$question->getAnswerHtml()}
{assign var='date'               value=$question->getDateAnsweredReadable()}

<div class="question" data-id="{$id}">
    <div class="question_header">
        <a href="{$siteUrl}{$user_to_username}">
            <div class="question_header_picture" style="background-image: url({$user_to_picture});"></div>
        </a>
        <div class="question_header_content">
            <a href="{$siteUrl}{$user_to_username}" class="question_header_user">{$user_to_name}
                <span class="question_header_user_username">@{$user_to_username}</span>
            </a>
            <span class="question_header_content">{$answer_html}</span>
        </div>
    </div>
    <div class="question_middle">
        {if is_null($user_from)}
            <span class="question_middle_content">Preguntado por un usuario anónimo: <span class="question_middle_question">{$question_html}</span></span>
        {else}
            <span class="question_middle_content">Preguntado por
                <a href="{$siteUrl}{$user_from->getUsername()}" class="question_middle_user">
                    {$user_from->getName()}
                    <span class="question_middle_user_username">
                        @{$user_from->getUsername()}
                    </span>
                </a>:
                <span class="question_middle_question">
                    {$question_html}
                </span>
            </span>
        {/if}
    </div>
    <div class="question_bottom">
        <span class="question_bottom_time">{$date}
            {if isset($loggedUser) && $loggedUser->getGroup() === 1}
                | {$question->getIp()} | {$question->getUseragent()}
            {/if}
        </span>
    </div>
</div>