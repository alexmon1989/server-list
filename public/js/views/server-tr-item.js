// public/js/views/item.js
var app = app || {};
app.ServerTrItemView = Backbone.View.extend({
	tagName: 'tr',

	template: _.template( $('#serverTrItemTemplate').html() ),

	events: {
		'click .destroy': 'clear'
	},
	
	initialize: function() {
		this.listenTo(this.model, 'destroy', this.remove);
	},

	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	},

	clear: function () {
		if (confirm('Ви дійсно бажаєте видалити цей сервер? ' + 
					'Увага: при видаленні ФІЗИЧНОГО СЕРВЕРА ' + 
					'віртуальні сервери, розташовані на ньому, також будуть видалені!')) {
			// Проверяем физ. ли это сервер
			if (this.model.get('type_id') == 1) {
				var id = this.model.get('id');
			}

			$('#servers').spin();
			this.model.destroy({ 
				wait: true, 
				success: function () {
					if (id) {
						// Удаляем и связанные модели, если они существуют
						var modelsToDelete = app.Servers.where({ physical_server_id: id });
						_.each(modelsToDelete, function (m) {
							m.destroy();
						});
						Backbone.trigger('flash', { message: 'Сервер успішно видалено!', type: 'success' });
					}
					$('#servers').spin(false);
				},
				error: function () {
					Backbone.trigger('flash', { message: 'Помилка при видаленні!', type: 'danger' });
					$('#servers').spin(false);
				}
			});
		}
	}
});