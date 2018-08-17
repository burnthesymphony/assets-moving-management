var index = 0;
var AjxUp = new Array();
var txtBrowse = "Select File..";
var txtCaption = "Caption..";
var txtImgsource = "Image Source..";

var paging, galleryClose, search;

$(document).ready(function(){
	// $( "#img-sortable" ).sortable();
	// $( "#img-sortable" ).disableSelection();
	$( ".img-box img" ).tipsy({gravity: 'w', html: true, trigger: 'manual', 'title' : tipsyTitle});
	$( ".edit-caption" ).click(showTipsy);
	
	$("a.nyroModal").nm();
	
	$("#showUploadBox").click(function(){
		index++;
		div = $("<div />").append(
			$("<input id='images_"+index+"' class='imageBrowser' name='image' value='"+txtBrowse+"' />")
		).append(
			$("<input class='images_"+index+" imgcaption' value='"+txtCaption+"' />")
		).append(
			$("<input class='source_images_"+index+" imgsource' value='"+txtImgsource+"' />")
		).append(
			$("<input type='button' class='remButton' onclick='del(this)' value='-' style='width:20px;'/>")
		).append(
			$("<hr style='margin: 3px 0px' />")
		).appendTo("#uploadBox");
		bindAjaxUpload(index);
		bindCaptionFocus();
		
		if($("#submit").length == 0)
			$(".remButton").after("<input type='button' style='height:26px;float:none;' onclick='upload()' value='Upload' id='submit' />");
		
		return false;
	});
});

function bindAjaxUpload(id){
	AjxUp['images_'+id] = new AjaxUpload('images_'+id, {
		action: 'http://localhost/hikmah/admin/image/upload',
		autoSubmit : false,
		onSubmit : function(file, ext){
	//		if($(".img-box").length >= 1) return false;
			
			if (!ext || !(/^(jpg|png|jpeg|gif)$/i.test(ext))){
				alert("File with extension '"+ ext +"' is not allowed!");
				return false;
			}
			$('#images_'+id).parent().attr("id", 'images_'+id).html("<span>Uploading "+file+"</span>");
		},
        onChange: function(file, extension){
			$('#images_'+id).val(file);
        },
		onComplete : function(file, responses){
			var response = responses.split('|');
			
			if(response.length === 4 && response[0] === 'ok')
			{
				$("#images_"+id).remove();
				
				$("<div />").attr({
					'class' : 'img-box',
					id : 'img-'+response[1],
				}).append(
					$("<img src='http://localhost/hikmah/files/media/uploads/images/kategori/"+response[2]+"' alt='"+response[3]+"' title='"+response[3]+"' align=\"left\" width='33' />")
				).append(
					$("<input type='hidden' name='image[]' value='"+response[2]+"' />")
				).append(
					$("<input type='hidden' name='news_image[]' value='"+response[1]+"' />")
				).append(
					$("<input type='text' name='image_caption[]' value='"+response[3]+"' size=\"73\" /><br /><br />")
				).append(
					$("<a href='javascript:del(this)' onclick='del(this, true);'>Remove</a>")
				).css({
					width: 'auto'
				}).appendTo("#img-sortable");
				$( ".img-box img" ).tipsy({gravity: 'w', html: true, trigger: 'manual', 'title' : tipsyTitle});
				
				$("#media-image").hide();
			}
			else
			{
				alert('An error has occured.\n\n' + responses+'\n\nPlease try again.');
				$("#images_"+id).remove();
			}
		},
	});
}

function upload() {
	$(".imageBrowser").each(function(i, obj) {
		id = $(obj).attr("id");
		
		if($(this).val() == txtBrowse) {
			alert("Please browse a file");
			return false;
		}
		if($("."+id).val() == txtCaption) {
			alert("Caption cannot be blank");
			return false;
		}
		imgsource = ($('.source_'+id).val() != txtImgsource) ? $('.source_'+id).val() : "";
		
		AjxUp[id].setData({caption : $('.'+id).val(), imgsource : imgsource});
		AjxUp[id].submit();
	});
}

function insert(obj) {
	if($("#img-"+$(obj).attr('id')).length == 0 && $(".img-box").length < 1) {
		$("<div />").attr({
			'class' : 'img-box',
			id : "img"+$(obj).attr('id'),
		}).append(
			$("<img src='"+$(obj).attr('src')+"' alt='"+$(obj).attr('alt')+"' title='"+$(obj).attr('title')+"' width='80' align=\"left\" />")
		).append(
			$("<input type='hidden' name='news_image[]' value='"+$(obj).attr('id')+"' />")
		).append(
			$("<input type='text' name='image_caption[]' value='"+$(obj).attr('alt')+"' size=\"73\" /><br /><br />")
		).append(
			$("<a href='javascript:del(this)' onclick='del(this, true);'>Remove</a>")
		).css({
			width: 'auto'
		}).appendTo("#img-sortable");
		
		// $( ".img-box img" ).tipsy({gravity: 'w', html: true, trigger: 'manual', 'title' : tipsyTitle});
		
		$("#media-image").hide();
		$.nyroModalRemove();
	}
	
	return false;
}

function del(obj, confirm) {
	$(obj).parent().remove();
	$("#media-image").show();
}

function bindCaptionFocus() {
	focus = function() {
		if($(this).val() == txtCaption || $(this).val() == txtImgsource) $(this).val("");
		return true;
	};
	blur = function() {
		if($(this).val() == "") $(this).val(txtCaption);
	};
	
	$(".imgcaption").unbind('focus', focus).bind('focus', focus).unbind('blur', blur).bind('blur', blur);
	$(".imgsource").unbind('focus', focus).bind('focus', focus);
}

function showTipsy(obj) {
	if(obj == null) obj = this;
	$(obj).prevAll( "img" ).tipsy('show');
	return false;
}

function tipsyTitle(obj) {
	title = $(obj).attr('original-title');
	index = $(obj).index(".img-box img");
	return "<input type='text' name='caption[]' style='width: 350px' value='"+title+"' /> <input type='button' value='OK' onclick='updateCaption(this, "+index+")' />";
}

function updateCaption(obj, index) {
	newval = $(obj).prev().val();
	$($(".img-box img").get(index)).attr('original-title', newval).nextAll(".caption-hidden").val(newval);
	$(obj).parent().parent().remove();
}
