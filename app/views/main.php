<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список серверів ДП "УІПВ"</title>

    <link rel="stylesheet" href="packages/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="packages/jquery-ui/themes/ui-darkness/jquery-ui.min.css">
    <link rel="stylesheet" href="packages/jquery-ui/themes/ui-darkness/theme.min.css">
    <link rel="stylesheet" href="packages/datatables-bootstrap3/BS3/assets/css/datatables.min.css">
    <link rel="stylesheet" href="<?php echo asset('css/style.min.css'); ?>">
    
</head>
<body>
    
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Список серверів</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li id="servers-li"><a href="#/servers/list">Усі сервери</a></li>
                    <li id="users-li"><a href="#/users/list">Управління користувачами</a></li>
                    <li id="about-li"><a href="#/about">Про програму</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="auth/logout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Вихід <strong>(<?php echo Auth::user()->username ?>)</strong></a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid theme-showcase" role="main">
        <div class="row">
            <div class="col-md-12" id="messages"></div>
        </div>

        <div class="row">
            <div class="col-md-12" id="content"></div>
        </div>

        <script type="text/template" id="serversListTemplate">
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/servers/add" class="btn btn-primary" type="button"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span> Додати</a></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover" id="servers">
                        <thead>
                        <th width="3%">ID</th>
                        <th>Назва</th>
                        <th>Модель</th>
                        <th>IP-адреса</th>
                        <th>Тип</th>
                        <th>Дата вводу</th>
                        <th>Документ</th>
                        <th>СPU</th>
                        <th>HDD</th>
                        <th>RAM</th>
                        <th>ОС</th>
                        <th>Інв. номер</th>
                        <th>Серійный номер </th>
                        <th>Призначення</th>
                        <th width="10%">Дії</th>
                        </thead>
                        <tbody id="list-tbody"></tbody>
                    </table>
                </div>
            </div>
        </script>

        <script type="text/template" id="serverTrItemTemplate">
            <td><%= id %></td>
            <td><%= name %></td>
            <td><%= model %></td>
            <td><%= ip %></td>
            <td><%= type %></td>
            <td><%= start_date %></td>
            <td><%= doc_name %></td>
            <td><%= cpu %></td>
            <td><%= hdd %></td>
            <td><%= ram %></td>
            <td><%= os %></td>
            <td><%= inventory_number %></td>
            <td><%= serial_number %></td>
            <td><%= appointment %></td>
            <td>
                <a href="#/servers/show/<%= id %>" class="btn btn-primary" type="button" title="Переглянути"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a>
                <a href="#/servers/edit/<%= id %>" class="btn btn-success" type="button" title="Редагувати"><span class="glyphicon glyphicon-edit"></span></a>
                <button class="btn btn-danger destroy" type="button" title="Видалити"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></button>
            </td>
        </script>

        <script type="text/template" id="serverShowTemplate">
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/servers/list">Назад</a></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Назва</strong>
                </div>
                <div class="col-md-9">
                    <%= server.name %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Модель</strong>
                </div>
                <div class="col-md-9">
                    <%= server.model %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>IP-адреса</strong>
                </div>
                <div class="col-md-9">
                    <%= server.ip %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Дата вводу в експлуатацію</strong>
                </div>
                <div class="col-md-9">
                    <%= server.start_date %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Тип</strong>
                </div>
                <div class="col-md-9">
                    <%= server.type %>
                </div>
            </div>

            <% if (parentServer) { %>
            <div class="row">
                <div class="col-md-3">
                    <strong>Знаходиться на фізичному сервері</strong>
                </div>
                <div class="col-md-9">
                    <%= parentServer.name %>
                </div>
            </div>
            <% }  %>

            <div class="row">
                <div class="col-md-3">
                    <strong>Документ</strong>
                </div>
                <div class="col-md-9">
                    <%= server.doc_name %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>СPU</strong>
                </div>
                <div class="col-md-9">
                    <%= server.cpu %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>HDD</strong>
                </div>
                <div class="col-md-9">
                    <%= server.hdd %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>RAM</strong>
                </div>
                <div class="col-md-9">
                    <%= server.ram %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>ОС</strong>
                </div>
                <div class="col-md-9">
                    <%= server.os %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Інв. номер</strong>
                </div>
                <div class="col-md-9">
                    <%= server.inventory_number %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Серійний номер</strong>
                </div>
                <div class="col-md-9">
                    <%= server.serial_number %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Призначення</strong>
                </div>
                <div class="col-md-9">
                    <%= server.appointment %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Дата створення запису</strong>
                </div>
                <div class="col-md-9">
                    <%= server.created_at %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <% if (server.history) { %>
                    <table class="table table-striped">
                        <caption>Історія змін</caption>
                        <thead>
                        <tr>
                            <th>Час</th>
                            <th>Поле</th>
                            <th>Старе значення</th>
                            <th>Нове значення</th>
                        </tr>
                        </thead>
                        <tbody>
                        <%
                        _.each(server.history, function(item){
                        %>
                        <tr>
                            <th scope="row"><% print( moment( item.time*1000 ).format("DD.MM.YYYY, HH:mm:ss") ); %></th>
                            <td><%= item.field %></td>
                            <td><%= item.old_value %></td>
                            <td><%= item.new_value %></td>
                        </tr>
                        <% }); %>
                        </tbody>
                    </table>
                    <% } %>
                </div>
            </div>
        </script>

        <script type="text/template" id="serverAddTemplate">
            <h3>Створення нового серверу</h3>
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/servers/list">Назад</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="form-div"></div>
                </div>
            </div>
        </script>

        <script type="text/template" id="serverEditTemplate">
            <h3>Редагування серверу <strong><i>"<%= name %>"</i></strong></h3>
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/servers/list">Назад</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="form-div"></div>
                </div>
            </div>
        </script>

        <script type="text/template" id="serverFormTemplate">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-1 control-label">Назва</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="name" value="<%= server.name || '' %>" placeholder="Назва">
                    </div>
                </div>

                <div class="form-group">
                    <label for="model" class="col-sm-1 control-label">Модель</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="model" value="<%= server.model || '' %>" placeholder="Модель">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ip" class="col-sm-1 control-label">IP-адреса</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="ip" value="<%= server.ip || '' %>" placeholder="IP-адреса">
                    </div>
                </div>

                <div class="form-group">
                    <label for="start_date" class="col-sm-1 control-label">Дата вводу в експлуатацію</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="start_date" value="<%= server.start_date || '' %>" placeholder="Дата вводу в експлуатацію">
                    </div>
                </div>

                <div class="form-group">
                    <label for="type_id" class="col-sm-1 control-label">Тип</label>
                    <div class="col-sm-11">
                        <select class="form-control" id="type_id">
                            <option value="1" <% if (server.type_id === 1) { %>selected="selected"<% } %>>Фізичний</option>
                            <option value="2" <% if (server.type_id === 2) { %>selected="selected"<% } %>>Віртуальний</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="physical-server-div" <% if (server.type_id !== 2) { %>style="display: none"<% } %>>
                <label for="physical_server_id" class="col-sm-1 control-label">Фізичний сервер</label>
                <div class="col-sm-11">
                    <select class="form-control" id="physical_server_id">
                        <option value=""></option>
                        <% _.each(physicalServers, function(physicalServer) { %>
                        <option value="<%= physicalServer.get('id') %>" <% if (server.physical_server_id === physicalServer.get('id')) { %>selected="selected"<% } %>><%= physicalServer.get('name') %></option>
                        <% }); %>
                    </select>
                </div>
                </div>

                <div class="form-group">
                    <label for="doc_name" class="col-sm-1 control-label">Документ</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="doc_name" value="<%= server.doc_name || '' %>" placeholder="Документ">
                    </div>
                </div>

                <div class="form-group">
                    <label for="cpu" class="col-sm-1 control-label">СPU</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="cpu" value="<%= server.cpu || '' %>" placeholder="СPU">
                    </div>
                </div>

                <div class="form-group">
                    <label for="hdd" class="col-sm-1 control-label">HDD</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="hdd" value="<%= server.hdd || '' %>" placeholder="HDD">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ram" class="col-sm-1 control-label">RAM</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="ram" value="<%= server.ram || '' %>" placeholder="RAM">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ram" class="col-sm-1 control-label">ОС</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="os" value="<%= server.os || '' %>" placeholder="ОС">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inventory_number" class="col-sm-1 control-label">Інв. номер</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="inventory_number" value="<%= server.inventory_number || '' %>" placeholder="Інв. номер">
                    </div>
                </div>

                <div class="form-group">
                    <label for="serial_number" class="col-sm-1 control-label">Серійний номер</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="serial_number" value="<%= server.serial_number || '' %>" placeholder="Серійний номер">
                    </div>
                </div>

                <div class="form-group">
                    <label for="appointment" class="col-sm-1 control-label">Призначення</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="appointment" value="<%= server.appointment || '' %>" placeholder="Призначення">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button type="submit" class="btn btn-primary">Зберегти</button><span id="spinner"></span>
                    </div>
                </div>
            </form>
        </script>

        <script type="text/template" id="usersListTemplate">
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/users/add" class="btn btn-primary" type="button"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span> Додати</a></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover" id="users">
                        <thead>
                            <th width="3%">ID</th>
                            <th>Логін</th>
                            <th>E-Mail</th>
                            <th>Створено</th>
                            <th width="10%">Дії</th>
                        </thead>
                        <tbody id="list-tbody"></tbody>
                    </table>
                </div>
            </div>
        </script>

        <script type="text/template" id="userTrItemTemplate">
            <td><%= id %></td>
            <td><%= username %></td>
            <td><%= email %></td>
            <td><%= created_at %></td>
            <td>
                <a href="#/users/show/<%= id %>" class="btn btn-primary" type="button" title="Переглянути"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a>
                <a href="#/users/edit/<%= id %>" class="btn btn-success" type="button" title="Редагувати"><span class="glyphicon glyphicon-edit"></span></a>
                <button class="btn btn-danger destroy" type="button" title="Видалити"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></button>
            </td>
        </script>

        <script type="text/template" id="userShowTemplate">
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/users/list">Назад</a></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Логін</strong>
                </div>
                <div class="col-md-9">
                    <%= username %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>E-Mail</strong>
                </div>
                <div class="col-md-9">
                    <%= email %>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>Дата створення запису</strong>
                </div>
                <div class="col-md-9">
                    <%= created_at %>
                </div>
            </div>
        </script>

        <script type="text/template" id="userFormTemplate">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="username" class="col-sm-1 control-label">Логін</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="username" value="<%= user.username || '' %>" placeholder="Логін">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-1 control-label">E-Mail</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="email" value="<%= user.email || '' %>" placeholder="E-Mail">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-1 control-label">Пароль</label>
                    <div class="col-sm-11">
                        <input type="password" class="form-control" id="password" value="" placeholder="Пароль">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button type="submit" class="btn btn-primary">Зберегти</button><span id="spinner"></span>
                    </div>
                </div>
            </form>
        </script>

        <script type="text/template" id="userEditTemplate">
            <h3>Редагування користувача <strong><i>"<%= username %>"</i></strong></h3>
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/users/list">Назад</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="form-div"></div>
                </div>
            </div>
        </script>

        <script type="text/template" id="userAddTemplate">
            <h3>Створення нового користувача</h3>
            <div class="row">
                <div class="col-md-12">
                    <p><a href="#/users/list">Назад</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="form-div"></div>
                </div>
            </div>
        </script>

        <script type="text/template" id="aboutTemplate">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">
                        Програмне забезпечення для обліку серверів ДП "УІПВ".<br><br><br>
                        &copy; ДП "Український інститут промислової власності", 2015 р.
                    </p>
                </div>
            </div>
        </script>

    </div>

    <script>
        var servers = <?php echo $servers ?>;
        var users = <?php echo $users ?>;
    </script>

    <!--<script src="packages/jquery/dist/jquery.js"></script>
    <script src="packages/jquery-ui/jquery-ui.min.js"></script>
    <script src="packages/jquery-ui/ui-datepicker-uk.js"></script>
    <script src="packages/moment/moment.js"></script>
    <script src="packages/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="packages/datatables/media/js/date-eu.js"></script>
    <script src="packages/datatables-bootstrap3/BS3/assets/js/datatables.js"></script>
    <script src="packages/spin.js/spin.js"></script>
    <script src="packages/spin.js/jquery.spin.js"></script>
    <script src="packages/bootstrap/dist/js/bootstrap.js"></script>
    <script src="packages/underscore/underscore.js"></script>
    <script src="packages/backbone/backbone.js"></script>
    <script src="packages/backbone-flash/backbone-flash.js"></script>
    <script src="js/models/server.js"></script>
    <script src="js/collections/servers.js"></script>
    <script src="js/views/servers.js"></script>
    <script src="js/views/server-show.js"></script>
    <script src="js/views/server-edit.js"></script>
    <script src="js/views/server-add.js"></script>
    <script src="js/views/server-tr-item.js"></script>
    <script src="js/models/user.js"></script>
    <script src="js/collections/users.js"></script>
    <script src="js/views/users.js"></script>
    <script src="js/views/user-tr-item.js"></script>
    <script src="js/views/user-show.js"></script>
    <script src="js/views/user-edit.js"></script>
    <script src="js/views/user-add.js"></script>
    <script src="js/views/about.js"></script>
    <script src="js/routes/router.js"></script>
    <script src="js/app.js"></script>-->

    <script src="build_js/scripts.min.js"></script>
</body>
</html>
