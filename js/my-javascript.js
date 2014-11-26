jQuery(document).ready(function() {
jQuery('#Logo_button').click(function() {
 formfield = jQuery('#Logo').attr('name');
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#Logo').val(imgurl);
 tb_remove();
}
});