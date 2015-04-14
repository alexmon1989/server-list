// public/js/views/server-show.js
var app = app || {};
app.ServerShowView = Backbone.View.extend({
	tagName: 'div',

	template: _.template( $('#serverShowTemplate').html() ),

	parentServerJSON: null,
	
	initialize: function( id ) {
		$("#content").html(this.el);

		this.model = app.Servers.get( id );

		// Если это виртуальный сервер
		if (this.model.get("physical_server_id")) {
			var parentServer = app.Servers.get( this.model.get("physical_server_id") );
			this.parentServerJSON = parentServer.toJSON();
		}

		this.render();
	},

	render: function() {
		this.$el.html( this.template({ server: this.model.toJSON(), parentServer: this.parentServerJSON }) );
		return this;
	}
});