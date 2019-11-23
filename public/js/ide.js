var ddir = $('meta[name=dir]').attr("content")+'/';
$(document).ready(function() {
  $('.nav-link-collapse').on('click', function() {
    $('.nav-link-collapse').not(this).removeClass('nav-link-show');
    $(this).toggleClass('nav-link-show');
  });
});

$(document).on("click",".console-link",function(){
	var status = $(".chknconsole").attr("data-toggle");
	if(status == "true"){
		$(".chknconsole").attr("data-toggle","false");
	}else{
		$(".chknconsole").attr("data-toggle","true");
		var frame = $("iframe");
		$(".console-input",frame.contents()).focus();
	}
});

$(".editor-container").click(function(){
	var status = $(".chknconsole").attr("data-toggle");
	if(status == "true"){
		$(".chknconsole").attr("data-toggle","false");
	}
});

$(".application-widget").click(function(e){
	e.preventDefault();
	getApplication();
	$("#openApplication").modal("show");
	return false;
});

$(".database-widget").click(function(e){
	e.preventDefault();
	getDatabase();
	$("#openDatabase").modal("show");
	return false;
});

$(".package-widget").click(function(e){
	e.preventDefault();
	getPackage();
	$("#openPackage").modal("show");
	return false;
});

$(".vendor-widget").click(function(e){
	e.preventDefault();
	getVendor();
	$("#openVendor").modal("show");
	return false;
});

$(".save-sapplication").click(function(){
	$.ajax({
		url:"ide/saveSApplication/",
		data:$("#Application_set_form").serialize(),
		dataType:"JSON",
		type:"POST",
		success:function(e){
			$("#openApplication").modal("hide");
			swal("Application Settings is successfully updated!");
		}
	});
});

$(".save-sdatabase").click(function(){
	$.ajax({
		url:"ide/saveSDatabase/",
		data:$("#Database_set_form").serialize(),
		dataType:"JSON",
		type:"POST",
		success:function(e){
			$("#openDatabase").modal("hide");
			swal("Database Settings is successfully updated!");
		}
	});
});

$(".pack[data-source='ALL']").change(function(){
	if($(this). prop("checked") == true){
		$(".pack").each(function(){
			$(this).prop("checked",true);
		});
	}else{
		$(".pack").each(function(){
			$(this).prop("checked",false);
		});
	}
});

$(".save-spackage").click(function(){
	var packages = "";
	$(".packages input[type='checkbox']").each(function(){
		if(packages == ""){
			pre = "";
		}else{
			pre = "|";
		}
		if($(this).prop("checked") == true){
			packages+=pre+$(this).attr("data-source")+":"+1;
		}else{
			packages+=pre+$(this).attr("data-source")+":"+0;
		}
	});

	$.ajax({
		url:"ide/saveSPackage/",
		data:{
			package:packages
		},
		dataType:"JSON",
		type:"POST",
		success:function(e){
			$("#openPackage").modal("hide");
			swal("Package Settings is successfully updated!");
		}
	});
});

$(".save-svendor").click(function(){
	$.ajax({
		url:"ide/saveSVendor/",
		data:$("#vendor_additionals").serialize(),
		dataType:"JSON",
		type:"POST",
		success:function(e){
			$("#openPackage").modal("hide");
			swal("Package Settings is successfully updated!");
		}
	});
});
$("#controller-wrap").click(function(){
	getController();
});
function getController(){
	$.ajax({
		url:"ide/getController",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			var html = '';
			$.each(e,function(e,v){
				html+='<li class="nav-item">'+
			            '<a class="nav-link file" data-type="controller" data-source="'+v+'" href="#">'+
			              '<span class="nav-link-text">'+v+'</span>'+
			            '</a>'+
			          '</li>';
			});

			html+='<li class="new-controller new-file"><a href="#"><i class="fas fa-plus"></i> New Controller</a></li>';
			$("#collapseSubItems2").html(html);
		}
	});
}

