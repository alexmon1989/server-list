// public/js/models/server.js
var app = app || {};

app.Server = Backbone.Model.extend({
	defaults: {
		name: null,
		model: null,
		ip: '0.0.0.0',
		start_date: null,
		type: 'Фізичний',
		doc_name: null,
		cpu: null,
		hdd: null,
		ram: null,
		inventory_number: '1',
		serial_number: '1',
		appointment: null,
		history: null
	},

	urlRoot: 'api/servers'
});