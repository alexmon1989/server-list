// public/js/collections/servers.js
var app = app || {};
app.ServerList = Backbone.Collection.extend({
	model: app.Server,
	url: 'api/servers'
});