function showFormOverlay(data){
	showFormOverlayWithDimentions(data,400,272);
}
function showFormOverlayWithDimentions(data,width,height){//use 400 or 600 or 800 as width
	$("#formOverlay").html(data);
	$("#formOverlay").show();
	if(width==400){
		$("#formOverlay").addClass("narrowFormOverlay");
	} else if(width==600){
		$("#formOverlay").addClass("wideFormOverlay");
	} else {
		$("#formOverlay").addClass("fullFormOverlay");	
	}
	marginleft=-(Math.floor(width)/2);
	$("#formOverlay").css({border:'1px solid #6771A1'});
	
	$("#formOverlay").animate({height:(height+'px'),width:(width+'px'),marginLeft:marginleft+'px'});
	$(".middleDiv").fadeOut();
	$("#options").fadeOut();	
}
function hideFormOverlay(){
	$(".middleDiv").not(".extraLinks").fadeIn();
	$("#options").fadeIn();
	$("#formOverlay").animate({height:'0px',width:'400px',marginLeft:'-200px'});
	$("#formOverlay").css({border:'none'});
	$("#formOverlay").show();
	$("#formOverlay").html();
	$("#formOverlay").removeClass("wideFormOverlay");
	$("#formOverlay").removeClass("narrowFormOverlay");
}
function processSelection(data){
		switch(data){
			case "Change Password":
				$.post("includes/generic/formOverlayForms/passwordChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})
				break;
			case "Change Picture":
				$.post("includes/generic/formOverlayForms/pictureChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})				
				break;
			case "Change Map":
				$.post("includes/generic/formOverlayForms/mapChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})				
				break;
			case "Change Crest":
				$.post("includes/generic/formOverlayForms/crestChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})				
				break;
			case "Change Policies":
				$.post("includes/generic/formOverlayForms/policyChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})
				break;
			case "Change Address":
				$.post("includes/generic/formOverlayForms/addressChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})				
				break;
			case "Change Email":
				$.post("includes/generic/formOverlayForms/emailChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})				
				break;
			case "Create Class":
				$.post("includes/generic/formOverlayForms/createClass.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,600);
				})
				break;
			case "Edit Class":
				$.post("includes/generic/formOverlayForms/editClass.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,600);
				})
				break;
			case "Delete Class":
				$.post("includes/generic/formOverlayForms/deleteClass.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,600);
				})
				break;
			case "Edit Subjects":
				$.post("includes/generic/formOverlayForms/teacherSubjectSelectForm.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,800);
				})
				break;
			case "Select Friends":
				$.post("includes/generic/formOverlayForms/teacherFriendsSelectForm.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,600);
				})
				break;
			case "Roll Call":
				$.post("includes/generic/formOverlayForms/pupilsPresentSelectForm.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,600);
				})
				break;
			case "Join Classes":
				$.post("includes/generic/formOverlayForms/joinClass.php",{param:"null"},function(data){
					showFormOverlay(data);
				})
				break;
			case "List of Teachers":
					document.location.href=$("#listofteachers").attr("href");
				break;
			case "School Policies":
					window.open($("#schoolpolicies").attr("href"));
				break;
			case "School Map":
					document.location.href=$("#schoolmap").attr("href");
			break;
			case "Back to teacher":
					document.location.href=$(".backToTeacher a").attr("href");
			break;
			case "Back to school":
					document.location.href="changeUserTypeSch.php";
			break;
			case "Log Out":
				$.post("ajax/logOut.php",{param:"null"},function(data){
					document.location.href="index.php";
				})
				break;
			default:
				break;
		}
}
$(document).ready(function(){
	if($("#schoolpolicies").length>1){
		
	}
	var winW = 630, winH = 460;
	if (document.body && document.body.offsetWidth) {
	 winW = document.body.offsetWidth;
	 winH = document.body.offsetHeight;
	}
	if (document.compatMode=='CSS1Compat' &&
		document.documentElement &&
		document.documentElement.offsetWidth ) {
	 winW = document.documentElement.offsetWidth;
	 winH = document.documentElement.offsetHeight;
	}
	if (window.innerWidth && window.innerHeight) {
	 winW = window.innerWidth;
	 winH = window.innerHeight;
	}
	vmenuvisible=false;
	$("#displayMenu").click(function(){
		if(vmenuvisible){
			$("#vmenu").fadeOut();
			$("#displayMenu").text("Show Menu");
			vmenuvisible=false;	
		} else {
			$("#displayMenu").text("Hide Menu");
			$("#vmenu").fadeIn();	
			vmenuvisible=true;	
		}	 
	})
	if(winW<1110){
		$("#vmenu").css('height',"240px");
		$("#vmenu").css('min-height',"240px");
		$("#vmenu").css('margin-left',"-390px");
		$("#vmenu").css('top',"80px");
		$("#vmenu div").not(".first_li").not(".inner_li").hide();		
		$("#vmenu").css('border',"1px solid #052167");
		$("#miniNoticeboard").css('display',"none");	
		$("#vmenu").fadeOut(1);
		$("#displayMenu").css('border',"1px solid #052167");
		$("#displayMenu").css('padding-top',"2px");
		$("#displayMenu").css('padding-bottom',"2px");
		$("#displayMenu").css('top',"55px");
	} else {
		$("#displayMenu").hide();
		hght=($("#centeredContent").height()-60)+"px";
		$("#vmenu").css('height',hght);
		$("#miniNoticeboard").css('height',hght);	
	}
	$(".inner_li").hide();
	$('.vmenu .first_li').live('click',function() {
		if($(this).find("a").length>0){
			window.open($(this).find("span").find("a").attr("href"));		
		} else {
			if( $(this).children().size() == 1) {
				processSelection($(this).children().text());
			}
		}
	});

	 $('.vmenu .inner_li span').live('click',function() {
		processSelection($(this).text());
	 });


	$(".first_li , .sec_li, .inner_li span").hover(function () {
		$(this).css({backgroundColor : '#052167' , color:'#FFFFFF' , cursor : 'pointer'});
		if ( $(this).children().size() >0 )
				$(this).find('.inner_li').show();	
				$(this).css({cursor : 'default'});
		}, 
		function () {
			$(this).css({backgroundColor:'#E7E7E7' , color:'#052167' });
			$(this).find('.inner_li').hide();
		});
	$("#passwordChangeForm #submit").live('click',function(){
			if($("#newPass").val()!=$("#confirmPass").val()){
				$("#confirmPass").click();
				$("#confirmPass").val("");
				alert("Passwords do not match");	
			} else {
				$.post("ajax/changePassword.php",$(this).parent().serialize(),function(data2){
					$("#formOverlay").html(data2);
					setTimeout("hideFormOverlay()",2000);
				});
			}
			return false;
	})
	$("#emailChangeForm #submit").live('click',function(){
			if($("#newEmail").val()!=$("#confirmEmail").val()){
				$("#confirmEmail").click();
				$("#confirmEmail").val("");
				alert("Email Addresses do not match");	
			} else {
				$.post("ajax/changeEmail.php",$(this).parent().serialize(),function(data2){
					$("#formOverlay").html(data2);
					setTimeout("hideFormOverlay()",2000);
				});
			}
			return false;
	});
	$("#createClassForm #submit").live('click',function(){
		var ok=true;
		if($("#extraRef").val()==""){
			ok=false;
			alert("You must provide and extra reference to distuinguish between classes");
		} else {
			$("input.roomInput").each(function(){
				   if($(this).val()=="" && $(this).prev().attr("checked")){
						alert("Every timeslot must have a room associated with it.");
						ok=false;
						return false;
					}
			})
		}
		if(!ok) return false;
		$.post("ajax/createClass.php",$(this).parent().serialize(),function(data2){
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		})
	})
	$("#deleteClassForm #submit").live('click',function(){
		if(confirm("Are you sure you want to delete this class?")){
			$.post("ajax/deleteClass.php",$(this).parent().serialize(),function(data2){
				$("#formOverlay").html(data2);
				setTimeout("hideFormOverlay()",2000);
			})
		}
	})
	$("#editClassForm #submit").live('click',function(){
		$.post("includes/generic/formOverlayForms/createClass.php",$(this).parent().serialize(),function(data){
//																										 alert(data);
			showFormOverlayWithDimentions(data,600,600);
		});
		return false;
	});
	$("#findStudentForm #submit").live('click',function(){
		$.post("ajax/findStudent.php",$(this).parent().serialize(),function(data){
			showFormOverlayWithDimentions(data,600,600);

});
		return false;
	});
	$("#findTeacherForm #submit").live('click',function(){
		$.post("ajax/findTeacher.php",$(this).parent().serialize(),function(data){
			showFormOverlayWithDimentions(data,600,600);

});
		return false;
	});
	$("#findStudentForm").live('submit',function(){
		$.post("ajax/findStudent.php",$(this).serialize(),function(data){
			showFormOverlayWithDimentions(data,600,600);

		});
		return false;
	});
	$("#teacherSubjectSelectForm #submit").live('click',function(){
			
		$.post("ajax/teacherTeachesSubmit.php",$(this).parent().parent().serialize(),function(data2){
			if(data2.indexOf("subHeading")==-1){
			data2="<div class='subHeading'>"+data2+"</div>"	
			}
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#teacherFriendsSelectForm #submit").live('click',function(){
		$.post("ajax/teacherFriendsSubmit.php",$(this).parent().parent().serialize(),function(data2){
			if(data2.indexOf("subHeading")==-1){
			data2="<div class='subHeading'>"+data2+"</div>"	
			}
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#pupilsPresentSelectForm #submit").live('click',function(){
		form=$(this).parent().parent();
		$.post("ajax/pupilsPresent.php",form.serialize(),function(data2){
			if(data2.indexOf("subHeading")==-1){
			data2="<div class='subHeading'>"+data2+"</div>"	
			}
			$("#formOverlay").html(data2);
//			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#joinClassForm #submit").live('click',function(){
		$.post("ajax/joinClass.php",$(this).parent().serialize(),function(data2){
			if(data2.indexOf("subHeading")==-1){
			data2="<div class='subHeading'>"+data2+"</div>"	
			}
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#addressChangeForm #submit").live('click',function(){
		$.post("ajax/changeAddress.php",$(this).parent().serialize(),function(data2){
			if(data2.indexOf("subHeading")==-1){
			data2="<div class='subHeading'>"+data2+"</div>"	
			}
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#TYSelection #submit").live('click',function(){
		$.post("ajax/TYsetter.php",$(this).parent().serialize(),function(data2){
			if(data2.indexOf("subHeading")==-1){
			data2="<div class='subHeading'>"+data2+"</div>"	
			}
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#formOverlay .subHeading").live("click",hideFormOverlay);
	
});