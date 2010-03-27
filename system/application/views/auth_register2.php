<?php region('content'); ?>
<?php 
echo 
form_open_multipart($form_action)
.form_fieldset('Kontoinställningar')
.input('text', 'username', 'Användarnamn', $user->username)
.input('text', 'email', 'E-mail, visas inte på presentationen', $user->email)
.input('password', 'password', 'Nytt lösenord')
.input('password', 'password_confirm', 'Nytt lösenord igen')
.form_fieldset_close()
.form_fieldset('Info om dig')
.input('text', 'first_name', 'Förnamn', $user->first_name)
.input('text', 'last_name', 'Efternamn', $user->last_name)
.textarea('presentation', 'Presentation', rqForm($user->presentation))
.form_label('Stad/län')
.form_dropdown('city', $locations, $user->city)
.input('text', 'inhabitance', 'Stadsdel/ort', $user->inhabitance)
.form_fieldset_close()
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