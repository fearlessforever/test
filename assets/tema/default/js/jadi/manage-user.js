
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
	tambah_lvl:function(){
		if(this.data_tr){
			var v = this.data_tr ;
			var a='',bb='';
			for(var i=1;i<=5;i++){ bb += v.bintang >= i ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>'; }
			v.bintang=bb;
			v.action = (v.level == 'admin') ? '' : '<span class="btn btn-danger" data-tombol="hapus-lvl">hapus</span>';
			a += this.add_tr(v) ;
			
				$('#tab1 table').find('tbody').prepend(a);
			setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
			this.data_tr =false;
		}
	},
	hapus_lvl:function(){
		if(this.data_tr){
				this.data_tr.remove();
			setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
			this.data_tr =false;
		}
	},
	tambah_user:function(){
		if(this.data_tr){
			var v =this.data_tr,a='';
			v.block = v.block=='N' ?'<span class="label label-success" >Aktif</span>' : '<span class="label label-warning" >Blocked</span>';
			v.action = '<span class="btn btn-danger" data-tombol="hapus-user"><i class="fa fa-eye"></i></span>';
			
			a += this.add_tr(v) ;
			$('#tab2 table').find('tbody').prepend(a);
			setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
			this.data_tr =false;
		}
	},
	block_user:function(){
		if(this.data_tr){
			var a = this.data_tr.find('td:nth-child(7)');
			if(a.length > 0){
				var b = ( a.text() == 'Blocked' ) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-warning">Blocked</span>' ;
				a.html( b );
			}
		}
	},
	tambah_izin:function(){
		if(this.data_tr){
			var ini =this;
			var data =this.data_tr,a='';
			$.each(data,function(k,v){
				v.nama_app = v.nama_app == null ? '<span class="label label-info">[NOT FOUND : '+v.nama_app+']</span>' : v.nama_app;
				v.keterangan = v.keterangan == null ? '<span class="label label-danger">[NOT FOUND]</span>' : v.keterangan;
				v.app = v.app=='N' ? '<span class="label label-warning" >[NOT FOUND]</span>':'<span class="label label-success" >Aktif</span>' ;
				v.action = '<span class="btn btn-danger" data-tombol="hapus-izin">hapus</span>';
							
				a += ini.add_tr(v) ;
			})
			
			$('#tab3 table').find('tbody').prepend(a);
			setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
			this.data_tr =false;
		}
	}
};
opsi_extra.run=function( cmd ){
	if(typeof opsi_extra.perintah[ cmd ] === 'function')
	{
		opsi_extra.perintah[cmd]();
	}
}
opsi_extra.get_tbody={
	run:function(b,a ,c){
		var ini = this;
		if(typeof b === 'undefined')return;
		var data = {controller:helmi.controller , mode:'view'} ;
		data = (typeof a !== 'undefined' ) ? $.extend({}, data, a ) : data; 
		$.ajax({
			url:helmi.current+'ajax/'+helmi.controller ,data:data,type:'POST',dataType:'json'
			,success:function(data){
				if(data.berhasil ){
					if(data.berhasil.level){
						var z = ini.level( data.berhasil.level );
						b.find('tbody').html(z);
					}else if(data.berhasil.user){
						var z = ini.user( data.berhasil.user );
						b.find('tbody').html(z);
					}else if(data.berhasil.izin){
						var z = ini.izin( data.berhasil.izin );
						b.find('tbody').html(z);
					}
				}else if(data.error){
					b.find('tbody').html('<h3>'+data.error+'</h3>');
				}
			}
		});
	},
	level:function( data ){
		var a='',bb;
		$.each(data ,function(k,v){
			bb=''; for(var i=1;i<=5;i++){ bb += v.bintang >= i ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>'; }
			v.bintang=bb;
			v.action = (v.level == 'admin') ? '' : '<button class="btn btn-danger" data-tombol="hapus-lvl">hapus</button>';
			a += opsi_extra.perintah.add_tr(v) ;
		});
		return a;
	},
	user:function( data ){
		var a='',bb;
		$.each( data ,function(k,v){
			v.ket = v.ket == null ? '<span class="label label-danger">[NOT FOUND]</span>' : v.ket;
			v.block = v.block=='N' ?'<span class="label label-success" >Aktif</span>' : '<span class="label label-warning" >Blocked</span>';
			v.action = '<span class="btn btn-danger" data-tombol="hapus-user"><i class="fa fa-eye"></i></span>';
			
			a += opsi_extra.perintah.add_tr(v) ;
		});
		return a;
	},
	izin:function( data ){
		var a='',bb;
		$.each(data ,function(k,v){
			v.nama_app = v.nama_app == null ? '<span class="label label-info">[NOT FOUND : '+v.nama_app+']</span>' : v.nama_app;
			v.keterangan = v.keterangan == null ? '<span class="label label-danger">[NOT FOUND]</span>' : v.keterangan;
			v.app = v.app=='N' ? '<span class="label label-warning" >[NOT FOUND]</span>':'<span class="label label-success" >Aktif</span>' ;
			v.action = '<span class="btn btn-danger" data-tombol="hapus-izin">hapus</span>';
						
			a += opsi_extra.perintah.add_tr(v) ;
		});
		return a;
	}
};

opsi_extra.add_tr = function( e ){
	if(typeof e ==='undefined')return'';
	var a=''; 
	$.each(e ,function(k,v){
		a+='<td>'+v+'</td>';
	});
	return '<tr>'+a+'</tr>';
};

opsi_extra.buat_opsi_lvl=function(e){
	if(typeof opsi_extra.core.level !== 'undefined'){
		var b = typeof e !== 'undefined' ? e : ''; var a='';
		$.each(opsi_extra.core.level ,function(k,v){
			a+='<option value="'+v.level+'" '+( (b ==v.level)?'selected':'') +'>'+v.ket+'</option>';
		});
		return a;
	}
	return '<option value="">[NOT FOUND]</option>';
};

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
			case 'tambah-lvl' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Tambah Level Login </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="tambah_lvl"><div class="form-group"><label> LeveL Login </label><input class="form-control" type="text" name="nama" value="" placeholder="contoh ny member,kasir" /></div><div class="form-group"><label> Keterangan LeveL </label><input class="form-control" type="text" name="ket" value="" placeholder="contoh ny Administrator" /></div><div class="form-group"><label>Rate 0 - 5 </label><input class="form-control" type="text" name="rate" value="" placeholder="contoh ny 1" /></div><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="mode" value="tambah-level" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'hapus-lvl' :
				buat_modal('modalnya-bro'); var a = $(this).parents('tr').find('td:nth-child(1)').text();
				opsi_extra.perintah.data_tr = $(this).parents('tr');
				
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Hapus LeveL </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="hapus_lvl"><p>Apakah anda yakin ingin menghapus Level Login ini ? <br><span class="label label-info">'+a+'</span> </p><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="level" value="'+a+'" /><input type="hidden" name="mode" value="hapus-level" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			/**************************************** ******************************************/
			case 'tambah-user' :
				buat_modal('modalnya-bro'); var a = opsi_extra.buat_opsi_lvl();
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Tambah User Login </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="tambah_user"><div class="input-group"><label class="input-group-addon"> User ID / Username </label><input class="form-control" type="text" name="id_user" value="" placeholder="contoh ny udin,Jhon" /></div><br><div class="input-group" data-selectpicker="level"><label class="input-group-addon"> LeveL </label> <select data-live-search="true" data-style="btn-primary" class="show-menu-arrow show-tick form-control selectpicker" name="level">'+a+'</select></div><div class="form-group"><label>Nama : </label><input class="form-control" type="text" name="nama" value="" placeholder="contoh ny Jhon Satoshi" /></div><div class="form-group"><label>Email : </label><input class="form-control" type="email" name="email" value="" placeholder="contoh ny jun@gmail.com" /></div><div class="input-group"><label class="input-group-addon">Password : </label><input class="form-control" type="text" name="password" value="" placeholder="Password Untuk Login" /></div><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="mode" value="tambah-user" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				$('#modalnya-bro .modal-body .selectpicker').selectpicker('refresh');
				break;
			case 'block-user' :
				var a = $('#modalnya-bro .modal-body').find('form');
				if(a.length > 0){
					a.attr('perintah','block_user').append('<input name="block" type="hidden" value="block" />');
					$('#modalnya-bro form').trigger('submit');
				}
				break;
			case 'unblock-user' :
				var a = $('#modalnya-bro .modal-body').find('form');
				if(a.length > 0){
					a.attr('perintah','block_user').append('<input name="block" type="hidden" value="unblock" />');
					$('#modalnya-bro form').trigger('submit');
				}
				break;
			case 'hapus-user' :
				buat_modal('modalnya-bro'); var a = $(this).parents('tr').find('td:nth-child(1)').text();
				
				opsi_extra.perintah.data_tr = $(this).parents('tr');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Hapus / Block User </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="hapus_lvl"><p>Apakah anda yakin ingin menghapus User ini <span class="label label-info">'+a+'</span>  ? <br> Menghapus User sangat - sangat tidak dianjurkan ,  pilihan terbaik adalah memblokir User ini Menggunakan System</p><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="level" value="'+a+'" /><input type="hidden" name="mode" value="hapus-user" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-success" data-tombol="unblock-user">UNBLOCK</button> &nbsp; <button class="btn btn-warning" data-tombol="block-user">BLOCK</button> &nbsp; <button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			/**************************************** ******************************************/
			case 'tambah-izin' :
				buat_modal('modalnya-bro'); var a = opsi_extra.buat_opsi_lvl();
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Tambah Izin Aplikasi Untuk Level Login </h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="tambah_izin"><div class="input-group" data-selectpicker="level"><label class="input-group-addon"> LeveL </label> <select data-live-search="true" data-style="btn-primary" class="show-menu-arrow show-tick form-control selectpicker" name="level">'+a+'</select></div>   <p></p><div class="input-group" data-selectpicker="app"><label class="input-group-addon"> Application </label> <select multiple data-live-search="true" class="show-menu-arrow show-tick form-control selectpicker" name="app[]"> </select></div><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="mode" value="tambah-izin" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				$('#modalnya-bro .modal-body .selectpicker').selectpicker('refresh');
				break;
			case 'hapus-izin':
				buat_modal('modalnya-bro'); var a = $(this).parents('tr').find('td:nth-child(1)').text() +'/'+ $(this).parents('tr').find('td:nth-child(3)').text();
				opsi_extra.perintah.data_tr = $(this).parents('tr');
				
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Remove Application Permission ?</h4> ' );
				$('#modalnya-bro .modal-body').html('<form perintah="hapus_lvl"><p>Apakah anda yakin ingin menghapus Hak Akses ini <span class="label label-info">'+a+'</span>  ? <br> </p><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="level" value="'+a+'" /><input type="hidden" name="mode" value="hapus-izin" /> </form>');
				$('#modalnya-bro .modal-footer').html(' <button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
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
		$.ajax({
			url:helmi.current+'ajax/'+helmi.controller ,data:{controller:helmi.controller , mode:'view'},type:'POST',dataType:'json'
			,success:function(data){
				if(data.berhasil){
					opsi_extra.core = data.berhasil ;
				if(data.berhasil.level){
					var a = opsi_extra.get_tbody.level( data.berhasil.level );
					$('#tab1 table').find('tbody').prepend(a);
					$('#tab1 table').easyTable({
						buttons:false,select:false,
						sortable:true,
						scroll: {active: true, height: '400px'},
						message:{
							all:'Pilih Semua',search:'Pencarian Level User',clear:'Batalkan Pilihan'
						},
						page:{
							total:data.total_level,limit:data.limit
							,callback:function(table,page){
								table.find('tbody').html('<div style="text-align:center; margin: 50px auto;"><img src="'+helmi.asset+'loading.gif" /></div>');
								opsi_extra.get_tbody.run(table,{page:page,pilihan:'level'} );
							}
						}
					});
				}
				if(data.berhasil.user){
					var a = opsi_extra.get_tbody.user( data.berhasil.user );
					$('#tab2 table').find('tbody').prepend(a);
					$('#tab2 table').easyTable({
						buttons:false,select:false,
						sortable:true,
						scroll: {active: true, height: '400px'},
						message:{
							all:'Pilih Semua',search:'Pencarian User',clear:'Batalkan Pilihan'
						},
						page:{
							total:data.total_user,limit:data.limit
							,callback:function(table,page){
								table.find('tbody').html('<div style="text-align:center; margin: 50px auto;"><img src="'+helmi.asset+'loading.gif" /></div>');
								opsi_extra.get_tbody.run(table,{page:page,pilihan:'user'} );
							}
						}
					});
				}
				if(data.berhasil.izin){
					var a = opsi_extra.get_tbody.izin( data.berhasil.izin );
					$('#tab3 table').find('tbody').prepend(a);
					$('#tab3 table').easyTable({
						buttons:false,select:false,
						sortable:true,
						scroll: {active: true, height: '400px'},
						message:{
							all:'Pilih Semua',search:'Pencarian Izin',clear:'Batalkan Pilihan'
						},
						page:{
							total:data.total_izin,limit:data.limit
							,callback:function(table,page){
								table.find('tbody').html('<div style="text-align:center; margin: 50px auto;"><img src="'+helmi.asset+'loading.gif" /></div>');
								opsi_extra.get_tbody.run(table,{page:page,pilihan:'izin'} );
							}
						}
					});
				}
				
				}				
			}
		});
	}
	
	$(document).on('submit','#modalnya-bro form',function(e){
		helmi.submit(e,$(this)) ;
	});
	
	
	
});