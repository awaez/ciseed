<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>CISeed Project Completed</title>
		
		<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		
		<style type="text/css">
			body {
			  padding-top: 20px;
			  padding-bottom: 20px;
			}
			button{
				margin: 0 10px;
			}
		</style>
	</head>
	<body>
		<i id="hp_info_board" style="display: none;"
			create_student_hyper = "<?= base_url('welcome/create_new_student'); ?>" 
			update_student_hyper = "<?= base_url('welcome/update_student'); ?>" 
			delete_student_hyper = "<?= base_url('welcome/delete_student'); ?>" 
		></i>
		<i id="hp_students_array" style="display: none;"><?= json_encode($students); ?></i>

		<table id="hp_students_table" class="table table-hover table-responsive table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>user_name</th>
					<th>password</th>
					<th>actions</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		
		<button type="button" class="btn btn-primary btn-xs">Create New User</button>

		<script>
			(function() {
				var hp = {};	//Global home-page object to hold all variables and functions related to this page in it
				hp.info_board = $('#hp_info_board');
				hp.table = $('#hp_students_table');
				hp.students_json_obj = null; hp.students_json_obj = $.parseJSON($('#hp_students_array').text());
			

				/***	Function to create the initial table   ***/
				hp.create_table = function(students_json_obj){
					var students_json_obj_length = students_json_obj.length;
					for(var k = 0; k < students_json_obj_length; k++){
						hp.add_student(students_json_obj[k]);
					}
				};
	
				

				/***	Function to add a student to the end of the current table   ***/
				hp.add_student = function(student){
					var student_row = $('<tr><td>'+student['id']+'</td><td>'+student['user_name']+'</td><td>'+student['password']+'</td></tr>');
						var action = $('<td>');
							$('<button type="button" class="btn btn-warning btn-xs">Randomize</button>&nbsp;&nbsp;&nbsp;').appendTo(action);
							$('<button type="button" class="btn btn-danger btn-xs">delete</button>').appendTo(action);
						action.appendTo(student_row);
					student_row.appendTo(hp.table.find('tbody'));
				}
				


				/***	Binding click handler to the New-Student-Creation buttons   ***/
				$('button.btn.btn-primary').click(function(){
					var thisButton = $(this);
					if( ! thisButton.find('span').length ){
						thisButton.prepend('<span class="glyphicon glyphicon-refresh"></span>');
						$.ajax({
							type:	'GET',
							url:	hp.info_board.attr('create_student_hyper'),
							success: function(data){
								if(data != 0){	//creation successful
									hp.add_student($.parseJSON(data));
									thisButton.find('span').remove();
								}else{	//creation failed
									alert( 'creation of the new student faild' );
									thisButton.find('span').remove();
								}
							},
							error: function(data){
								alert( 'there was an error while connecting to the server' );
								thisButton.find('span').remove();
							}
						});
					}
				});



				/***	Binding click handler to the Update buttons   ***/
				$('table').off('click', 'button.btn-warning').on('click', 'button.btn-warning', function(){
					var thisButton = $(this);
					if( ! thisButton.find('span').length ){
						var tr = thisButton.parent().parent();
						thisButton.prepend('<span class="glyphicon glyphicon-refresh"></span>');
						$.ajax({
							type:	'GET',
							url:	hp.info_board.attr('update_student_hyper'),
							data:   { id: tr.find('td').eq('0').text() },
							success: function(data){
								if(data != 0){	//updation successful
									var returned_data = $.parseJSON(data);
									tr.find('td').eq(1).text(returned_data['user_name']);
									tr.find('td').eq(2).text(returned_data['password']);
								
									thisButton.find('span').remove();
								}else{	//updation failed
									alert( 'updating the student info faild' );
									thisButton.find('span').remove();
								}
							},
							error: function(data){
								alert( 'there was an error while connecting to the server' );
								thisButton.find('span').remove();
							}
						});
					}
				});



				/***	Binding click handler to the Delete buttons   ***/
				$('table').off('click', 'button.btn-danger').on('click', 'button.btn-danger', function(){
					var thisButton = $(this);
					if( ! thisButton.find('span').length ){
						var tr = thisButton.parent().parent();
						thisButton.prepend('<span class="glyphicon glyphicon-refresh"></span>');
						$.ajax({
							type:	'GET',
							url:	hp.info_board.attr('delete_student_hyper'),
							data:   { id: tr.find('td').eq('0').text() },
							success: function(data){
								if(data == 1){	//deletion successful
									tr.remove();
								}else{	//updation failed
									alert( 'deleting the student info faild' );
									thisButton.find('span').remove();
								}
							},
							error: function(data){
								alert( 'there was an error while connecting to the server' );
								thisButton.find('span').remove();
							}
						});
					}
				});


				/*** Initializing table creation ***/
				hp.create_table(hp.students_json_obj);
			})();
		</script>
	</body>
</html>