$('#fournisseur_form').click(function(){
$('#form_client').removeClass('activeform');	
$('#form_client').addClass('hideform');
$('#form_fournisseur').removeClass('hideform');
$('#client_form').removeClass('active');
$('#form_fournisseur').addClass('activeform');
$('#fournisseur_form').addClass('active');
$('#col1').removeClass('active_tab');
$('#col2').addClass('active_tab')

});


$('#client_form').click(function(){
$('#form_fournisseur').removeClass('activeform');	
$('#form_fournisseur').addClass('hideform');
$('#form_client').removeClass('hideform');
$('#fournisseur_form').removeClass('active');
$('#form_client').addClass('activeform');
$('#client_form').addClass('active');
$('#col2').removeClass('active_tab');
$('#col1').addClass('active_tab')
});



if($('#home').hasClass('show'))
{
        alert('hello');
	$('#profile').removeClass('show');
}



$('#navigationhome').click(function(){
$('#profile').removeClass('show');

});

$('#navigationprofile').click(function(){
$('#home').removeClass('show');

});