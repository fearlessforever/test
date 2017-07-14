var __ajax_p=false,opsi_extra={}; opsi_extra.userdata='';
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
if( $('#ui-datepicker-div').length > 0 ){
	$('#ui-datepicker-div').remove();
}

$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'set-name' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Edit Nama </h4> ' );
				$('#modalnya-bro .modal-body').html('<form ><div class="form-group"><label> Set Nama </label><input class="form-control" type="text" name="nama" value="'+ opsi_extra.userdata.nama +'"/></div><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="mode" value="ganti-nama" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'set-password' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Set Password </h4> ' );
				$('#modalnya-bro .modal-body').html('<h4 style="font-weight:bold;">Username : '+opsi_extra.userdata.username+'</h4><form ><div class="form-group"><label> Password Lama </label><input class="form-control" type="password" name="pass_lama" value=""/></div><div class="form-group"><label> Password Baru </label><input class="form-control" type="password" name="pass_baru" value=""/></div><div class="form-group"><label> Password Baru Konfirmasi </label><input class="form-control" type="password" name="pass_baru_con" value=""/></div><input type="hidden" name="controller" value="'+helmi.controller+'" /> <input type="hidden" name="mode" value="ganti-password" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'set-photo-profile':
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Set Photo Profile</h4> ' );
				$('#modalnya-bro .modal-body').html('<form method="POST" enctype="multipart/form-data" action="'+helmi.current+'ajax/'+helmi.controller+'" role="form"><div class="form-group"><label> Set Photo Profile </label><input  type="file" name="upload_image"  /></div><input type="hidden" name="controller" value="data-image" /><input type="hidden" name="controller2" value="'+helmi.controller+'" /><input type="hidden" name="mode" value="profile-pic" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				''
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				//if (!$(this).hasClass("hasDatepicker")) { }
				break;
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
				
			default: break;
		}
	});
	
	if(opsi_extra.userdata == ''){
		$.ajax({
			url:helmi.current+'ajax/'+helmi.controller ,data:{controller:helmi.controller , mode:'view'},type:'POST',dataType:'json'
			,success:function(data){
				if(data.berhasil){
					var e=data.berhasil,c = buat_tabel(data.berhasil); opsi_extra.userdata=data.berhasil;
					$('#user-profile').html(c);
					$('#tab-preview').html('<div class="main-box-body" style="min-height:200px;"><div class="form-group "> <label> Name : </label> <input disabled class="form-control" value="'+e.nama+'" ></div> <div class="form-inline"> <button class="btn btn-success" data-tombol="set-name">Set name</button> &nbsp; <button class="btn btn-info" data-tombol="set-photo-profile">Set Photo profile</button> &nbsp; <button class="btn btn-danger" data-tombol="set-password">Set Password</button></div></div>');
				}
			}
		});
	}
	
	$(document).on('submit','#modalnya-bro form',function(e){
		helmi.submit(e,$(this) ); 
	});
	
	function buat_tabel(e){
		var b = (e.bintang || e.bintang > 0) ? parseInt(e.bintang) : 0 ,bb='';
		e.extra = (typeof e.extra === 'undefined') ? {} : e.extra ;
		var c='';
		 c += '<header class="main-box-header clearfix"> <h2>'+e.nama+'</h2> </header>';
		 c += '<div class="main-box-body clearfix">';
		 c += '<div class="profile-status"> <i class="fa fa-circle"></i> Online </div>';
		 c += '<img style="max-width:250px;" src="'+( (typeof e.extra.folder !== 'undefined' && typeof e.extra.profile_pic !== 'undefined' ) ? helmi.asset + e.extra.folder +e.extra.profile_pic+'?_='+Date.now() : helmi.asset + 'noimage.jpg' )+'" alt="" class="profile-img img-responsive center-block">';
		 c += '<div class="profile-label"> <span class="label label-danger">'+e.level+'</span> </div>';
		 for(var i=1;i<=5;i++){
			bb += b >= i ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>';
		 }
		 c += '<div class="profile-stars"> '+bb+' <span> '+e.level_ket+' </span> </div>';
		 c += '<div class="profile-since"> Registered : '+e.buat+' </div>';
		 c += '<div class="profile-details"> <ul class="fa-ul"> <li><i class="fa-li fa fa-truck"></i> ~~~ </span></li> <li><i class="fa-li fa fa-comment"></i> ~~~ </span></li> </ul> </div>';
		 //c += '<div class="profile-message-btn center-block text-center"> <a href="#" class="btn btn-success"> <i class="fa fa-envelope"></i> Send message </a> </div>';
		 c += '</div>';
		 return c;
	}
});