$(document).on("click",".new-controller",function(e){
	e.preventDefault();
	swal({
	  text: 'Enter Controller Name',
	  content: "input",
	  button: {
	    text: "Create",
	    closeModal: true,
	  }
	}).then((value)=>{
		if(value == ""){
			swal("Invalid Input!");
		}else{
			$.ajax({
				url:"ide/createController",
				type:"POST",
				data:{
					controller:value
				},
				success:function(e){
					if(e.message != "Undefined value for CREATE CONTROLLER command"){
						swal(e.message);
						getController();
						getPage();
					}
					
				}
			});
		}
	});
	return false;
});

$(document).on("click",".rename-file",function(e){
	e.preventDefault();
	var group = selected_group;
	if(group == "page"){
		var file = (selected_file.split("/"))[1];
	}else{
		var file = selected_file;
	}
	
	swal({
	  text: 'Rename File Name',
	  content: {
	    element: 'input',
	    attributes: {
	      defaultValue: file,
	    }
	  },
	  button: {
	    text: "Create",
	    closeModal: true,
	  }
	}).then((value)=>{
		if(value == ""){
			swal("Invalid Input!");
		}else{
			if(file != value){
				// $.ajax({
				// 	url:"ide/createController",
				// 	type:"POST",
				// 	data:{
				// 		controller:value
				// 	},
				// 	success:function(e){
				// 		if(e.message != "Undefined value for CREATE CONTROLLER command"){
				// 			swal(e.message);
				// 			getController();
				// 			getPage();
				// 		}
						
				// 	}
				// });
			}else{
				alert(1);
			}
			
		}
	});
	return false;
});

$(document).on("click",".new-template",function(e){
	e.preventDefault();
	swal({
	  text: 'Enter Template Name',
	  content: "input",
	  button: {
	    text: "Create",
	    closeModal: true,
	  }
	}).then((value)=>{
		if(value == ""){
			swal("Invalid Input!");
		}else{
			$.ajax({
				url:"ide/createTemplate",
				type:"POST",
				data:{
					template:value
				},
				dataType:"JSON",
				success:function(e){
					swal(e.message);
					getTemplate();
				}
			});
		}
	});
	return false;
});

$(document).on("click",".new-styles",function(e){
	e.preventDefault();
	swal({
	  text: 'Enter Style Name',
	  content: "input",
	  button: {
	    text: "Create",
	    closeModal: true,
	  }
	}).then((value)=>{
		if(value == ""){
			swal("Invalid Input!");
		}else{
			$.ajax({
				url:"ide/createStyle",
				type:"POST",
				data:{
					style:value
				},
				dataType:"JSON",
				success:function(e){
					getStyles();
				}
			});
		}
	});
	return false;
});

$(document).on("click",".new-scripts",function(e){
	e.preventDefault();
	swal({
	  text: 'Enter Script Name',
	  content: "input",
	  button: {
	    text: "Create",
	    closeModal: true,
	  }
	}).then((value)=>{
		if(value == ""){
			swal("Invalid Input!");
		}else{
			$.ajax({
				url:"ide/createScript",
				type:"POST",
				data:{
					style:value
				},
				dataType:"JSON",
				success:function(e){
					getScripts();
				}
			});
		}
	});
	return false;
});
$(document).on("click",".new-page",function(){
	$.ajax({
		url:"ide/getControllerFolders/",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			var html = "";
			additional = "";
			$.each(e,function(key,value){
				if(html == ""){
					additional = value;
				}
				html+='<option value="'+value+'" '+additional+'>'+value+'</option>';
			});

			$(".controller-folder").html(html);
			$(".controller-folder").val(additional);
			$(".controller-file").val("");
			$("#newPage").modal("show");
		}
	});
	
});


$(".controller-file").keyup(function(){
	var string = "view/page/"+$(".controller-folder").val()+"/"+$(this).val()+".cvf";
	$(".controller-label").html(string);
});

