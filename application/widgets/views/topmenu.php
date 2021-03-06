<div id="navbar">
	<div class="inner">
	<div id="menuItems">
		<a <?php if($active == 'forum') echo 'class="active" ' ?>href="/forum" title="Diskutera, fundera och spekulera fritt med andra eldsjälar *inlägg kräver medlemskap*">Forum<?php echo $forum_alerts; ?><span class="tagline">Snacka loss!</span></a>
		<a <?php if($active == 'calendar') echo 'class="active" ' ?>href="/calendar" title="Se vad som händer runtomkring i världen!">Kalender<?php echo $calendar_alerts; ?><span class="tagline">Se vad som händer</span></a>
		<a <?php if($active == 'gallery') echo 'class="active" ' ?>href="/gallery" title="Underbara bilder med anknytning till alternativkonst från våra medlemmar *uppladdning kräver medlemskap*">Galleri<?php echo $gallery_alerts; ?><span class="tagline">Spana på bilder</span></a>
		<a href="http://www.cby.se/" title="Camp Burn Yourselfs egna sida!" target="_blank">C.B.Y<span class="tagline">Vårt event!</span></a>
		<a <?php if($active == 'board') echo 'class="active" ' ?>href="/board" title="Information om föreningen">Om<span class="tagline">Allmän info</span></a>
	</div>
<?php if($show_search): ?>
	<form id="quicksearch" action = "/people/search" method = "get"> 
		<div>
		<label for="query">Snabbsök</label>
		<input type = "text" name = "query" id = "quicksearch-username" class="form-item-text"/> 
		</div>
	</form>
<?php endif; ?>
	</div>
	<div class="clear"> </div>
</div>