// public/js/routers/router.js
// Маршрутизатор
// -------------------
var app = app || {};
app.Router = Backbone.Router.extend({
	routes: {
		'': 'serversList',
		'servers/list': 'serversList',
		'servers/show/:id': 'serversShow',
		'servers/add': 'serversAdd',
		'servers/edit/:id': 'serversEdit',
		'users/list': 'usersList',
        'users/show/:id': 'usersShow',
        'users/edit/:id': 'usersEdit',
        'users/add': 'usersAdd',
        'about': 'about'
	},

    serversList: function () {
		this.loadView( new app.ServersView() );
	},

    serversShow: function (id) {
		this.loadView( new app.ServerShowView( id ) );
	},

    serversAdd: function () {
		this.loadView( new app.ServerAddView() );
	},

    serversEdit: function (id) {
		this.loadView( new app.ServerEditView( id ) );
	},

    usersList: function () {
        this.loadView( new app.UsersView() );
    },

    usersShow: function (id) {
        this.loadView( new app.UserShowView( id ) );
    },

    usersEdit: function (id) {
        this.loadView( new app.UserEditView( id ) );
    },

    usersAdd: function () {
        this.loadView( new app.UserAddView() );
    },

    about: function () {
        this.loadView( new app.AboutView() );
    },

	loadView : function(view) {
		this.view && (this.view.close ? this.view.close() : this.view.remove());
		this.view = view;
	}
});