$(".save-page").click(function(){
	if($(".controller-file").val() != "" && $(".controller-folder").val() != ""){
		$.ajax({
			url:"ide/createPage",
			data:$("#newpage_form").serialize(),
			type:"POST",
			success:function(e){
				if(e == 0){
					swal("File already exist");
				}else{
					getPage();
					$(".controller-file").val("");
					$("#newPage").modal("hide");
				}
			}
		});
	}else{
		swal("Invalid Input!");
	}
});

$(".controller-folder").change(function(){
	var string = "view/page/"+$(this).val()+"/"+$(".controller-file").val()+".cvf";
	$(".controller-label").html(string);
});


var selected_file = "";
var selected_group = "";
$(document).on("mouseover",".file",function(){
	selected_file = $(this).find("span").html();
});

$(".delete-file").click(function(){
	swal("Are you sure you want to delete "+selected_file+"?", {
	  buttons: ["No", "Yes"],
	}).then(function(e){
		if(e){
			$.ajax({
				url:"ide/deleteFile/",
				data:{
					group:selected_group,
					file:selected_file
				},
				type:"POST",
				success:function(e){
					swal("File successfully deleted!");
					if(selected_group == "controller"){
						getController();
					}
					if(selected_group == "page"){
						getPage();
					}
					if(selected_group == "template"){
						getTemplate();
					}
					if(selected_group == "style"){
						getStyles();
					}
					if(selected_group == "script"){
						getScripts();
					}
				}
			});
		}
	});
});
$("#collapseSubItems2").on('contextmenu', function(e) {
	selected_group = "controller";
  var top = e.pageY - 10;
  var left = e.pageX - 90;
  $("#context-menu").css({
    display: "block",
    top: top,
    left: left
  }).addClass("show");
  return false; //blocks default Webbrowser right click menu
})

$("#collapseSubItems1").on('contextmenu', function(e) {
	selected_group = "page";
  var top = e.pageY - 10;
  var left = e.pageX - 90;
  $("#context-menu").css({
    display: "block",
    top: top,
    left: left
  }).addClass("show");
  return false; //blocks default Webbrowser right click menu
})

$("#collapseSubItems3").on('contextmenu', function(e) {
	selected_group = "template";
  var top = e.pageY - 10;
  var left = e.pageX - 90;
  $("#context-menu").css({
    display: "block",
    top: top,
    left: left
  }).addClass("show");
  return false; //blocks default Webbrowser right click menu
})
$("#collapseSubItems4").on('contextmenu', function(e) {
	selected_group = "style";
  var top = e.pageY - 10;
  var left = e.pageX - 90;
  $("#context-menu").css({
    display: "block",
    top: top,
    left: left
  }).addClass("show");
  return false; //blocks default Webbrowser right click menu
})

$("#collapseSubItems5").on('contextmenu', function(e) {
	selected_group = "script";
  var top = e.pageY - 10;
  var left = e.pageX - 90;
  $("#context-menu").css({
    display: "block",
    top: top,
    left: left
  }).addClass("show");
  return false; //blocks default Webbrowser right click menu
})

$(document).on("click", function() {
  $("#context-menu").removeClass("show").hide();
});

