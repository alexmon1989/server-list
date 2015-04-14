// public/js/views/user.js
var app = app || {};
app.UserTrItemView = Backbone.View.extend({
	tagName: 'tr',

	template: _.template( $('#userTrItemTemplate').html() ),

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
		if (confirm('Ви дійсно бажаєте видалити цього користувача?')) {
			$('#servers').spin();
			this.model.destroy({ 
				wait: true, 
				success: function () {
					Backbone.trigger('flash', { message: 'Користувача успішно видалено!', type: 'success' });
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