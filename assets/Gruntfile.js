module.exports = function(grunt) {

    // Load all grunt tasks
    require('load-grunt-tasks')(grunt);

    // Display how match time it took to build each task
    require('time-grunt')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',

        paths : {
            components : 'bower_components',
            src        : 'source',
            build      : 'build',
            temp       : 'temp'
        },

        components : {
            jquery : {
                path    : '<%= paths.components %>/jquery',
                scripts : [
                    '<%= components.jquery.path %>/dist/jquery.js'
                ],
            },
            foundation  : {
                path    : '<%= paths.components %>/foundation',
                scripts : [
                    '<%= components.foundation.path %>/js/vendor/*.js',
                    '<%= components.foundation.path %>/js/foundation.min.js'
                ],
                styles  : [
                    '<%= components.foundation.path %>/css/normalize.css',
                    '<%= components.foundation.path %>/css/foundation.css'
                ]
            },
            fontawesome : {
                path   : '<%= paths.components %>/font-awesome',
                fonts  : '<%= components.fontawesome.path %>/fonts',
                styles : [
                    '<%= components.fontawesome.path %>/less/variables.less',
                    '<%= components.fontawesome.path %>/less/mixins.less',
                    '<%= components.fontawesome.path %>/less/path.less',
                    '<%= components.fontawesome.path %>/less/core.less',
                    '<%= components.fontawesome.path %>/less/larger.less',
                    '<%= components.fontawesome.path %>/less/fixed-width.less',
                    '<%= components.fontawesome.path %>/less/list.less',
                    '<%= components.fontawesome.path %>/less/stacked.less',
                    '<%= components.fontawesome.path %>/less/icons.less'
                ]
            },
        },

        less : {
            development: {
                options: {
                    compress: true,
                    optimization: 2
                }
            },
            build : {
                src : [
                    '<%= paths.build %>/less/<%= pkg.name %>.less'
                ],
                dest : '<%= paths.build %>/css/<%= pkg.name %>.min.css'
            }
        },
        cssmin : {
            build : {
                src : ['<%= paths.build %>/css/<%= pkg.name %>.css'],
                dest : '<%= paths.build %>/css/<%= pkg.name %>.min.css'
            }
        },
        uglify : {
            build : {
                src : ['<%= paths.build %>/js/<%= pkg.name %>.js'],
                dest : '<%= paths.build %>/js/<%= pkg.name %>.min.js'
            }
        },

        watch : {
            scripts : {
                files : [
                    '<%= components.foundation.scripts %>',
                    '<%= paths.src %>/js/**/*.js'
                ],
                tasks : ['scripts']
            },
            styles : {
                files : [
                    '<%= components.foundation.styles %>',
                    '<%= paths.src %>/less/**/*.less'
                ],
                tasks : ['styles']
            },
        },

        clean : {
            scripts : [
                '<%= paths.build %>/js'
            ],
            styles : [
                '<%= paths.build %>/less',
                '<%= paths.build %>/css'
            ],
            images : [
                '<%= paths.build %>/img'
            ],
            fonts : [
                '<%= paths.build %>/fonts'
            ],
        },

        concat : {
            scripts : {
                options: {
                    banner: '<%= banner %>'
                },
                src : [
                    '<%= components.foundation.scripts %>',
                    '<%= paths.src %>/scripts/**/*.js',
                    '<%= paths.src %>/scripts/*.js'
                ],
                dest : '<%= paths.build %>/js/<%= pkg.name %>.js'
            },
            styles : {
                options: {
                    banner: '<%= banner %>'
                },
                src : [
                    '<%= components.foundation.styles %>',
                    '<%= components.fontawesome.styles %>',
                    '<%= paths.src %>/less/style.less',
                    '<%= paths.src %>/less/default.less',
                    '<%= paths.src %>/less/about.less',
                    '<%= paths.src %>/less/category.less',
                    '<%= paths.src %>/less/single.less',
                    '<%= paths.src %>/less/widgets/posts.less'
                ],
                dest : '<%= paths.build %>/less/<%= pkg.name %>.less'
            }
        },
        copy : {
            images : {
                files : [{
                    expand : true,
                    cwd : '<%= paths.src %>/img/',
                    src : ['**/*.*'],
                    dest : '<%= paths.build %>/img/'
                }]
            },
            fonts : {
                files: [{
                    expand : true,
                    cwd : '<%= components.fontawesome.fonts %>/',
                    src : ['**/*.*'],
                    dest : '<%= paths.build %>/fonts/'
                }]
            }
        },

        bower : {
            install : {
                copy : true,
                cleanup : true,
                install : true
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');

    // Custom Tasks
    grunt.registerTask('default',  ['scripts', 'styles', 'images', 'fonts']);
    grunt.registerTask('optimize', ['default', 'uglify', 'cssmin', 'imagemin']);

    grunt.registerTask('scripts', ['clean:scripts', 'concat:scripts']);
    grunt.registerTask('styles',  ['clean:styles', 'concat:styles', 'less:build']);
    grunt.registerTask('images',  ['clean:images', 'copy:images']);
    grunt.registerTask('fonts',   ['clean:fonts', 'copy:fonts']);
};
