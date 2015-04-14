// public/js/views/user-show.js
var app = app || {};
app.UserShowView = Backbone.View.extend({
	tagName: 'div',

	template: _.template( $('#userShowTemplate').html() ),
	
	initialize: function( id ) {
		$("#content").html(this.el);

		this.model = app.Users.get( id );

		this.render();
	},

	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	}
});