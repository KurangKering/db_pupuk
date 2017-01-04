$('document').ready(function() { 
	/* handling form validation */
	$("#login-form").validate({
		rules: {
			login_username: {
				required: true,
				
			},
			login_password: {
				required: true,
			},
		},
		messages: {
			login_username: {
				required: "username tidak boleh kosong"
			},
			login_password: "password tidak boleh kosong",
		},
		submitHandler: submitForm	
	});	   
	/* Handling login functionality */
	function submitForm() {		
		var data = $("#login-form").serialize();				
		$.ajax({				
			type : 'POST',
			url  : 'proses_login.php',
			data : data,
			beforeSend: function(){	

				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Mengecek ...');
			},
			success : function(response){						
				if(response == true){									
					$("#login_button").html('<img src="assets/img/ajax-loader.gif" /> &nbsp; Signing In ...');
					setTimeout(' window.location.href = "dashboard.php"; ',2000);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger text-center"> <span class="glyphicon glyphicon-info-sign"></span> Username atau Password Salah</div>');
						$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
					});
				}
			}
		});
		return false;
	}   
});