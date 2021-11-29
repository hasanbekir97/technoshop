$(document).ready(function() {



});
function numberFormat(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
        dec = typeof dec_point === 'undefined' ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
function calcAll(){
    var totalWeight = 0;
    var totalanzahl = 0;
    var totallange = 0;
    var totalbreite = 0;
    var totalhohe = 0;
    var totalgewicht = 0;

    $('#list').find('tr').each (function( column, tr) {
        var anzahl = parseInt($(this).find('.anzahl').val());
        var lange = parseInt($(this).find('.lange').val());
        var breite = parseInt($(this).find('.breite').val());
        var hohe = parseInt($(this).find('.hohe').val());
        var gwicht = parseInt($(this).find('.gwicht').val());



        if(anzahl>0){
            totalanzahl+=anzahl;
        }
        if(lange>0){
            totallange+=lange;
        }
        if(breite>0){
            totalbreite+=breite;
        }
        if(hohe>0){
            totalhohe+=hohe;
        }
        if(gwicht>0){
            totalgewicht+=gwicht;
        }


        if(anzahl>0 && lange>0 && breite>0 && hohe>0 && gwicht>0){

            calcKG = anzahl * lange * breite * hohe / 6000;
            if(calcKG>=0.01){
                totalWeight = totalWeight+calcKG;
            }
        }

    });



    $(".totalanzahl").text(numberFormat(totalanzahl, 2, ',', '.'));
    $(".totalanzahl").text(numberFormat(totalanzahl, 2, ',', '.'));
    $(".totallange").text(numberFormat(totallange, 2, ',', '.'));
    $(".totalbreite").text(numberFormat(totalbreite, 2, ',', '.'));
    $(".totalhohe").text(numberFormat(totalhohe, 2, ',', '.'));
    $(".totalgewicht").text(numberFormat(totalgewicht, 2, ',', '.'));
    $(".totalfrach").text(numberFormat(totalWeight, 2, ',', '.'));


    gwicht = $("#totalWeight").text(numberFormat(totalWeight, 2, ',', '.'));
    pergentCalc = (totalWeight*100)/2500;
    if(pergentCalc>100){
        pergentCalc = 100
    }
    $('#gewichtwidth').css('width',pergentCalc+"%");
    if(totalWeight>2500){
        $('#crm .mainWrap .content .formStep .step2 .note').hide();
        $('#crm .mainWrap .content .formStep .step2 .note2').show();
    } else {
        $('#crm .mainWrap .content .formStep .step2 .note').show();
        $('#crm .mainWrap .content .formStep .step2 .note2').hide();

    }
}
function calcTable(telement) {
    var tdnumber = $(telement).parent().parent('tr').index();


    var anzahl = $("#list tr:nth-child("+(tdnumber+1)+") .anzahl").val();
    var lange = $("#list tr:nth-child("+(tdnumber+1)+") .lange").val();
    var breite = $("#list tr:nth-child("+(tdnumber+1)+") .breite").val();
    var hohe = $("#list tr:nth-child("+(tdnumber+1)+") .hohe").val();
    var gwicht = $("#list tr:nth-child("+(tdnumber+1)+") .gwicht").val();


    if(anzahl>0 && lange>0 && breite>0 && hohe>0 && gwicht>0){
        $("#list tr:nth-child("+(tdnumber+1)+")").css("background", "#2ecc71");

        calcKG = anzahl * lange * breite * hohe / 6000;
        if(calcKG>=0.01){
            $("#list tr:nth-child("+(tdnumber+1)+")").css("background", "#2ecc71");
        } else {
            $("#list tr:nth-child("+(tdnumber+1)+")").css("background", "#e74c3c");
        }
        gwicht = $("#list tr:nth-child("+(tdnumber+1)+") .result").text(numberFormat(calcKG, 2, ',', '.'));

    } else if(anzahl<1 && lange<1 && breite<1 && hohe<1 && gwicht<1){
        $("#list tr:nth-child("+(tdnumber+1)+")").css("background", "#FFF");

    } else {
        $("#list tr:nth-child("+(tdnumber+1)+")").css("background", "#e74c3c");
    }

    calcAll();
    //$("#list tr:nth-child("+(tdnumber+1)+")").css("background", "red")

}
function  step(element) {

    var nextButton = $('#nextButton');
    var prevButton = $('#prevButton');
    var step = $(element).data("step");


    if(step===2) {
        var plzcode = parseInt($('.plzList').val());
        if (isNaN(plzcode)) {

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-right"
            };
            toastr.warning('Bitte wählen Sie die PLZ.', 'Error');
            return false;
        }
    }

    if(step===3){

        var totalWeight = 0;

        $('#list').find('tr').each (function( column, tr) {
            var anzahl = $(this).find('.anzahl').val();
            var lange = $(this).find('.lange').val();
            var breite = $(this).find('.breite').val();
            var hohe = $(this).find('.hohe').val();
            var gwicht = $(this).find('.gwicht').val();



            if(anzahl>0 && lange>0 && breite>0 && hohe>0 && gwicht>0){

                calcKG = anzahl * lange * breite * hohe / 6000;
                if(calcKG>=0.01){
                    totalWeight = totalWeight+calcKG;
                }
            }


        });

        if(totalWeight>2500){

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-right"
            };
            toastr.warning('Ihre Sendung ist über 2.500 KG, bitte kontaktieren Sie uns.', 'Warnung');
            return false;


        }
    }


    $('.steps').css('display','none');
    $('.step'+step).css('display','flex');

    if(step===1){


        $('.step1bullet').addClass('active');
        $('.step2bullet').removeClass('active');
        $('.step3bullet').removeClass('active');
        $('.step4bullet').removeClass('active');


        prevButton.addClass("pasife");
        prevButton.attr("disabled", true);
        prevButton.data("step",0);
        nextButton.data("step",2);
    } else if(step===2){
        $('.step1bullet').addClass('active');
        $('.step2bullet').addClass('active');
        $('.step3bullet').removeClass('active');
        $('.step4bullet').removeClass('active');


        prevButton.removeClass("pasife");
        prevButton.attr("disabled", false);
        prevButton.data("step",1);
        nextButton.data("step",3);
    }else if(step===3){



        $('.step1bullet').addClass('active');
        $('.step2bullet').addClass('active');
        $('.step3bullet').addClass('active');
        $('.step4bullet').removeClass('active');

        prevButton.data("step",2);
        nextButton.data("step",4);
    } else if(step===4){

        $('.step1bullet').addClass('active');
        $('.step2bullet').addClass('active');
        $('.step3bullet').addClass('active');
        $('.step4bullet').addClass('active');


        $('.formStep .buttons').hide();
        prevButton.data("step",3);
        nextButton.data("step",5);

    } else if(step===5){
        alert('finish');
    }
}

function resetForm() {
    location.reload();

}

function successForm(){
    $('#postDataForm').modal('show');
}