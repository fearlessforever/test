var __ajax_p=false,opsi_extra={}; 
opsi_extra.reload=true;

$(document).off('click','[data-tombol]');
$(document).off('keyup','#modalnya-bro .modal-body ');
$(document).off('change','#modalnya-bro #filegambar');
$(document).off('change','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
if( $('#ui-datepicker-div').length > 0 ){
	$('#ui-datepicker-div').remove();
}