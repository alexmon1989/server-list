// public/js/app.js
var app = app || {};
$(function(){
    $.ajaxSetup({
        statusCode: {
            401: function(){
                // Redirect the to the login page.
                location.href = 'auth/login'+location.hash;
            }
        }
    });

	//$("body").spin();
	
	// Инициализация библиотеки флеш-сообщений
	Backbone.Flash.initialize({
		el: '#messages',
		stayDuration: 5000
	});

    // Предзагрузка моделей
    app.Servers = new app.ServerList;
    app.Servers.reset( servers );
    app.Users = new app.UserList;
    app.Users.reset( users );

    // Роутер
    var router = new app.Router();

    // Какой пункт меню делать активным
    router.on("route", function(route, params) {
        var activeLink = window.location.hash.split('/')[1];
        $('#navbar ul li').each(function (i, el) {
            $(el).removeClass('active');
        });
        if (!activeLink) {
            $('#servers-li').addClass('active');
        } else {
            $('#' + activeLink + '-li').addClass('active');
        }
    });

    Backbone.history.start();

    /*
	// Загружаем данные с сервера и создаём роутер
	app.Servers = new app.ServerList;
	app.Servers.fetch({
		reset: true, 
		success: function () {
			var router = new app.Router();

            // Какой пункт меню делать активным
            router.on("route", function(route, params) {
                var activeLink = window.location.hash.split('/')[1];
                $('#navbar ul li').each(function (i, el) {
                    $(el).removeClass('active');
                });
                if (!activeLink) {
                    $('#servers-li').addClass('active');
                } else {
                    $('#' + activeLink + '-li').addClass('active');
                }
            });

			Backbone.history.start();
			$("body").spin(false);
		},
		error: function () {
			Backbone.trigger('flash', { message: '<strong>Помилка при завантаженні даних з серверу!</strong>', type: 'danger' });
			$("body").spin(false);
		}
	});
	*/
});