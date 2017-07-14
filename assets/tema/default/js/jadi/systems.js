
$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){ 
			case 'set-photo-profile':
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Set Background Image </h4> ' );
				$('#modalnya-bro .modal-body').html('<form method="POST" enctype="multipart/form-data" action="'+helmi.current+'ajax/'+helmi.controller+'" role="form"><div class="form-group"><label> Select Image </label><input  type="file" name="upload_image"  /></div><input type="hidden" name="controller" value="'+helmi.controller+'" /><input type="hidden" name="mode" value="setting-background" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				break;
			case 'hapus-photo':
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Delete Background Image </h4> ' );
				$('#modalnya-bro .modal-body').html('<form role="form"> <p>Apakah anda yakin ingin menghapus background image ini ? <div style="max-height:500px; overflow-y:scroll;"> <img src="'+helmi.asset+ $(this).attr('data-gambar') +'" style="border-radius:17px;" /> </div></p><input type="hidden" name="controller" value="'+helmi.controller+'" /><input type="hidden" name="mode" value="delete-background" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-warning" data-tombol="simpan-modal">DELETE</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'hapus-notif':
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Clear System Notification Log </h4> ' );
				$('#modalnya-bro .modal-body').html('<form role="form"> <p>Apakah anda yakin ingin menghapus Log Notifikasi ini ? </p><input type="hidden" name="controller" value="'+helmi.controller+'" /><input type="hidden" name="mode" value="delete-notif" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-warning" data-tombol="simpan-modal">CLEAR</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'simpan': 
				var a = $('#settingan-system');
				$.ajax({
					url:helmi.current+'ajax/'+helmi.controller,data:a.serialize() ,type:'POST',dataType:'json'
					,beforeSend:function(){
						if( a.parent('div').find('.loading-nya-bro').length > 0){
							a.parent('div').find('.loading-nya-bro').html('<img src="'+helmi.asset+'loading.gif" />');
						}else{
							a.parent('div').append('<div class="loading-nya-bro" style="text-align:center;"><img src="'+helmi.asset+'loading.gif" /></div>');
						}
					}
					,success:function(data){
						if(data.error){
							a.parent('div').find('.loading-nya-bro').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button><strong>Error :</strong> '+ data.error +'</div>');
						}else if(data.berhasil){
							a.parent('div').find('.loading-nya-bro').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button><strong>Success :</strong> '+ data.berhasil +'</div>');
						}
						if(data.location){
							setTimeout(function(){ window.location.href= data.location ; },3000);
						}
					}
				});
				break;
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
				
			default: break;
		}
	});
	
	$(document).on('submit','#modalnya-bro form',function(e){
		helmi.submit(e,$(this) ); 
	});
	
});