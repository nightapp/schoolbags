$(document).ready(function(){
	$(".option").click(function(){
		src=$(this).attr("rel");
		document.location.href=src;
	});						
});