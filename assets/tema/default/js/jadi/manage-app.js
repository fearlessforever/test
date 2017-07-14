
opsi_extra.core='';
opsi_extra.perintah={
	data_tr:false,
	add_tr:function( e ){
		if(typeof e ==='undefined')return'';
		var a=''; 
		$.each(e ,function(k,v){
			v = (v == null)?'<span class="label label-danger">[NOT FOUND]</span>':v;
			a+='<td>'+v+'</td>';
		});
		return '<tr>'+a+'</tr>';
	},
	tambah_row:function(){
		if(this.data_tr){
			var v = this.data_tr ;
			var a='' ;
			v.mainten = (v.mainten == 0) ? '<span class="ttt label label-success">Active</span>' : '<span class="ttt label label-danger">Inactive</span>';
			v.action = (v.app == 'manage-app') ? '' : '<span class="ttt label label-warning" data-tombol="hapus"><i class="fa fa-eye"> </i></span>';
			a += this.add_tr(v) ;
			$('#app table').find('tbody').prepend(a);
			
			setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
			this.data_tr =false;
		}
	},
	hapus_row:function(){
		if(this.data_tr){
				this.data_tr.remove();
			setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
			this.data_tr =false;
		}
	},
	mainten:function(){
		if(this.data_tr){
			var a = this.data_tr.find('td:nth-child(6)');
			if(a.length > 0){
				var b = ( a.text() == 'Active' ) ? '<span class="label label-danger">Inactive</span>' : '<span class="label label-success">Active</span>' ;
				a.html( b );
			}
		}
	}
};
opsi_extra.run=function( cmd ){
	if(typeof opsi_extra.perintah[ cmd ] === 'function')
	{
		opsi_extra.perintah[cmd]();
	}
}

opsi_extra.get_tbody=function(b,a ,c){
	if(typeof b === 'undefined')return;
	var data = {controller:helmi.controller , mode:'view'} ;
	data = (typeof a !== 'undefined' ) ? $.extend({}, data, a ) : data; 
	$.ajax({
		url:helmi.current+'ajax/'+helmi.controller ,data:data,type:'POST',dataType:'json'
		,success:function(data){
			if(data.berhasil ){
				var a='' ;
				$.each(data.berhasil ,function(k,v){
					v.mainten = (v.mainten == 0) ? '<span class="ttt label label-success">Active</span>' : '<span class="ttt label label-danger">Inactive</span>';
					v.action = (v.app == 'manage-app') ? '' : '<span class="ttt label label-warning" data-tombol="hapus"><i class="fa fa-eye"> </i></span>';
					a += opsi_extra.perintah.add_tr(v) ;
				});
				b.find('tbody').html(a);
				if(typeof c === 'function')c(data );
			}else if(data.error){
				b.find('tbody').html('<h3>'+data.error+'</h3>');
			}
		}
	});
	
}
opsi_extra.select = {
	ajax:false,
	hasil:false,
	opsi:{
		'pilihan':'pilihan','input':false,'target':false,'load':false
	},
	run:function(option){ // ,z, zz, zzz
		var opsi = $.extend({}, this.opsi , option);
		if( opsi.load){
			if(!opsi.load.find('span').length)
			opsi.load.append(' &nbsp; <span ><img src="'+helmi.asset+'loading.gif" /> Search in DB </span>')
		}
		if(this.ajax)return;
		if( ! opsi.target || ! opsi.input )return;
		
		this.ajax = true; this.hasil = false;
		var a = this;
		$.ajax({
			url:helmi.current+'ajax/'+helmi.controller ,type:'POST',dataType:'json',data:{pilihan: opsi.pilihan ,cari: opsi.input.val() ,mode:'view' }
			,success:function(data){
				if(data.berhasil){
				if(typeof data.berhasil[ opsi.pilihan ] !== 'undefined'){
					var b =''; $.each( data.berhasil[ opsi.pilihan ] ,function(k,v){
						b += '<option value="'+v[opsi.pilihan] +'">'+v.ket+'</option>';
					});
					opsi.target.prepend(b).selectpicker('refresh');
				}
				}
			},complete:function(){
				setTimeout(function(){ a.ajax = false; },1000);
				if(opsi.load)if(opsi.load.find('span').length)opsi.load.find('span').remove();
			}
		});
	}
};

