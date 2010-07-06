<?php if( ! empty($items)): ?>
<h3 class="widget-title">Nyheter</h3>
<?php foreach( $items as $topic ): ?>
<div class="news">
	<h4><a href="/forum/topic/<?php echo $topic->topicid; ?>"><?php echo $topic->topicname; ?></a> <span class="meta"><?php echo timesince(strtotime($topic->messagedate)); ?></span></h4>
	<p><?php echo truncate(rq($topic->message), 200); ?></p>
</div>
<?php endforeach; ?>
<p><a href='/forum/category/19'>Mer nyheter &raquo;</a></p>
<?php endif; ?>