// public/js/views/server-add.js
var app = app || {};
app.ServerAddView = Backbone.View.extend({
	tagName: 'div',

	template: _.template( $('#serverAddTemplate').html() ),
	
	events: {
		'change #type_id': 'showPhysicalServerList',
		'submit': 'addServer'
	},

	initialize: function( id ) {
		$("#content").html(this.el);
		
		this.render();
	},

	render: function() {
		// Список физических серверов (отфильтрованная коллекция)
		var physicalServers = app.Servers.where({ 'type_id': 1 }); 
		// Отображаем "внешний" шаблон
		this.$el.html( this.template() );

		// Отображаем "внутренний" шаблон-форму
		var form_compiled = _.template( $("#serverFormTemplate").html() );
		$("#form-div").html( form_compiled({server: {}, physicalServers: physicalServers }) );

		// Отображаем дэйтпикер
		$( "#start_date" ).datepicker();

		return this;
	},

	// Добавление сервера
	addServer: function (e) {
		e.preventDefault();
		var data = {
			name: $("#name").val(),
			model: $("#model").val(),
			ip: $("#ip").val(),
			start_date: $("#start_date").val(),
			type_id: parseInt( $("#type_id").val() ),
			doc_name: $("#doc_name").val(),
			cpu: $("#cpu").val(),
			hdd: $("#hdd").val(),
			ram: $("#ram").val(),
			inventory_number: $("#inventory_number").val(),
			serial_number: $("#serial_number").val(),
			appointment: $("#appointment").val()
		};
		if (data.type_id === 2) {
			data.physical_server_id = parseInt( $("#physical_server_id").val() );
		}
		
		$('#spinner').spin();

		app.Servers.create(data, {
			wait: true,
			success: function () {
				Backbone.trigger('flash', { message: '<strong>Сервер успішно створено!</strong>', type: 'success' });
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
	},

	showPhysicalServerList: function () {
		var currentTypeId = parseInt($('#type_id').val());
		if (currentTypeId === 1) {
			$('#physical-server-div').fadeOut();
		} else {
			$('#physical-server-div').fadeIn();
		}
	}
});