$(document).ready(function () {
	console.log(alerts);
	alerts.forEach(function(element) {
		console.log(element);
		Materialize.toast(element, 4000);
	});
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
	
	if($("#hasPhotosFb").val() == 0){
		$(".titlePhoto").hide();
		$(".descriptionPhoto").hide();
		$(".reset").hide();
		$(".validate").hide();
	}
	
	$(".addPhotoFrom").click(function(){
		if( $(this).attr("id")  == "addPhotoFromFile" ){
			$(this).attr("id", "addPhotoFromFb");
			$(this).val("Ajouter une photo depuis une image de votre compte facebook");
			$("#addPhotoFb").css("display", "none");
			$("#addPhotoFile").css("display", "block");
			$("#titleSourceDAajout").html("Ajout d'une image depuis votre ordinateur");
			$("#helpSourceDAajout").html("Cliquez sur le bouton d'upload d'image");
			
			$(".titlePhoto").show();
			$(".descriptionPhoto").show();
			$(".reset").show();
			$(".validate").show();
			
			$("#ValidFormSendPhotoFromFb").css("display", "none");
			$("#ValidFormSendPhotoFromFile").css("display", "inline");			
		}else{
			$(this).attr("id", "addPhotoFromFile");
			$(this).val("Ajouter une photo depuis une image de votre ordinateur");
			$("#addPhotoFb").css("display", "block");
			$("#addPhotoFile").css("display", "none");
			
			if($("#hasPhotosFb").val() == 1){
				$("#titleSourceDAajout").html("Ajout d'une image depuis Facebook");
				$("#helpSourceDAajout").html("Sélectionnez une image en cochant le bouton radio");
				$(".titlePhoto").show();
				$(".descriptionPhoto").show();
				$(".reset").show();
				$(".validate").show();
			}else{
				$("#titleSourceDAajout").html("");
				$("#helpSourceDAajout").html("");
				$(".titlePhoto").hide();
				$(".descriptionPhoto").hide();
				$(".reset").hide();
				$(".validate").hide();
			}			
			
			
			$("#ValidFormSendPhotoFromFb").css("display", "inline");
			$("#ValidFormSendPhotoFromFile").css("display", "none");			
		}
			
	});
	
	// vérifie si l'on montre ou cache le bouton
	//testHideButtonSeeMorePhotos();
	
	$("#seeMorePhotos").click(function(){
		var nbPhotosToDisp = $("#nbPhotosToDisp").val();

		for(var i = 1; i<parseInt(nbPhotosToDisp)+1; i++){
			$("."+parseInt(parseInt(nbPhotosToDisp)+i)).show();
		}
		
		$("#nbPhotosToDisp").val((parseInt(nbPhotosToDisp)+8));
		
		//testHideButtonSeeMorePhotos();
	});
	
	$('.carousel').carousel();
	// Next slide
	$('.carousel').carousel('next');
	$('.carousel').carousel('next', 3); // Move next n times.
	// Previous slide
	$('.carousel').carousel('prev');
	$('.carousel').carousel('prev', 4); // Move prev n times.
	// Set to nth slide
	$('.carousel').carousel('set', 4);
	
	$("[name='resetCarrousel']").click(function(){
		$('.carousel').carousel();
	});
	
	// date format français	
	var date;
	var dateSplit;
	var y, m, d;
	
	for(var i = 0; i<$(".dateFR").length; i++){
		date = $(".dateFR").eq(i).html().split(" ")[0];
		dateSplit = date.split('-');
		
		y = dateSplit[0];
		m = dateSplit[1];
		d = dateSplit[2];

		$(".dateFR").eq(i).html(d+"/"+m+"/"+y);
	}
	
	$('.datepicker').Picker({
	  labelMonthNext: 'Mois suivant',
	  labelMonthPrev: 'Mois passé',
	  labelMonthSelect: 'Sélectionnez un mois',
	  labelYearSelect: 'Sélectionnez une année',
	  monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
	  monthsShort: [ 'Jan', 'Feb', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc' ],
	  weekdaysFull: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
	  weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
	  weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
	  today: 'Aujourd\'hui',
	  clear: 'Effacer',
	  close: 'Fermer'
	});
});

function selectedPic(){
    $('.image_upload').each(function () {
        $(this).css('border', '1px solid white');
        $('input[name=idPhotoFbToSend]').prop("checked", false); 
    });
}
$('.image_upload').each(function () {
    $(this).click(function () {
            selectedPic();
            $(this).css('border', '3px solid #1E90FF');
            $('input[name=idPhotoFbToSend]').prop("checked", true);
    });
});
