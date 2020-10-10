<?php /* Smarty version 2.6.31, created on 2020-05-27 17:24:22
         compiled from C:/xampp/htdocs/openemr/templates/documents/general_queue.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'xlt', 'C:/xampp/htdocs/openemr/templates/documents/general_queue.html', 3, false),array('modifier', 'attr', 'C:/xampp/htdocs/openemr/templates/documents/general_queue.html', 9, false),array('modifier', 'text', 'C:/xampp/htdocs/openemr/templates/documents/general_queue.html', 26, false),array('modifier', 'attr_url', 'C:/xampp/htdocs/openemr/templates/documents/general_queue.html', 32, false),)), $this); ?>
<div class="btn-group">
    <a href="controller.php?practice_settings&<?php echo $this->_tpl_vars['TOP_ACTION']; ?>
document_category&action=list" onclick="top.restoreSession()" class="btn btn-default btn-edit" >
        <?php echo smarty_function_xlt(array('t' => 'Edit Categories'), $this);?>

    </a>
    <a href="#" onclick="submit_documents();" class="btn btn-default btn-update" target="_self" onclick="top.restoreSession()">
        <?php echo smarty_function_xlt(array('t' => 'Update files'), $this);?>

    </a>
</div>
<input type="hidden" name="process" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['PROCESS'])) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
" /><br><br>

<form name="queue" method="post" action="<?php echo $this->_tpl_vars['FORM_ACTION']; ?>
" onsubmit="return top.restoreSession()">
<table class="table table-responsive table-striped">
	<tr class="center_display">
		<td colspan="6"><?php echo $this->_tpl_vars['messages']; ?>
</td>
	</tr>
	<tr class="showborder_head">
		<th colspan="2" width="110px"><?php echo smarty_function_xlt(array('t' => 'Name'), $this);?>
</td>
		<th width="100px"><?php echo smarty_function_xlt(array('t' => 'Date'), $this);?>
</td>
		<th width="200px"><?php echo smarty_function_xlt(array('t' => 'Patient'), $this);?>
</td>
		<th colspan="2"><?php echo smarty_function_xlt(array('t' => 'Category'), $this);?>
</td>
	</tr>
	<?php $_from = $this->_tpl_vars['queue_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['queue_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['queue_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['file']):
        $this->_foreach['queue_list']['iteration']++;
?>
	<tr>
		<td><input type="checkbox" name="files[<?php echo $this->_tpl_vars['file']['document_id']; ?>
][active]" value="1" <?php if (is_numeric ( $this->_tpl_vars['file']['patient_id'] )): ?>checked<?php endif; ?>></td>

		<td><a href="<?php echo $this->_tpl_vars['file']['web_path']; ?>
" onclick="top.restoreSession()"><?php echo ((is_array($_tmp=$this->_tpl_vars['file']['filename'])) ? $this->_run_mod_handler('text', true, $_tmp) : text($_tmp)); ?>
</a><input type="hidden" name="files[<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['document_id'])) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
][name]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['filename'])) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
"></td>

		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['file']['mtime'])) ? $this->_run_mod_handler('text', true, $_tmp) : text($_tmp)); ?>
</td>

		<td><input type="text" name="files[<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['document_id'])) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
][patient_id]" size="5" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['patient_id'])) ? $this->_run_mod_handler('attr', true, $_tmp) : attr($_tmp)); ?>
"><input type="hidden" name="patient_name" value=""></td>

		<td><a href="javascript:<?php echo '{}'; ?>
" onclick="top.restoreSession();var URL='controller.php?patient_finder&find&form_id=queue<?php echo ((is_array($_tmp="['files[".($this->_tpl_vars['file']['document_id'])."][patient_id]']")) ? $this->_run_mod_handler('attr_url', true, $_tmp) : attr_url($_tmp)); ?>
&form_name=patient_name'; window.open(URL, 'queue', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=450,height=400,left = 425,top = 250');"><img src="<?php echo $this->_tpl_vars['IMAGES_STATIC_RELATIVE']; ?>
/stock_search-16.png" border="0" /></a>&nbsp;&nbsp;&nbsp;</td>
		<td><select name="files[<?php echo $this->_tpl_vars['file']['document_id']; ?>
][category_id]"><?php echo $this->_tpl_vars['tree_html_listbox']; ?>
</select></td>

	</tr>
	<?php endforeach; else: ?>
	<tr height="25" class="center_display">
		<td colspan="6"><?php echo smarty_function_xlt(array('t' => 'No Documents Found'), $this);?>
</td>
	</tr>
	<?php endif; unset($_from); ?>

</table><br><br>

</form>

<?php echo '
<head>
<script language="javascript">
function submit_documents()
{
    top.restoreSession();
    document.queue.submit();
}
</script>
</head>
'; ?>
