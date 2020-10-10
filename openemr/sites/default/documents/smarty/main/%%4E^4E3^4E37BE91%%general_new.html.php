<?php /* Smarty version 2.6.31, created on 2020-09-24 06:09:44
         compiled from /Library/WebServer/www/openemr/interface/forms/prior_auth/templates/prior_auth/general_new.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'attr', '/Library/WebServer/www/openemr/interface/forms/prior_auth/templates/prior_auth/general_new.html', 41, false),array('modifier', 'text', '/Library/WebServer/www/openemr/interface/forms/prior_auth/templates/prior_auth/general_new.html', 50, false),)), $this); ?>
<html>
<head>
<?php echo '
 <style type="text/css" title="mystyles" media="all">
<!--
td {
	font-size:12pt;
	font-family:helvetica;
}
li{
	font-size:11pt;
	font-family:helvetica;
	margin-left: 15px;
}
a {
	font-size:11pt;
	font-family:helvetica;
}
.title {
	font-family: sans-serif;
	font-size: 12pt;
	font-weight: bold;
	text-decoration: none;
	color: #000000;
}

.form_text{
	font-family: sans-serif;
	font-size: 9pt;
	text-decoration: none;
	color: #000000;
}

-->
</style>
'; ?>

</head>
<body bgcolor="<?php echo $this->_tpl_vars['STYLE']['BGCOLOR2']; ?>
">
<p><span class="title">Prior Authorization Form</span></p>
<form name="prior_auth" method="post" action="<?php echo $this->_tpl_vars['FORM_ACTION']; ?>
/interface/forms/prior_auth/save.php">
<input type="hidden" name="csrf_token_form" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['CSRF_TOKEN_FORM'])) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
">
<table>
<tr>
	<td>Prior Authorization Number</td><td><input type="text" size="35" name="prior_auth_number" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['prior_auth']->get_prior_auth_number())) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
"></td>
</tr>
<tr>
	<td><br><br>Comments</td>
</tr>
<tr>
	<td colspan="2"><textarea name="comments" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['prior_auth']->get_comments())) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
" wrap="virtual" cols="75" rows="8"><?php echo ((is_array($_tmp=$this->_tpl_vars['prior_auth']->get_comments())) ? $this->_run_mod_handler('text', true, $_tmp) : text($_tmp)); ?>
</textarea></td>
</tr>
<?php if ($this->_tpl_vars['VIEW'] != true): ?>
<tr>
	<td><br><br><input type="submit" name="Submit" value="Save Form">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['DONT_SAVE_LINK']; ?>
" class="link">[Don't Save]</a></td>
</tr>
<?php endif; ?>
</table>
<input type="hidden" name="id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['prior_auth']->get_id())) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
" />
<input type="hidden" name="activity" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['prior_auth']->get_activity())) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
">
<input type="hidden" name="pid" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['prior_auth']->get_pid())) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
">
<input type="hidden" name="process" value="true">
</form>
</body>
</html>