$(document).ready(function(){

    //AUTOCOMPLETE
    $('.autocompleteItem input').tagit({
        tagLimit: 3,
        autocomplete: {
            minLength: 2,
            source: function(request, response) {
                $.getJSON($('.formPages').data('url'), {
                    term: extractLast(request.term)
                }, response);
            }
        }
    });


    //SUBSCRIBE
    var triggerPromotion = function() {
        if ($('.choicePromotion input:checked').val()=='promoted') {
            $('.formFieldsPromoted').show();
        } else {
            $('.formFieldsPromoted').hide();
        }
    }
    triggerPromotion();
    $('.choicePromotion input').on('change', function(){
        triggerPromotion();
    });

    //INSCRIPTION
    activateCK();
    fixHeights();
    if ($('.formPages').length > 0) {
        
        $(document).on('submit', '#formPlaceEdit', function(evt) {
            if (evt.delegateTarget.activeElement.type!=="submit") {
                evt.preventDefault();
            }
            var recaptcha = $("#g-recaptcha-response").val();
            if (recaptcha === "") {
                evt.preventDefault();
                $('.formField-captcha').addClass('errorField');
            }
        });

        // Pages
        var pageActive = 0;
        var changePage = function() {
            $('.formPage').hide();
            $('.formPage:eq(' + pageActive + ')').show();
            $('.formSubmitWrapper').hide();
            (pageActive == 0) ? $('.formButtonPrev').hide() : $('.formButtonPrev').show();
            (pageActive >= $('.formPage').length-1) ? $('.formButtonNext').hide() : $('.formButtonNext').show();
            (pageActive >= $('.formPage').length-1) ? $('.formButtons').addClass('formButtonsBottom') : $('.formButtons').removeClass('formButtonsBottom');
            if (pageActive == $('.formPage').length-1) {
                $('.formSubmitWrapper').show();
            }
        }
        var checkErrors = function() {
            var errors = [];
            $('.formField-title').removeClass('errorField');
            $('.formField-address').removeClass('errorField');
            $('.formField-city').removeClass('errorField');
            $('.formField-cityother').removeClass('errorField');
            $('.formField-shortdescription').removeClass('errorField');
            $('.formField-nameeditor').removeClass('errorField');
            $('.formField-emaileditor').removeClass('errorField');
            $('.formField-idtag').removeClass('errorField');
            if (pageActive == 1) {
                if ($('.formField-title input').val().trim()==='') {
                    errors.push('title');
                    $('.formField-title').addClass('errorField');
                }
            }
            if (pageActive == 2) {
                if ($('.formField-email input').val().trim()!='' && !validateEmail($('.formField-email input').val())) {
                    errors.push('email');
                    $('.formField-email').addClass('errorField');
                }
            }
            if (pageActive == 4) {
                if ($('.formField-address textarea').val().trim()==='') {
                    errors.push('address');
                    $('.formField-address').addClass('errorField');
                }
                if ($('.formField-city select').is(':visible') && $('.formField-city select').val().trim()==='') {
                    errors.push('city');
                    $('.formField-city').addClass('errorField');
                }
                if ($('.formField-cityother input').is(':visible') && $('.formField-cityother input').val().trim()==='') {
                    errors.push('cityother');
                    $('.formField-cityother').addClass('errorField');
                }
            }
            if (pageActive == 5) {
                if ($('.formField-shortdescription textarea').val().trim()==='') {
                    errors.push('shortdescription');
                    $('.formField-shortdescription').addClass('errorField');
                }
                if ($('.formField-idtag input').val().trim()==='') {
                    errors.push('idtag');
                    $('.formField-idtag').addClass('errorField');
                }
            }
            if (pageActive == 8) {
                if ($('.formField-nameeditor input').val().trim()==='') {
                    errors.push('nameeditor');
                    $('.formField-nameeditor').addClass('errorField');
                }
                if ($('.formField-emaileditor input').val().trim()==='' || !validateEmail($('.formField-emaileditor input').val())) {
                    errors.push('emaileditor');
                    $('.formField-emaileditor').addClass('errorField');
                }
            }
            return errors;
        }
        $(document).on('click touch', '.formButtonNext', function(evt) {
            if (checkErrors().length == 0) {
                pageActive = (pageActive < $('.formPage').length-1) ? pageActive + 1 : pageActive;
                if (pageActive==10 && $('input[name=choicePromotion]').val()=='not-promoted') {
                    pageActive = pageActive + 1;
                }
                changePage();
            }
        });
        $(document).on('click touch', '.formButtonPrev', function(evt) {
            if (pageActive==11 && $('input[name=choicePromotion]').val()=='not-promoted') {
                pageActive = pageActive - 1;
            }
            pageActive = (pageActive > 0) ? pageActive - 1 : 0;
            changePage();
        });
        if ($('.formPage').length > 0) {
            changePage();
        }

        // City
        $(document).on('click touch', '.triggerCity', function(evt) {
            $('.triggerCitySelect').hide();
            $('.triggerCityInfo').show();
        });

        // Promotion
        $(document).on('click touch', '.formPromotionItem', function(evt) {
            $('.formPromotionItem i').removeClass('icon-checked');
            $(this).find('i').addClass('icon-checked');
            var value = $(this).data('value');
            $('input[name=choicePromotion]').val(value);
        });

        // Promotion
        $(document).on('click touch', '.formPaymentItem', function(evt) {
            $('.formPaymentItem i').removeClass('icon-checked');
            $(this).find('i').addClass('icon-checked');
            var value = $(this).data('value');
            $('input[name=choicePayment]').val(value);
        });

        // Image
        $(document).on('change', '.uploadLogo input', function(evt){
            var imageFile = $(this).prop('files');
            if (imageFile.length > 0 && (imageFile[0].type=='image/png' || imageFile[0].type=='image/jpg' || imageFile[0].type=='image/jpeg')) {
                var imageFile = imageFile[0];
                var fileSize = imageFile.size;
                if (fileSize > 3000000) {
                    $(this).val(null);
                    $('.uploadLogoImage').html('');
                    $('.uploadLogoMessage').html('<div class="message messageError">No aceptamos archivos que pesen mas de 3Mb</div>');
                } else {
                    var fileReader = new FileReader();
                    fileReader.onload = function(fileLoadedEvent) {
                        var srcData = fileLoadedEvent.target.result;
                        $('.uploadLogoImage').html('<img src="' + srcData + '"/>');
                        $('.uploadLogoMessage').html('');
                        if (fileSize > 1000000) {
                            $('.uploadLogoMessage').html('<div class="message">El archivo pesa mas de 1Mb, es probable que tome tiempo en cargar al sistema</div>');
                        }
                    }
                    fileReader.readAsDataURL(imageFile);
                }
            } else {
                $(this).val(null);
                $('.uploadLogoImage').html('');
                $('.uploadLogoMessage').html('<div class="message messageError">La imagen debe ser un archivo JPG o PNG</div>');
            }
        });


    }

    //RATING
    var activateStars = function() {
        $('.ratingAllWrapper').each(function(index, ele){
            var valueRating = $(ele).find('input').val() * 1;
            $(ele).find('.rating i').removeClass('icon-star');
            $(ele).find('.rating i').addClass('icon-star-empty');
            for (var i=0; i<valueRating; i++) {
                $(ele).find('.rating i').eq(i).addClass('icon-star');
            }
        });
    }
    activateStars();
    $(document).on('click touch', '.rating', function(evt){
        var inputText = $(this).parents('.ratingAllWrapper').first().find('input');
        inputText.val($(this).data('rating'));
        activateStars();
    });

    //MAPS
    //activateMaps();

    //SMOOTH SCROLL
    smoothScroll();

});

