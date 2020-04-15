 /*Push уведомления*/
    function notifyMe(_nameTitle,_bodyTitle,_icon) {
		var notification = new Notification (_nameTitle, {
			body : _bodyTitle,
			icon : _icon
		});
	}
    function notifSet(_nameTitle,_bodyTitle,_icon) {
		if (!("Notification" in window))
			alert ("Ваш браузер не поддерживает уведомления.");
		else if (Notification.permission === "granted")
			setTimeout(notifyMe(_nameTitle,_bodyTitle,_icon), 2000);
		else if (Notification.permission !== "denied") {
			Notification.requestPermission (function (permission) {
				if (!('permission' in Notification))
					Notification.permission = permission;
				if (permission === "granted")
					setTimeout(notifyMe(_nameTitle,_bodyTitle,_icon), 2000);
			});
		}
	}