$(document).ready(function(){
	$(document).on('keyup','#modalnya-bro .modal-body [data-selectpicker] input',function(){
		if(typeof opsi_extra === 'undefined' || typeof opsi_extra.select === 'undefined' || typeof opsi_extra.select.run !== 'function'){
			$(this).off('keyup');
			return;
		}			
		var a=$(this); var utama = $(this).parents('[data-selectpicker]');
		$(this).parents('div.dropdown-menu').find('li.no-results').each(function(){
			opsi_extra.select.run( {
				'pilihan': a.parents('[data-selectpicker]').attr('data-selectpicker')
				,'input': a
				,'target': utama.find('.selectpicker') 
				,'load': $(this)
			} );
		});
	});
	
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			/**************************************** ******************************************/
			case 'tambah-app' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Registrasi Aplikasi Ke Dalam Database </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="tambah_row"><div class="form-group"><label> App ID * </label><input class="form-control" type="text" name="app" value="" placeholder="Hanya a-z , angka , _ (underscore) dan - (dash) yang diperbolehkan" /></div><div class="form-group"><label> Folder </label><input class="form-control" type="text" name="folder" value="" placeholder="Nama Folder case sensitive di Operating System Linux ,jika menggunakan window case insensitive" /></div><div class="form-group"><label>File View</label><input class="form-control" type="text" name="file_view" value="" placeholder="Nama File view Dari Aplikasi misal : data_mahasiswa_view " /></div><div class="form-group"><label>File Model</label><input class="form-control" type="text" name="file_model" value="" placeholder="Nama File model Dari Aplikasi misal : data_mahasiswa_model " /></div><div class="form-group "><label>Keterangan</label><input class="form-control" type="text" name="ket" value="" placeholder="Misal : Data Mahasiswa " /></div><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="mode" value="tambah-app" /> </form><p> * Hash Link untuk mengakses Applikasi</p>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'block-app' :
				var a = $('#modalnya-bro .modal-body').find('form');
				if(a.length > 0){
					a.attr('perintah','mainten').append('<input name="block" type="hidden" value="block" />');
					$('#modalnya-bro form').trigger('submit');
				}
				break;
			case 'unblock-app' :
				var a = $('#modalnya-bro .modal-body').find('form');
				if(a.length > 0){
					a.attr('perintah','mainten').append('<input name="block" type="hidden" value="unblock" />');
					$('#modalnya-bro form').trigger('submit');
				}
				break;
			case 'hapus' :
				buat_modal('modalnya-bro'); var a = $(this).parents('tr').find('td:nth-child(1)').text();
				
				opsi_extra.perintah.data_tr = $(this).parents('tr');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Hapus / Ganti Status Aplikasi </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="hapus_row"><p>Apakah anda yakin ingin menghapus Aplikasi ini <span class="label label-info">'+a+'</span>  ? <br> Jika anda hanya ingin aplikasi tidak bisa diakses sementara dikarenakan ada bug atau dalam pengembangan, lebih baik di nonaktif kan saja.</p><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="level" value="'+a+'" /><input type="hidden" name="mode" value="hapus-app" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-success" data-tombol="unblock-app">Active</button> &nbsp; <button class="btn btn-warning" data-tombol="block-app">Inactive</button> &nbsp; <button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			/**************************************** ******************************************/
			
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
				
			default: break;
		}
	});
	
	if( opsi_extra.reload ){
		opsi_extra.reload=false;
		opsi_extra.get_tbody( $('#app table') ,{}, function(e){
			$('#app table').easyTable({
				buttons:false,select:false,
				sortable:true,
				scroll: {active: true, height: '400px'},
				message:{
					all:'Pilih Semua',search:'Pencarian Table Aplikasi',clear:'Batalkan Pilihan',searchText:'Cari'
				},
				page:{
					limit:e.limit,total:e.total,
					callback:function( table, page){
						table.find('tbody').html('<div style="text-align:center; margin: 50px auto;"><img src="'+helmi.asset+'loading.gif" /></div>');
						opsi_extra.get_tbody( table ,{'page':page} );
					}
				}
			});
		} );
					
		/* $.ajax({
			url:helmi.current+'ajax/'+helmi.controller ,data:{controller:helmi.controller , mode:'view'},type:'POST',dataType:'json'
			,success:function(data){
				if(data.berhasil){
					opsi_extra.core = data.berhasil ;
				if(data.berhasil ){
					var a='' ;
					$.each(data.berhasil ,function(k,v){
						v.mainten = (v.mainten == 0) ? '<span class="ttt label label-success">Active</span>' : '<span class="ttt label label-danger">Inactive</span>';
						v.action = (v.app == 'manage-app') ? '' : '<span class="ttt label label-warning" data-tombol="hapus"><i class="fa fa-eye"> </i></span>';
						a += opsi_extra.perintah.add_tr(v) ;
					});
					$('#app table').find('tbody').prepend(a);
					$('#app table').easyTable({
						buttons:false,select:false,
						sortable:true,
						scroll: {active: true, height: '400px'},
						message:{
							all:'Pilih Semua',search:'Pencarian Level User',clear:'Batalkan Pilihan'
						},
						page:{
							limit:27,total:3,
							callback:function(e){
								alert(e);
							}
						}
					});
				}
				
				}				
			}
		}); */
	}
	
	$(document).on('submit','#modalnya-bro form',function(e){
		helmi.submit(e,$(this)) ;
	});
	
	
	
});