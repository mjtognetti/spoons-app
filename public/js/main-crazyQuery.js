require.config({
   paths: {
      'jquery': 'lib/vendor/jquery',
      'underscore': 'lib/vendor/underscore',
      'backbone': 'lib/vendor/backbone',
      'publisher': 'lib/vendor/publisher',
      'moment': 'lib/vendor/moment'
   }
});
require([
   'jquery',
   'lib/utils',
   'src/crazyQuery'
], function($, Utils, CrazyQuery) {
   CrazyQuery.initialize();
});
