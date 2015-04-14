// public/js/views/users.js
var app = app || {};
app.UsersView = Backbone.View.extend({
	tagName: 'div',

	template:  _.template( $('#usersListTemplate').html() ),
	
	initialize: function() {
		this.subViews = [];

		$("#content").html(this.el);

		this.listenTo(app.Users, 'remove', this.render);

		this.render();
	},

	render: function() {
		this.$el.html( this.template() );

        this.addAll();

		// Превращаем нашу таблицу в умную Datatables
		$('#users').dataTable({
			language: {
				url: "packages/datatables/media/js/ukr.json"
			},
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 4 ] }
			],
			stateSave: true
		});
		$('#users').each(function(){
			var datatable = $(this);
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.addClass('form-control input-sm');
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-sm');
		});
	},

	// Добавление одного пользователя
	addOne: function (user) {
		var view = new app.UserTrItemView({ model: user });
		this.subViews.push( view );
		$('#list-tbody').append( view.render().el );
	},

	// Добавление всех пользователей
	addAll: function () {
		$('#list-tbody').html('');
		app.Users.each(this.addOne, this);
	},

	// Метод для уничтожения данного и его вложенных представлений
	close: function() {
		_.each(this.subViews, function(view) { view.remove(); });
		this.remove();
	}
});