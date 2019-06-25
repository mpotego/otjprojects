
function LoadDetails(){ 
	
	/* denism@otjprojects.co.za */
    $("#emailAFirst").text("denism@");
	$("#emailASecond").text("otjprojects");	
	$("#emailAThird").text(".co.za");	
  	
	/* mphom@otjprojects.co.za */
	$("#emailBFirst").text("mphom@");
	$("#emailBSecond").text("otjprojects");	
	$("#emailBThird").text(".co.za");	
	
	/* 011 575 0909 */
	$("#cellFirst").text("011 ");
	$("#cellSecond").text("575 ");	
	$("#cellThird").text("0909");	
};


$("#ContactUsForm").submit(function(e){
 
var email = $("#email");
var name = $("#name");
var message = $("#message"); 

var valid = true;
	
if(!email.val()){
	valid = false;
	$("#emailError").css('display', 'block');
}
 
if(!name.val()){
	valid = false;
	$("#nameError").css('display', 'block');
}
 
if(!message.val()){
	valid = false;
	$("#messageError").css('display', 'block');
}

if (valid == false){
		event.preventDefault(); 
	}
	 else{
		$("#checking").show();		
    }  

});  