{extends "calendar.tpl"}

{block "body"}
{form_open_multipart($form_action)}
{input 'text' 'title' 'Rubrik' $event->title}
{input 'text' 'date-show' 'Datum'}
{input 'hidden' 'date' '' $event->date}
{textarea 'body' 'Beskrivning' $event->body}
{input "file" "file" "Bifoga en bild (valfritt)"}
{select "location" $locations "" "Område"}
{input "checkbox" "informall" 'Informera hela landet'}
{input 'submit' 'save' '' 'Spara'}
</form>
{/block}