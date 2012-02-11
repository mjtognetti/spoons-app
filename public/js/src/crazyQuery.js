define([
   'order!jquery',
   'underscore',
   'backbone',
   'lib/utils',
   'src/constants',
   'order!js/lib/vendor/jquery.flot.js',
   'order!js/lib/vendor/jquery.flot.resize.js',
   'order!js/lib/vendor/jquery.flot.selection.js'
], function ($, _, Backbone, Utils, constants){
   var input, submit, chartContainer, plot, labels;

   labels = [
      'Crazy Chart',
      'mind blower',
      'wtf',
      'interesting line',
      'super series',
      'glorious graph',
      'total failure',
      'not what I wanted',
      'exactly what I wanted!',
      'wrong',
      'Erick\'s series',
      'don\'t know what I\'m doing',
      'don\'t let Cailin see this',
      'France-worthy data',
      'shit',
      'brilliance',
      'puppies kicked / day'
   ];

   function initialize() {
      var plotOptions;

      input = $('#crazy-query-input');
      submit = $('#crazy-query-submit');
      chartContainer = $('#crazy-chart-container');

      submit.on('click', submitQuery);

      plotOptions = {
         xaxis: {
            mode: 'time',
            position: 'bottom'
         },
         grid: {
            borderWidth: 0,
         },
         selection: {
            mode: 'x'
         }
      };
      
      plot = $.plot(chartContainer, [], plotOptions);
   }

   function submitQuery() {
      var url, query;

      query = input.val();

      $.ajax('crazyQuery', {
         type: 'POST',
         data: {
            query: query
         },
         datatype: 'json',
         url: constants.root + '/crazyQuery',
         success: querySuccess,
         error: queryError
      });
      
      return false;
   }

   function querySuccess(data, textStatus) {
      drawChart(JSON.parse(data));
   }

   function queryError(response) {
      console.log(response);
      alert(response);
   }

   function drawChart(data) {
      var labelIndex;

      labelIndex = Math.floor(Math.random() * labels.length);

      plot.setData([{
         label: labels[labelIndex],
         data: data
      }]);

      plot.clearSelection();
      plot.setupGrid();
      plot.draw();

      console.log(plot.getData());
   }

   return {
      initialize: initialize
   };
});
