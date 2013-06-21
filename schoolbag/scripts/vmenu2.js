function showFormOverlay(data){
	showFormOverlayWithDimentions(data,400,272);
}
function showFormOverlayWithDimentions(data,width,height){
	$("#formOverlay").html(data);
	$("#formOverlay").show();
	marginleft=-(Math.floor(width)/2);
	$("#formOverlay").css({border:'1px solid brown',});
	
	$("#formOverlay").animate({height:(height+'px'),width:(width+'px'),marginLeft:marginleft+'px'});
	$(".middleDiv").fadeOut();
	$("#options").fadeOut();	
}
function hideFormOverlay(){
	$(".middleDiv").fadeIn();
	$("#options").fadeIn();
	$("#formOverlay").animate({height:'0px',width:'400px',marginLeft:'-200px'});
	$("#formOverlay").css({border:'none'});
	$("#formOverlay").show();
	$("#formOverlay").html();
	
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
			case "Change Address":
				$.post("includes/generic/formOverlayForms/addressChangeForm.php",{param:"null"},function(data){
					showFormOverlay(data);
				})				
				break;
			case "Change Email Address":
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
			case "Edit Subjects":
				$.post("includes/generic/formOverlayForms/teacherSubjectSelectForm.php",{param:"null"},function(data){
					showFormOverlayWithDimentions(data,600,600);
				})
				break;
			case "Join Classes":
				$.post("includes/generic/formOverlayForms/joinClass.php",{param:"null"},function(data){
					showFormOverlay(data);
				})
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
function vMenu(e,w){
var cmenu = $("#vmenu");
		$('<div class="overlay"></div>').css({left : '0px', top : '0px',position: 'absolute', width:'100%', height: '100%', zIndex: '100' }).click(function() {
			$(this).remove();
			cmenu.hide();
		}).bind('contextmenu' , function(){return false;}).appendTo(top.document.body);
		if(top==w){
			oX=oY=0;
		} else {
			oX=$("iframe").offset().left;
			oY=$("iframe").offset().top;
		}

		cmenu.css({ left: e.pageX+oX, top: e.pageY+oY, zIndex: '101'}).show();	
}
$(document).ready(function(){
	$("#vmenu").hide();
	$(".inner_li").hide();
	$('body').bind('contextmenu',function(e){
		vMenu(e,window);
		return false;
	});

	 $('.vmenu .first_li').live('click',function() {
		if( $(this).children().size() == 1 ) {
			processSelection($(this).children().text());
			$('.vmenu').hide();
			$('.overlay').hide();
		}
	 });

	 $('.vmenu .inner_li span').live('click',function() {
processSelection($(this).text());
			$('.vmenu').hide();
			$('.overlay').hide();
	 });


	$(".first_li , .sec_li, .inner_li span").hover(function () {
		$(this).css({backgroundColor : '#E0EDFE' , cursor : 'pointer'});
		if ( $(this).children().size() >0 )
				$(this).find('.inner_li').show();	
				$(this).css({cursor : 'default'});
		}, 
		function () {
			$(this).css('background-color' , '#fff' );
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
alert("J");
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
	$("#editClassForm #submit").live('click',function(){
		$.post("includes/generic/formOverlayForms/createClass.php",$(this).parent().serialize(),function(data){
			showFormOverlayWithDimentions(data,600,600);
		});
		return false;
	});
	$("#teacherSubjectSelectForm #submit").live('click',function(){
		$.post("ajax/teacherTeachesSubmit.php",$(this).parent().serialize(),function(data2){
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#joinClassForm #submit").live('click',function(){
		$.post("ajax/joinClass.php",$(this).parent().serialize(),function(data2){
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#addressChangeForm #submit").live('click',function(){
		$.post("ajax/changeAddress.php",$(this).parent().serialize(),function(data2){
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});

	$("#TYSelection #submit").live('click',function(){
		$.post("ajax/TYsetter.php",$(this).parent().serialize(),function(data2){
			$("#formOverlay").html(data2);
			setTimeout("hideFormOverlay()",2000);
		});
		return false;
	});
	$("#formOverlay .subHeading").live("click",hideFormOverlay);

});