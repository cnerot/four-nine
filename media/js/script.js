$(document).ready(function () {
    showHideGift("hide");

    $("#nameGift").change(function () { // quand photo sélectionnée
        var nameGift = $("#nameGift").val();

        $("#infoNameGift").html(nameGift);

        showHideGift("show");
    });

    $(".cancelImageGift").click(function () { // clic annuler image lot
        $("#nameGift").val("");

        showHideGift("hide");
    });

    function showHideGift(showHide) {
        if (showHide == "show") {
            $(".containerImageGift").show();
            $(".cancelImageGift").show();
        } else {
            $(".containerImageGift").hide();
            $(".cancelImageGift").hide();
        }
    }

    $("#static-container-button").click(function () {
        var base_url = window.location.origin;
        $.ajax({url: base_url+"/pages/ajax", success: function(result){
             $("#static-container").append(result);
        }});
    });
	
	// page /photo
	
	$("#ValidFormSendPhotoFromFb").click(function(){
		// valide formulaire
		
		$("#typeSubmit").val("fb"); // envoi par fb			
		$("#formAddPhoto").submit();
	});
	
	$("#ValidFormSendPhotoFromFile").click(function(){
		// valide formulaire
		
		$("#typeSubmit").val("file"); // envoi par fichier ordinateur		
		$("#formAddPhoto").submit();
	});
	
	$(".addPhotoFrom").click(function(){
		if( $(this).attr("id")  == "addPhotoFromFile" ){
			$(this).attr("id", "addPhotoFromFb");
			$(this).val("Ajouter une photo depuis une image de votre compte facebook");
			$("#addPhotoFb").css("display", "none");
			$("#addPhotoFile").css("display", "block");
			$("#titleSourceDAajout").html("Ajout d'une image depuis votre ordinateur");
			
			$("#ValidFormSendPhotoFromFb").css("display", "none");
			$("#ValidFormSendPhotoFromFile").css("display", "inline");			
		}else{
			$(this).attr("id", "addPhotoFromFile");
			$(this).val("Ajouter une photo depuis une image de votre ordinateur");
			$("#addPhotoFb").css("display", "block");
			$("#addPhotoFile").css("display", "none");
			$("#titleSourceDAajout").html("Ajout d'une image depuis Facebook");
			
			$("#ValidFormSendPhotoFromFb").css("display", "inline");
			$("#ValidFormSendPhotoFromFile").css("display", "none");			
		}
			
	});
});
