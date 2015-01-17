module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      scripts: {
        files: ['Resources/public/js/main.js', 'Resources/public/js/search.js'],
        tasks: ['minify'],
        options: {
          spawn: false
        }
      }
    },
    uglify: {
      main: {
        src: 'Resources/public/js/main.js',
        dest: 'Resources/public/js/main.min.js'
      },
      search: {
        src: 'Resources/public/js/search.js',
        dest: 'Resources/public/js/search.min.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('minify', ['uglify']);

};
