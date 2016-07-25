module.exports = function(grunt) {

    // Load all grunt tasks
    require('load-grunt-tasks')(grunt);

    // Display how match time it took to build each task
    require('time-grunt')(grunt);

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-img');

    // Project configuration.
    grunt.initConfig({
        banner: "/*! <%= pkg.name %> <%= grunt.template.today('yyyy-mm-dd') %> */\n",

        pkg: grunt.file.readJSON('package.json'),

        paths : {
            components : 'bower_components',
            src        : 'source',
            build      : 'build',
            temp       : 'temp'
        },

        components : {
            jquery : {
                path    : '<%= paths.components %>/jquery',
                scripts : '<%= components.jquery.path %>/dist/jquery.js'
            },
            foundation  : {
                path    : '<%= paths.components %>/foundation-sites',
                scripts : '<%= components.foundation.path %>/dist/foundation.min.js',
                styles  : '<%= components.foundation.path %>/scss'
            },
            fontawesome : {
                path   : '<%= paths.components %>/font-awesome',
                fonts  : '<%= components.fontawesome.path %>/fonts',
                styles : '<%= components.fontawesome.path %>/scss'
            },
        },

        cssmin : {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1,
                keepSpecialComments: 0
            },
            target: {
                files: [{
                    expand: true,
                    cwd: '<%= paths.build %>/css',
                    src: ['*.css', '!*.min.css'],
                    dest: '<%= paths.build %>/css',
                    ext: '.min.css'
                }]
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
                    '<%= paths.src %>/js/**/*.js',
                    '<%= paths.src %>/js/*.js'
                ],
                tasks : ['scripts']
            },
            styles : {
                files : [
                    '<%= paths.src %>/scss/**/*.scss',
                    '<%= paths.src %>/scss/*.scss'
                ],
                tasks : ['styles']
            },
        },

        concat : {
            admin_scripts: {
                options: {
                    banner: "<%= banner %>\n\n"
                },
                src : [
                    '<%= paths.src %>/scripts/widgets/**/*.js',
                    '<%= paths.src %>/scripts/widgets/*.js'
                ],
                dest : '<%= paths.build %>/js/admin.js'
            },
            scripts : {
                options: {
                    banner: "<%= banner %>\n\n"
                },
                src : [
                    '<%= components.foundation.scripts %>',
                    '<%= paths.src %>/scripts/themes/*.js',
                    '<%= paths.src %>/scripts/themes/**/*.js'
                ],
                dest : '<%= paths.build %>/js/<%= pkg.name %>.js'
            }
        }
    });

    // Work with image
    grunt.config.merge({
        img: {
            // using only dirs with output path
            optimize: {
                src  : '<%= paths.build %>/img/',
            },
        }
    });

    grunt.config.merge({
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
        }
    });

    grunt.config.merge({
        clean : [
            '<%= paths.build %>/'
        ]
    });

    grunt.config.merge({
        sass: {
            options: {
                includePaths: [
                    '<%= components.foundation.styles %>',
                    '<%= components.fontawesome.styles %>',
                ]
            },
            dist: {
                options: {
                    outputStyle: 'expanded',
                    sourceMap: true,
                },
                files: {
                    '<%= paths.build %>/css/theme.css': '<%= paths.src %>/scss/theme.scss'
                }
            }
        },
    });

    grunt.config.merge({
        bower : {
            install : {
                copy    : true,
                cleanup : true,
                install : true
            }
        }
    });

    // Custom Tasks
    grunt.registerTask('default',  ['scripts', 'styles', 'images', 'fonts']);
    grunt.registerTask('optimize', ['default', 'uglify', 'imagemin']);

    grunt.registerTask('scripts', ['concat:scripts', 'concat:admin_scripts']);
    grunt.registerTask('styles',  ['sass', 'cssmin']);
    grunt.registerTask('images',  ['copy:images', 'img:optimize']);
    grunt.registerTask('fonts',   ['copy:fonts']);
};
