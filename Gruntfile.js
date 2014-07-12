'use strict';

module.exports = function (grunt) {

  grunt.initConfig({
    wp_readme_to_markdown: {
      columnify: {
        files: {
          'readme.md': 'readme.txt'
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-wp-readme-to-markdown');

  // Register readme task in short
  grunt.registerTask('readme', 'wp_readme_to_markdown');

};
