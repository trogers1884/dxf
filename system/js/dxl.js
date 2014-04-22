$( document ).ready(function() {
	$("#login").submit(function (event) {
//		alert('hello world');
//		window.location.replace("/dxf/");
		jsTestLogin();
		return false;
		
	});
});

function jsTestLogin(){
	alert('hello dolly');
	$('#dxajax').val('hellodolly');
	alert( $('#dxajax').val() );
	var data = $('#frmCtrl').serialize() + $('#login').serialize();
	$.post('dxajax.php', data,
	function(data){
		alert('whatever');	
	
	},'json');
}

/*

function jsEditDuty(pk,fk_directory,ts_prcdate){
	$('#dfajax').val('86.php');
	var data = $('#frmProcess').serialize() + '&pk=' + pk + '&fk_directory=' + fk_directory + '&ts_prcdate=' + ts_prcdate;
	$.post('dfajax.php',data,
	function(data){
		$('#deform').html(data.deform);
		$('#dewindow').jqmShow();
	},"json");
}

*/