<?php region('content'); ?>
<p>Vi behöver lite mer info om dig för att kunna släppa in dig. Det får ju inte vara för lätt. ;) Och du, var ärlig är du snäll. Det blir så mycket trevligare då. :)</p>
<?php 
echo 
form_open_multipart($form_action)
.form_fieldset('Kontoinställningar')
.input('text', 'new_username', 'Användarnamn', $user->username)
.input('text', 'email', 'E-mail, visas inte på presentationen', $user->email)
.input('password', 'new_password', 'Nytt lösenord')
.input('password', 'new_password_confirm', 'Nytt lösenord igen')
.form_fieldset_close()
.form_fieldset('Info om dig')
.input('text', 'first_name', 'Förnamn', $user->first_name)
.input('text', 'last_name', 'Efternamn', $user->last_name)
.textarea('presentation', 'Presentation', rqForm($user->presentation))
.form_label('Stad/län')
.form_dropdown('city', $locations, $user->city)
.input('text', 'inhabitance', 'Stadsdel/ort', $user->inhabitance)
.form_fieldset_close()
.form_fieldset('Födelsedag')
.form_label('År')
.form_dropdown('born_year', array('-' => '-') + range(1900, date('Y')))
.form_error('born_year', "<span class='form-error-description'>", "</span>")
.form_label('Månad')
.form_dropdown('born_month', array('-' => '-') + range(1, 12))
.form_error('born_month', "<span class='form-error-description'>", "</span>")
.form_label('Dag')
.form_dropdown('born_date', array('-' => '-') + range(1, 31))
.form_error('born_date', "<span class='form-error-description'>", "</span>")
.form_fieldset_close()
.form_fieldset('Bild')
.form_label('Nuvarande bild')
.userimage($user)
.form_label('Ny bild')
.form_upload('image')
.form_fieldset_close()
.submit('Spara!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>