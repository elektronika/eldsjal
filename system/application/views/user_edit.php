<?php region('content'); ?>
<?php 
echo 
form_open_multipart($form_action)
.form_fieldset('Kontoinställningar')
.'<p>För att kunna ändra någon utav dessa uppgifterna så måste du fylla i ditt lösenord.</p>'
.input('text', 'username', 'Användarnamn', $user->username)
.input('text', 'email', 'E-mail, visas inte på presentationen', $user->email)
.input('password', 'old_password', 'Ditt lösenord')
.input('password', 'new_password', 'Nytt lösenord')
.input('password', 'new_password_confirm', 'Nytt lösenord igen')
.form_fieldset_close()
.form_fieldset('Presentationsinställningar')
.textarea('presentation', 'Presentation', rqForm($user->presentation))
.form_label(form_radio('privacy', 0, $user->privacy == 0).'Låt alla se min presentation')
.form_label(form_radio('privacy', 1, $user->privacy == 1).'Låt bara inloggade se min presentation')
.form_label(form_radio('privacy', 2, $user->privacy == 2).'Låt bara faddrade se min presentation')
.form_fieldset_close()
.form_fieldset('Bild')
.'<p>Om du vill behålla din nuvarande bild så behöver du inte röra något här. :)</p>'
.form_label('Nuvarande bild')
.userimage($user)
.form_label('Ny bild')
.form_upload('image')
.form_label(form_checkbox('delete_image', 1).'Radera min bild')
.form_fieldset_close()
.form_fieldset('Medlemsskapsuppgifter')
.'<p>De här uppgifterna behöver vi för medlemslistan till föreningen.</p>'
.input('text', 'first_name', 'Förnamn', $user->first_name)
.input('text', 'last_name', 'Efternamn', $user->last_name)
.input('text', 'street_address', 'Gatuadress', $user->street_address)
.input('text', 'postal_code', 'Postnummer', $user->postal_code)
.input('text', 'postal_city', 'Postort', $user->postal_city)
.input('text', 'country', 'Land', $user->country)
.form_fieldset_close()
.form_fieldset('Frivilliga uppgifter')
.'<p>Allt detta visas på din presentation, vilka som kan se din presentation väljer du under "Presentationsinställningar".</p>'
.input('text', 'public_email', 'E-mail', $user->public_email)
.input('text', 'webpage', 'Hemsida', $user->webpage)
.input('text', 'icq', 'ICQ', $user->icq)
.input('text', 'msn', 'MSN', $user->msn)
.input('text', 'phone', 'Telefonnummer', $user->phone)
.form_label('Stad/län')
.form_dropdown('city', $locations, $user->city)
.input('text', 'inhabitance', 'Stadsdel/ort', $user->inhabitance)
.form_fieldset_close()
.form_fieldset('Sysslar med', array('id' => 'usertags'));
foreach($tags as $id => $tag)
	echo form_label(form_checkbox("tags[{$id}]", $id, isset($user_tags[$id])).$tag);
echo form_fieldset_close()
.submit('Spara!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>