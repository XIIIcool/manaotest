$(document).ready(function(){

    		$("#form-register").validate({
			rules: {
				login: "required",
				name: "required",
				
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				login: "Please enter your login",
				name: "Please enter your name",
				
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address"
				
			},
                    submitHandler: function(form) {
                        
                        $.ajax( {
                            type: "POST",
                            url: 'ajax.php',
                            data: {method:'register',data:$(form).serialize()},
                            success: function( response ) {
                               
                                 $('.form-validator-reg').html(response.text);
                               
                            }
                        })
                        return false;
                      }
		});
                
                $("#form-auth").validate({
			rules: {
				login: "required",
						
				password: {
					required: true,
					minlength: 5
				}
			},
			messages: {
				login: "Please enter your login",
							
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				}
				
			},
                    submitHandler: function(form) {
                        
                        $.ajax( {
                            type: "POST",
                            url: 'ajax.php',
                            data: {method:'auth',data:$(form).serialize()},
                            success: function( response ) {
                                 $('.form-validator-auth').html(response.text);
                               if(response.status == 'OK'){
                                //   location.reload();
                               }
                            }
                        })
                        return false;
                      }
		});
                
                $('.logout').click(function(){
                     $.ajax( {
                            type: "POST",
                            url: 'ajax.php',
                            data: {method:'logout'},
                            success: function( response ) {

                                   location.reload();
                               
                            }
                        })
                })

    
});