$("#context-menu a").on("click", function() {
  $(this).parent().removeClass("show").hide();
});
$("#page-wrap").click(function(){
	getPage();
});
var files = [];
$(document).on("click",".file",function(e){
	e.preventDefault();
	var data_type = $(this).attr("data-type");
	var data_source = $(this).attr("data-source");
	pushFile(data_type,data_source);
	return false;
});
var connector = 0;
var comp = [];
function pushFile(data_type,data_source){
	var lastChar = data_source[data_source.length -3]+data_source[data_source.length -2]+data_source[data_source.length -1];
	var ind = 0;
	var raw = data_type+"/"+data_source;
	$.ajax({
		url:"ide/getContent",
		data:{
			"file":raw
		},
		type:"POST",
		success:function(e){
			$.each(files,function(key,value){
				if(value == raw){
					ind++;
				}
			})
			if(ind == 0){
				connector++;
				$(".header-container .content-file").each(function(){
					$(this).removeClass("active-file");
				});
				$(".editor-container .editor-wrap").each(function(){
					$(this).removeClass("active-wrap");
				});
				$(".header-container").append('<span data-bind="'+connector+'" title="'+raw+'" class="content-file active-file" data-content="'+raw+'"><span>'+raw+'</span> <a data-bind="'+connector+'" href="#" class="close-file" data-content="'+raw+'"><i class="fas fa-times"></i></a></span>');
				$(".editor-container").append(''+
			 '<div class="editor-wrap active-wrap"  data-bind="'+connector+'"><textarea name="editor'+connector+'" id="editor'+connector+'"></textarea>'+
		      '</div>');
				files.push(raw);
				var name = "";
				if(lastChar == "php"){
					name = "application/x-httpd-php-open";
				}else if(lastChar == "cvf"){
					name = "text/html";
				}else if(lastChar == "tpl"){
					name = "text/html";
				}else if(lastChar == "css"){
					name="css";
				}else if(lastChar == ".js"){
					name = "javascript";
				}

				var editor = CodeMirror.fromTextArea(document.getElementById('editor'+connector), {
					value:e,
			     	lineNumbers: true,
			    	theme:"gruvbox-dark",
		        	autoCloseTags: true,
		        	gutters: ["CodeMirror-lint-markers"],
    				lint: {
						disableEval: true,
						disableExit: true,
						disabledFunctions: ['proc_open', 'system'],
						deprecatedFunctions: ['wp_list_cats']
					},
					extraKeys: {
						"Ctrl-Space": "autocomplete",
						"Ctrl-S":function(e){
							var val = editor.getDoc().getValue();
							var source = $(".active-file span").html();
							$.ajax({
								url:"ide/saveFile",
								data:{
									"source":source,
									"value":val
								},
								type:"POST",
								beforeSend:function(e){
									$(".editor-blocker").css({"display":"block"});
								},
								success:function(e){
									$(".editor-blocker").css({"display":"none"});
								}
							});
						}
					},
					mode: {name: name, globalVars: true},
			   });

				editor.getDoc().setValue(e);
				
			}
			compressor();
		}
	});
	
}



$(document).on("click",".content-file",function(){
	var bind = $(this).attr("data-bind");
	$(".content-file").each(function(){
		$(this).removeClass("active-file");
	});
	$(".editor-wrap").each(function(){
		$(this).removeClass("active-wrap");
	});
	$(".editor-wrap[data-bind='"+bind+"']").addClass("active-wrap");
	$(this).addClass("active-file");
});

$(document).on("click",".close-file",function(e){
	e.preventDefault();
	var bind = $(this).attr("data-bind");
	$(this).parent().remove();
	$(".editor-wrap[data-bind='"+bind+"']").remove();
	var d = $(this).attr("data-content");
	files.splice(files.indexOf(d), 1 );
	var numItems = $('.active-wrap').length;
	if(numItems == 0){
		$(".editor-wrap").each(function(){
			$(this).removeClass("active-wrap");
		});
		$(".main-file").addClass("active-wrap");
	}

	var ew = $('.editor-wrap').length;
	if(ew==0){
		$(".main-file").addClass("active-wrap");
	}
	return false;
});
$(".open-file").click(function(e){
	e.preventDefault();
	pushFile(selected_group,selected_file);
	return false;
});

function compressor(){
	var counter = 0;
	$(".header-container .content-file").each(function(){
		counter++;
	});

	if(counter < 4){
		$(".header-container .content-file").each(function(){
			$(this).css({"width":"20%"});
		});
	}else{
		var size = 100 / counter;
		$(".header-container .content-file").each(function(){
			$(this).css({"width":(size-.6)+"%"});
		});
	}
	
}

