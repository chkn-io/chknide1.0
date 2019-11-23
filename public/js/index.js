var folder = $('meta[name=dir]').attr("content")+'/';
var csrf = $('meta[name=csrf-token]').attr("content");

function callProjects(){
	$.ajax({
		url:"setup/getProjects",
		type:"GET",
		success:function(e){
			var html = '';
			$(e).each(function(e,v){
				f = (v.replace(/\s/g,'')).toLowerCase();
				html+='<li>'+v+''+   
              			'<a href="#" class="delete-project" title="Delete Project" data-source="'+v+'.chkn" data-dependent="'+f+'"><i class="fas fa-trash"></i></a>'+
             			'<a href="#" class="open-project" title="Open Project" data-source="'+v+'.chkn" data-dependent="'+f+'"><i class="fas fa-folder-open"></i></a>'+ 
            			'</li>';
			});

			$(".project-list").html(html);
		},
		error:function(e){

		}
	});
}
$(".folder_name").html(folder);
$(".folder_name_advance").html(folder);
$(".new-project").click(function(e){
	e.preventDefault();
	$("#newProject").modal("show");
	return false;
});
$(".open-project").click(function(e){
	e.preventDefault();
	$("#openProject").modal("show");
	callProjects();
	return false;
});

var counter = 0;
setInterval(function(){
	counter++;
	if(counter == 1){
		$("#pre1-content").html("Please wait");
	}
	else if(counter == 2){
		$("#pre1-content").html("Please wait.");
	}
	else if(counter == 3){
		$("#pre1-content").html("Please wait..");
	}else if(counter == 4){
		$("#pre1-content").html("Please wait...");
	}else{
		counter = 0;
	}
},500);

var folder_name = "";
$(".project_name").keyup(function(){
	folder_name = ($(this).val().replace(/\s/g,'')).toLowerCase();  
	$(".folder_name").html(folder+folder_name);
});

var folder_name_advance = "";
$(".project_name_advance").keyup(function(){
	folder_name_advance = ($(this).val().replace(/\s/g,'')).toLowerCase();  
	$(".folder_name_advance").html(folder+folder_name_advance);
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

$(".pack_ad[data-source='ALL']").change(function(){
	if($(this). prop("checked") == true){
		$(".pack_ad").each(function(){
			$(this).prop("checked",true);
		});
	}else{
		$(".pack_ad").each(function(){
			$(this).prop("checked",false);
		});
	}
});
$(".build-basic").click(function(){
	var packages = "";
	if($(".project_name").val() != ""){
		$(".project_name").css({
			"border":"1px solid #ccc"
		});

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
			url:"setup/basic",
			data:{
				"folder_name":folder_name,
				"project_name":$(".project_name").val(),
				"packages":packages,
				"CSRFToken":csrf
			},
			type:"POST",
			dataType:"JSON",
			beforeSend:function(){
				$("#pre1").css({"display":"block"});
			},
			success:function(e){
				$("#pre1").css({"display":"none"});
				window.location = "ide";
			},
			error:function(e){
				$("#pre1").css({"display":"none"});
				swal("Folder Already exists!");
			}
		});
	}else{
		$(".project_name").css({
			"border":"1px solid red"
		});
	}
});


$(document).on("click",".delete-project",function(e){
	e.preventDefault();
	var dfolder = $(this).attr("data-dependent");
	var dproject = $(this).attr("data-source");
	swal("Are you sure you want to delete this project?", {
	  buttons: ["No", "Yes"],
	}).then(function(e){
		if(e){
			$.ajax({
				url:"setup/deleteProject",
				data:{
					"folder":dfolder,
					"project":dproject,
					"CSRFToken":csrf
				},
				beforeSend:function(){
					$("#pre2").css({"display":"block"});
				},
				type:"POST",
				success:function(e){
					$("#pre2").css({"display":"none"});
					callProjects();
				},
				error:function(e){
					$("#pre2").css({"display":"none"});
					swal("Something went wrong!");
				}
			});
		}
	});
	return false;
});

$(".build-advance").click(function(){
	var packages = "";
	if($(".project_name_advance").val() != ""){
		$(".project_name_advance").css({
			"border":"1px solid #ccc"
		});

		$(".packages_advance input[type='checkbox']").each(function(){
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
			url:"setup/advance",
			data:{
				"folder_name":folder_name_advance,
				"project_name":$(".project_name_advance").val(),
				"packages":packages,
				"CSRFToken":csrf,
				"local":$(".local").val(),
				"console":$(".local").val(),
				"css_error":$(".css_error").val(),
				"js_error":$(".js_error").val(),
				"default_image_size":$(".default_image_size").val(),
				"default_file_size":$(".default_file_size").val(),
				"db_connection":$(".db_connection").val(),
				"db_host":$(".db_host").val(),
				"db_name":$(".db_name").val(),
				"db_charset":$(".db_charset").val(),
				"db_user":$(".db_user").val(),
				"db_password":$(".db_password").val(),
				"vendor_styles":$(".vendor_styles").val(),
				"vendor_scripts":$(".vendor_scripts").val()
			},
			type:"POST",
			dataType:"JSON",
			beforeSend:function(){
				$("#pre1").css({"display":"block"});
			},
			success:function(e){
				$("#pre1").css({"display":"none"});
				window.location = "ide";
			},
			error:function(e){
				$("#pre1").css({"display":"none"});
				swal("Folder Already exists!");
			}
		});
	}else{
		$(".project_name_advance").css({
			"border":"1px solid red"
		});
	}
});

$(document).on("click",".open-project",function(){
	$.ajax({
		url:"setup/openProject",
		type:"POST",
		data:{
			"project":$(this).attr("data-source"),
			"folder":$(this).attr("data-dependent")
		},
		dataType:"JSON",
		beforeSend:function(){
			$("#pre1").css({"display":"block"});
		},
		success:function(e){
			window.location = "ide";
		},
		error:function(e){
			$("#pre1").css({"display":"none"});
			swal("Project Not Found!");
		}
	});
});