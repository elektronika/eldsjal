<h3 class="widget-title">Visheter</h3>
<p><?php echo rq($wisdom->body); ?></p>
<?php if($can_edit): ?><p><a href="/admin/wisdom/<?php echo $wisdom->id; ?>">Redigera</a></p><?php endif; ?>