module.exports = function(grunt) {
    'use strict';

    var requirejs   = grunt.config('requirejs') || {};
    var clean       = grunt.config('clean') || {};
    var copy        = grunt.config('copy') || {};

    var root        = grunt.option('root');
    var libs        = grunt.option('mainlibs');
    var ext         = require(root + '/tao/views/build/tasks/helpers/extensions')(grunt, root);
    var out         = 'output';

    /**
     * Remove bundled and bundling files
     */
    clean.itemqticreatorbundle = [out];

    /**
     * Compile tao files into a bundle
     */
    requirejs.itemqticreatorbundle = {
        options: {
            baseUrl : '../js',
            dir : out,
            mainConfigFile : './config/requirejs.build.js',
            paths : {
                'itemqtiCreator' : root + '/itemqtiCreator/views/js',
                'taoItems' : root + '/taoItems/views/js',
                'taoItemsCss' : root + '/taoItems/views/css',
                'taoQtiItem' : root + '/taoQtiItem/views/js'
            },
            modules : [{
                name: 'itemqtiCreator/controller/routes',
                include : ext.getExtensionsControllers(['itemqtiCreator']),
                exclude : ['mathJax'].concat(libs)
            }]
        }
    };

    /**
     * copy the bundles to the right place
     */
    copy.itemqticreatorbundle = {
        files: [
            { src: [out + '/itemqtiCreator/controller/routes.js'],  dest: root + '/itemqtiCreator/views/js/controllers.min.js' },
            { src: [out + '/itemqtiCreator/controller/routes.js.map'],  dest: root + '/itemqtiCreator/views/js/controllers.min.js.map' }
        ]
    };

    grunt.config('clean', clean);
    grunt.config('requirejs', requirejs);
    grunt.config('copy', copy);

    // bundle task
    grunt.registerTask('itemqticreatorbundle', ['clean:itemqticreatorbundle', 'requirejs:itemqticreatorbundle', 'copy:itemqticreatorbundle']);
};