$(window).load(function() {
    fixHeights();
});

$(window).resize(function() {
    fixHeights();
});

$(window).scroll(function() {
});

function activateMenu() {
	$('.menuMobile').click(function(){
		$('.menuWrapper').toggle();
	});
}

function activateMaps() {
    if ($('.pointMap').length > 0) {
        $('.pointMap').each(function(index, ele){
            var initLat = $(ele).data('initlat') * 1;
            var initLng = $(ele).data('initlng') * 1;
            var initZoom = $(ele).data('initzoom') * 1;
            var mapLat = $(ele).find('.map').data('lat') * 1;
            var mapLng = $(ele).find('.map').data('lng') * 1;
            var mapZoom = $(ele).find('.map').data('zoom') * 1;
            var mapIns = $(ele).find('.mapIns');
            var inputLat = $(ele).find('.inputLat');
            var inputLng = $(ele).find('.inputLng');
            var checkboxShowHide = $(ele).find('.showHide input[type=checkbox]');
            var activateSingleMap = function() {
                mapLat = (mapLat!=0) ? mapLat : initLat;
                mapLng = (mapLng!=0) ? mapLng : initLng;
                mapZoom = (mapZoom!=0) ? mapZoom : initZoom;
                inputLat.val(mapLat);
                inputLng.val(mapLng);
                var mapOptions = {
                    zoom: mapZoom,
                    center: new google.maps.LatLng(mapLat, mapLng)
                };
                var mapEle = new google.maps.Map(document.getElementById(mapIns.attr('id')), mapOptions);
                markerPort = new google.maps.Marker({
                    position: new google.maps.LatLng(mapLat, mapLng),
                    map: mapEle
                });
                google.maps.event.addListener(mapEle, 'click', function(newPosition) {
                    markerPort.setPosition(newPosition.latLng);
                    inputLat.val(newPosition.latLng.lat());
                    inputLng.val(newPosition.latLng.lng());
                });
            }
            if (checkboxShowHide.length > 0) {
                if (mapLat=='' || mapLng=='') {
                    checkboxShowHide.attr('checked', false);
                    $('.map').hide();
                } else {
                    checkboxShowHide.attr('checked', true);
                    activateSingleMap();
                }
                checkboxShowHide.click(function(){
                    if ($(this).is(':checked')) {
                        $('.map').show();
                        activateSingleMap();
                    } else {
                        $('.map').hide();
                        inputLat.val('');
                        inputLng.val('');
                    }
                });
            } else {
                activateSingleMap();
            }
        });
    }
}

