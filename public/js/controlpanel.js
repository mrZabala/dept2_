
var table_data = new Vue({
	el: '.content',
	data:{
		users: users,
		guests: guests
	},
	methods:{
		updateUserInformation: function(userID, targetColumn, element){
			$.ajax({data : {userID: userID, targetColumn: targetColumn, targetValue: element.target.checked}, url : homepath + '/Sysadmin/UpdateUserRequest', dataType : 'json',
			    success: function(data){
			    	switch(data.statusCode){
						case 200:
							toastr['success']("Action Completed", "Success");
						break;
						case 303:
							toastr['error']("Try again later", "System Error");
						break;
					}
			    }
			});
		},
		ChangeDepartmentModal: function(user){
			UserDepartmentUpdate.user = user
			$('.UserDepartmentUpdate').modal('show')
		},
		updateGuestAccess: function(ip, element){
			this.$http.get(homepath + '/updateGuestAccess', {params: {ip: ip, val: element.target.checked}});
			toastr['success']("Action Completed", "Success");
		}
	},
	mounted: function(){
		$('.users-table').DataTable()
	}
})
// setInterval(function(){
// 	$.ajax({url : homepath + '/Sysadmin/GetUsers', dataType : 'json',
// 	    success: function(data){
// 	    	switch(data.statusCode){
// 				case 200:
// 					table_data.users = data.data;
// 				break;
// 			}
// 	    }
// 	});
// }, 30000);

window.paceOptions = {
    ajax: false,
    restartOnRequestAfter: false,
};