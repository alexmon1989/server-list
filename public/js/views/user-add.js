// public/js/views/user-add.js
var app = app || {};
app.UserAddView = Backbone.View.extend({
	tagName: 'div',

	template: _.template( $('#userAddTemplate').html() ),
	
	events: {
		'submit': 'addUser'
	},

	initialize: function( id ) {
		$("#content").html(this.el);
		
		this.render();
	},

	render: function() {
		// Отображаем "внешний" шаблон
		this.$el.html( this.template() );

		// Отображаем "внутренний" шаблон-форму
		var form_compiled = _.template( $("#userFormTemplate").html() );
		$("#form-div").html( form_compiled({user: {} }) );

		// Отображаем дэйтпикер
		$( "#start_date" ).datepicker();

		return this;
	},

	// Добавление пользователя
    addUser: function (e) {
		e.preventDefault();
		var data = {
            username: $("#username").val(),
            email: $("#email").val(),
            password: $("#password").val()
		};
		
		$('#spinner').spin();

		app.Users.create(data, {
			wait: true,
			success: function () {
				Backbone.trigger('flash', { message: '<strong>Користувача успішно створено!</strong>', type: 'success' });
				$('#spinner').spin(false);
			},
			error: function (model, response) {
				var message = '<strong>Помилка при створенні!</strong>';
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