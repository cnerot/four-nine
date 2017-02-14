
var $overlay = $('<div id="overlay"></div>');
var $image = $("<img>");
var $caption = $("<p></p>");
//An image to overlay
$overlay.append($image);
var $leftArrow = $("<div id='leftArrow'></div>");
var $rightArrow = $("<div id='rightArrow'></div>");
var $closeLightbox = $("<div id='closeLightbox'></div><div style='clear:both'></div>");
//var $form =$('<div id="rating"> <form method="post" action="/Concours/vote/" id="ratingsForm"> <div class="stars"><input type="radio" name="star" value="1" class="star-1" id="star-1" /> <label class="star-1" for="star-1">1</label><input type="radio" value="2" name="star" class="star-2" id="star-2" /><label class="star-2" for="star-2">2</label><input type="radio" value="3" name="star" class="star-3" id="star-3" /><label class="star-3" for="star-3">3</label><input type="radio" value="4" name="star" class="star-4" id="star-4" /><label class="star-4" for="star-4">4</label><input type="radio" name="star" value="5" class="star-5" id="star-5" /><label class="star-5" for="star-5">5</label><span></span></div></form></div>');

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
    //$caption.append($form);
    var base_url = window.location.origin;
    //alert(base_url+'/concours/ajax');
    $.ajax({url: base_url+'/concours/ajax' , success: function(result){
        $caption.append(result);
        document.getElementById("star-1").addEventListener("click", voteFunction1);
        document.getElementById("star-2").addEventListener("click", voteFunction2);
        document.getElementById("star-3").addEventListener("click", voteFunction3);
        document.getElementById("star-4").addEventListener("click", voteFunction4);
        document.getElementById("star-5").addEventListener("click", voteFunction5);
    }});

}
function voteFunction1() {
    $.post('/concours/ajax', { star: $("#star-1").val()
        }, function(data) {
            alert($("#star-1").val());

        });
}
function voteFunction2() {
    $.post('/concours/ajax', { star: $("#star-2").val()
        }, function(data) {
            alert($("#star-2").val());

        });
}
function voteFunction3() {
    $.post('/concours/ajax', { star: $("#star-3").val()
        }, function(data) {
            alert($("#star-3").val());

        });}
function voteFunction4() {
    $.post('/concours/ajax', { star: $("#star-4").val()
        }, function(data) {
            alert($("#star-4").val());

        });
}
function voteFunction5() {
    $.post('/concours/ajax', { star: $("#star-5").val()
        }, function(data) {
            alert($("#star-5").val());

        });
}

function getPrevImage() {
    imageParent = $(thisImage).parent().prev();;
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
