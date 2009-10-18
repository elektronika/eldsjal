<?php /* Smarty version 2.6.26, created on 2009-07-12 00:09:08
         compiled from dev.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'dev.tpl', 5, false),array('modifier', 'is_array', 'dev.tpl', 9, false),array('modifier', 'escape', 'dev.tpl', 11, false),array('modifier', 'round', 'dev.tpl', 33, false),array('function', 'time', 'dev.tpl', 33, false),)), $this); ?>
<ul id="dev">
<?php $_from = $this->_tpl_vars['dev']['logs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['l'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['l']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['log']):
        $this->_foreach['l']['iteration']++;
?>
<a class="container">
<li>
<h2><?php echo $this->_tpl_vars['name']; ?>
 - <?php echo count($this->_tpl_vars['log']); ?>
</h2>
   <ul class='log'>
     <?php $_from = $this->_tpl_vars['log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['l'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['l']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['l']['iteration']++;
?>
     	<li class="item"><pre>
<?php if (((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
<?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['logparts'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['logparts']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['partkey'] => $this->_tpl_vars['part']):
        $this->_foreach['logparts']['iteration']++;
?>
<?php if (( $this->_tpl_vars['partkey'] == 'time' && $this->_tpl_vars['part'] > 0.005 ) || $this->_tpl_vars['partkey'] == 'error'): ?>[<?php echo $this->_tpl_vars['partkey']; ?>
] => <span class='warning'><?php echo ((is_array($_tmp=$this->_tpl_vars['part'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span>
<?php elseif ($this->_tpl_vars['partkey'] == 'time' && $this->_tpl_vars['part'] < 0.0005): ?>[<?php echo $this->_tpl_vars['partkey']; ?>
] => <span class='good'><?php echo ((is_array($_tmp=$this->_tpl_vars['part'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span>
<?php else: ?>[<?php echo $this->_tpl_vars['partkey']; ?>
] => <?php echo ((is_array($_tmp=$this->_tpl_vars['part'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php else: ?>
<?php echo $this->_tpl_vars['item']; ?>

<?php endif; ?>
</pre></li>
     <?php endforeach; endif; unset($_from); ?>
   </ul>
</li>
</a>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['dev']['globals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['l'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['l']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['global']):
        $this->_foreach['l']['iteration']++;
?>
<a class="container">
<li>
<h2><?php echo $this->_tpl_vars['name']; ?>
</h2>
   <ul class='log'>
     	<li class="item"><pre><?php echo ((is_array($_tmp=$this->_tpl_vars['global'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</pre></li>
   </ul>
</li>
<?php endforeach; endif; unset($_from); ?>
<li><?php echo ((is_array($_tmp=smarty_function_time(array(), $this))) ? $this->_run_mod_handler('round', true, $_tmp, 3) : round($_tmp, 3));?>
 sekunder</li>
</a>
</ul>