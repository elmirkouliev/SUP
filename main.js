// JavaScript Document

$(document).ready(function () {

$('.thread-list li').hover(function(e) {
	
	$(this).hoverFlow(e.type, { backgroundColor: "#476cb7" });

}, function(e) {
	
	$(this).hoverFlow(e.type, { backgroundColor: "#FFF", color:"#000" });	

});

$('.inbox-nav-icon').click(function(){
	
	id = $(this).attr('id');
	
	if($('#'+id+'-thread-list').html()){
		
		$('#'+id+'-thread-list').filter(':not(:animated)').fadeToggle('slide');
	
	}
	
	else {

		dataString = 'id=' + id;
			
		$.ajax({
			
			type: "POST",
			url: "/resources/classes/inbox/inbox_script.php",
			data: dataString,
			success: function(data){
				
				$('#inbox').prepend(data);
				
				$('#'+id+'-thread-list').fadeIn();
				
				$('.thread-list li').click(function(){
					
					message_id = $(this).attr('id');
					
					receiver_id = $(this).find('.thread_item_name').attr('id');
								
					network = $(this).attr('class');
					
					dataString = 'message_id=' + message_id + '&receiver_id=' + receiver_id + '&network=' + network;
								
					$.ajax({
						type: "POST",
						url: "/resources/classes/inbox/inbox_script.php",
						data: dataString,
						success: function(data){
							
							$('#message-pane').fadeIn();
							$('#message-pane').html(data);
							
							
							$('.chat_send').click(function(){
								
								message = $(this).prev().val();		
								
								if(/\S/.test(message)){
								
									receiver_id = $(this).attr('id');	
									
									thread_id = $(this).parent().attr('id');
									
									dataString = 'send_message=true&thread_id=' + thread_id + '&receiver_id=' + receiver_id + '&message=' + message;
																			
									$.ajax({
									
										type: "POST",
										url: "/resources/classes/inbox/inbox_script.php",
										data: dataString,
										success: function(data){
											alert('ok');
											$('.chat_message').value = '';
											
										}
								
									});//AJAX
									
									return false;
												
								}
					
							});//Listener 
							
							return false;
							
						}//Success
					
					});//AJAX
				
				});//Listener
			
			}//Success
		
		});//Super AJAX
	
	}//Condition
		
});//Close



});