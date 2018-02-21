
$('#formauto').hide();
$('#formhotel').show();
$('#hotelsform').on('click',function(){ //on checkboxes check
    //bouton

    $('#hotelsform').removeClass('active dfilter');
    $('#autoform').removeClass('active dfilter');
    $('#appartsform').removeClass('active dfilter');

    $('#appartsform').addClass('dfilter');
    $('#hotelsform').addClass('active dfilter');
    $('#autoform').addClass('dfilter');

    $('#formauto').hide();
    $('#formhotel').show();
});
$('#autoform').on('click',function(){ //on checkboxes check
    //bouton

    $('#hotelsform').removeClass('active dfilter');
    $('#autoform').removeClass('active dfilter');
    $('#appartsform').removeClass('active dfilter');

    $('#appartsform').addClass('dfilter');
    $('#hotelsform').addClass('dfilter');
    $('#autoform').addClass('active dfilter');

    $('#formappartement').hide();
    $('#formhotel').hide();
    $('#formauto').show();
});
$('#appartsform').on('click',function(){ //on checkboxes check
    //bouton


    $('#hotelsform').removeClass('active dfilter');
    $('#autoform').removeClass('active dfilter');
    $('#appartsform').removeClass('active dfilter');

    $('#appartsform').addClass('active  dfilter');
    $('#hotelsform').addClass('dfilter');
    $('#autoform').addClass('dfilter')

    $('#formauto').hide();
    $('#formhotel').show();


});