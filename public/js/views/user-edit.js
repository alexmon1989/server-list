// public/js/views/user-edit.js
var app = app || {};
app.UserEditView = Backbone.View.extend({
	tagName: 'div',

	template: _.template( $('#userEditTemplate').html() ),
	
	events: {
		'submit': 'editUser'
	},

	initialize: function( id ) {
		$("#content").html(this.el);

		this.model = app.Users.get( id );

		this.listenTo(this.model, 'change', this.render);

		this.render();
	},

	render: function() {
		// Данные JSON сервера
		var data = this.model.toJSON();
		// Отображаем "внешний" шаблон
		this.$el.html( this.template( data ) );

		// Отображаем "внутренний" шаблон-форму
		var form_compiled = _.template( $("#userFormTemplate").html() );
		$("#form-div").html( form_compiled({ user : data }) );

		return this;
	},

	// Редактирование данных пользователя
    editUser: function (e) {
		e.preventDefault();
		var data = {
			username: $("#username").val(),
            email: $("#email").val(),
			password: $("#password").val()
		};

		$('#spinner').spin();

		var that = this;
		this.model.save(data, { 
			patch: true,
			wait: true,
			success: function () {
				Backbone.trigger('flash', { message: '<strong>Дані користувача успішно відредаговано!</strong>', type: 'success' });
				$('#spinner').spin(false);
			},
			error: function (model, response) {
				var message = '<strong>Помилка при збереженні!</strong>';
                if (response.responseJSON) {
                    if (response.responseJSON.validation_errors) {
                        message += '<br>' + response.responseJSON.validation_errors;
                    }
                }
				Backbone.trigger('flash', { message: message, type: 'danger' });
				$('#spinner').spin(false);
			}
		});
	}
});