function smoothScroll() {
    $('a[href*="#"]')
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function(event) {
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                &&
                location.hostname == this.hostname
            ) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000, function() {
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) {
                            return false;
                        } else {
                            $target.attr('tabindex','-1');
                            $target.focus();
                        };
                    });
                }
            }
        });
}

function fixHeights() {
    $('.contentWrapper-form .contentWrapperIns').css('min-height', $(window).height() - 70);
    $('.formPagesWrapper .formPages .formPage').css('min-height', $(window).height() - 140);
}

function activateCK() {
    $('.ckeditorArea textarea').each(function(index, ele){
        if ($(ele).attr('rel') != 'ckeditor') {
            $(ele).attr('rel', 'ckeditor');
            if ($(ele).attr('id')=='' || $(ele).attr('id')==undefined) {
                $(ele).attr('id', randomString());
            }
            CKEDITOR.replace($(ele).attr('id'), {
                height: '450px',
                toolbar: [
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                    '/',
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks', 'CodeSnippet' ] },
                ]
            });
        }
    });
    $('.ckeditorAreaSimple textarea').each(function(index, ele){
        if ($(ele).attr('rel') != 'ckeditor') {
            $(ele).attr('rel', 'ckeditor');
            if ($(ele).attr('id')=='' || $(ele).attr('id')==undefined) {
                $(ele).attr('id', randomString());
            }
            CKEDITOR.replace($(ele).attr('id'), {
                height: '250px',
                toolbar: [
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup', 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList'] },
                ]
            });
        }
    });
}

function randomString() {
    return Math.random().toString(36).substring(7);
}

function split( val ) {
    return val.split( /,\s*/ );
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function extractLast( term ) {
    return split( term ).pop();
}
