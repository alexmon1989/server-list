// public/js/views/about.js
var app = app || {};
app.AboutView = Backbone.View.extend({
	tagName: 'div',

	template: _.template( $('#aboutTemplate').html() ),
	
	initialize: function( ) {
		$("#content").html(this.el);

		this.render();
	},

	render: function() {
		this.$el.html( this.template() );
		return this;
	}
});