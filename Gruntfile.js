module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
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

  grunt.registerTask('minify', ['uglify']);

};
