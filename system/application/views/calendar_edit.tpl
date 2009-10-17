{extends "calendar.tpl"}

{block "body"}
{form_open_multipart('calendar/edit')}
{input 'text' 'title' 'Rubrik' $event->title}
{input 'text' 'date' 'Datum' $event->date}
{textarea 'body' 'Beskrivning' $event->body}
{input "file" "file" "Bifoga en bild (valfritt)"}
{select "location" $locations "" "Område"}
{input "checkbox" "informall" 'Informera hela landet'}
{input 'submit' 'save' '' 'Spara'}
</form>
{/block}