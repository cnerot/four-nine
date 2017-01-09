var $overlay = $('<div id="overlay"></div>');
var $image = $("<img>");
var $caption = $("<p></p>");
var $voting= $('<div class="rating rating2">\n\
                        <a href="#5" title="Give 5 stars">★</a>\n\
                        <a href="#4" title="Give 4 stars">★</a>\n\
                        <a href="#3" title="Give 3 stars">★</a>\n\
                        <a href="#2" title="Give 2 stars">★</a>\n\
                        <a href="#1" title="Give 1 star">★</a>\n\
                     </div>');
//An image to overlay
$overlay.append($image);


var $leftArrow = $("<div id='leftArrow'></div>");
var $rightArrow = $("<div id='rightArrow'></div>");
var $closeLightbox = $("<div id='closeLightbox'></div><div style='clear:both'></div>");
var $voting= $('<div class="rating rating2"><a href="#5" title="Give 5 stars">★</a><a href="#4" title="Give 4 stars">★</a><a href="#3" title="Give 3 stars">★</a><a href="#2" title="Give 2 stars">★</a><a href="#1" title="Give 1 star">★</a></div>');

$image.before($closeLightbox);
$image.before($leftArrow);
$image.after($rightArrow);
//$image.in($voting);

//A caption to overlay
$overlay.append($caption);

//Add overlay
$("body").append($overlay);

//Capture the click event on a link to an image
$("#imageGallery a").click(function(event){
  event.preventDefault();
  
  getCurrentImage(this);

  //Show the overlay.
  $overlay.show();
});

$leftArrow.click(function(){
  getPrevImage();
});

$rightArrow.click(function(){
  getNextImage();
});

function getCurrentImage (currentImage) {  
    thisImage = currentImage;
    var imageLocation = $(currentImage).attr("href");
    //Update overlay with the image linked in the link
    $image.attr("src", imageLocation);
    $image.attr("width", "600px");
    $image.attr("height", "400px");
    //$image.append($voting);
    //Get child's alt attribute and set caption
    var captionText = $(currentImage).children("img").attr("title");
    //$(currentImage).children("img").append($voting);
    $caption.text(captionText);
    $caption.after($voting);
}

function getPrevImage() {
    imageParent = $(thisImage).parent().prev();
    if(imageParent.length!=0){
      thisImage = $(imageParent).children("a");
    // imageLocation = $(thisImage).attr("href");
    // $image.attr("src", imageLocation);
    }
    getCurrentImage(thisImage);
    
}

function getNextImage() {
    imageParent = $(thisImage).parent().next();
    if(imageParent.length!=0){
    thisImage = $(imageParent).children("a");
      // imageLocation = $(thisImage).attr("href");
      // $image.attr("src", imageLocation);
    }
    getCurrentImage(thisImage);
}

//When overlay is clicked
$closeLightbox.click(function(){
  //Hide the overlay
  $overlay.hide();
});
