$(document).ready(function(){
    $.ajax({
		url : "/checkmaintenance",
		type : "get",
		async: true,
		success : function(data) {
		   if(data)
			{
				window.location.replace("/maintenance");
				return;
			}
		},
		error: function() {
			window.location.replace("/");
		}
	 });
});