function getPage(){
	$.ajax({
		url:"ide/getPage",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			var html = '';
			$.each(e,function(e,v){
				html+='<li class="nav-item">'+
			            '<a class="nav-link file" data-type="page" data-source="'+v+'" href="#">'+
			              '<span class="nav-link-text">'+v+'</span>'+
			            '</a>'+
			          '</li>';
			});
			html+='<li class="new-page new-file"><a href="#"><i class="fas fa-plus"></i> New Page</a></li>';
			$("#collapseSubItems1").html(html);
		}
	});
}

$("#template-wrap").click(function(){
	getTemplate();
});	
function getTemplate(){
	$.ajax({
		url:"ide/getTemplate",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			var html = '';
			$.each(e,function(e,v){
				html+='<li class="nav-item">'+
			            '<a class="nav-link file" data-type="template" data-source="'+v+'" href="#">'+
			              '<span class="nav-link-text">'+v+'</span>'+
			            '</a>'+
			          '</li>';
			});
			html+='<li class="new-template new-file"><a href="#"><i class="fas fa-plus"></i> New Template</a></li>';
			$("#collapseSubItems3").html(html);
		}
	});
}

$("#styles-wrap").click(function(){
	getStyles();
});	
function getStyles(){
	$.ajax({
		url:"ide/getStyles",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			var html = '';
			$.each(e,function(e,v){
				html+='<li class="nav-item">'+
			            '<a class="nav-link file" data-type="css" data-source="'+v+'" href="#">'+
			              '<span class="nav-link-text">'+v+'</span>'+
			            '</a>'+
			          '</li>';
			});
			html+='<li class="new-styles new-file"><a href="#"><i class="fas fa-plus"></i> New Style</a></li>';
			$("#collapseSubItems4").html(html);
		}
	});
}

$("#scripts-wrap").click(function(){
	getScripts();
});	
function getScripts(){
	$.ajax({
		url:"ide/getScripts",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			var html = '';
			$.each(e,function(e,v){
				html+='<li class="nav-item">'+
			            '<a class="nav-link file" data-type="js" data-source="'+v+'" href="#">'+
			              '<span class="nav-link-text">'+v+'</span>'+
			            '</a>'+
			          '</li>';
			});
			html+='<li class="new-scripts new-file"><a href="#"><i class="fas fa-plus"></i> New Script</a></li>';
			$("#collapseSubItems5").html(html);
		}
	});
}

function getApplication(){
	$.ajax({
		url:"ide/getApplication",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			$(".local").val(parseInt(e.LOCAL)).change();
			$(".console").val(parseInt(e.CONSOLE)).change();
			$(".css_error").val(parseInt(e.CSS_ERROR)).change();
			$(".js_error").val(parseInt(e.JS_ERROR)).change();
			$(".default_image_size").val(e.DEFAULT_IMAGE_SIZE);
			$(".default_file_size").val(e.DEFAULT_FILE_SIZE);
		}
	});
}


function getDatabase(){
	$.ajax({
		url:"ide/getDatabase",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			$(".db_connection").val(e.DB_CONNECTION);
			$(".db_host").val(e.DB_HOST);
			$(".db_name").val(e.DB_NAME);
			$(".db_charset").val(e.DB_CHARSET);
			$(".db_user").val(e.DB_USER);
			$(".db_password").val(e.DB_PASSWORD);
		}
	});
}

function getPackage(){
	$.ajax({
		url:"ide/getPackage",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			$.each(e,function(k,v){
				if(v == 1){
					$(".pack[data-source='"+k+"']").prop("checked",true);
				}
			});
		}
	});
}


function getVendor(){
	$.ajax({
		url:"ide/getVendors",
		type:"GET",
		dataType:"JSON",
		success:function(e){
			$(".vendor_styles").val(e.VENDOR_STYLES);
			$(".vendor_scripts").val(e.VENDOR_SCRIPTS);
		}
	});
}
