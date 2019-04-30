<?php
/*
Plugin Name: Responsive File Manager for GetSimple
Description: Responsive File Manager plugin Integrated for Getsimple
Version: 1.0
Author: Andrejus Semionovas
Author URI: http://pigios-svetaines.eu/
*/

/* 
 This version uses a slightly modified Layer Slider core to function correctly in GetSimple.
*/

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");

# language support
i18n_merge($thisfile, substr($LANG,0,2)) || i18n_merge($thisfile, $LANG) || i18n_merge($thisfile, 'en') || i18n_merge($thisfile, 'en_US');


$data_path = GSDATAPATH."responsivefilemanager/";
$plugin_path = GSPLUGINPATH."responsivefilemanager/";

# register plugin
register_plugin(
	$thisfile, 										# ID of plugin, should be filename minus php
	'Responsive File Manager', 						# Title of plugin
	'1.0', 											# Version of plugin
	'Andrejus Semionovas',							# Author of plugin
	'http://pigios-svetaines.eu/', 					# Author URL
	i18n_r($thisfile.'/FM_PLUGIN_DESC'), 	    	# Plugin Description
	'files', 										# Page type of plugin
	'responsivefilemanager_get'  					# Function that displays content
);

# activate hooks
add_action('files-sidebar','createSideMenu',array($thisfile,'Responsive File Manager')); 	// Add the sidebar 
add_action('edit-extras', 'editorChangeParams', array());
register_style('settings', $SITEURL.'plugins/responsivefilemanager/css/settings.css', GSVERSION, 'screen');
queue_style('settings', GSBACK);

if (file_exists(GSDATAOTHERPATH.'rfm_config.xml')) {
	$rfm_xml = getXML(GSDATAOTHERPATH . 'rfm_config.xml');
	$rfm_jquery = $rfm_xml->jquery;
	$rfm_prettyphoto = $rfm_xml->prettyphoto;
	$rfm_fancybox = $rfm_xml->fancybox;
	if (isset($rfm_jquery) && $rfm_jquery == 1) {
		register_script('gs_jquery', $SITEURL.'admin/template/js/jquery.min.js', GSVERSION,TRUE);
		queue_script('gs_jquery', GSFRONT);
	}
	if (isset($rfm_prettyphoto) && $rfm_prettyphoto == 1) {
		register_style('pretty', $SITEURL.'plugins/responsivefilemanager/css/prettyPhoto.css', '3.1.5', 'screen');
		queue_style('pretty', GSFRONT);
		register_script('pretty_photo', $SITEURL.'plugins/responsivefilemanager/js/prettyPhoto/jquery.prettyPhoto.js', '3.1.5',TRUE);
		queue_script('pretty_photo', GSFRONT);
		register_script('prettyload', $SITEURL.'plugins/responsivefilemanager/js/prettyPhoto/rfm_prettyphoto.js', GSVERSION,TRUE);
		queue_script('prettyload', GSFRONT);
	}
	if (isset($rfm_fancybox) && $rfm_fancybox == 1) {
		register_style('fancy', $SITEURL.'plugins/responsivefilemanager/js/FancyBox/jquery.fancybox.css', '2.1.5', 'screen');
		queue_style('fancy', GSFRONT);
		register_script('fancy_box', $SITEURL.'plugins/responsivefilemanager/js/FancyBox/jquery.fancybox.pack.js', '2.1.5',TRUE);
		queue_script('fancy_box', GSFRONT);
		register_script('fancyload', $SITEURL.'plugins/responsivefilemanager/js/FancyBox/rfm_fancybox.js', GSVERSION,TRUE);
		queue_script('fancyload', GSFRONT);
	}
}

