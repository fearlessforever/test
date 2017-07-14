
opsi_extra.core='';
opsi_extra.ckeditor = false;
opsi_extra.perintah = {
	closeModal:function(){
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
						if(v == 1){
							$('[data-tombol="toggle-publish"]').removeClass('btn-info').addClass('btn-warning').text('Hide').show();
						}else{
							$('[data-tombol="toggle-publish"]').removeClass('btn-warning').addClass('btn-info').text('Publish').show();
						}						
					}
				});
				$('#modalnya-bro').find('[data-tombol],input').removeAttr('disabled');
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

$(document).ready(function(){ 
	(function(){
		$.ajax({
			url:helmi.current+'ajax/'+helmi.controller,data:{mode:'view',controller:helmi.controller},type:'POST',dataType:'json'
			,success:function(a){
				try{
					var b ='';
					if(a.berhasil ){
						$.each(a.berhasil,function(k,v){
							v.icon = v.icon ? '<i class="'+v.icon+'" title="'+v.icon+'"></i>' : v.icon ;
							v.action = '<button title="edit" class="btn btn-sm btn-danger" data-tombol="edit" data-id="'+v.id+'"><i class="fa fa-gear"></i></button>';
							v.action += ' <button title="view" class="btn btn-sm btn-info" data-tombol="view-sub" data-id="'+v.id+'"><i class="fa fa-eye"></i></button>';
							b += opsi_extra.perintah.addTr(v) ;
						});
					}else if(a.error){
						$('[data-tombol="tampil-table-1"]').append('<div class="alert alert-warning"><strong>Error : </strong> '+a.error+' <button data-dismiss="alert" class="close">&times;</button></div>');
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
	})();
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			/**************************************** ******************************************/
			case 'tambah':
				buat_modal('modalnya-bro');
				helmi.modalSet('header','<h4>Tambah NavBar </h4>');
				helmi.modalSet('body','<form perintah="editForm1">'+$('[data-tombol="form-1"]').html()+'<input type="hidden" name="mode" value="edit"/><input type="hidden" name="pilihan" value="tambah" /><input type="hidden" name="controller" value="'+helmi.controller+'"/></form><br/><p> </p>');
				helmi.modalSet('footer','<button class=" btn btn-info" data-tombol="simpan-modal">Save</button><button class="btn btn-default" data-dismiss="modal">Close</button>');
				helmi.modalSet('show');
				break;
			case 'edit':
				buat_modal('modalnya-bro');
				helmi.modalSet('header','<h4>Edit NavBar :'+$(this).attr('data-id')+' </h4>');
				var a={form:$('[data-tombol="form-1"]').html(),id: $(this).attr('data-id') };
				a.run=function(){
					helmi.modalSet('body','<form perintah="editForm1">'+a.form+'<input type="hidden" name="mode" value="view"/><input type="hidden" name="id" value="'+a.id+'"/><input type="hidden" name="controller" value="'+helmi.controller+'"/></form><br/><p> </p>');
					helmi.modalSet('footer','<button class="btn btn-danger pull-left" disabled data-tombol="hapus">Delete</button><button class=" btn btn-info" disabled data-tombol="simpan-modal">Save</button><button class="btn btn-default" data-dismiss="modal">Close</button>');
					helmi.modalSet('get').find('input').each(function(){
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
					helmi.modalSet('get').find('input[name="mode"]').val('edit');
				});
				
				break;
			case 'hapus':
				if(confirm('Apakah anda ingin menghapus data ini ? ')){
					var a = function(){
						helmi.modalSet('get').find('form').attr('perintah','closeModal').append('<input type="hidden" name="pilihan" value="hapus" >');
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
			/**************************************** SUB ******************************************/
			case 'view-sub':
				var c = $(this).attr('data-id');
				$('.main-box-body .nav-tabs').find('li a[href="#tab2"]').trigger('click');
				(function(){
					$.ajax({
						url:helmi.current+'ajax/'+helmi.controller
						,data:{mode:'view',controller:helmi.controller,pilihan:'sub',id:c}
						,type:'POST',dataType:'json'
						,success:function(a){
							try{
								var b ='';
								if(a.berhasil ){
									opsi_extra.navbar_id = c ;
									if(a.z[0].sub == null){
										b ='<tr><td colspan="4" ><h2>Tidak Ada Data</h2></td></tr>';
									}else{
									opsi_extra.navbar_sub = a.berhasil = JSON.parse(a.z[0].sub);
									
									$.each(a.berhasil,function(k,v){
										v.icon = v.icon ? '<i class="'+v.icon+'" title="'+v.icon+'"></i>' : v.icon ;
										v.idc =k;
										v.action = '<button title="edit" class="btn btn-sm btn-warning" data-tombol="edit-sub" data-id="'+v.idc+'"><i class="fa fa-gear"></i></button>';
										b += opsi_extra.perintah.addTr(v) ;
									});
									}
									
								}else if(a.error){
									$('[data-tombol="tampil-table-2"]').append('<div class="alert alert-warning"><strong>Error : </strong> '+a.error+' <button data-dismiss="alert" class="close">&times;</button></div>');
								}
								if(b){
									$('[data-tombol="tampil-table-2"] table').find('tbody').html(b);
								}
								
							}catch(e){
								console.log(e);
							}
							$('[data-tombol="tampil-table-2"]').find('[disabled]').each(function(){
								$(this).removeAttr('disabled');
							});
							
						},complete:function(){
							$('[data-tombol="gambar-loading"]').hide();
						}
					});
				})();
				break;
			case 'tambah-sub':
				if(typeof opsi_extra.navbar_id === 'undefined'){
					$(this).attr('disabled','disabled');
					return;
				}
				buat_modal('modalnya-bro');
				helmi.modalSet('header','<h4>Tambah Sub dari NavBar : '+ opsi_extra.navbar_id +' </h4>');
				helmi.modalSet('body','<form perintah="editForm1">'+$('[data-tombol="form-1"]').html()+'<input type="hidden" name="mode" value="edit-sub"/><input type="hidden" name="id" value="'+opsi_extra.navbar_id+'"/><input type="hidden" name="pilihan" value="tambah" /><input type="hidden" name="controller" value="'+helmi.controller+'"/></form><br/><p> </p>');
				helmi.modalSet('footer','<button class=" btn btn-info" data-tombol="simpan-modal">Save</button><button class="btn btn-default" data-dismiss="modal">Close</button>');
				helmi.modalSet('show');
				break;
			case 'edit-sub':
				buat_modal('modalnya-bro');
				helmi.modalSet('header','<h4>Edit NavBar Sub : '+$(this).attr('data-id')+' </h4>');
				var a={form:$('[data-tombol="form-1"]').html(),id: opsi_extra.navbar_id,idc: $(this).attr('data-id') };
				a.run=function(){
					helmi.modalSet('body','<form perintah="editForm1">'+a.form+'<input type="hidden" name="mode" value="view"/><input type="hidden" name="id" value="'+a.id+'"/><input type="hidden" name="idc" /><input type="hidden" name="controller" value="'+helmi.controller+'"/></form><br/><p> </p>');
					helmi.modalSet('footer','<button class="btn btn-danger pull-left" disabled data-tombol="hapus">Delete</button><button class=" btn btn-info" disabled data-tombol="simpan-modal">Save</button><button class="btn btn-default" data-dismiss="modal">Close</button>');
					helmi.modalSet('get').find('input').each(function(){
						if(typeof $(this).attr('type') !== 'undefined' && $(this).attr('type') == 'hidden'){
							
						}else{
							$(this).attr('disabled','disabled');
						}
					});
					helmi.modalSet('show');
				}
				$.when(a.run()).then(function(){
					opsi_extra.data ={}; 
					opsi_extra.data.z=[ opsi_extra.navbar_sub[a.idc]]; 
					opsi_extra.run('editForm1');
				}).then(function(){
					helmi.modalSet('get').find('input[name="mode"]').val('edit-sub');
				});
				
				break;
			/**************************************** ******************************************/
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

