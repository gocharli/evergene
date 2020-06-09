function error_box(message,autoClose) {
	var msg= message|| "Something went wrong";
	if(autoClose>0)
	{
		$.confirm({
			title: 'Error!',
			icon:  'fa fa-warning',
			closeIcon: true,
			content: msg,
			type: 'red',
			autoClose: 'close|'+autoClose,
			typeAnimated: true,
			buttons: {
				close: function () {
				}
			}
		});
	}
	else
	{
		$.confirm({
			title: 'Error!',
			icon:  'fa fa-warning',
			closeIcon: true,
			content: msg,
			type: 'red',
			typeAnimated: true,
			buttons: {
				close: function () {
				}
			}
		});

	}
}


