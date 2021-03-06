<?php
/**
 * Implementation of EditComment view
 *
 * @category   REPO
 * @package    MediaREPO
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("class.Bootstrap.php");

/**
 * Class which outputs the html page for EditComment view
 *
 * @category   REPO
 * @package    MediaREPO
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class mediarepo_View_EditComment extends mediarepo_Bootstrap_Style {

	function js() { /* {{{ */
		$strictformcheck = $this->params['strictformcheck'];
		header('Content-Type: application/javascript; charset=UTF-8');
?>
function checkForm()
{
	msg = new Array();
<?php
		if ($strictformcheck) {
?>
	if (document.form1.comment.value == "") msg.push("<?php printMLText("js_no_comment");?>");
<?php
		}
?>
	if (msg != "")
	{
  	noty({
  		text: msg.join('<br />'),
  		type: 'error',
      dismissQueue: true,
  		layout: 'topRight',
  		theme: 'defaultTheme',
			_timeout: 1500,
  	});
		return false;
	}
	else return true;
}
$(document).ready(function() {
	$('body').on('submit', '#form1', function(ev){
		if(checkForm()) return;
		ev.preventDefault();
	});
});
<?php
	} /* }}} */

	function show() { /* {{{ */
		$repo = $this->params['repo'];
		$user = $this->params['user'];
		$folder = $this->params['folder'];
		$document = $this->params['document'];
		$version = $this->params['version'];
		$strictformcheck = $this->params['strictformcheck'];

		$this->htmlStartPage(getMLText("document_title", array("documentname" => htmlspecialchars($document->getName()))));
		$this->globalNavigation($folder);
		$this->contentStart();
		$this->pageNavigation($this->getFolderPathHTML($folder, true, $document), "view_document", $document);

		$this->contentHeading(getMLText("edit_comment"));
		$this->contentContainerStart();
?>
<form class="form-horizontal" action="../op/op.EditComment.php" id="form1" name="form1" method="post">
	<?php echo createHiddenFieldWithKey('editcomment'); ?>
	<input type="Hidden" name="documentid" value="<?php print $document->getID();?>">
	<input type="Hidden" name="version" value="<?php print $version->getVersion();?>">
	<div class="control-group">
			<label class="control-label"><?php printMLText("comment");?>:</label>
			<div class="controls">
				<textarea name="comment" rows="4" cols="80"><?php print htmlspecialchars($version->getComment());?></textarea>
			</div>
	</div>
	<div class="controls">
		<button type="submit" class="btn"><i class="icon-save"></i> <?php printMLText("save") ?></button>
	</div>
</form>
<?php
		$this->contentContainerEnd();
		$this->contentEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
