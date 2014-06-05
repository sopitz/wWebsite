	// Custom example logic
									function $(id) {
										return document.getElementById(id);	
									}


									var uploader = new plupload.Uploader({
										runtimes : 'gears,html5,flash,silverlight,browserplus',
										browse_button : 'pickfiles',
										container: 'container',
										max_file_size : '100mb',
										url : 'upload.php?ordner=<?php echo $pl_ord; ?>',
										resize : {width : 700, height : 700, quality : 100},
										flash_swf_url : '<?php echo Vars::$SERVERPATH; ?>/upload/js/plupload.flash.swf',
										silverlight_xap_url : '<?php echo Vars::$SERVERPATH; ?>/upload/js/plupload.silverlight.xap',
										filters : [
											{title : "Image files", extensions : "jpg,gif,png"},
											{title : "Zip files", extensions : "zip"}
										]
									});
									
									

									uploader.bind('Init', function(up, params) {
										$('filelist').innerHTML = "<div>&nbsp;</div>";
									});

									uploader.bind('FilesAdded', function(up, files) {
										for (var i in files) {
											$('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
										}
									});

									uploader.bind('UploadProgress', function(up, file) {
										$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
									});

									$('uploadfiles').onclick = function() {
										uploader.start();
										return false;
									};
								

									uploader.init();