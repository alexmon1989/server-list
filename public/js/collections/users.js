// public/js/collections/users.js
var app = app || {};
app.UserList = Backbone.Collection.extend({
	model: app.User,
	url: 'api/users'
});