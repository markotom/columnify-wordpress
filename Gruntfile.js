'use strict';

module.exports = function (grunt) {

  grunt.initConfig({
    release: {
      npm: false,
      push: false,
      commit: false,
      pushTags: false,
      tagMessage: 'Version <%= version %>',
      commitMessage: 'Release <%= version %>'
    },
    wp_readme_to_markdown: {
      columnify: {
        files: {
          'readme.md': 'readme.txt'
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
  grunt.loadNpmTasks('grunt-release');

  // Register readme task in short
  grunt.registerTask('readme', 'wp_readme_to_markdown');

};
