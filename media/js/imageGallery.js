var currentImage;
function showoverlay() {
    var overlay = $("#overlay");
    overlay.css("display", "block");
}
function hideoverlay() {
    var overlay = $("#overlay");
    overlay.css("display", "none");
}
function setCurrentImage(url) {
    var image = $('#overlay_image');
    image.attr('src', url);

}
function setCurrentLink(link) {
    var image = $('#overlay_image');
    image.attr('data-extra', link);
}
function nextImage() {
    currentImage = $(currentImage).next();
    setCurrentImage($(currentImage).data('source'));
    setCurrentLink($(currentImage).data('link'));
    resetStars();
}
function previousImage() {
    currentImage = $(currentImage).prev();
    setCurrentImage($(currentImage).data('source'));
    setCurrentLink($(currentImage).data('link'));
    resetStars();
}
function resetStars(){
    $('[name="star"]').each(function () {
        console.log(this);
        $(this).prop('checked', false);

    });
}
$('[name="image_div"]').each(function () {
    $(this).click(function () {
        currentImage = this;
        showoverlay();
        setCurrentImage($(this).data('source'));
        setCurrentLink($(this).data('link'));
    });
});
$('[name="star"]').each(function () {
    $(this).click(function () {
        var data = {
            'grade': $(this).val(),
            'link' : $('#overlay_image').data('extra')
        };
        $.ajax({
            url: $(this).parent().parent().attr('action'),
            type: 'POST',
            data: data,
            success: function (code_html, statut) {
                Materialize.toast('Merci d\'avoir voté.', 4000);
            }
        });
    });
})
;

