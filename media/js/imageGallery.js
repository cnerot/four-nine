$(document).ready(function(){
	dispStars(4, "_small");
	
	$('.link-gallery').click(function(){
		var galleryId = $(this).attr('data-target');
		var currentLinkIndex = $(this).index('a[data-target="'+ galleryId +'"]');

		createGallery(galleryId, currentLinkIndex);
		/*createStars(galleryId, currentLinkIndex);*/
		//createPagination(galleryId, currentLinkIndex);

		$(galleryId).on('hidden.bs.modal', function (){
			destroyGallry(galleryId);
			destroyPagination(galleryId);
		});

		$(galleryId +' .carousel').on('slid.bs.carousel', function (){
			var currentSlide = $(galleryId +' .carousel .item.active');
			var currentSlideIndex = currentSlide.index(galleryId +' .carousel .item');

			setTitle(galleryId, currentSlideIndex);
			//setPagination(++currentSlideIndex, true);
		})
	});
	
	function dispStars(nbYellowStars, nameSize){		
		var nbMaxStars = 5; // nombre d'étoiles possibles : 5
		var imgStar = '';			
		
		for(var i = 0; i<nbYellowStars; i++){
			imgStar += '<img class="yellow" src="/media/images/star_yellow'+nameSize+'.png">'
		}
		
		for(var i = 0; i<nbMaxStars - nbYellowStars; i++){
			imgStar += '<img class="white" src="/media/images/star_white'+nameSize+'.png">'
		}
		
		var stars = imgStar;
		
		$(".gallery-item .imgStars").html(stars);
	}
	
	function createGallery(galleryId, currentSlideIndex){
		var galleryBox = $(galleryId + ' .carousel-inner');

		$('a[data-target="'+ galleryId +'"]').each(function(){
			var img = $(this).html();
			
			nbYellowStars = 4; // à récupérer

			var nbMaxStars = 5; // nombre d'étoiles possibles : 5
			var imgStar = '';			
			
			for(var i = 0; i<nbYellowStars; i++){
				imgStar += '<img class="yellow" src="/media/images/star_yellow.png">'
			}
			
			for(var i = 0; i<nbMaxStars - nbYellowStars; i++){
				imgStar += '<img class="white" src="/media/images/star_white.png">'
			}
			
			var stars = '<div>'+imgStar+'</div>';
			
			var title = 'Titre 1'; // titre récupéré			
			var imgTitle = '<h1>'+title+'</h1>';
			
			var description = 'Description 1'; // description récupérée
			var imgDescription = '<p class="descriptionGallery">'+description+'</p>';
			
			var leftArrow = '<ul class="pagination paginationLeft col-xs-1">';
			     leftArrow += '<li><a data-slide="prev" href="#carouselGallery"></a></li>';
			  leftArrow += '</ul>';
			  
			  //leftArrow = '';			  
			  
			var rightArrow = '<ul class="pagination paginationRight col-xs-1">';
			     rightArrow += '<li><a data-slide="next" href="#carouselGallery"></a></li>';
			  rightArrow += '</ul>';
			  
			  //rightArrow = '';
			
			var galleryItem = $('<div class="item row">'+leftArrow+'<div class="containerPost"> <div class="imageGrand col-xs-5">'+ img + '</div><div class="stars center col-xs-5">' + stars + imgTitle + imgDescription + '</div> </div>'+rightArrow+'</div>');
			
			
			
			galleryItem.appendTo(galleryBox);
		});

		galleryBox.children('.item').eq(currentSlideIndex).addClass('active');
				
		setTitle(galleryId, currentSlideIndex);
	}

	function destroyGallry(galleryId){
		$(galleryId + ' .carousel-inner').html("");
	}
	
	/*function createStars(galleryId, currentSlideIndex){
		var pagination = $(galleryId + ' .pagination');
		var carouselId = $(galleryId).find('.carousel').attr('id');
		var star = $('<li><a href="#'+ carouselId +'" data-slide="prev"></a></li>');
		//var nextLink = $('<li><a href="#'+ carouselId +'" data-slide="next">»</a></li>');

		//star.appendTo(pagination);
		//nextLink.appendTo(pagination);

		$('a[data-target="'+ galleryId +'"]').each(function(){
			//var linkIndex = $(this).index('a[data-target="'+ galleryId +'"]');
			//var paginationLink = $('<li><a data-target="#carouselGallery" data-slide-to="'+ linkIndex +'">'+ (linkIndex+1) +'</a></li>');
			$();
			$(".stars").attr("name", nbStars);
			//paginationLink.insertBefore('.pagination li:last-child');
			console.log("ok");
		});

		//setPagination(++currentSlideIndex);
	}*/
	
	//function createPagination(galleryId, currentSlideIndex){
		//var pagination = $(galleryId + ' .pagination');
		//var carouselId = $(galleryId).find('.carousel').attr('id');
		//var prevLink = $('<li><a href="#'+ carouselId +'" data-slide="prev">«</a></li>');
		//var nextLink = $('<li><a href="#'+ carouselId +'" data-slide="next">»</a></li>');
//
		//prevLink.appendTo(pagination);
		//nextLink.appendTo(pagination);
//
		//$('a[data-target="'+ galleryId +'"]').each(function(){
			//var linkIndex = $(this).index('a[data-target="'+ galleryId +'"]');
			//var paginationLink = $('<li><a data-target="#carouselGallery" data-slide-to="'+ linkIndex +'">'+ (linkIndex+1) +'</a></li>');
//
			//paginationLink.insertBefore('.pagination li:last-child');
		//});
//
		//setPagination(++currentSlideIndex);
	//}

	//function setPagination(currentSlideIndex, reset = false){
		//if (reset){
			//$('.pagination li').removeClass('active');
		//}
//
		//$('.pagination li').eq(currentSlideIndex).addClass('active');
	//}

	function destroyPagination(galleryId){
		$(galleryId + ' .pagination').html("");
	}

	function setTitle(galleryId, currentSlideIndex){
		var imgAlt = $(galleryId + ' .item').eq(currentSlideIndex).find('img').attr('alt');

		$('.modal-title').text(imgAlt);
	}
});
