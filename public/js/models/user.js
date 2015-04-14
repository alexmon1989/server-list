// public/js/models/user.js
var app = app || {};

app.User = Backbone.Model.extend({
	defaults: {
		email: null,
		username: null
	},

	urlRoot: 'api/users'
});