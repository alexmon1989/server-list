// public/js/views/servers.js
var app = app || {};
app.ServersView = Backbone.View.extend({
	tagName: 'div',

	template:  _.template( $('#serversListTemplate').html() ),
	
	initialize: function() {
		this.subViews = [];

		$("#content").html(this.el);

		//this.listenTo(app.Servers, 'add', this.addOne);
		//this.listenTo(app.Servers, 'reset', this.render);
		this.listenTo(app.Servers, 'remove', this.render);

		this.render();
	},

	render: function() {
		this.$el.html( this.template() );
		this.addAll();

		// Превращаем нашу таблицу в умную Datatables
		$('#servers').dataTable({
			language: {
				url: "packages/datatables/media/js/ukr.json"
			},
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 12 ] },
                { type: 'date-eu', aTargets: 5 }
			],
			stateSave: true
		});
		$('#servers').each(function(){
			var datatable = $(this);
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.addClass('form-control input-sm');
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-sm');
		});
	},

	// Добавление одного сервера
	addOne: function (server) {
		var view = new app.ServerTrItemView({ model: server });
		this.subViews.push( view );
		$('#list-tbody').append( view.render().el );
	},

	// Добавление всех серверов
	addAll: function () {
		$('#list-tbody').html('');
		app.Servers.each(this.addOne, this);
	},

	// Метод для уничтожения данного и его вложенных представлений
	close: function() {
		_.each(this.subViews, function(view) { view.remove(); });
		this.remove();
	}
});