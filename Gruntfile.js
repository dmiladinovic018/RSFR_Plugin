module.exports = function (grunt) {

  const sass = require('node-sass');

  /* * Load Grunt Plugins * */
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-stylelint');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-eslint');
  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-terser');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.loadNpmTasks('grunt-exec');

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    eslint: {
      options: {
        configFile: '.eslintrc'
      },
      target: [
        'assets/admin/src/js/**/*.js',
        'assets/public/src/js/**/*.js'
      ]
    },
    stylelint: {
      options: {
        configFile: '.stylelintrc',
        formatter: 'string',
        ignoreDisables: false,
        failOnError: true,
        outputFile: '',
        reportNeedlessDisables: false,
        syntax: 'scss'
      },
      src: [
        'assets/admin/src/scss/**/*.{css,scss}',
        'assets/public/src/scss/**/*.{css,scss}'
      ]
    },
    sass: {
      dev: {
        options: {
          implementation: sass,
        },
        files: [
          {'assets/admin/dist/css/admin.min.css': ['assets/admin/src/scss/admin.scss']},
          {'assets/public/dist/css/public.min.css': ['assets/public/src/scss/public.scss']}
        ]
      },
      prod: {
        options: {
          implementation: sass,
          outputStyle: 'compressed',
        },
        files: [
          {'assets/admin/dist/css/admin.min.css': ['assets/admin/src/scss/admin.scss']},
          {'assets/public/dist/css/public.min.css': ['assets/public/src/scss/public.scss']}
        ]
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions']
      },
      dist: {
        options: {
          map: false
        },
        files: [
          {'assets/admin/dist/css/admin.min.css': 'assets/admin/dist/css/admin.min.css'},
          {'assets/public/dist/css/public.min.css': 'assets/public/dist/css/public.min.css'}
        ]
      }
    },
    browserify: {
      dev: {
        src: [
          'assets/public/src/js/public.js'
        ],
        dest: 'assets/public/dist/js/public.min.js',
        options: {
          transform: [
            [
              'babelify',
              {
                presets: [
                  ['@babel/preset-env',
                    {
                      targets: '> 0.25%, not dead',
                      useBuiltIns: 'usage',
                      'corejs': 3
                    }
                  ]
                ]
              }
            ]
          ],
          browserifyOptions: {
            debug: true
          }
        }
      },
      prod: {
        src: [
          'assets/public/src/js/public.js'
        ],
        dest: 'assets/public/dist/js/public.min.js',
        options: {
          transform: [
            [
              'babelify',
              {
                presets: [
                  ['@babel/preset-env',
                    {
                      targets: '> 0.25%, not dead',
                      useBuiltIns: 'usage',
                      'corejs': 3
                    }
                  ]
                ]
              }
            ]
          ],
          browserifyOptions: {
            debug: false
          }
        }
      }
    },
    terser: {
      options: {},
      target: {
        files: {
          'assets/admin/dist/js/admin.min.js': ['assets/admin/dist/js/admin.min.js'],
          'assets/public/dist/js/public.min.js': ['assets/public/dist/js/public.min.js']
        }
      },
    },
    copy: {
      deploy: {
        files: [
          {
            expand: true,
            src: [
              'assets/admin/dist/**',
              'assets/admin/img/**',
              'assets/public/dist/**',
              'assets/public/img/**',
              'src/**',
              'views/**',
              'vendor/**',
              '*.php',
              '*.md',
              'wp-plugin-plugin_name.json'
              // add all files which are required
            ],
            dest: 'build/plugin_name'
          }
        ]
      },
      adminjs: {
        expand: true,
        flatten: true,
        src: ['assets/admin/src/js/**/*.js'],
        dest: 'assets/admin/dist/js/'
      }
    },
    compress: {
      deploy: {
        options: {
          archive: 'wp-plugin-plugin_name.zip'
        },
        expand: true,
        cwd: 'build/',
        src: ['**/*']
      }
    },
    clean: {
      deploy: {
        src: ["build"]
      }
    },
    exec: {
      composer_install: 'composer install --prefer-dist --no-dev',
      composer_dumpautoload: 'composer dump-autoload -o',
      composer_lint: 'composer lint'
    },
    watch: {
      sass: {
        files: [
          'assets/admin/src/sass/**/*.scss',
          'assets/public/src/sass/**/*.scss'
        ],
        tasks: ['stylelint', 'sass-dev', 'autoprefixer']
      },
      js: {
        files: ['assets/public/src/js/**/*.js'],
        tasks: ['eslint', 'browserify:dev']
      },
      adminjs: {
        files: ['assets/admin/src/js/*.js'],
        tasks: ['eslint', 'copy:adminjs']
      }
    }
  });

  /* * Register Tasks * */
  grunt.registerTask('dev', [
    'exec:composer_lint',
    'stylelint',
    'eslint',
    'sass:dev',
    'autoprefixer',
    'browserify:dev',
    'copy:adminjs'
  ]);

  grunt.registerTask('default', [
    'stylelint',
    'sass:prod',
    'autoprefixer',
    'eslint',
    'browserify:prod',
    'terser',
    'copy:adminjs'
  ]);

  // * grunt build * triggers on every merge to master
  grunt.registerTask('build', [
    'exec:composer_install',
    'exec:composer_dumpautoload',
    'exec:composer_lint',
    'stylelint',
    'eslint',
    'sass:prod',
    'autoprefixer',
    'browserify:prod',
    'terser',
    'copy:adminjs',
    'copy:deploy'
  ]);

  // * grunt deploy * triggers when releasing
  grunt.registerTask('deploy', [
    'compress',
    'clean:deploy'
  ]);
};
