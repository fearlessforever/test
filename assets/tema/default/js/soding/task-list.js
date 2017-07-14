
opsi_extra.core='';
opsi_extra.ckeditor = false;
opsi_extra.viewOption={controller:helmi.controller};
opsi_extra.perintah = {
	closeModal:function(){
		setTimeout(function(){ helmi.modalSet('hide'); },1000);
	},closeModalRefresh:function(){
		opsi_extra.viewOption={mode:'view',controller:helmi.controller};
		opsi_extra.ajaxBuatTabel();
		setTimeout(function(){ helmi.modalSet('hide'); },1000);
	},addTr:function( e ){
		if(typeof e ==='undefined')return'';
		var a=''; 
		$.each(e ,function(k,v){
			v = (v == null)?'<span class="label label-danger">[NOT FOUND]</span>':v;
			a+='<td>'+v+'</td>';
		});
		return '<tr>'+a+'</tr>';
	},editForm1:function(){
		try{
			//$('[data-tombol="'+opsi_extra.tombol+'"]').trigger('click');
			var a = opsi_extra.data ;
			if( typeof a.z[0] !== 'undefined'){
				$.each( a.z[0] , function(k,v){
					$('#modalnya-bro form [name="'+k+'"]').val(v);
					if(k == 'publish'){
						
					}
				});
				$('#modalnya-bro').find('[data-tombol],input,textarea').removeAttr('disabled');
			}
		}catch(e){console.log(e);}
	}
};
opsi_extra.run=function(cmd){
	if(typeof opsi_extra.perintah[ cmd ] === 'function')
	{
		opsi_extra.perintah[cmd]();
	}
};
opsi_extra.ajaxBuatTabel=function(a){
	opsi_extra.viewOption = (typeof a !== 'undefined') ? $.extend({},opsi_extra.viewOption,a) : opsi_extra.viewOption ;
	$.ajax({
			url:helmi.current+'ajax/'+helmi.controller,data:opsi_extra.viewOption,type:'POST',dataType:'json'
			,beforeSend:function(){
				$('[data-tombol="tampil-table-1"] table').find('tbody').html('');
				$('[data-tombol="gambar-loading"]').show();
			}
			,success:function(a){
				try{
					var b ='';
					if(a.berhasil ){
						$.each(a.berhasil,function(k,v){
							//v.action = '<button title="edit" class="btn btn-sm btn-danger" data-tombol="edit" data-id="'+v.id+'"><i class="fa fa-gear"></i></button>';
							v.action = ' <button title="view" class="btn btn-sm btn-info" data-tombol="edit" data-id="'+v.id+'"><i class="fa fa-eye"></i></button>';
							//delete v.id;
							b += opsi_extra.perintah.addTr(v) ;
						});
					}else if(a.error){
						$('[data-tombol="tampil-table-1"]').append('<div class="alert alert-warning"><strong>Error : </strong> '+a.error+' <button data-dismiss="alert" class="close">&times;</button></div>');
					}
					if(a.limit && a.total){
						helmi.buatOptionPage(a.limit , a.total , $('[data-tombol="paginationnya"]') );
					}
					if(b){
						$('[data-tombol="tampil-table-1"] table').find('tbody').html(b);
					}
					
				}catch(e){
					console.log(e);
				}
				$('.main-box-body').find('[disabled]').each(function(){
					$(this).removeAttr('disabled');
				});
			},complete:function(){
				$('[data-tombol="gambar-loading"]').hide();
			}
		});
};
$(document).ready(function(){
	opsi_extra.viewOption={mode:'view',controller:helmi.controller};
	opsi_extra.ajaxBuatTabel();
	
	$(document).off('change','[data-tombol="paginationnya"] select');
	$(document).on('change','[data-tombol="paginationnya"] select',function(){
		var a = {mode:'view',controller:helmi.controller,page:$(this).val() };
		opsi_extra.ajaxBuatTabel(a);
	});
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			/**************************************** ******************************************/
			case 'tambah-scanid':
				buat_modal('modalnya-bro');
				helmi.modalSet('header','<h4>Add Task  <button class="close" data-dismiss="modal">&times;</button> </h4>');
				helmi.modalSet('body','<form perintah="closeModalRefresh">'+$('[data-tombol="form-1"]').html()+'<input type="hidden" name="mode" value="save"/><input type="hidden" name="pilihan" value="tambah"/><input type="hidden" name="controller" value="'+helmi.controller+'"/></form><br/><p> </p>');
				helmi.modalSet('footer','<button class=" btn btn-info" data-tombol="simpan-modal">Add Task</button><button class="btn btn-default" data-dismiss="modal">Close</button>');
				helmi.modalSet('show');
				break;
			case 'edit':
				buat_modal('modalnya-bro');
				helmi.modalSet('header','<h4>Edit Members Log :'+$(this).attr('data-id')+' </h4>');
				var a={form:$('[data-tombol="form-1"]').html(),id: $(this).attr('data-id') };
				a.run=function(){
					helmi.modalSet('body','<form perintah="editForm1">'+a.form+'<input type="hidden" name="mode" value="view"/><input type="hidden" name="id" value="'+a.id+'"/><input type="hidden" name="controller" value="'+helmi.controller+'"/></form><br/><p> </p>');
					helmi.modalSet('footer','<button class="btn btn-danger pull-left" disabled data-tombol="hapus">Delete</button><button class=" btn btn-info" disabled data-tombol="simpan-modal">Save</button><button class="btn btn-default" data-dismiss="modal">Close</button>');
					helmi.modalSet('get').find('input,textarea').each(function(){
						if(typeof $(this).attr('type') !== 'undefined' && $(this).attr('type') == 'hidden'){
							
						}else{
							$(this).attr('disabled','disabled');
						}
					});
					helmi.modalSet('show');
				}
				$.when(a.run()).then(function(){
					$('#modalnya-bro form').trigger('submit');
				}).then(function(){
					helmi.modalSet('get').find('input[name="mode"]').val('save');
				});
				
				break;
			case 'hapus':
				if(confirm('Apakah anda ingin menghapus data ini ? ')){
					var a = function(){
						helmi.modalSet('get').find('form').attr('perintah','closeModalRefresh').append('<input type="hidden" name="pilihan" value="hapus" >');
						helmi.modalSet('get').find('input').each(function(){
							if(typeof $(this).attr('type') !== 'undefined' && $(this).attr('type') == 'hidden'){}
							else{
								$(this).attr('disabled','disabled');
							}
						});
						$('#modalnya-bro [data-tombol="simpan-modal"]').attr('disabled','disabled');
					}
					$.when(a()).then(function(){
						$('#modalnya-bro form').trigger('submit');
					});
				}
				break;
				
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
				
			default: break;
		}
	}); 
	
	$(document).on('submit','#modalnya-bro form',function(e){
		helmi.submit(e,$(this)) ;
	}); 
	
});