function responsivefilemanager_get() {
	global $thisfile;
	global $plugin_info;
	global $plugins;
	global $LANG;
	global $data_path;
	global $plugin_path;
	global $SITEURL;

$filename = GSPLUGINPATH.'responsivefilemanager/config/config.php';
$file = fopen($filename, "r")  or die("Couldn't open $filename");
while(!feof($file)){
    $line = fgets($file);
	$pos = strpos($line, 'upload_dir');
	if ($pos !== false) {
		$rfm_upload = substr($line, strpos($line, '/'), (rtrim(strpos($line, ','))-strpos($line, '/'))-1);
		break;
	}
}
fclose($file);

$urls = parse_url($SITEURL, PHP_URL_PATH);
if($urls == "/") $upload_d = "/data/uploads/";
else  $upload_d = $urls."data/uploads/";
if ($rfm_upload != $upload_d) {
	$file_temp = GSPLUGINPATH.'responsivefilemanager/config/config.tmp';
	$file = fopen($filename, "r")  or die("Couldn't open $filename");
	$file_new = fopen($file_temp, "w")  or die("Couldn't open $file_temp");
	while(!feof($file)){
    $line = fgets($file);
	$pos = strpos($line, 'upload_dir');
	if ($pos !== false) {
		fwrite($file_new, "\t'upload_dir' => '".$upload_d."',\n");
	}
	else {
		fwrite($file_new, $line);
	}
	}
	fclose($file);
	fclose($file_new);
	unlink($filename);
	rename($file_temp, $filename);
?> <div class="fancy-message info"><p><?php i18n('responsivefilemanager/FILE_UPLOAD'); echo $upload_d; ?></p></div> <?php
}
	
	if(file_exists($plugin_path."lang/".$LANG.".php")) $lang_curr = $LANG;
	else $lang_curr = substr($LANG,0,2);
	if(isset($_POST['rfm_replace']) && $_POST['rfm_replace']) {
			if (check_plugin()) {
				$rfm_xml = getXML(GSDATAOTHERPATH . 'rfm_config.xml');
				$rfm_xml->replace = 1;
				XMLsave($rfm_xml, GSDATAOTHERPATH.'rfm_config.xml');
				?> <div class="fancy-message seccess"><p><?php i18n('responsivefilemanager/FM_INTEGR_SECC'); ?></p></div> <?php
			}
			else {
				?> <div class="fancy-message error"><p><?php i18n('responsivefilemanager/FM_THUMB_ERR'); ?></p></div> <?php
			}
	}

	if(isset($_POST['rfm_dereplace']) && $_POST['rfm_dereplace']) {
		if(file_exists(GSADMINPATH.'template/js/ckeditor/plugins/thumb')) {
			recursiveRemoveDirectory(GSADMINPATH.'template/js/ckeditor/plugins/thumb');
		}
		$rfm_xml = getXML(GSDATAOTHERPATH . 'rfm_config.xml');
		$rfm_xml->replace = '';
		XMLsave($rfm_xml, GSDATAOTHERPATH.'rfm_config.xml');
		?> <div class="fancy-message seccess"><p><?php i18n('responsivefilemanager/FM_INTEGR_CANC'); ?></p></div> <?php
				
	}
	if(isset($_POST['rfm_save']) && $_POST['rfm_save']) {
		$rfm_xml = getXML(GSDATAOTHERPATH . 'rfm_config.xml');
		$rfm_xml->w_width = str_replace(array("px"," "), "", $_POST['rfm_w_width']);
		$rfm_xml->w_height = str_replace(array("px"," "), "", $_POST['rfm_w_height']);
		if(isset($_POST['rfm_toolbar']) && !empty($_POST['rfm_toolbar'])) {
			$rfm_xml->toolbar = $_POST['rfm_toolbar']; }
		else { $rfm_xml->toolbar = 0; }
		if(isset($_POST['rfm_prettyphoto']) && !empty($_POST['rfm_prettyphoto'])) {
			$rfm_xml->prettyphoto = $_POST['rfm_prettyphoto']; }
		else { $rfm_xml->prettyphoto = 0; }
		if(isset($_POST['rfm_fancybox']) && !empty($_POST['rfm_fancybox'])) {
			$rfm_xml->fancybox = $_POST['rfm_fancybox']; }
		else { $rfm_xml->fancybox = 0; }
		if(isset($_POST['rfm_jquery']) && !empty($_POST['rfm_jquery'])) {
			$rfm_xml->jquery = $_POST['rfm_jquery']; }
		else { $rfm_xml->jquery = 0; }
		XMLsave($rfm_xml, GSDATAOTHERPATH.'rfm_config.xml');
		?> <div class="fancy-message seccess"><p><?php i18n('responsivefilemanager/FM_LANG_PARAM'); ?></p></div> <?php
	}
	if (!file_exists(GSDATAOTHERPATH.'rfm_config.xml')) {
		$rfm_xml = @new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><rfm_config></rfm_config>');
		$rfm_xml->addChild('replace', false);
		$rfm_xml->addChild('toolbar', false);
		$rfm_xml->addChild('prettyphoto', false);
		$rfm_xml->addChild('fancybox', false);
		$rfm_xml->addChild('jquery', false);
		$rfm_xml->addChild('w_width', "75%");
		$rfm_xml->addChild('w_height', "60%");
		XMLsave($rfm_xml, GSDATAOTHERPATH.'rfm_config.xml');
	}
	else {
		$rfm_xml = getXML(GSDATAOTHERPATH . 'rfm_config.xml');
		$rfm_replace = $rfm_xml->replace;
		$win_width = $rfm_xml->w_width;
		$win_height = $rfm_xml->w_height;
		$rfm_toolbar = $rfm_xml->toolbar;
		$rfm_prettyphoto = $rfm_xml->prettyphoto;
		$rfm_fancybox = $rfm_xml->fancybox;
		$rfm_jquery = $rfm_xml->jquery;
	}
?>
	<h3 class="floated" style="float:left">Responsive FileManager</h3>
	<div class="edit-nav">
        <p>
		 <a href="../plugins/responsivefilemanager/dialog.php?type=0&lang=<?php echo $lang_curr; ?>" class="btn iframe-btn" type="button"><?php i18n('responsivefilemanager/OPEN_FM'); ?></a>
        </p>
        <div class="clear"></div>
    </div>
	
	<div id="respfm"> 
		<div id="respbrowser">
			<iframe name="respfm" id="respframe" frameborder="0" width="100%" height="550px" src="../plugins/responsivefilemanager/dialog.php?type=0&lang=<?php echo $lang_curr; ?>">
			</iframe>
		</div>
	</div>
	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="rfm-postform">
	<fieldset class="container-collapsed">
	<legend class="collapsedlegend"><?php i18n('responsivefilemanager/FM_SET_EXPAND'); ?></legend>
	<h3 style="margin:20px 10px"><?php i18n('responsivefilemanager/FM_SET_INTEGR'); ?></h3>

	<div class="edit-settings">

	
		<?php if (isset($rfm_replace) && $rfm_replace == 1) : ?>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_INTEGR_SECC'); ?></span>
			<input type="submit" name="rfm_dereplace" class="iframe-buttn" value="<?php i18n('responsivefilemanager/FM_BTN_RESTORE'); ?>"/></div>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_WIDTH'); ?></span>
			<input type="text" name="rfm_w_width" class="rfm_input" value="<?php echo (isset($win_width) && strpos($win_width,'%')) === false ? $win_width.'px' : $win_width; ?>"/></div>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_HEIGHT'); ?></span>
			<input type="text" name="rfm_w_height" class="rfm_input" value="<?php echo (isset($win_height) && strpos($win_height,'%')) === false ? $win_height.'px' : $win_height; ?>"/></div>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_TOOLBAR'); ?></span>
			<input type="checkbox" name="rfm_toolbar" class="rfm_input" value=1 <?php echo $rfm_toolbar==1?"checked":"" ?>/></div>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_PRETTY'); ?></span>
			<input type="checkbox" name="rfm_prettyphoto" class="rfm_input groups" value=1 <?php echo (isset($rfm_prettyphoto) && $rfm_prettyphoto==1)?"checked":"" ?>/></div>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_FANCY'); ?></span>
			<input type="checkbox" name="rfm_fancybox" class="rfm_input groups" value=1 <?php echo (isset($rfm_fancybox) &&$rfm_fancybox==1)?"checked":"" ?>/></div>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_JQUERY'); ?></span>
			<input type="checkbox" name="rfm_jquery" class="rfm_input" value=1 <?php echo (isset($rfm_jquery) && $rfm_jquery==1)?"checked":"" ?>/></div>
			<div class="inner-divs"><input type="submit" name="rfm_save" class="iframe-buttn" value="<?php i18n('responsivefilemanager/FM_BTN_SAVE'); ?>" style="float:left; margin-bottom:20px;"/></div>
		<?php else: ?>
			<div class="inner-divs"><span class="rfm-activate"><?php i18n('responsivefilemanager/FM_SET_NOINTEGR'); ?></span>
			<input type="submit" name="rfm_replace" class="iframe-buttn" value="<?php i18n('responsivefilemanager/FM_BTN_INTEGR'); ?>"/></div>
		<?php endif; ?>
	</div>
	</fieldset>
	</form>
<script type="text/javascript">
jQuery('.collapsedlegend').click(function(){
	 var path = '<?php echo $SITEURL; ?>';
	 var expand = '<?php i18n('responsivefilemanager/FM_SET_EXPAND'); ?>';
	 var colapse = '<?php i18n('responsivefilemanager/FM_SET_COLAPS'); ?>';
	if($(this).text()==expand){
		jQuery('.edit-settings').show(500);
		jQuery(this).text(colapse);
		jQuery(this).css('background-image', 'url('+path+'admin/template/images/tick.png)');
	}else{
		jQuery('.edit-settings').hide(500);
		jQuery(this).text(expand);
		jQuery(this).css('background-image', 'url('+path+'admin/template/images/utick.png)');
	}
});
jQuery(function(){
   setTimeout(function() {
       jQuery(".fancy-message").hide('slow');
   }, 10000);
});
jQuery('.iframe-btn').fancybox({	
	'width'		: 900,
	'height'	: 600,
	'type'		: 'iframe',
	'autoScale'    	: false
});
jQuery('.groups').on('change', function() {
   jQuery('.groups').not(this).prop('checked', false);
});
</script>
<?php
}
function editorChangeParams() {
	global $GSEDITORBROWSER;
	global $LANG;
	global $plugin_path;
	global $filebrowserBrowseUrl;
	global $filebrowserUploadUrl;
	global $filebrowserImageBrowseUrl;
	global $filebrowserWidth;
	global $filebrowserHeight;
	global $toolbar_ins;
	
	if(file_exists($plugin_path."lang/".$LANG.".php")) $lang_curr = $LANG;
	else $lang_curr = substr($LANG,0,2);
	
	if (file_exists(GSDATAOTHERPATH.'rfm_config.xml')) {
		$rfm_xml = getXML(GSDATAOTHERPATH . 'rfm_config.xml');
	}
	if(empty($rfm_xml->replace)) $GSEDITORBROWSER = FALSE;
	else $GSEDITORBROWSER = $rfm_xml->replace;
	if(empty($rfm_xml->toolbar)) $toolbar_ins = FALSE;
	else $toolbar_ins = $rfm_xml->toolbar;
	if($GSEDITORBROWSER) {
        $filebrowserBrowseUrl = "../plugins/responsivefilemanager/dialog.php?type=2&lang=".$lang_curr."&editor=ckeditor&fldr=";
        $filebrowserUploadUrl = "../plugins/responsivefilemanager/dialog.php?type=2&lang=".$lang_curr."&editor=ckeditor&fldr=";
        $filebrowserImageBrowseUrl = "../plugins/responsivefilemanager/dialog.php?type=1&lang=".$lang_curr."&editor=ckeditor&fldr=";
        $filebrowserWidth = $rfm_xml->w_width;
        $filebrowserHeight = $rfm_xml->w_height;

// gsconfig GSEDITOROPTIONS is stored in global $EDOPTIONS, you can append whatever you want
        GLOBAL $EDOPTIONS;
		GLOBAL $EDTOOL;
		$EDOPTIONS .= ',
		filebrowserBrowseUrl:"'.$filebrowserBrowseUrl.'"';
		$EDOPTIONS .= ',
		filebrowserImageBrowseUrl:"'.$filebrowserImageBrowseUrl.'"';
		$EDOPTIONS .= ',
		filebrowserWindowWidth:"'.$filebrowserWidth.'"';
		$EDOPTIONS .= ',
		filebrowserWindowHeight:"'.$filebrowserHeight.'"';
		$EDOPTIONS .= ',
		extraPlugins:"thumb"';
		if($toolbar_ins) {
			$EDTOOL='[["Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "NumberedList", "BulletedList", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock", "HorizontalRule", "Table", "TextColor", "BGColor", "Link", "Unlink", "Anchor", "Image", "Thumb", "Youtube"], "/", ["Styles", "Format", "FontSize", "Video", "Flash", "CreateDiv", "Iframe", "SpecialChar", "RemoveFormat", "Undo", "Redo", "Source"]]';
		}
		else {
			if(strpos($EDTOOL,'advanced') !== false) {
				$EDTOOL='[["Bold", "Italic", "Underline", "NumberedList", "BulletedList", "JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock", "Table", "TextColor", "BGColor", "Link", "Unlink", "Image", "RemoveFormat", "Source"],"/",["Styles","Format","Font","FontSize"]]';
			}
			if(strpos($EDTOOL,'basic') !== false) {
				$EDTOOL='[["Bold", "Italic", "Underline", "NumberedList", "BulletedList", "JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock", "Link", "Unlink", "Image", "RemoveFormat", "Source"]]';
			}
			$EDTOOL=str_replace(']]', ',"Thumb"]]', $EDTOOL);
			
		}
	}
}

