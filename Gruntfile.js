(function (){
	'use strict';

	module.exports = function(grunt){
		require('load-grunt-tasks')(grunt);

		grunt.initConfig({
			pkg: grunt.file.readJSON('package.json'),

			/*** Clean folders with build ***/
			clean: {
				all: ['assets/css/*.css', 'assets/js/*.js']
			},

			/*** JS Validation ***/
			jshint: {
				all: ['Gruntfile.js', 'assets/js/source/*.js'],
				options: {
					"bitwise": true,
					"browser": true,
					"curly": true,
					"eqeqeq": true,
					"eqnull": true,
					"esnext": true,
					"immed": true,
					"jquery": true,
					"latedef": false,
					"newcap": false,
					"noarg": true,
					"node": true,
					"strict": false,
					"trailing": false,
					"undef": false,
					"devel": true,
					"globals": {
						"jQuery": true,
						"alert": true
					}
				}
			},

			/*** JS concatenation ***/
			concat: {
				dist: {
					options: {
						separator: ';\n',
					},
					files: {
						'assets/js/theme.js': ['assets/js/vendor/*.js', 'assets/js/vendor/*/*.js', 'assets/js/source/*.js']
					},
				}
			},

			/*** JS minification ***/
			uglify: {
				dist: {
					files: {
						'assets/js/theme.js': ['assets/js/theme.js']
					},
				}
			},

			/*** SASS compilation ***/
			sass: {
				dist: {
					options: {
						// noSourceMap: true,
						style: 'compressed'
					},
					files: [
						{
							'assets/css/theme.css': 'assets/scss/theme.scss',
							'assets/css/admin.css': 'assets/scss/admin.scss',
							'assets/css/editor.css': 'assets/scss/editor.scss'
						},
						{
							expand: true,
							cwd: 'parts/block',
							src: ['**/style.scss'],
							dest: 'parts/block',
							ext: '.css'
						}
					]
				}
			},

			/*** POSTCSS plugins ***/
			postcss: {
				options: {
					processors: [
						require('postcss-sort-media-queries')({sort: 'mobile-first'}),
						require('autoprefixer')()
					]
				},
				dist: {
					src: ['assets/css/*.css', 'parts/block/**/*.css']
				}
			},

			/*** Watch files for changes ***/
			watch: {
				js: {
					files: [
						'<%= jshint.all %>'
					],
					tasks: ['jshint', 'concat', 'uglify'],
					options: {
						// livereload: true,
					}
				},
				css: {
					files: [
						'assets/scss/',
						'assets/scss/*',
						'assets/scss/**/*',
						'parts/block/**/*'
					],
					tasks: ['sass', 'postcss'],
					options: {
						// livereload: true,
					}
				},
				php: {
					files: ['../*.php', '../**/*.php'],
					options: {
						// livereload: true
					}
				}
			}
		});

		/*** Register tasks ***/
		grunt.registerTask('default', [
			'jshint',
			'concat',
			'uglify',
			'sass',
			'postcss',
			'watch',
		]);
	};
}());