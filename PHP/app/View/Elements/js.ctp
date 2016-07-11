<script type="text/javascript">
	function showLoad() {
		$('.loading-container').slideDown(200);
	}
	
	function hideLoad() {
		$('.loading-container').slideUp(200);
	}

	$('a.del').on("click", function () {
		var cid = $(this).attr('cid');
		
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array('controller' => 'comments', 'action' => 'delete.json' )); ?>",
			data: { id: cid },
			dataType: 'json',
			beforeSend: function () {
				showLoad();
			}
		})
		 .done(function (data) {
			if (data[0] == 0) {
				hideLoad();
				
				$('#_comment'+cid).slideUp(400, function () {
					$('#_comment'+cid).remove();
				});
			}
			else
				alert(data);
		 });
		
		return false;
	});
	
	$('a.history').on("click", function () {
		var cid = $(this).attr('cid');
		
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array('controller' => 'comments', 'action' => 'history.json' )); ?>",
			data: { id: cid },
			dataType: 'json',
			beforeSend: function () {
				showLoad();
			}
		})
		 .done(function (data) {
			if (data[0] == 0) {
				hideLoad();
				
				var modalBody = $('#history-modal').children('.modal-dialog').children('.modal-content').children('.modal-body');
				
				modalBody.empty();
				
				var key;
				for(key in data[1]['history']) {
					var keyc;
					for(keyc in data[1]['history'][key]) {
						var comment = data[1]['history'][key][keyc];
						
						
						modalBody
							.append("<h5>há "+comment['time']+" <small>("+ comment['created'] +")</small></h5>")
							.append("<p>"+ comment['content'] +"</p>");
						
					}
				}
				
				var original = data[1]['original']['Comment'];
				
				modalBody
					.append("<hr />")
					.append("<h5>Comentário Original <small>"+ original['created'] +"</small>")
					.append("<p>"+ original['content'] +"</p>");
				
				
				$('#history-modal').modal();
				
				
			}
			else
				alert(data[1]);
		 });
		
		return false;
	});
	
	$('a.edit').on("click", function () {
		var cid = $(this).attr('cid');
		var content = $(this).attr('content');
		
		$('#edit-comment-id').val(cid);
		$('#edit-comment-content').val(content);
		
		$('#edit-modal').modal();
		
		return false;
	});
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();
	})
	
	// $('.loading-container').slideDown();
</script>