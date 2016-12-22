$(document).ready(function(){
	showHideGift("hide");
	
	$("#nameGift").change(function(){ // quand photo sélectionnée
		var nameGift = $("#nameGift").val();
	
		$("#infoNameGift").html(nameGift);
		
		showHideGift("show");
	});
	
	$(".cancelImageGift").click(function(){ // clic annuler image lot
		$("#nameGift").val("");
		
		showHideGift("hide");
	});
	
	function showHideGift(showHide){
		if(showHide == "show"){
			$(".containerImageGift").show();
			$(".cancelImageGift").show();
		}else{
			$(".containerImageGift").hide();
			$(".cancelImageGift").hide();
		}
	}
});