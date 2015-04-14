module.exports = function(grunt) {

    // Задачи
    grunt.initConfig({
        // Склеиваем
        concat: {
            main: {
                src: [
                    'public/packages/jquery/dist/jquery.js',
                    'public/packages/jquery-ui/jquery-ui.min.js',
                    'public/packages/jquery-ui/ui-datepicker-uk.js',
                    'public/packages/moment/moment.js',
                    'public/packages/datatables/media/js/jquery.dataTables.min.js',
                    'public/packages/datatables/media/js/date-eu.js',
                    'public/packages/datatables-bootstrap3/BS3/assets/js/datatables.js',
                    'public/packages/spin.js/spin.js',
                    'public/packages/spin.js/jquery.spin.js',
                    'public/packages/bootstrap/dist/js/bootstrap.js',
                    'public/packages/underscore/underscore.js',
                    'public/packages/backbone/backbone.js',
                    'public/packages/backbone-flash/backbone-flash.js',
                    'public/js/models/*',
                    'public/js/collections/*',
                    'public/js/views/*',
                    'public/js/routes/router.js',
                    'public/js/app.js'
                ],
                dest: 'public/build_js/scripts.js'
            }
        },

        // Сжимаем
        uglify: {
            main: {
                files: {
                    // Результат задачи concat
                    'public/build_js/scripts.min.js': '<%= concat.main.dest %>'
                }
            }
        },

        cssmin: {
            target: {
                files: {
                    'public/css/style.min.css': ['public/css/style.css'],
                    'public/packages/jquery-ui/themes/ui-darkness/theme.min.css': ['public/packages/jquery-ui/themes/ui-darkness/theme.css'],
                    'public/packages/datatables-bootstrap3/BS3/assets/css/datatables.min.css': ['public/packages/datatables-bootstrap3/BS3/assets/css/datatables.css']
                }
            }
        }
    });

    // Загрузка плагинов, установленных с помощью npm install
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    // Задача по умолчанию
    grunt.registerTask('default', ['concat', 'uglify', 'cssmin']);
};