function check_plugin() {
	if(!file_exists(GSADMINPATH.'template/js/ckeditor/plugins/thumb')) {
		if (!mkdir(GSADMINPATH.'template/js/ckeditor/plugins/thumb', 0777, true)) {
			die('Failed to create folders...');
			return false;
		}
		elseif (!mkdir(GSADMINPATH.'template/js/ckeditor/plugins/thumb/dialogs', 0777, true)) {
			die('Failed to create folders...');
			return false;
			}
				elseif (!mkdir(GSADMINPATH.'template/js/ckeditor/plugins/thumb/icons', 0777, true)) {
					die('Failed to create folders...');
					return false;
				}
		$myplugin = fopen(GSADMINPATH.'template/js/ckeditor/plugins/thumb/plugin.js', "w") or die("Unable to open file!");
		$line = "CKEDITOR.plugins.add( 'thumb', {
    icons: this.path + 'thumb',
    init: function( editor ) {
        editor.addCommand( 'thumbDialog', new CKEDITOR.dialogCommand( 'thumbDialog' ) );
        editor.ui.addButton( 'Thumb', {
            label: 'Insert Thumbnail',
            command: 'thumbDialog',
			icon: this.path + 'icons/thumb.png',
            toolbar: 'insert'
        });

        CKEDITOR.dialog.add( 'thumbDialog', this.path + 'dialogs/thumb.js' );
    }
});";
		fwrite($myplugin, $line);
		fclose($myplugin);
		$myplugin1 = fopen(GSADMINPATH.'template/js/ckeditor/plugins/thumb/dialogs/thumb.js', "w") or die("Unable to open file!");
		$line = "CKEDITOR.dialog.add( 'thumbDialog', function( editor ) {
	return {
		title : editor.lang.image.title,
		minWidth : 400,
		minHeight : 160,
		contents : [
			{
				id : 'general',
				label : 'Settings',
				elements : [
					{
						type : 'text',
						id : 'file_url',
						label : editor.lang.common.url,
						validate : CKEDITOR.dialog.validate.notEmpty( 'The link must have a URL.' ),
						required : true,
						commit : function( data )
							{
								data.file_url = this.getValue();
							}
					},
					{
						id:'img_url',
						type:'text',
						hidden : true,
						label:editor.lang.image.url,accessKey:'A',
						'default':'',
						commit : function( data )
							{
								data.img_url = this.getValue();
							}
					},
					{
						type : 'button',
						hidden : true,
						id : 'browse',
						style : 'display:inline-block;margin-bottom:10px;float: right;',
						align : 'center',
						label : editor.lang.common.browseServer,
						filebrowser : {
							action : 'Browse',
							onSelect : function( fileUrl, data ) {
								var dialog = this.getDialog();
								dialog.getContentElement( 'general', 'file_url' ).setValue( fileUrl.replace(\"uploads\", \"thumbs\") );
								dialog.getContentElement( 'general', 'img_url' ).setValue( fileUrl );
								return false;
							}
						}
					},
					{
						id:'txtAlt',
						type:'text',
						label:editor.lang.image.alt,accessKey:'A',
						'default':'',
						commit : function( data )
							{
								data.txtAlt = this.getValue();
							}
					},
					{
						type:'hbox',
						children:[
							{
								type: 'select',
								id: 'img_Align',
								label: editor.lang.common.align,
								items:[[editor.lang.common.notSet,''], [editor.lang.common.alignLeft,'left'],[editor.lang.common.alignRight,'right']],
								commit : function( data ) {
									data.img_Align = this.getValue();
								}
							},
							{
								type: 'select',
								id: 'img_loader',
								label: editor.lang.common.target,
								items:[[editor.lang.common.targetNew,'_blank'], [editor.lang.common.targetSelf,'_self'], ['prettyPhoto','prettyPhoto'], ['FancyBox','fancybox']],
								'default':'prettyPhoto',
								commit : function( data ) {
									data.img_loader = this.getValue();
								}
							},
							{
								id:'img_margins',
								type:'text',
								label:'Margins (px)',
								validate: CKEDITOR.dialog.validate.integer(editor.lang.common.validateNumberFailed),
								'default':'',
								commit : function( data ) {
									data.img_margins = this.getValue();
								}
							},
					]},
				]
			}
		],
		onOk : function() {
			var dialog = this, data = {}, reff = editor.document.createElement( 'a' ); 
			var styles = 'border: 0 none;';
			this.commitContent( data );
			if(data.img_margins) {
				styles = styles + ' margin: '+data.img_margins+'px;';
			}
			reff.setAttribute('href', data.img_url);
			if(data.img_loader == '_blank' || data.img_loader == '_self') {
				reff.setAttribute('target', data.img_loader);
			} else {
				reff.setAttribute('rel', data.img_loader);
			}
			if(data.img_Align == 'left' || data.img_Align == 'right') {
				styles = styles + ' float: '+data.img_Align+';';
			}
			reff.setHtml( '<img alt=\"'+data.txtAlt+'\" src=\"'+data.file_url+'\" style=\"'+styles+'\" />' );
			editor.insertElement( reff );
		}
	};
});";
		fwrite($myplugin1, $line);
		fclose($myplugin1);
		$icon_file = GSPLUGINPATH."responsivefilemanager/img/thumb.png";
		if(!file_exists($icon_file)) {
			$icon_file = GSPLUGINPATH."responsivefilemanager/img/thumbnail.png";
		}
		if (!copy($icon_file, GSADMINPATH.'template/js/ckeditor/plugins/thumb/icons/thumb.png')) {
			echo "failed to copy $icon_file...\n";
			return false;
		}
		return true;
	}
	return true;
}

function recursiveRemoveDirectory($directory) {
    foreach(glob("{$directory}/*") as $file) {
        if(is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}
?>